@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Media Library</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Media Library</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Media Library</h3>
                    <p class="text-muted w-100 m-auto">
                        Manage all video content in your media library
                    </p>
                </div>

                @if($videos->isEmpty())

                <div class="no-investment">
                    <div class="card-header d-flex flex-wrap justify-content-end align-items-end gap-2">
                        <div class="w-auto">
                            <a href="{{ route('admin.add-video') }}" class="btn btn-primary bg-gradient">
                                <i class="ti ti-plus me-1"></i> Add Video
                            </a>
                        </div>
                    </div>
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No media files found</p>
                            <span class="text-gray-100">Your media library is currently empty.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">Video List</h4>
                                <div class="w-auto">
                                    <a href="{{ route('admin.add-video') }}" class="btn btn-primary bg-gradient">
                                        <i class="ti ti-plus me-1"></i> Add Video
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <!-- <th scope="col" class="text-muted">Reference ID</th> -->
                                                <!-- <th scope="col" class="text-muted">Title</th> -->
                                                <th scope="col" class="text-muted">Language</th>
                                                <th scope="col" class="text-muted">Preview</th>
                                                <th scope="col" class="text-muted">Date Added</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($videos as $video)
                                            <tr>
                                                <!-- <td>{{ $video->reference_id }}</td> -->
                                                <!-- <td>
                                                    <h6 class="mb-0">{{ $video->title }}</h6>
                                                    <small class="text-muted">{{ Str::limit($video->description, 30) }}</small>
                                                </td> -->
                                                <td>{{ ucfirst($video->language) }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($video->video_path) }}"
                                                        class="btn btn-sm btn-info"
                                                        target="_blank">
                                                        <i class="ti ti-eye me-1"></i> Preview
                                                    </a>
                                                </td>
                                                <td>{{ $video->created_at->format('M j, Y') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('admin.edit-video', ['reference' => $video->reference_id, 'language' => $video->language]) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.delete-video', ['reference' => $video->reference_id, 'language' => $video->language]) }}"
                                                            method="POST"
                                                            class="delete-video-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-video">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-top border-light">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">{{ $videos->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $videos->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $videos->total() }}</span> Videos
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $videos->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @include('admin.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete video confirmation
        const deleteButtons = document.querySelectorAll('.delete-video');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Delete Video',
                    text: 'Are you sure you want to delete this video?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Deleting...
                        `;
                        this.disabled = true;
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
