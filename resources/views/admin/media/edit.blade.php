@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="page-container">

        <!-- Title & Breadcrumb -->
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3">
            <div class="flex-grow-1">
                <!-- <h4 class="mb-0">Edit Video</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.media.list') }}">Media Library</a></li>
                    <li class="breadcrumb-item active">Edit Video</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">

                <!-- Title and Description -->
                <div class="text-center mb-4">
                    <h3 class="mb-2">Edit Video: {{ $video->title }}</h3>
                    <p class="text-muted w-100 w-md-75 m-auto">
                        Update your video details or replace the video file while maintaining the same reference ID.
                    </p>
                </div>

                <div class="card position-relative deposit-wrapper">
                    <div class="card-body">

                        <!-- Edit Form -->
                        <form id="videoEditForm" action="{{ route('admin.update-video', ['reference' => $video->reference_id, 'language' => $video->language]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Video Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $video->title) }}"
                                    placeholder="Enter video title" required>
                                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-select" id="language" name="language" required>
                                    <option value="" disabled>Select Language</option>
                                    <option value="english" {{ old('language', $video->language) == 'english' ? 'selected' : '' }}>English</option>
                                    <option value="spanish" {{ old('language', $video->language) == 'spanish' ? 'selected' : '' }}>Spanish</option>
                                    <option value="french" {{ old('language', $video->language) == 'french' ? 'selected' : '' }}>French</option>
                                    <option value="russia" {{ old('language', $video->language) == 'russia' ? 'selected' : '' }}>Russian</option>
                                    <option value="chinese" {{ old('language', $video->language) == 'chinese' ? 'selected' : '' }}>Chinese</option>
                                </select>
                                @error('language') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Video File</label>
                                <div class="border rounded p-3 text-center bg-light" id="videoDropArea" style="cursor:pointer;">
                                    <input type="file" class="form-control d-none" id="videoInput" name="video" accept="video/*">
                                    <div id="uploadAreaContent">
                                        <i class="ti ti-video text-primary display-6 mb-2"></i>
                                        <p class="mb-0 text-muted">Click here or drag & drop to replace current video</p>
                                        <small class="text-muted d-block">Current: {{ basename($video->video_path) }}</small>
                                        <small class="text-muted d-block">Max file size: 50MB. Formats: MP4, MOV, AVI</small>
                                    </div>
                                    <div id="videoPreviewContainer" class="mt-3">
                                        <video id="videoPreview" width="100%" controls style="max-height: 300px;">
                                            <source src="{{ Storage::url($video->video_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                @error('video') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Add a description">{{ old('description', $video->description) }}</textarea>
                                @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress mb-3 d-none" id="uploadProgressWrapper" style="height: 8px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgress" style="width: 0%;"></div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="submit-btn btn-default flex-grow-1">
                                    Update Video <i class="ti ti-upload ms-1"></i>
                                </button>
                                <a href="{{ route('admin.media.list') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Upload & Preview Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('videoEditForm');
        const fileInput = document.getElementById('videoInput');
        const dropArea = document.getElementById('videoDropArea');
        const preview = document.getElementById('videoPreview');
        const progressWrapper = document.getElementById('uploadProgressWrapper');
        const progressBar = document.getElementById('uploadProgress');
        const submitBtn = form.querySelector('button[type="submit"]');

        const redirectUrl = @json(route('admin.media.list'));

        // Open file dialog on drop area click
        dropArea.addEventListener('click', () => fileInput.click());

        // Preview selected video when replacing
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('video/')) {
                const url = URL.createObjectURL(file);
                preview.src = url;
            }
        });

        // Upload progress (XHR)
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');

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
                        window.location.href = redirectUrl;
                    } else {
                        alert('Update failed. Please try again.');
                        location.reload();
                    }
                }
            };

            xhr.send(formData);
        });
    });
</script>
@endsection
