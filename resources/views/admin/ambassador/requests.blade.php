@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">Ambassador Requests</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ambassador Requests</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Pending Ambassador Requests</h3>
                    <p class="text-muted w-100 m-auto">
                        Review and manage ambassador applications
                    </p>
                </div>

                @if($requests->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No pending requests</p>
                            <span class="text-gray-100">There are currently no pending ambassador requests.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive table-card ambassador-requests-table">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Phone</th>
                                                <th scope="col" class="text-muted">Balance</th>
                                                {{-- <th scope="col" class="text-muted">Requested At</th> --}}
                                                <th scope="col" class="text-muted text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests as $request)
                                            <tr onclick="window.location='{{ route('admin.users.show', $request->id) }}'" style="cursor: pointer;">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{ $request->profile && $request->profile->profile_picture ? asset('storage/profile_pictures/' . $request->profile->profile_picture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}" class="rounded-circle profile" width="40" alt="User">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $request->name }}</h6>
                                                            <small class="text-muted">{{ $request->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $request->profile->phone ?? 'N/A' }}</td>
                                                <td>${{ number_format($request->balance, 2) }}</td>
                                                {{-- <td>{{ $request->created_at ? $request->created_at->diffForHumans() : 'N/A' }}</td> --}}
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <form action="{{ route('admin.ambassador.approve', $request->id) }}" method="POST" class="approve-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success approve-button">
                                                                <i class="ti ti-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.ambassador.reject', $request->id) }}" method="POST" class="reject-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger reject-button">
                                                                <i class="ti ti-x me-1"></i> Reject
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
                                            Showing <span class="fw-semibold">{{ $requests->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $requests->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $requests->total() }}</span> Requests
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $requests->links('vendor.pagination.bootstrap-5') }}
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
        // Confirmation dialogs
        const actions = [{
                selector: '.approve-button',
                text: 'approve this ambassador request',
                confirmText: 'Yes, Approve!',
                confirmColor: '#28a745'
            },
            {
                selector: '.reject-button',
                text: 'reject this ambassador request',
                confirmText: 'Yes, Reject!',
                confirmColor: '#d33'
            }
        ];

        actions.forEach(action => {
            document.querySelectorAll(action.selector).forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const form = this.closest('form');

                    Swal.fire({
                        title: `Are you sure?`,
                        text: `You are about to ${action.text}`,
                        showCancelButton: true,
                        confirmButtonColor: action.confirmColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: action.confirmText
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            const originalText = this.innerHTML;
                            this.innerHTML = `
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Processing...
                            `;
                            this.disabled = true;
                            form.submit();
                        }
                    });
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.approve-button, .reject-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .ambassador-requests-table tbody td .profile {
        width: 40px !important;
        height: 40px !important;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

@endsection
