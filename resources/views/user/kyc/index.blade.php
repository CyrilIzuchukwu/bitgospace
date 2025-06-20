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

                        <h2 class="header-text">KYC Verification</h2>

                        <div class="kyc-list">
                            <ul>
                                <li> <span>🔒</span>
                                    <p>To keep your account secure and comply with regulations, we need to verify your identity.</p>
                                </li>
                                <li><span>🪪</span>
                                    <p>Please have a valid ID (e.g., National ID, Passport, or Driver’s License) ready.</p>
                                </li>
                                <li><span>⏱️</span>
                                    <p> This process takes only a few minutes.</p>
                                </li>
                            </ul>
                        </div>


                        <div class="proceed-btn">
                            <a class="btn-default" href="{{ $signedUrl }}">
                                Proceed <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>

                        <div class="kyc-footer">
                            <p class="">Your information is safe and will only be used for verification purposes.</p>
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

@push('scripts')
<script>
    document.getElementById('document_type').addEventListener('change', function() {
        const backContainer = document.getElementById('document_back_container');
        if (this.value === 'id_card' || this.value === 'driving_license') {
            backContainer.style.display = 'block';
            document.getElementById('document_back').setAttribute('required', '');
        } else {
            backContainer.style.display = 'none';
            document.getElementById('document_back').removeAttribute('required');
        }
    });
</script>
@endpush
