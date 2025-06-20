<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    // Show the forgot password form
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.forgot-password');
    }


    // Handle the forgot password form submission
    public function submitForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();



        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate a password reset token and OTP
        $resetToken = Str::random(40);
        $otp = rand(100000, 999999);

        $user->password_reset_token = $resetToken;
        $user->password_reset_otp = $otp;
        $user->password_reset_token_expires_at = now()->addMinutes(30); // Token expires in 30 minutes
        $user->save();

        // Send password reset OTP email
        Mail::to($user->email)->send(new PasswordResetOtpMail($otp));

        return redirect()->route('confirm.code', ['token' => $resetToken])->with('status', 'We have sent a password reset OTP to your email.');
    }


    public function showConfirmCodeForm(Request $request, $token)
    {
        $user = User::where('password_reset_token', $token)
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'Invalid or expired password reset token.');
        }

        // Mask the email for display
        $maskedEmail = $this->maskEmail($user->email);

        // return view('auth.passwords.confirm-code', [
        //     'token' => $token,
        //     'email' => $maskedEmail
        // ]);

        return view('auth.passwords.confirm-code', [
            'token' => $token,
            'email' => $maskedEmail,
            'expiresAt' => $user->password_reset_token_expires_at->timestamp * 1000,
        ]);
    }


    // submit reset code
    public function submitResetCode(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = User::where('password_reset_token', $request->token)
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        if (!$user || $user->password_reset_otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // OTP is valid, show reset password form
        return redirect()->route('password.reset.form', ['token' => $request->token]);
    }



    public function resendOtp(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
            ]);

            // Find user by password reset token (not email verification token)
            $user = User::where('password_reset_token', $request->token)
                ->where('password_reset_token_expires_at', '>', now())
                ->first();

            if (!$user) {
                return back()->with('error', 'Invalid or expired token');
            }

            // Generate new OTP
            $otp = rand(100000, 999999);

            // Update user record
            $user->password_reset_otp = $otp;
            $user->password_reset_token_expires_at = now()->addMinutes(30); // Reset expiration
            $user->save();

            // Resend email
            Mail::to($user->email)->send(new PasswordResetOtpMail($otp));

            return back()->with('success', 'A new code has been sent to your email.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to resend code. Please try again.');
        }
    }




    public function showResetPasswordForm($token)
    {
        $user = User::where('password_reset_token', $token)
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'Invalid or expired password reset token.');
        }

        return view('auth.passwords.reset-password', ['token' => $token]);
    }




    public function submitResetPassword(Request $request)
    {
        // dd('hi');
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|max:40|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ]);

        // dd([
        //     'request_token' => $request->token,
        //     'db_match' => User::where('password_reset_token', $request->token)->pluck('password_reset_token'),
        // ]);

        $user = User::where('password_reset_token', trim($request->token))
            ->where('password_reset_token_expires_at', '>', now())
            ->first();

        // dd($user);


        if (!$user) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }


        DB::beginTransaction();
        try {
            $user->password = Hash::make($request->password);
            $user->password_reset_token = null;
            $user->password_reset_otp = null;
            $user->password_reset_token_expires_at = null;
            $user->save();

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Password changed. Proceed to login.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reset password. Please try again.')
                ->withInput();
        }
    }



    // Reuse your existing maskEmail method
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
