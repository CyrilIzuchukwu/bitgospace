@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">

        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Trade Plans</h4> -->
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">BitGoSpace</a></li>

                    <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pricing</a></li> -->
                </ol>
            </div>
        </div>

        <div class="row justify-content-center mt-1">
            <div class="row justify-content-center mb-3 mt-2">
                <div class="col-md-12">

                    <!-- Pricing Title-->
                    <div class="text-center">
                        <h3 class="mb-2">CONFIRM SMART TRADE</h3>
                    </div>

                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Smart Trade Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column (Investment Details) -->
                            <div class="col-lg-7 border-end-lg pe-lg-4">
                                <div class="investment-details">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-md bg-light rounded p-2">
                                                <i class="ti ti-pig-money fs-3 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1">{{ $plan->name }}</h5>
                                        </div>
                                    </div>

                                    <div class="plan-details">
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Trade Amount:</span>
                                            <span class="fw-medium">${{ number_format($amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Daily Profit:</span>
                                            <span class="fw-medium">{{ $plan->interest_rate }}% (${{ number_format($amount * $plan->interest_rate / 100, 2) }})</span>
                                        </div>
                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span class="text-muted">Duration:</span>
                                            <span class="fw-medium">{{ $plan->duration }} days</span>
                                        </div>
                                        <!-- <div class="d-flex justify-content-between py-3 border-bottom">
                                            <span class="text-muted">Total Return:</span>
                                            <span class="text-success fw-bold">
                                                ${{ number_format($amount + ($amount * $plan->interest_rate / 100 * $plan->duration), 2) }}
                                            </span>
                                        </div> -->
                                    </div>

                                    <div class="alert alert-light mt-4">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-info-circle fs-4 text-primary me-2"></i>
                                            <div>
                                                <h6 class="mb-1">Important Note</h6>
                                                <p class="small mb-0">
                                                    Your smart trades will start earning returns immediately after confirmation.
                                                    Monitor progress in your dashboard.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Right Column (Confirmation) -->
                            <div class="col-lg-5 ps-lg-4">
                                <div class="confirmation-section">
                                    <!-- <h6 class="mb-3 fw-semibold">Payment Summary</h6> -->
                                    <div class="bg-light p-3 rounded mb-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Amount:</span>
                                            <span>${{ number_format($amount, 2) }}</span>
                                        </div>
                                        <hr class="my-2">
                                    </div>

                                    <form action="{{ route('user.process-investment') }}" class="process-investment" id="processInvestmentForm" method="POST">

                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="amount" value="{{ $amount }}">

                                        <div class="mt-4 pt-3">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="termsCheck" name="terms_agreed">
                                                <label class="form-check-label" for="termsCheck">
                                                    I agree to the <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> and
                                                    <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a>
                                                </label>
                                                <div class="invalid-feedback terms-error" style="display: none;">
                                                    Please agree to the Terms and Privacy Policy
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 py-3 mb-2">
                                            <i class="ti ti-checks me-1"></i> Confirm & Activate
                                        </button>

                                        <a href="{{ URL::previous() }}" class="btn btn-outline-secondary w-100">
                                            <i class="ti ti-arrow-left me-1"></i> Back
                                        </a>
                                    </form>


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
        const form = document.getElementById('processInvestmentForm');
        const confirmBtn = form.querySelector('button[type="submit"]');
        const termsCheck = document.getElementById('termsCheck'); // NOT inside form
        const termsError = document.querySelector('.terms-error');

        console.log("Form found:", form);
        console.log("Confirm Button found:", confirmBtn);
        console.log("Checkbox found:", termsCheck);

        form.addEventListener('submit', function(e) {
            console.log("Form submit triggered");

            if (!termsCheck.checked) {
                e.preventDefault(); // Prevent form submission
                console.log("Checkbox not checked!");

                termsError.style.display = 'block';
                termsCheck.classList.add('is-invalid');

                // Scroll to error
                termsError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                return false;
            }

            console.log("Checkbox is checked. Proceeding...");
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Processing Investment...
            `;
        });

        termsCheck.addEventListener('change', function() {
            if (this.checked) {
                console.log("Checkbox checked, removing error.");
                termsError.style.display = 'none';
                this.classList.remove('is-invalid');
            }
        });
    });
</script>



<style>
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .terms-error {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>

@endsection
