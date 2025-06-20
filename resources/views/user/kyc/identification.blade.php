@extends('layouts.dashboard')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="row mt-2 align-items-center justify-content-center">
            <div class="col-md-12">
                <div class="card max-w-4xl rounded-2xl text-white space-y-6">
                    <div class="card-body kyc-main kyc-identification">
                        <div class="content">
                            <!-- Aside Left Section -->
                            <div class="aside">

                                <h2 class="title">KYC Verification</h2>
                                <p class="sub-text">Verify your identity to get started</p>


                                <div class="kyc-steps ">
                                    <div class="step active">
                                        <div class="step-text">
                                            <p class="">Verification type</p>
                                            <span class="">Choose verification method</span>
                                        </div>
                                        <div class="step-icon">
                                            <i class="ri-shield-user-line"></i>
                                        </div>
                                    </div>


                                    <div class="step">
                                        <div class="step-text">
                                            <p class="">ID Verification</p>
                                            <span class="">Browse and upload</span>
                                        </div>
                                        <div class="step-icon">
                                            <i class="ri-id-card-line"></i>
                                        </div>
                                    </div>


                                    <div class="step">
                                        <div class="step-text">
                                            <p class="">Review</p>
                                        </div>
                                        <div class="step-icon">
                                            <i class="ri-time-line"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Main Right Section -->
                            <div class="main">
                                <div class="type-head type-head-one">
                                    <h2 class="type-head__title">Verification Type</h2>
                                    <p class="type-head__description">Select the document type and issuing country to proceed with your verification.</p>
                                </div>

                                <div class="verification-form">
                                    <form action="{{ route('user.kyc.verification.store') }}" id="typeForm" method="POST">
                                        @csrf

                                        <!-- Add hidden field for country flag -->
                                        <input type="hidden" name="country_flag" id="country-flag-input">
                                        <input type="hidden" name="country" id="country-input">


                                        <div class="country-select-wrapper">
                                            <label class="country-label form-label">Select Document issuing country</label>
                                            <div class="country-select-container">
                                                <select class="form-select country-select" id="country-select">
                                                    <option value="" disabled selected>Select your country</option>
                                                    <!-- Options will be added by JavaScript -->
                                                </select>
                                                <div class="country-flag-container">
                                                    <img src="" class="country-flag" id="country-flag">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group document-group">
                                            <label class="form-label">Select Document Type</label>
                                            <div class="document-options">
                                                <!-- ID Card Option -->
                                                <label class="document-option">
                                                    <input type="radio" name="document_type" value="id_card" class="document-radio">
                                                    <div class="document-option-content">
                                                        <div class="icon">
                                                            <img src="{{ asset('dashboard_assets/assets/images/kyc/idcard.png') }}" alt="icon image">
                                                        </div>
                                                        <div>
                                                            <span class="document-option-title">ID Card</span>
                                                            <p class="document-option-description">Upload a clear photo of your government-issued ID (e.g., National ID, Voter's Card).</p>
                                                        </div>
                                                    </div>
                                                </label>

                                                <!-- Passport Option -->
                                                <label class="document-option">
                                                    <input type="radio" name="document_type" value="passport" class="document-radio">
                                                    <div class="document-option-content">
                                                        <div class="icon">
                                                            <img src="{{ asset('dashboard_assets/assets/images/kyc/passport.png') }}" alt="icon image">
                                                        </div>
                                                        <div>
                                                            <span class="document-option-title">Passport</span>
                                                            <p class="document-option-description">Upload the bio-data page showing your photo and details.</p>
                                                        </div>
                                                    </div>
                                                </label>

                                                <!-- Driver's License Option -->
                                                <label class="document-option">
                                                    <input type="radio" name="document_type" value="driver_license" class="document-radio">
                                                    <div class="document-option-content">
                                                        <div class="icon">
                                                            <img src="{{ asset('dashboard_assets/assets/images/kyc/driverlicence.png') }}" alt="icon image">
                                                        </div>
                                                        <div>
                                                            <span class="document-option-title">Driver's License</span>
                                                            <p class="document-option-description">Upload the front side of your valid driver's license. Ensure your name, photo, and expiry date are clear.</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="next-btn">

                                            <a href="{{ route('user.kyc') }}" class="back">Back </a>

                                            <button type="submit" class="btn-default">
                                                Next <i class="ri-arrow-right-line"></i>
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
    </div>

    @include('user.snippets.footer')
</div>

<style>
    .country-select-wrapper {
        margin-bottom: 1.5rem;
    }

    .country-select-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .country-select {
        width: 100%;
        padding: 0.75rem;
        padding-left: 40px;
    }

    .country-flag-container {
        position: absolute;
        left: 10px;
        pointer-events: none;
    }

    .country-flag {
        display: none;
        width: 20px;
        height: 15px;
        object-fit: cover;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('country-select');
        const flag = document.getElementById('country-flag');
        const flagInput = document.getElementById('country-flag-input');

        // Fetch countries data
        fetch('/dashboard_assets/countries.json')
            .then(response => response.json())
            .then(countries => {
                countries.sort((a, b) => a.name.localeCompare(b.name));

                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name; // Store country name as value
                    option.dataset.flag = country.flag; // Store flag path in data attribute
                    option.textContent = country.name;
                    select.appendChild(option);
                });
            })
            .catch(err => console.error('Error loading countries:', err));

        // Handle country selection
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const flagPath = selectedOption.dataset.flag;

            // Update visible flag
            if (flagPath) {
                flag.src = flagPath;
                flag.alt = selectedOption.text + ' flag';
                flag.style.display = 'inline-block';
            }

            // Update hidden inputs
            document.getElementById('country-input').value = this.value; // Add this line
            flagInput.value = JSON.stringify({
                name: this.value,
                flag: flagPath
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('typeForm');
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
