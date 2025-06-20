@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Media Library</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Media Library</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Video Library</h3>
                    <p class="text-muted w-100 m-auto">
                        Browse our collection of educational and training videos
                    </p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">Available Videos</h4>
                                <div class="w-auto">
                                    <select class="form-select form-select-sm language-select" id="languageFilter">
                                        @foreach($validLanguages as $lang)
                                        <option value="{{ $lang }}" {{ $lang == $language ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row" id="videoGrid">
                                    @foreach($videos as $video)
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card h-100 video-item">
                                            <div class="card-body p-0 position-relative">
                                                <div class="video-thumbnail-wrapper">
                                                    <div class="video-thumbnail" style="background-image: url('{{ asset('assets/images/banner/mission-img.png') }}');">
                                                        <div class="thumbnail-overlay"></div>
                                                        <div class="play-button" data-video-src="{{ Storage::url($video->video_path) }}" data-title="{{ $video->title }}">
                                                            <i class="ti ti-player-play"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-3 pb-0">
                                                    <h6 class="video-title mb-1">{{ $video->title }}</h6>
                                                    <span class="badge bg-primary-subtle text-primary">{{ ucfirst($language) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>

                                @if($videos->isEmpty())
                                <div class="no-investment" style="margin-top: 0px;">
                                    <div class="not-found">
                                        <div class="image-notfound">
                                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                                        </div>
                                        <div class="text-notfound">
                                            <p class="text-dark">No videos available</p>
                                            <span class="text-gray-100">There are currently no {{ ucfirst($language) }} videos available.</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.snippets.footer')
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="text-align: center;" id="videoModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2  p-0">
                <div class="ratio ratio-16x9">
                    <video id="modalVideoPlayer" controls style="width: 100%;">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .video-thumbnail {
        height: 350px;
        background-size: cover;
        background-position: center;
        position: relative;
        cursor: pointer;
        border-radius: 8px 8px 0 0;
        overflow: hidden;
    }

    .thumbnail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        transition: background-color 0.3s ease;
    }

    .video-item:hover .thumbnail-overlay {
        background-color: rgba(0, 0, 0, 0.5);
    }


    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .play-button i {
        font-size: 24px;
        color: white;
    }

    .video-item:hover .play-button {
        background-color: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%) scale(1.1);
    }

    .video-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #videoModal .modal-content {
        background-color: transparent;
        border: none;
    }

    #videoModal .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    #videoModal .modal-title {
        color: white;
    }

    #videoModal .btn-close {
        filter: invert(1);
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Video modal functionality
        const videoModalElement = document.getElementById('videoModal');
        const videoModal = new bootstrap.Modal(videoModalElement);
        const videoPlayer = document.getElementById('modalVideoPlayer');
        const videoModalTitle = document.getElementById('videoModalTitle');

        // Set up play buttons
        document.querySelectorAll('.play-button').forEach(button => {
            button.addEventListener('click', function() {
                const videoSrc = this.getAttribute('data-video-src');
                const videoTitle = this.getAttribute('data-title');

                // Set video source and title
                videoPlayer.src = videoSrc;
                videoModalTitle.textContent = videoTitle;

                // Show the modal
                videoModal.show();

                // Auto-play video when ready
                videoPlayer.oncanplay = function() {
                    videoPlayer.play().catch(e => console.log('Auto-play prevented:', e));
                };
            });
        });

        // Reset video when modal closes - IMPROVED VERSION
        videoModalElement.addEventListener('hidden.bs.modal', function() {
            if (videoPlayer) {
                // Pause the video
                videoPlayer.pause();

                // Reset time to beginning
                videoPlayer.currentTime = 0;

                // Remove the source
                videoPlayer.removeAttribute('src');

                // Force load to clear any buffered content
                videoPlayer.load();

                // Clear the oncanplay event handler
                videoPlayer.oncanplay = null;
            }
        });

        // Additional cleanup when modal is about to hide
        videoModalElement.addEventListener('hide.bs.modal', function() {
            if (videoPlayer) {
                videoPlayer.pause();
            }
        });

        // Language filter change handler
        document.getElementById('languageFilter').addEventListener('change', function() {
            const selectedLanguage = this.value;
            window.location.href = `{{ route('user.media') }}?language=${selectedLanguage}`;
        });
    });
</script>


@endsection
