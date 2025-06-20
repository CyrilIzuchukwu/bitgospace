@extends('layouts.dashboard')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="row mt-2 align-items-center justify-content-center">
            <div class="col-md-12">
                <div class="card max-w-md rounded-2xl  text-white space-y-6">
                    <div class="card-body kyc-main pb-5">
                        <div class="kyc-image">
                            <img src="{{ asset('dashboard_assets/assets/images/kyc/kyc-key.png') }}" alt="KYC Icon">
                        </div>

                        <h2 class="header-text">Verification in Progress</h2>

                        <div class="kyc-list">
                            <ul>
                                <li>
                                    <p style="text-align: center;">Your documents have been submitted and are now under review. This process typically takes 5 - 15 minutes. You'll be notified once your verification is complete.
                                    </p>
                                </li>
                            </ul>


                        </div>
                        <p class="text-center mb-3">Thanks for your patience!</p>


                        <div class="proceed-btn">
                            <a class="btn-default" href="{{ route('user.dashboard') }}">
                                Return to dashboard <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->
</div>
@endsection
