<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    // public function authenticated()
    // {
    //     $user = Auth::user();

    //     // Update last login timestamp
    //     $user->update(['last_login_at' => now()]);

    //     if (in_array($user->role, ['admin'])) {
    //         return redirect('admin/dashboard')->with('success', 'Welcome to Admin Dashboard');
    //     } elseif (Auth::user()->role == 'user') {

    //         $user = Auth::user();
    //         // Check if the user's email is verified
    //         if (!$user->email_verified_at) {
    //             // Use existing token if available, otherwise create new
    //             $verificationToken = $user->email_verification_token ?? Str::random(40);

    //             $email_verification_otp = rand(100000, 999999);
    //             $user->update([
    //                 'email_verification_otp' => $email_verification_otp,
    //                 'email_verification_token' => $verificationToken // Store the token
    //             ]);

    //             $verificationUrl = URL::temporarySignedRoute(
    //                 'verify.otp',
    //                 now()->addMinutes(30),
    //                 ['token' => $verificationToken]
    //             );

    //             Mail::to($user->email)->send(new OtpMail($user->email_verification_otp, $verificationUrl));

    //             Auth::logout();

    //             return redirect()->route('verify.otp', ['token' => $verificationToken])
    //                 ->with('error', 'Email not verified. Please enter the OTP sent to your email.');
    //         }

    //         return redirect()->route('user.dashboard')->with('success', 'Logged in successfully');
    //     }
    // }

    public function authenticated()
    {

        $user = User::find(Auth::id());
        // $user->update(['last_login_at' => now()]);

        // Check if account is banned
        if (!$user->active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact support.');
        }

        $user->update(['last_login_at' => now()]);

        // Handle admin login
        if ($user->role === 'admin') {
            return redirect('admin/dashboard')->with('success', 'Welcome to Admin Dashboard');
        }

        // Handle user login with email verification check
        if (!$user->email_verified_at) {
            $verificationToken = $user->email_verification_token ?? Str::random(40);
            $email_verification_otp = rand(100000, 999999);

            $user->update([
                'email_verification_otp' => $email_verification_otp,
                'email_verification_token' => $verificationToken
            ]);

            $verificationUrl = URL::temporarySignedRoute(
                'verify.otp',
                now()->addMinutes(30),
                ['token' => $verificationToken]
            );

            Mail::to($user->email)->send(new OtpMail($user->email_verification_otp, $verificationUrl));

            Auth::logout();

            return redirect()->route('verify.otp', ['token' => $verificationToken])
                ->with('error', 'Email not verified. Please enter the OTP sent to your email.');
        }

        return redirect()->route('user.dashboard')->with('success', 'Logged in successfully');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
