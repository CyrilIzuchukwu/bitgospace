@extends('layouts.auth')

@section('content')

<div class="slider-area slider-style-1 bg-transparent">
    <div class="container">
        <div class="log-wrapper">
            <div class="content">
                <div class="form-content">
                    <div class="header-text">
                        <h3 class="welcome-title">
                            Let’s Get You Verified 🔐
                        </h3>

                        <p class="subhead">We've sent a verification code to <span>{{ $email }}.</span>
                            Enter the verification code to confirm your account.</p>
                    </div>

                    <form action="{{ route('otp.submit') }}" method="POST" class="" id="otp-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Code</label>
                                <div class="input-group otp-inputs">
                                    

                                    @for ($i = 0; $i < 6; $i++) <input type="text" maxlength="1" name="otp" class="otp-digit" required
                                        {{ $i > 0 ? 'disabled' : '' }}>
                                        @endfor

                                </div>
                                @error('otp')
                                <span style="display: block !important;" class="error-msg">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="resend-text">
                            Didn't get the email?
                            <a href="#" class="resend-link" id="resend-otp-link">Resend Code</a>
                        </div>





                        <div class="auth-buttons">
                            <button type="submit" class="default-btn auth-button"> Verify <i class="ri-arrow-right-line"></i></button>
                        </div>
                    </form>

                    <!-- Hidden form for resend OTP  -->
                    <form id="resend-otp-form" action="{{ route('otp.resend') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                    </form>

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

<!-- JavaScript to handle resend OTP -->
<script>
    document.getElementById('resend-otp-link').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('resend-otp-form').submit();
    });
</script>

<script>
    // Select all OTP input fields
    const otpInputs = document.querySelectorAll('.otp-digit');

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
        const otpInputs = document.querySelectorAll('.otp-digit');
        const otpForm = document.getElementById('otp-form');
        const hiddenOtpInput = document.createElement('input');
        hiddenOtpInput.type = 'hidden';
        hiddenOtpInput.name = 'otp';
        otpForm.appendChild(hiddenOtpInput);

        otpForm.addEventListener('submit', function() {
            hiddenOtpInput.value = Array.from(otpInputs).map(input => input.value).join('');
        });
    });
</script>

@endsection
