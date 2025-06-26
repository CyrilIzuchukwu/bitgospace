@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">
                            <!-- Pricing Title-->
                            <div class="text-center">
                                <h3 class="mb-2">CREATE NEW TICKET</h3>
                            </div>
                        </div>
                    </div>

                    <form id="createTicketForm" action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Subject:</label>
                                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Enter subject">
                                        <span class="text-danger">@error('subject') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Message:</label>
                                        <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue in detail">{{ old('message') }}</textarea>
                                        <span class="text-danger">@error('message') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Attachment (optional):</label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="attachment" id="attachmentInput" class="form-control file-upload-input" accept="image/*,.pdf,.doc,.docx">
                                            <span class="text-danger">@error('attachment') {{ $message }} @enderror</span>
                                            <div id="filePreviewContainer" class="mt-2 d-none">
                                                <div class="file-preview-box">
                                                    <span id="fileNamePreview"></span>
                                                    <button type="button" id="removeFileBtn" class="btn btn-sm btn-danger ms-2">×</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default">Create Ticket<i class="ti ti-chevron-right ms-1"></i></button>
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

<style>
    /* File Upload and Preview Styles */
    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-input {
        padding: 10px;
        border: 1px dashed #ddd;
        border-radius: 5px;
        background-color: none;
        transition: all 0.3s ease;
    }

    .file-upload-input:hover {
        border-color: #ccc;
    }

    .file-preview-box {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #e9ecef;
    }

    #fileNamePreview {
        flex-grow: 1;
        font-size: 14px;
        color: #495057;
    }

    #removeFileBtn {
        padding: 0 6px;
        font-size: 16px;
        line-height: 1.5;
    }

    /* Textarea styling */
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('createTicketForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const attachmentInput = document.getElementById('attachmentInput');
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const fileNamePreview = document.getElementById('fileNamePreview');
        const removeFileBtn = document.getElementById('removeFileBtn');

        // Handle file selection
        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                fileNamePreview.textContent = file.name;
                filePreviewContainer.classList.remove('d-none');
            }
        });

        // Handle file removal
        removeFileBtn.addEventListener('click', function() {
            attachmentInput.value = '';
            filePreviewContainer.classList.add('d-none');
        });

        // Form submission handler
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.style.cursor = 'not-allowed';
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Creating Ticket...
            `;
        });
    });
</script>

@endsection