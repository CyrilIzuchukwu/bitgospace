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
                                    <div class="step ">
                                        <div class="step-text">
                                            <p class="">Verification type</p>
                                            <span class="">Choose verification method</span>
                                        </div>
                                        <div class="step-icon">
                                            <i class="ri-shield-user-line"></i>
                                        </div>
                                    </div>


                                    <div class="step active">
                                        <div class="step-text">
                                            <p class="">Document Verification</p>
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
                                    <h2 class="type-head__title">Document verification</h2>
                                    <p class="type-head__description">Please upload a clear photo of one of the following valid IDs to continue with your KYC process: National ID, Passport, Driver's License</p>
                                </div>

                                <div class="verification-form">
                                    <form action="{{ route('user.kyc.document-upload.store') }}" id="documentForm" method="POST" enctype="multipart/form-data">

                                        @csrf

                                        <div class="doc-wrapper">
                                            <div class="single-doc">
                                                <span>Upload a clear image of the front side of your document</span>
                                                <div class="label-wrapper">
                                                    <label for="document_front" class="document-label">
                                                        <div class="default-icon">
                                                            <img src="{{ asset('dashboard_assets/assets/images/kyc/doc-frame.png') }}" alt="Document icon">
                                                        </div>
                                                        <img id="preview-document" class="preview-img" alt="Preview">
                                                        <button type="button" class="custom-upload-btn document-upload-btn">Upload photo</button>
                                                    </label>
                                                    <input type="file" name="document_front" id="document_front" accept="image/*" class="file-input" style="display: none;">
                                                </div>
                                            </div>

                                            <div class="single-doc">
                                                <span>Upload a clear photo of your face in good lighting.</span>
                                                <div class="label-wrapper">
                                                    <label for="profile_photo" class="document-label">
                                                        <div class="default-icon">
                                                            <img src="{{ asset('dashboard_assets/assets/images/kyc/doc-frame.png') }}" alt="Profile icon">
                                                        </div>
                                                        <img id="preview-profile" class="preview-img" alt="Preview">
                                                        <button type="button" class="custom-upload-btn profile-upload-btn">Upload photo</button>
                                                    </label>
                                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="file-input" style="display: none;">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="next-btn">

                                            <a href="javascript:void(0)" class="back">Back </a>

                                            <button type="submit" class="btn-default">
                                                Verify <i class="ri-arrow-right-line"></i>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Function to handle file upload for any section
        function setupFileUpload(inputId, previewId, btnClass) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const uploadBtn = document.querySelector(`.${btnClass}`);
            const defaultIcon = uploadBtn.closest('.document-label').querySelector('.default-icon');

            uploadBtn.addEventListener('click', () => {
                input.click();
            });

            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        defaultIcon.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.style.display = 'none';
                    defaultIcon.style.display = 'flex';
                }
            });
        }

        // Setup document upload
        setupFileUpload('document_front', 'preview-document', 'document-upload-btn');

        // Setup profile photo upload
        setupFileUpload('profile_photo', 'preview-profile', 'profile-upload-btn');
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('documentForm');
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
