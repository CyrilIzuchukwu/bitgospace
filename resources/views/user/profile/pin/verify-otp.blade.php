@extends('layouts.dashboard')

@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row  px-xxl-4">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body overflow-hidden text-center p-xxl-4 p-3 mb-0">

                                <div class="text-center mb-2">
                                    <div class="mb-3">
                                        <i class="ti ti-shield-lock fs-1 text-primary"></i>
                                    </div>
                                    <h3 class="mb-2 fw-bold">OTP Verification</h3>
                                    <p class="text-muted">We've sent a 6-digit verification code to your email<br>
                                        <span class="fw-semibold">{{ auth()->user()->email }}</span>
                                    </p>
                                </div>


                                <form action="{{ route('user.verify.pin.otp.submit') }}" method="POST" id="otpVerifyForm">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 mb-3 text-center">
                                                <div class="d-flex justify-content-center gap-2 otp-input-group">
                                                    @for ($i = 0; $i < 6; $i++)
                                                        <input type="text" name="otp_digits[]" maxlength="1"
                                                        class="form-control text-center otp-input @error('otp') is-invalid @enderror"
                                                        style="width: 40px; height: 40px; font-size: 14px;"
                                                        required {{ $i > 0 ? 'disabled' : '' }}>
                                                        @endfor
                                                </div>
                                                @error('otp')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12" style="display: flex; justify-content: center;">
                                                <button type="submit" class="submit-btn btn-default w-100 d-flex align-items-center justify-content-center" id="submitBtn" style="max-width: 200px !important;">
                                                    <span id="submitText">Verify</span>
                                                    <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="text-center mb-3">
                                    <small class="text-muted">Didn't get the code? <a href="#">Resend</a></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInputs = document.querySelectorAll('.otp-input');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index].disabled = true;
                    otpInputs[index + 1].disabled = false;
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && index > 0 && !e.target.value) {
                    otpInputs[index].disabled = true;
                    otpInputs[index - 1].disabled = false;
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Combine OTP before submitting
        const form = document.getElementById('otpVerifyForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const otp = Array.from(otpInputs).map(input => input.value).join('');

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'otp';
            hiddenInput.value = otp;
            form.appendChild(hiddenInput);

            submitBtn.disabled = true;
            submitText.textContent = 'Verifying...';
            spinner.classList.remove('d-none');

            form.submit();
        });
    });
</script>

@endsection
