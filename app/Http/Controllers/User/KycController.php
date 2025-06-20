<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use App\Models\User;
use App\Notifications\NewKycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Notification;

class KycController extends Controller
{
    //



    // public function index()
    // {

    //     $signedUrl = URL::signedRoute('user.kyc.verification');

    //     return view('user.kyc.index', compact('signedUrl'));
    // }

    public function index()
    {
        $user = Auth::user();
        $latestKyc = $user->kycVerifications()->latest()->first();

        // If no KYC exists or can submit new one
        if (!$latestKyc || $this->canResubmitKyc($latestKyc)) {
            $signedUrl = URL::signedRoute('user.kyc.verification');
            return view('user.kyc.index', compact('signedUrl'));
        }

        // Otherwise redirect to status page
        return redirect()->route('user.kyc.status');
    }


    public function status()
    {
        $user = Auth::user();

        $latestKyc = KycVerification::where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$latestKyc) {
            return redirect()->route('user.kyc');
        }

        return view('user.kyc.status', [
            'kyc' => $latestKyc,
            'canResubmit' => $this->canResubmitKyc($latestKyc),
        ]);
    }


    protected function canResubmitKyc($kyc)
    {
        // Only allow resubmission if rejected within last 30 days
        if ($kyc->status === 'rejected') {
            $rejectionDate = $kyc->reviewed_at ?? $kyc->updated_at;
            return $rejectionDate && $rejectionDate->greaterThan(now()->subDays(30));
        }

        return false;
    }



    public function verification(Request $request)
    {
        return view('user.kyc.identification');
    }


    public function storeVerification(Request $request)
    {

        // dd('why');
        $validator = Validator::make($request->all(), [
            'document_type' => 'required|in:id_card,passport,driver_license',
            'country_flag' => 'required|string', // Make this required instead
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please fill in all required fields correctly.');
        }

        // Parse the country_flag JSON to extract country name
        $countryData = json_decode($request->country_flag, true);

        // Validate that JSON was parsed successfully
        if (!$countryData || !isset($countryData['name']) || !isset($countryData['flag'])) {
            return redirect()->back()->with('error', 'Invalid country data. Please select a country again.');
        }


        // Store into session with extracted values
        session()->put('kyc_data', [
            'document_type' => $request->document_type,
            'country' => $countryData['name'],           // Extract country name
            'country_flag' => $countryData['flag'],      // Extract flag URL
            'country_data' => $request->country_flag,    // Optional: keep original JSON if needed
        ]);

        // dd(session('kyc_data'));

        return redirect()->route('user.kyc.document-upload');
    }



    public function documentUpload()
    {
        if (!session()->has('kyc_data')) {
            return redirect()->route('user.kyc')->with('error', 'Please start the KYC process again.');
        }

        // dd(session('kyc_data'));

        return view('user.kyc.document-upload');
    }



    public function storeDocuments(Request $request)
    {
        $user = Auth::user();

        // Check if session has kyc_data
        if (!session()->has('kyc_data')) {
            return redirect()->route('user.kyc')->with('error', 'Please start the KYC process again.');
        }

        // Validate uploaded files
        $validator = Validator::make($request->all(), [
            'document_front' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',  // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please upload valid image files (JPEG, PNG, JPG) under 5MB.');
        }

        try {
            // Get KYC data from session
            $kycData = session('kyc_data');

            // Store document front image
            $documentFrontFile = $request->file('document_front');
            $frontImagePath = $documentFrontFile->store('kyc_documents', 'public');
            $frontImageFilename = basename($frontImagePath);

            // Store profile photo (selfie)
            $profilePhotoFile = $request->file('profile_photo');
            $selfieImagePath = $profilePhotoFile->store('kyc_selfies', 'public');
            $selfieImageFilename = basename($selfieImagePath);

            // Create KYC verification record
            $kycVerification = KycVerification::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'document_type' => $kycData['document_type'],
                'country' => $kycData['country'],
                'country_flag' => $kycData['country_flag'],
                'front_image_path' => $frontImageFilename,
                'selfie_image_path' => $selfieImageFilename,
                'submitted_at' => now(),
            ]);

            // Create or update wallet
            $user->wallet()->updateOrCreate(
                ['user_id' => $user->id],
                ['status' => true] // Activate wallet upon KYC submission
            );


            // Send notification to admin email
            $adminEmail = env('KYC_ADMIN_EMAIL', 'alexcyril34@gmail.com');
            Notification::route('mail', $adminEmail)->notify(new NewKycSubmission($kycVerification, $user));

            // $adminUser = User::where('role', 'admin')->first();
            // if ($adminUser) {
            //     $adminUser->notify(new NewKycSubmission($kycVerification, $user));
            // }


            // Clear session data
            session()->forget('kyc_data');

            // Redirect with success message
            return redirect()->route('user.kyc.status')->with('success', 'KYC verification submitted successfully! We will review your documents within 5 - 15 minutes.');
        } catch (\Exception $e) {
            // Log the error
            dd('KYC Document Upload Error: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function review()
    {
        $user = Auth::user();

        // Check if user has any KYC record with status pending/approved/rejected
        $kyc = KycVerification::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->latest()
            ->first();

        if ($kyc) {
            // If a KYC record exists, redirect to the KYC status page
            return redirect()->route('user.kyc.status');
        }

        // If no KYC record, redirect to KYC start page
        return redirect()->route('user.kyc')->with('error', 'No recent KYC submission found.');
    }


    public function kycList()
    {
        $user = Auth::user();

        $kycs = KycVerification::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('user.kyc.kyc-list', [
            'user' => $user,
            'kycs' => $kycs,
        ]);
    }
}
