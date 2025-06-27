<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KycApprovedMail;
use App\Mail\KycRejectedMail;
use App\Models\KycVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminKycController extends Controller
{
    //

    public function index()
    {
        $kycs = KycVerification::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.kyc.index', compact('kycs'));
    }



    public function show($id)
    {
        $kyc = KycVerification::with('user')->findOrFail($id);

        // Update status to in_review when admin views it
        if ($kyc->status === 'pending') {
            $kyc->update([
                'status' => 'in_review',
                'reviewed_at' => Carbon::now()
            ]);
        }

        return view('admin.kyc.show', compact('kyc'));
    }


    // public function approve($id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $kyc = KycVerification::findOrFail($id);
    //         $user = $kyc->user;

    //         dd($user);

    //         // ✅ Send email before updating anything
    //         Mail::to($user->email)->send(new KycApprovedMail($user));

    //         // ✅ Now update KYC status
    //         $kyc->update([
    //             'status' => 'approved',
    //             'reviewed_at' => now(),
    //         ]);

    //         DB::commit();

    //         return back()->with('success', 'KYC approved successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return back()->with('error', 'Failed to approve KYC: ' . $e->getMessage());
    //     }
    // }

    // public function approve($id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $kyc = KycVerification::with('user')->findOrFail($id);

    //         dd($kyc);
    //         $user = $kyc->user;

    //         // dd($user);

    //         // Verify the user is correct before sending email
    //         if (!$user) {
    //             throw new \Exception('User not found for this KYC');
    //         }

    //         // Mail::to($user->email)->send(new KycApprovedMail($user));
    //         Mail::to($kyc->user->email)->send(new KycApprovedMail($kyc->user));

    //         $kyc->update([
    //             'status' => 'approved',
    //             'reviewed_at' => now(),
    //         ]);

    //         DB::commit();

    //         return back()->with('success', 'KYC approved successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Failed to approve KYC: ' . $e->getMessage());
    //     }
    // }


    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $kyc = KycVerification::with('user')->findOrFail($id);

            $userToNotify = $kyc->user;

            // dd($userToNotify->name, $userToNotify->email);

            if (!$userToNotify) {
                throw new \Exception('User not found for this KYC');
            }

            // ✅ Ensure the correct user is passed
            Mail::to($userToNotify->email)->send(new KycApprovedMail($userToNotify));

            $kyc->update([
                'status' => 'approved',
                'reviewed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'KYC approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve KYC: ' . $e->getMessage());
        }
    }


    // public function reject(Request $request, $id)
    // {
    //     $request->validate([
    //         'rejection_reason' => 'required|string|max:500'
    //     ]);

    //     $kyc = KycVerification::findOrFail($id);

    //     $kyc->update([
    //         'status' => 'rejected',
    //         'rejection_reason' => $request->rejection_reason,
    //         'reviewed_at' => Carbon::now()
    //     ]);

    //     return back()->with('success', 'KYC rejected');
    // }



    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $kyc = KycVerification::findOrFail($id);
            $userToNotify = $kyc->user;

            // Update KYC status first
            $kyc->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'reviewed_at' => Carbon::now()
            ]);

            // Send rejection email
            Mail::to($userToNotify->email)->send(new KycRejectedMail($userToNotify, $request->rejection_reason));

            DB::commit();

            return back()->with('success', 'KYC rejected and user notified');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject KYC: ' . $e->getMessage());
        }
    }
}
