@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-2">
                    </div>

                    <form id="setPinForm" action="" method="POST">

                        <div class="row  px-xxl-4">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body overflow-hidden text-center p-xxl-4 p-3 mb-0">

                                    <div class="col-md-12 mb-3">
                                        <div class="alert alert-info">
                                            <strong>SET WITHDRAWAL PIN</strong>

                                            <p>
                                                <strong>Important:</strong> This PIN will be required for all withdrawals
                                            </p>
                                        </div>
                                    </div>


                                    <div class="bg-body-secondary border border-dashed p-3 rounded my-3 text-center">
                                        <p class=" mb-0"> Create a 4-digit PIN to secure your withdrawals</p>
                                    </div>


                                    <form id="otp-form" action="{{ route('user.create-pin') }}" method="POST" class="text-start mb-3">
                                        @csrf

                                        <input type="hidden" name="pin" id="fullPin" />

                                        <label class="form-label" for="code">Enter 4-Digit PIN</label>
                                        <div class="d-flex justify-content-center gap-2">
                                            @for($i = 0; $i < 4; $i++)
                                                <input type="password"
                                                maxlength="1"
                                                class="form-control text-center digit-input"
                                                style="width: 60px; height: 50px; font-size: 1.5rem;"
                                                {{ $i > 0 ? 'disabled' : '' }}
                                                required>
                                                @endfor
                                        </div>

                                        <!-- <div class="mb-3 d-grid">
                                            <div class=" pt-2">
                                                <div class="">
                                                    <button type="submit" class="submit-btn btn-default">Proceed<i class="ti ti-chevron-right ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="pt-3 mb-3 text-center">
                                            <button type="submit" class="btn submit-btn btn-default px-4" id="submitBtn">
                                                <span id="btnText">Set PIN</span>
                                                <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                                            </button>
                                        </div>
                                    </form>

                                    <p class="text-danger fs-14 mb-4">Back To <a href="{{ route('user.dashboard') }}" class="fw-semibold text-dark ms-1">Dashboard !</a></p>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('user.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PIN Input Logic
        const digitInputs = document.querySelectorAll('.digit-input');
        const confirmInputs = document.querySelectorAll('.confirm-digit-input');
        const fullPinInput = document.getElementById('fullPin');
        const form = document.getElementById('pinForm');

        // Helper function to allow only numbers
        function allowOnlyNumbers(input) {
            // Remove any non-digit characters
            input.value = input.value.replace(/\D/g, '');

            // If empty after replacement, clear the input
            if (input.value === '') {
                input.value = '';
            }
        }

        // First set of digits
        digitInputs.forEach((input, index) => {
            // Allow only numbers on input
            input.addEventListener('input', (e) => {
                allowOnlyNumbers(e.target);

                if (e.target.value && index < digitInputs.length - 1) {
                    digitInputs[index].disabled = true;
                    digitInputs[index + 1].disabled = false;
                    digitInputs[index + 1].focus();
                }
                updateFullPin();
            });

            // Handle backspace and navigation
            input.addEventListener('keydown', (e) => {
                // Allow backspace, tab, arrow keys
                if (e.key === "Backspace" || e.key === "Tab" ||
                    e.key === "ArrowLeft" || e.key === "ArrowRight") {
                    return;
                }

                // Prevent non-numeric keys
                if (isNaN(parseInt(e.key))) {
                    e.preventDefault();
                    return;
                }

                if (e.key === "Backspace" && index > 0 && !e.target.value) {
                    digitInputs[index].disabled = true;
                    digitInputs[index - 1].disabled = false;
                    digitInputs[index - 1].value = '';
                    digitInputs[index - 1].focus();
                    updateFullPin();
                }
            });

            // Prevent paste of non-numeric content
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text/plain').replace(/\D/g, '');
                if (pasteData.length === 1) {
                    input.value = pasteData;
                    updateFullPin();
                    if (index < digitInputs.length - 1) {
                        digitInputs[index].disabled = true;
                        digitInputs[index + 1].disabled = false;
                        digitInputs[index + 1].focus();
                    }
                }
            });
        });

        // Second set of digits (confirmation)
        confirmInputs.forEach((input, index) => {
            // Allow only numbers on input
            input.addEventListener('input', (e) => {
                allowOnlyNumbers(e.target);

                if (e.target.value && index < confirmInputs.length - 1) {
                    confirmInputs[index].disabled = true;
                    confirmInputs[index + 1].disabled = false;
                    confirmInputs[index + 1].focus();
                }
            });

            // Handle backspace and navigation
            input.addEventListener('keydown', (e) => {
                // Allow backspace, tab, arrow keys
                if (e.key === "Backspace" || e.key === "Tab" ||
                    e.key === "ArrowLeft" || e.key === "ArrowRight") {
                    return;
                }

                // Prevent non-numeric keys
                if (isNaN(parseInt(e.key))) {
                    e.preventDefault();
                    return;
                }

                if (e.key === "Backspace" && index > 0 && !e.target.value) {
                    confirmInputs[index].disabled = true;
                    confirmInputs[index - 1].disabled = false;
                    confirmInputs[index - 1].value = '';
                    confirmInputs[index - 1].focus();
                }
            });

            // Prevent paste of non-numeric content
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text/plain').replace(/\D/g, '');
                if (pasteData.length === 1) {
                    input.value = pasteData;
                    if (index < confirmInputs.length - 1) {
                        confirmInputs[index].disabled = true;
                        confirmInputs[index + 1].disabled = false;
                        confirmInputs[index + 1].focus();
                    }
                }
            });
        });

        function updateFullPin() {
            fullPinInput.value = Array.from(digitInputs).map(i => i.value).join('');
        }

        // Form submission
        form.addEventListener('submit', function(e) {
            // Validate PINs match
            const pin1 = Array.from(digitInputs).map(i => i.value).join('');
            const pin2 = Array.from(confirmInputs).map(i => i.value).join('');

            if (pin1.length !== 4 || pin2.length !== 4) {
                e.preventDefault();
                alert('Please enter a complete 4-digit PIN in both fields');
                return;
            }

            if (pin1 !== pin2) {
                e.preventDefault();
                alert('PINs do not match!');
                return;
            }

            // Show loading state
            document.getElementById('btnText').textContent = 'Setting PIN...';
            document.getElementById('spinner').classList.remove('d-none');
            document.getElementById('submitBtn').disabled = true;
        });
    });
</script>





@endsection
