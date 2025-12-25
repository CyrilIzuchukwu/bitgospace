@extends('layouts.admin')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="row">
                <div class="col-12">
                    <div class="card position-relative deposit-wrapper">
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h3 class="mb-2">SEND EMAIL TO USER(S)</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.emails.store') }}" method="POST" enctype="multipart/form-data" id="createEmailForm">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Subject <span class="text-danger">*</span></label>
                                        <input type="text" name="email_title"
                                            class="form-control @error('email_title') is-invalid @enderror"
                                            value="{{ old('email_title') }}" placeholder="Enter email subject" required>
                                        @error('email_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">User Type <span class="text-danger">*</span></label>
                                        <select name="user_type" id="userType" style="height: 45px !important;"
                                            class="form-control @error('user_type') is-invalid @enderror" required>
                                            <option value="">-- Select Recipient Type --</option>
                                            <option value="all" {{ old('user_type') == 'all' ? 'selected' : '' }}>All Users</option>
                                            <option value="single" {{ old('user_type') == 'single' ? 'selected' : '' }}>Single User</option>
                                        </select>
                                        @error('user_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Single User Email (Hidden by default) -->
                                    <div class="col-md-12 mb-3" id="singleEmailContainer" style="display: none;">
                                        <label class="form-label">Recipient Email <span class="text-danger">*</span></label>
                                        <input type="email" name="recipient_email" id="recipientEmail"
                                            class="form-control @error('recipient_email') is-invalid @enderror"
                                            value="{{ old('recipient_email') }}"
                                            placeholder="Enter recipient email address">
                                        @error('recipient_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email Content with Summernote -->
                                    <div class="col-lg-12 mb-4">
                                        <label class="form-label">Email Content <span class="text-danger">*</span></label>
                                        <textarea id="summernote" name="email_content" class="form-control bg-transparent" rows="5"
                                            placeholder="Enter text ...">{{ old('email_content') }}</textarea>
                                        @error('email_content')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Attachment Section -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Attachment (Optional)</label>
                                        <div class="drag-drop-area" id="dragDropArea">
                                            <input type="file" name="attachment" id="attachmentInput" class="d-none"
                                                accept=".jpg,.jpeg,.png,.pdf">
                                            <div class="drag-drop-content text-center py-4">
                                                <i class="ti ti-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                                <p class="mb-1">Drag and drop file or <span class="text-primary"
                                                        style="cursor: pointer;"
                                                        onclick="document.getElementById('attachmentInput').click()">browse</span>
                                                </p>
                                                <small class="text-muted">JPG, PNG or PDF format • Max 5MB</small>
                                            </div>
                                            <div id="filePreview" class="mt-3" style="display: none;">
                                                <div class="d-flex align-items-center justify-content-between border rounded p-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ti ti-file me-2"></i>
                                                        <span id="fileName"></span>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="removeFile()">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('attachment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default" id="sendEmailBtn">
                                        Send Email <i class="ti ti-chevron-right ms-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('user.snippets.footer')
    </div>

    <style>
        .drag-drop-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .drag-drop-area.dragover {
            border-color: #0d6efd;
            background: #e7f1ff;
        }

        .drag-drop-content {
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
         

            // Toggle single email input
            const userTypeSelect = document.getElementById('userType');
            const singleEmailContainer = document.getElementById('singleEmailContainer');
            const recipientEmail = document.getElementById('recipientEmail');

            userTypeSelect.addEventListener('change', function() {
                if (this.value === 'single') {
                    singleEmailContainer.style.display = 'block';
                    recipientEmail.required = true;
                } else {
                    singleEmailContainer.style.display = 'none';
                    recipientEmail.required = false;
                    recipientEmail.value = ''; // Clear the input
                }
            });

            // Initialize on page load if single is selected
            if (userTypeSelect.value === 'single') {
                singleEmailContainer.style.display = 'block';
                recipientEmail.required = true;
            }

            // Drag and Drop functionality
            const dragDropArea = document.getElementById('dragDropArea');
            const attachmentInput = document.getElementById('attachmentInput');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, () => {
                    dragDropArea.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, () => {
                    dragDropArea.classList.remove('dragover');
                }, false);
            });

            dragDropArea.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    attachmentInput.files = files;
                    handleFileSelect(files[0]);
                }
            });

            attachmentInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    handleFileSelect(this.files[0]);
                }
            });

            function handleFileSelect(file) {
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                const maxSize = 5 * 1024 * 1024;

                if (!validTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload JPG, PNG or PDF files only.');
                    attachmentInput.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    alert('File size exceeds 5MB. Please choose a smaller file.');
                    attachmentInput.value = '';
                    return;
                }

                fileName.textContent = file.name;
                filePreview.style.display = 'block';
            }

            window.removeFile = function() {
                attachmentInput.value = '';
                filePreview.style.display = 'none';
            }

            // Handle form submission
            const form = document.getElementById('createEmailForm');
            const submitButton = document.getElementById('sendEmailBtn');

            form.addEventListener('submit', function(e) {
                // Validate Summernote content
                const content = $('#summernote').summernote('code');
                const textContent = $('<div>').html(content).text().trim();

                if (textContent.length === 0) {
                    e.preventDefault();
                    alert('Please enter email content.');
                    return false;
                }

                // Show loading state
                submitButton.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Sending Email...';
                submitButton.disabled = true;
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                }, 5000);
            });
        });
    </script>
@endsection