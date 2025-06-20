@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-2">
                    </div>

                    <div class="row px-xxl-4">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body overflow-hidden text-center p-xxl-4 p-0 md-p-3 mb-0">

                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-info">
                                        <strong>Reset PIN</strong>
                                    </div>
                                </div>

                                <div class="bg-body-secondary border border-dashed p-3 rounded my-3 text-center">
                                    <p class="mb-0">Set a new secure 4-digit PIN for your transactions.</p>
                                </div>

                                <form id="otp-form" action="{{ route('user.reset.pin.submit') }}" method="POST" class="text-center mb-3">
                                    @csrf

                                    <!-- Add the missing token field -->
                                    <input type="hidden" name="token" value="{{ $token }}">


                                    <label class="form-label text-center" for="code">Enter 4-Digit PIN</label>
                                    <div class="d-flex justify-content-center gap-2">
                                        @for($i = 0; $i < 4; $i++)
                                            <input type="password"
                                            maxlength="1"
                                            class="form-control text-center otp-input"
                                            style="width: 60px; height: 50px; font-size: 1.5rem;"
                                            data-index="{{ $i }}"
                                            {{ $i > 0 ? 'disabled' : '' }}
                                            required>
                                            @endfor
                                    </div>

                                    <div class="pt-3 mb-3 text-center">
                                        <button type="submit" class="btn submit-btn btn-default px-4" id="submitBtn">
                                            <span id="btnText">Set PIN</span>
                                            <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                                        </button>
                                    </div>
                                </form>

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
                // Only allow digits
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                if (e.target.value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].disabled = false;
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace") {
                    if (!e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index].disabled = true;
                    }
                }
            });
        });

        // Handle form submission
        const form = document.getElementById('otp-form');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const otp = Array.from(otpInputs).map(input => input.value).join('');

            if (otp.length !== 4) {
                alert('Please enter a complete 4-digit PIN');
                return;
            }

            // Create hidden input for the full PIN
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'pin';
            hiddenInput.value = otp;
            form.appendChild(hiddenInput);

            // Update button state
            submitBtn.disabled = true;
            btnText.textContent = 'Setting PIN...';
            spinner.classList.remove('d-none');

            form.submit();
        });
    });
</script>

@endsection
