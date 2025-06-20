<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\PinResetOtpMail;
use App\Models\Wallet;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Str;

class ForgotPinController extends Controller
{
    //
    public function forgotPin()
    {
        try {
            $user = Auth::user();
            $wallet = $user->wallet;

            // Generate OTP and token
            $otp = rand(100000, 999999);
            $token = Str::random(60);
            $expiresAt = Carbon::now()->addMinutes(60);

            // Attempt to send the email first
            try {
                Mail::to($user->email)->send(new PinResetOtpMail($otp));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send OTP email. Please try again.');
            }

            // If email sent successfully, update the wallet
            $wallet->update([
                'otp_pin' => $otp,
                'otp_pin_token' => $token,
                'otp_pin_expires_at' => $expiresAt,
            ]);

            return redirect()->route('user.verify.pin.otp', ['token' => $token])
                ->with('success', 'An OTP has been sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }



    public function showVerifyOtpForm($token)
    {
        $wallet = Auth::user()->wallet;

        if (
            !$wallet || $wallet->otp_pin_token !== $token || now()->greaterThan($wallet->otp_pin_expires_at)
        ) {
            return redirect()->route('user.profile')->with('error', 'Invalid or expired OTP token.');
        }

        return view('user.profile.pin.verify-otp', compact('token'));
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'token' => 'required'
        ]);

        $wallet = Auth::user()->wallet;

        if (
            !$wallet || $wallet->otp_pin_token !== $request->token || now()->greaterThan($wallet->otp_pin_expires_at)
        ) {
            return redirect()->back()->with('error', 'Invalid or expired OTP token.');
        }

        if ($wallet->otp_pin !== $request->otp) {
            return redirect()->back()->with('error', 'Invalid OTP code.');
        }

        // ✅ OTP verified, redirect with token for PIN reset
        return redirect()->route('user.reset.pin', ['token' => $request->token])->with('success', 'OTP verified. You can now reset your PIN.');
    }


    public function showResetPinForm($token)
    {
        $wallet = Auth::user()->wallet;

        if (!$this->isValidToken($wallet, $token)) {
            return redirect()->route('user.profile')->with('error', 'Invalid or expired reset token.');
        }

        return view('user.profile.pin.reset-pin', compact('token'));
    }



    public function resetPin(Request $request)
    {

        // dd('hi');
        $validated = $request->validate([
            'token' => 'required',
            'pin' => 'required|digits:4',
        ]);

        // dd($request->all());
        // dd($validated);

        $wallet = Auth::user()->wallet;
        // dd($wallet);

        if (!$this->isValidToken($wallet, $validated['token'])) {
            return redirect()->route('user.profile')->with('error', 'Invalid or expired reset token.');
        }

        $this->updateWalletPin($wallet, $validated['pin']);

        return redirect()->route('user.profile')->with('success', 'Your PIN has been successfully updated.');
    }

    /**
     * Check if the reset token is valid.
     */
    protected function isValidToken(?Wallet $wallet, string $token): bool
    {
        return $wallet &&
            $wallet->otp_pin_token === $token &&
            now()->lessThanOrEqualTo($wallet->otp_pin_expires_at);
    }

    /**
     * Update wallet PIN and clear reset token fields.
     */
    protected function updateWalletPin(Wallet $wallet, string $pin): void
    {
        $wallet->update([
            'pin' => Hash::make($pin),
            'otp_pin' => null,
            'otp_pin_token' => null,
            'otp_pin_expires_at' => null,
        ]);
    }
}
