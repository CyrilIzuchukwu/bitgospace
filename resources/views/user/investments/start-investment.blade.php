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

        <div class="row">

            <div class="col-12">
                <div class="card position-relative deposit-wrapper investment-wrapper">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">

                            <!-- Pricing Title-->
                            <div class="text-center">
                                <h3 class="mb-2">NEW SMART TRADE</h3>
                                <!-- <p class="mb-2 text-center">Step: 1 of 2</p> -->

                                <p class="text-muted w-100 w-md-50 m-auto">
                                    You can trade in any plan using your wallet.
                                </p>
                            </div>

                        </div>
                    </div>

                    <form id="initiateInvestment" class="initiateInvestment" action="{{ route('user.validate-investment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Smart Trade Plan</label>
                                        <input type="text" name="plan_name" value="{{ $plan->name }}" class="form-control" placeholder="" readonly>
                                        <small class="info">* Trade for Daily and get profit {{ $plan->interest_rate }}%</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label">Amount (USD)</label>
                                        <input type="text" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="Enter amount">
                                        <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                                        <small class="info">* Note: Minimum invest {{ number_format($plan->minimum_amount) }} USD and up to {{ number_format($plan->maximum_amount) }} USD</small>
                                    </div>
                                </div>


                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default">Proceed<i class="ti ti-chevron-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- container -->

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('initiateInvestment');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.style.cursor = 'not-allowed'; // explicitly set cursor
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Processing...
            `;
        });
    });
</script>


@endsection
