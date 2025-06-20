@extends('layouts.dashboard')
@section('content')
<div class="page-content">

    <div class="page-container">

        <div class="row">

            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">

                            <div class="mb-4 d-flex justify-content-center align-items-center">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="#28a745"></circle>
                                    <path d="M17.3333 8L10 15.3333L6.66667 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>

                            <!-- Pricing Title-->
                            <div class="text-center">
                                <h3 class="mb-2 ">DEPOSIT SUBMITTED SUCCESSFULLY</h3>
                                <p class="mb-2 text-center">Step: 3 of 3</p>
                                <div class="text-center mb-2">
                                    <svg class="mt-18 nscaleX-1" width="314" height="6" viewBox="0 0 314 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                        <rect class="rect-B87" x="107" width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                        <rect class="rect-B87" x="214" width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                    </svg>
                                </div>
                                <p class="text-muted w-100 w-md-50 m-auto">
                                    Your deposit is being processed. You'll receive a confirmation once completed.
                                </p>
                            </div>





                            <div class="deposit-details text-left bg-light mt-3 p-3 p-md-4 rounded mb-3 mb-md-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Amount:</span>
                                    <strong>{{ number_format($deposit->amount, 2) }} USD</strong>
                                </div>

                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('user.dashboard') }}" class="btn default-btn mr-2">Go to Dashboard</a>
                                <a href="{{ route('user.deposit') }}" class="btn btn-outline-secondary">Make Another Deposit</a>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div> <!-- container -->

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>
@endsection
