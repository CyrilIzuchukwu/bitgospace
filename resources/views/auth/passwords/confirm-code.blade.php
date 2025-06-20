@extends('layouts.auth')

@section('content')

<div class="slider-area slider-style-1 bg-transparent">
    <div class="container">
        <div class="log-wrapper">
            <div class="content">
                <div class="form-content">
                    <div class="header-text">
                        <h3 class="welcome-title">
                            Confirm OTP 🔐
                        </h3>
                        <p class="subhead">Enter the OTP sent to your email <span>{{ $email }}.</span></p>
                    </div>

                    <form id="otp-form" action="{{ route('password-reset-code.submit') }}" method="POST" class="">
                        @csrf


                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="otp" id="otp-hidden-input">


                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Enter OTP</label>
                                <div class="input-group otp-inputs">

                                    @for ($i = 0; $i < 6; $i++) <input type="text" maxlength="1" class="otp-digit" required
                                        {{ $i > 0 ? 'disabled' : '' }}>
                                        @endfor

                                </div>
                                @error('otp')
                                <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="auth-buttons">
                            <button type="submit" class="default-btn auth-button">Verify Code <i class="ri-arrow-right-line"></i></button>
                        </div>
                    </form>


                    <div class="resend-text">
                        Didn't get the code?
                        <form id="resend-form" action="{{ route('password-reset.resend') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <button type="submit" class="resend-link" id="resend-otp-link"
                                style="background: none; border: none; color: #4986DB; cursor: pointer;">
                                Resend Code
                            </button>
                        </form>
                    </div>

                    <div class="log-footer">
                        <p>We use <span>OAuth 2.0 + JWT</span> security tokens to manage sessions safely across your devices.</p>
                    </div>

                </div>

                <div class="log-image">
                    <img src="{{ asset('assets/images/log-image.png') }}" alt="Log image">
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .auth-buttons{
        margin-top: 50px;
    }
    .resend-text {
        margin-top: 20px;
        font-size: 16px;
        text-align: center;
    }
</style>


<script>
    // Select all OTP input fields

    const otpInputs = document.querySelectorAll('.otp-digit');
    const otpForm = document.getElementById('otp-form');
    const hiddenOtpInput = document.getElementById('otp-hidden-input');


    otpInputs.forEach((input, index) => {
        // Listen for input event on each field
        input.addEventListener('input', (e) => {
            if (e.target.value && index < otpInputs.length - 1) {
                otpInputs[index].disabled = true; // Disable the current input
                otpInputs[index + 1].disabled = false; // Enable the next input
                otpInputs[index + 1].focus(); // Move focus to the next input
            }
        });

        input.addEventListener('keydown', (e) => {
            // Move to the previous input if Backspace is pressed and the current field is empty
            if (e.key === "Backspace" && index > 0 && !e.target.value) {
                otpInputs[index].disabled = true; // Disable current input
                otpInputs[index - 1].disabled = false; // Enable previous input
                otpInputs[index - 1].focus(); // Move focus back
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        otpForm.addEventListener('submit', function(e) {
            const otpValue = Array.from(otpInputs).map(input => input.value).join('');
            hiddenOtpInput.value = otpValue;
        });
    });
</script>

@endsection
