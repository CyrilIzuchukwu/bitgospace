<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Mail\OtpVerificationMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function createAdmin(Request $request)
    {
        // Check if admin already exists
        if (User::where('role', 'admin')->exists()) {
            return redirect()->back()->with('error', 'Admin account already exists');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|max:40|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = 'admin';
        $admin->email_verification_otp = rand(100000, 999999);

        // Generate admin's referral link
        if ($admin->save()) {
            $admin->referral_link = url('sign-up?ref=' .
                'BGS-' . // Short brand prefix
                now()->format('Y-W') . '-' . // Year and week number (2024-24)
                Str::upper(Str::random(4)) . '-' . // 4 random chars
                $admin->id . '-' .
                substr(md5($admin->id . $admin->email . now()->timestamp), 0, 8) . '-' .
                Str::upper(Str::random(3)));
            $admin->save();

            // For testing:
            dd([
                'status' => 'Admin created successfully',
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'admin_referral_link' => $admin->referral_link
            ]);

            /* Production:
        Mail::to($admin->email)->send(new OtpMail($admin->email_verification_otp));
        return redirect()->route('verify.otp', ['email' => $admin->email]);
        */
        }

        return redirect()->back()->with('error', 'Admin registration failed');
    }

    public function showRegistrationForm(Request $request)
    {
        if (!$request->has('ref')) {
            return redirect('/')->with('error', 'Registration requires a referral link');
        }

        $ref = $request->ref; // Just get the code portion, not full URL
        $referrer = User::where('referral_link', 'like', "%{$ref}%")->first();

        if (!$referrer) {
            return redirect('/')->with('error', 'Invalid referral link');
        }

        // Store referrer in session for the POST request
        session(['referrer' => $referrer->id]);

        return view('auth.register', ['ref' => $request->ref]);
    }



    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|max:40|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            // 'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get referrer from session instead of querying again
        if (!session()->has('referrer')) {
            return redirect('/')->with('error', 'Referral session expired');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'user';
        $user->email_verification_otp = rand(100000, 999999);
        $user->referred_by = session('referrer'); // Get from session

        $verificationToken = Str::random(40);
        $user->email_verification_token = $verificationToken;

        if ($user->save()) {

            $refCode = 'BGS-' . now()->format('Y-W') . '-' . Str::upper(Str::random(4)) . '-' . $user->id;
            $user->referral_link = url('sign-up') . '?ref=' . $refCode;

            $user->save();

            // Clear the referrer session
            session()->forget('referrer');

            $verificationUrl = URL::temporarySignedRoute(
                'verify.otp',
                now()->addMinutes(30), // Expires in 30 minutes
                ['token' => $verificationToken]
            );

            Mail::to($user->email)->send(new OtpMail($user->email_verification_otp, $verificationUrl));
            // return redirect()->route('verify.otp', ['email' => $user->email]);
            return redirect()->route('verify.otp', ['token' => $verificationToken]);
        }

        return redirect()->back()->with('error', 'Registration failed');
    }



    public function showVerifyOtpForm(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            abort(404, 'Invalid verification token');
        }

        // Mask the email for display (e.g., j*****e@domain.com)
        $maskedEmail = $this->maskEmail($user->email);

        return view('auth.verify-otp', [
            'token' => $token,
            'email' => $maskedEmail
        ]);
    }


    public function submitOtp(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'otp' => 'required|numeric|digits:6'

        ]);

        $user = User::where('email_verification_token', $request->token)
            ->firstOrFail();

        if (!$user) {
            return back()->with('error', 'Invalid verification token');
        }

        if ($user->email_verification_otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid  Code']);
        }


        if ($user->email_verification_otp == $request->otp) {
            // Mark as verified
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->email_verification_otp = null;
            $user->save();

            // auth()->login($user);
            // return redirect()->intended('/dashboard');

            return redirect()->route('login')->with('success', 'Email verified, please login');
        }

        return back()->withErrors(['otp' => 'Invalid OTP']);
    }

    public function resendOtp(Request $request)
    {

        try {
            // Validate that the request has a token
            $request->validate([
                'token' => 'required',
            ]);


            // Find the user by the token
            $user = User::where('email_verification_token', $request->token)->first();


            if (!$user) {
                return back()->with('error', 'Invalid verification token');
            }

            // Generate a new 6-digit OTP
            $newOtp = rand(100000, 999999);

            // Update the user's OTP
            $user->email_verification_otp = $newOtp;
            $user->save();

            // Resend the email with the new OTP
            // You'll need to implement your email sending logic here
            // For example:
            Mail::to($user->email)->send(new OtpVerificationMail($newOtp));

            return back()->with('success', 'A new verification code has been sent to your email.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    

    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1] ?? '';

        $maskedUsername = substr($username, 0, 1)
            . str_repeat('*', max(0, strlen($username) - 2))
            . substr($username, -1);

        return $maskedUsername . '@' . $domain;
    }





}
