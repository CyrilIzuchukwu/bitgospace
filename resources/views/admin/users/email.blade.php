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
                                    <h3 class="mb-2">SEND EMAIL TO USER</h3>
                                    <p class="text-muted">{{ $userEmail->name }} ({{ $userEmail->email }})</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.users.email.send', $userEmail->id) }}" method="POST"
                            enctype="multipart/form-data" id="singleUserEmailForm">
                            @csrf

                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Recipient Email</label>
                                    <input type="email" name="email" value="{{ $userEmail->email }}"
                                        class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Title <span class="text-danger">*</span></label>
                                    <input type="text" name="email_title" placeholder="Email title"
                                        value="{{ old('email_title') }}"
                                        class="form-control @error('email_title') is-invalid @enderror" required>
                                    @error('email_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Content <span class="text-danger">*</span></label>
                                    <textarea id="summernote" name="email_content" class="form-control bg-transparent" rows="5"
                                        placeholder="Enter text ...">{{ old('email_content') }}</textarea>
                                    @error('email_content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Multiple Attachments Section -->
                                <div class="mb-3">
                                    <label class="form-label">Attachments (Optional) <span class="text-muted">- Max 5 files</span></label>
                                    <div class="drag-drop-area" id="dragDropArea">
                                        <input type="file" name="attachments[]" id="attachmentInput" class="d-none"
                                            accept=".jpg,.jpeg,.png,.pdf" multiple>
                                        <div class="drag-drop-content text-center py-4">
                                            <i class="ti ti-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                                            <p class="mb-1">Drag and drop files or <span class="text-primary"
                                                    style="cursor: pointer;"
                                                    onclick="document.getElementById('attachmentInput').click()">browse</span>
                                            </p>
                                            <small class="text-muted">JPG, PNG or PDF format • Max 5MB per file • Max 5 files</small>
                                        </div>
                                        <div id="filePreviewContainer" class="mt-3" style="display: none;">
                                            <!-- File previews will be added here dynamically -->
                                        </div>
                                    </div>
                                    @error('attachments')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('attachments.*')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default" id="sendEmailBtn">
                                        Send Email <i class="ti ti-chevron-right ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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

        .file-preview-item {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedFiles = [];
            const maxFiles = 5;
            const maxFileSize = 5 * 1024 * 1024; // 5MB

            // Drag and Drop functionality
            const dragDropArea = document.getElementById('dragDropArea');
            const attachmentInput = document.getElementById('attachmentInput');
            const filePreviewContainer = document.getElementById('filePreviewContainer');

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
                const files = Array.from(dt.files);
                handleFiles(files);
            });

            attachmentInput.addEventListener('change', function() {
                const files = Array.from(this.files);
                handleFiles(files);
            });

            function handleFiles(files) {
                if (selectedFiles.length + files.length > maxFiles) {
                    alert(`You can only upload a maximum of ${maxFiles} files.`);
                    return;
                }

                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

                for (let file of files) {
                    if (!validTypes.includes(file.type)) {
                        alert(`Invalid file type: ${file.name}. Please upload JPG, PNG or PDF files only.`);
                        continue;
                    }

                    if (file.size > maxFileSize) {
                        alert(`File size exceeds 5MB: ${file.name}. Please choose a smaller file.`);
                        continue;
                    }

                    selectedFiles.push(file);
                }

                updateFileList();
                updateInputFiles();
            }

            function updateFileList() {
                if (selectedFiles.length === 0) {
                    filePreviewContainer.style.display = 'none';
                    return;
                }

                filePreviewContainer.style.display = 'block';
                filePreviewContainer.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-preview-item d-flex align-items-center justify-content-between';
                    fileItem.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="ti ti-file me-2"></i>
                            <span>${file.name}</span>
                            <small class="text-muted ms-2">(${formatFileSize(file.size)})</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFile(${index})">
                            <i class="ti ti-trash"></i>
                        </button>
                    `;
                    filePreviewContainer.appendChild(fileItem);
                });
            }

            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                attachmentInput.files = dataTransfer.files;
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateFileList();
                updateInputFiles();
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            // Handle form submission
            const form = document.getElementById('singleUserEmailForm');
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
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Sending Email...';
                submitButton.disabled = true;
            });
        });
    </script>
@endsection
