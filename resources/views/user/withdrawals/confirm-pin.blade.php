@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-2 mt-md-2 ">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h3 class="mb-2 section-title">CONFIRM WITHDRAWAL</h3>
                                <p class="text-muted w-100 w-md-50 m-auto">
                                    Please enter your PIN to confirm the withdrawal
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="confirmPinForm" action="{{ route('user.withdrawal.confirm') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <!-- Withdrawal Summary -->
                                    <div class="alert alert-info mb-4">
                                        <h5 class="alert-heading">Withdrawal Details</h5>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Amount:</span>
                                            <strong>${{ number_format(session('pending_withdrawal.amount'), 2) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Payment Method:</span>
                                            <strong>{{ strtoupper(session('pending_withdrawal.payment_method')) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Wallet Address:</span>
                                            <strong class="text-truncate" style="max-width: 150px;">
                                                {{ session('pending_withdrawal.wallet_address') }}
                                            </strong>
                                        </div>
                                    </div>

                                    <!-- PIN Input -->
                                    <div class="mb-4 text-center">
                                        <label class="form-label">Enter Your 4-Digit PIN</label>
                                        <div class="d-flex justify-content-center gap-3">
                                            @for($i = 0; $i < 4; $i++)
                                                <input type="password"
                                                maxlength="1"
                                                class="form-control text-center digit-input"
                                                style="width: 60px; height: 50px; font-size: 1.5rem;"
                                                {{ $i > 0 ? 'disabled' : '' }}
                                                required>
                                                @endfor

                                        </div>
                                        <input type="hidden" name="full_pin" id="fullPin">
                                    </div>

                                    <div class="col-md-12 pt-1">
                                        <button type="submit" class="submit-btn btn-default d-flex align-items-center" id="submitBtn">
                                            <span id="btnText">Confirm Withdrawal</span>
                                            <div id="spinner" class="spinner-border spinner-border-sm text-light ms-2 d-none" role="status"></div>
                                            <i class="ti ti-chevron-right ms-2"></i>
                                        </button>
                                    </div>
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
        const digitInputs = document.querySelectorAll('.digit-input');
        const fullPinInput = document.getElementById('fullPin');
        const form = document.getElementById('confirmPinForm');

        function allowOnlyNumbers(input) {
            input.value = input.value.replace(/\D/g, '');
        }

        digitInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                allowOnlyNumbers(e.target);
                if (e.target.value && index < digitInputs.length - 1) {
                    digitInputs[index + 1].disabled = false;
                    digitInputs[index + 1].focus();
                }
                updateFullPin();
            });

            input.addEventListener('keydown', (e) => {
                if (["Tab", "ArrowLeft", "ArrowRight"].includes(e.key)) {
                    return; // Allow navigation
                }

                if (e.key === "Backspace") {
                    if (e.target.value === '') {
                        if (index > 0) {
                            digitInputs[index].disabled = true;
                            digitInputs[index - 1].disabled = false;
                            digitInputs[index - 1].focus();
                            digitInputs[index - 1].value = '';
                            updateFullPin();
                            e.preventDefault(); // prevent the browser from going "back"
                        }
                    } else {
                        // Clear current input and prevent moving cursor back
                        e.target.value = '';
                        updateFullPin();
                        e.preventDefault();
                    }
                    return;
                }

                // Block non-numeric keys
                if (isNaN(parseInt(e.key))) {
                    e.preventDefault();
                    return;
                }
            });
        });

        function updateFullPin() {
            if (fullPinInput) {
                fullPinInput.value = Array.from(digitInputs).map(i => i.value).join('');
            }
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                const pin = Array.from(digitInputs).map(i => i.value).join('');

                if (pin.length !== 4) {
                    e.preventDefault();
                    alert('Please enter a complete 4-digit PIN');
                    return;
                }

                // Show loading state
                document.getElementById('btnText').textContent = 'Processing...';
                document.getElementById('spinner').classList.remove('d-none');
                document.getElementById('submitBtn').disabled = true;
            });
        }
    });
</script>
@endsection
