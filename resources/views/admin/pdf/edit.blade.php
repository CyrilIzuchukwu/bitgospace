@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3">
            <div class="flex-grow-1">
                <h4 class="mb-0">Edit PDF Document</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.list') }}">PDF Documents</a></li>
                    <li class="breadcrumb-item active">Edit PDF</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="card-body">
                        <form id="pdfUploadForm" action="{{ route('admin.update-pdf', ['reference' => $pdf->reference_id, 'language' => $pdf->language]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-select" id="language" name="language" required>
                                    <option value="english" {{ $pdf->language == 'english' ? 'selected' : '' }}>English</option>
                                    <option value="spanish" {{ $pdf->language == 'spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="french" {{ $pdf->language == 'french' ? 'selected' : '' }}>French</option>
                                    <option value="russia" {{ $pdf->language == 'russia' ? 'selected' : '' }}>Russia</option>
                                    <option value="chinese" {{ $pdf->language == 'chinese' ? 'selected' : '' }}>Chinese</option>
                                </select>
                                @error('language') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">PDF Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="overview" {{ $pdf->type == 'overview' ? 'selected' : '' }}>Overview</option>
                                    <option value="bot" {{ $pdf->type == 'bot' ? 'selected' : '' }}>Bot</option>
                                </select>
                                @error('type') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current PDF</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="ti ti-file-text text-primary display-6"></i>
                                        <div>
                                            <p class="mb-1">{{ basename($pdf->pdf_path) }}</p>
                                            <a href="{{ Storage::disk('public')->url($pdf->pdf_path) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                View Current PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Replace PDF (Optional)</label>
                                <div class="border rounded p-3 text-center bg-light" id="pdfDropArea" style="cursor:pointer;">
                                    <input type="file" class="form-control d-none" id="pdfInput" name="pdf" accept=".pdf">
                                    <div id="uploadAreaContent">
                                        <i class="ti ti-file-upload text-primary display-6 mb-2"></i>
                                        <p class="mb-0 text-muted">Click here or drag & drop to select a new PDF file</p>
                                        <small class="text-muted d-block">Max file size: 20MB. Format: PDF</small>
                                    </div>
                                    <div id="pdfPreviewContainer" class="d-none mt-3">
                                        <div id="pdfPreviewMobile" class="d-block d-md-none">
                                            <i class="ti ti-file-text text-primary display-6 mb-2"></i>
                                            <p class="mb-1" id="pdfFileName"></p>
                                            <small class="text-muted" id="pdfFileSize"></small>
                                            <!-- <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="viewPdfBtn">View PDF</button> -->
                                        </div>
                                        <embed id="pdfPreviewDesktop" src="#" width="100%" height="500px" type="application/pdf" class="d-none d-md-block">
                                    </div>
                                </div>
                                @error('pdf') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="progress mb-3 d-none" id="uploadProgressWrapper" style="height: 8px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgress" style="width: 0%;"></div>
                            </div>

                            <button type="submit" class="submit-btn btn-default w-100">
                                Update PDF <i class="ti ti-edit ms-1"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('pdfUploadForm');
        const fileInput = document.getElementById('pdfInput');
        const dropArea = document.getElementById('pdfDropArea');
        const previewDesktop = document.getElementById('pdfPreviewDesktop');
        const previewMobile = document.getElementById('pdfPreviewMobile');
        const previewContainer = document.getElementById('pdfPreviewContainer');
        const progressWrapper = document.getElementById('uploadProgressWrapper');
        const progressBar = document.getElementById('uploadProgress');
        const submitBtn = form.querySelector('button[type="submit"]');
        const pdfFileName = document.getElementById('pdfFileName');
        const pdfFileSize = document.getElementById('pdfFileSize');
        const viewPdfBtn = document.getElementById('viewPdfBtn');

        // Check if mobile device
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Open file dialog on drop area click
        dropArea.addEventListener('click', () => fileInput.click());

        // Preview selected PDF
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type === 'application/pdf') {
                const url = URL.createObjectURL(file);

                if (isMobile()) {
                    // For mobile devices, show file info instead of embedding
                    pdfFileName.textContent = file.name;
                    pdfFileSize.textContent = formatFileSize(file.size);
                    previewDesktop.classList.add('d-none');
                    previewMobile.classList.remove('d-none');

                    // Set up view button
                    viewPdfBtn.onclick = function() {
                        window.open(url, '_blank');
                    };
                } else {
                    // For desktop, show embedded preview
                    previewDesktop.src = url;
                    previewDesktop.classList.remove('d-none');
                    previewMobile.classList.add('d-none');
                }

                previewContainer.classList.remove('d-none');
            }
        });

        // Handle drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('border-primary');
        }

        function unhighlight() {
            dropArea.classList.remove('border-primary');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }

        // Upload progress (XHR)
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    progressBar.style.width = percent + '%';
                }
            });

            xhr.onloadstart = function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...
                `;
                progressWrapper.classList.remove('d-none');
                progressBar.style.width = '0%';
            };

            xhr.onloadend = function() {
                progressBar.style.width = '100%';
            };

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Parse the JSON response if your backend returns one
                        let response = {};
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            response = {
                                success: true,
                                message: 'PDF updated successfully'
                            };
                        }

                        // Show success notification matching your existing style
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message || 'PDF updated successfully',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        }).then(() => {
                            window.location.href = "{{ route('admin.pdf.list') }}";
                        });

                    } else {
                        let errorMessage = 'Update failed. Please try again.';

                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            errorMessage = errorResponse.message || errorMessage;

                            // Check for validation errors
                            if (errorResponse.errors) {
                                errorMessage = Object.values(errorResponse.errors).join('<br>');
                            }
                        } catch (e) {
                            // If not JSON, use default message
                        }

                        // Show error notification matching your existing style
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: errorMessage,
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });

                        // Re-enable the submit button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Update PDF <i class="ti ti-edit ms-1"></i>';

                        // Hide progress bar
                        progressWrapper.classList.add('d-none');
                    }
                }
            };

            xhr.send(formData);
        });
    });
</script>
@endsection
