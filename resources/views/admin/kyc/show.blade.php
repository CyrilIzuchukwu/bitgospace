@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">KYC Review</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kyc') }}">KYC Verifications</a></li>
                    <li class="breadcrumb-item active">Review</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">KYC Verification Review</h5>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <span class="badge p-1
                                @if($kyc->status == 'pending') bg-warning-subtle text-warning
                                @elseif($kyc->status == 'approved') bg-success-subtle text-success
                                @elseif($kyc->status == 'rejected') bg-danger-subtle text-danger
                                @else bg-info-subtle text-info @endif">
                                {{ ucfirst($kyc->status) }}
                            </span>
                            <small class="text-muted">Submitted: {{ $kyc->created_at->format('M j, Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- User Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light bg-opacity-10">
                                        <h6 class="mb-0">User Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                @if($kyc->user->profile && $kyc->user->profile->profile_picture)
                                                <img src="{{ asset('storage/profile_pictures/' . $kyc->user->profile->profile_picture) }}"
                                                    alt="Profile"
                                                    class="rounded-circle"
                                                    width="70" height="70">
                                                @else
                                                <img src="{{ asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                                    alt="Default Profile"
                                                    class="rounded-circle"
                                                    width="70" height="70">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-0">{{ $kyc->user->name }}</h5>
                                                <p class="text-muted mb-0">{{ $kyc->user->email }}</p>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><strong>Registered:</strong> {{ $kyc->user->created_at->format('M j, Y') }}</li>
                                            <li class="mb-1"><strong>Last login:</strong> {{ $kyc->user->last_login_at?->diffForHumans() ?? 'Never' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Verification Details -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light bg-opacity-10">
                                        <h6 class="mb-0">Verification Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1"><strong>Document Type:</strong> {{ ucfirst(str_replace('_', ' ', $kyc->document_type)) }}</li>
                                            <li class="mb-1">
                                                <strong>Country:</strong>
                                                @if($kyc->country_flag)
                                                <img src="{{ $kyc->country_flag }}" alt="{{ $kyc->country }}" class="ms-2" style="height: 20px;">
                                                @endif
                                                {{ $kyc->country }}
                                            </li>
                                            <li class="mb-2"><strong>Status:</strong>
                                                <span class="badge p-1
                                                    @if($kyc->status == 'pending') bg-warning-subtle text-warning
                                                    @elseif($kyc->status == 'approved') bg-success-subtle text-success
                                                    @elseif($kyc->status == 'rejected') bg-danger-subtle text-danger
                                                    @else bg-info-subtle text-info @endif">
                                                    {{ ucfirst($kyc->status) }}
                                                </span>
                                            </li>
                                            @if($kyc->rejection_reason)
                                            <li class="mb-2"><strong>Rejection Reason:</strong> {{ $kyc->rejection_reason }}</li>
                                            @endif
                                            <li class="mb-2"><strong>Submitted At:</strong> {{ $kyc->created_at->format('M j, Y H:i') }}</li>
                                            @if($kyc->reviewed_at)
                                            <li class="mb-2"><strong>Reviewed At:</strong> {{ $kyc->reviewed_at->format('M j, Y H:i') }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Images -->
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-light bg-opacity-10">
                                        <h6 class="mb-0">Document Verification</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <!-- Front Image -->
                                            <div class="col-md-5 mb-3 mb-md-0">
                                                <div class="border rounded p-2 h-100">
                                                    <h6 class="text-center mb-3">Document</h6>
                                                    <div class="ratio ratio-4x3 bg-light bg-opacity-10 rounded">
                                                        <img src="{{ $kyc->front_image_url }}" alt="Front of Document" class="img-fluid object-fit-cover">
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Selfie Image -->
                                            <div class="col-md-5">
                                                <div class="border rounded p-2 h-100">
                                                    <h6 class="text-center mb-3">Profile Photo</h6>
                                                    <div class="ratio ratio-4x3 bg-light bg-opacity-10 rounded">
                                                        <img src="{{ $kyc->selfie_image_url }}" alt="Selfie with Document" class="img-fluid object-fit-cover">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approval Actions -->
                        @if(in_array($kyc->status, ['pending', 'in_review']))
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-light bg-opacity-10">
                                        <h6 class="mb-0">Review Actions</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                                            <form method="POST" action="{{ route('admin.kyc.approve', $kyc->id) }}" class="mb-0">
                                                @csrf
                                                <button type="submit" class="btn btn-success px-4 kyc-approve-button">
                                                    <i class="ti ti-check me-1"></i> Approve
                                                </button>
                                            </form>


                                            <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="ti ti-x me-1"></i> Reject
                                            </button>
                                        </div>
                                    </div>
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

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.kyc.reject', $kyc->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject KYC Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please specify the reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Approval confirmation for KYC
    document.addEventListener('DOMContentLoaded', function() {
        const kycApproveButtons = document.querySelectorAll('.kyc-approve-button');

        kycApproveButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const originalText = this.innerHTML;

                Swal.fire({
                    title: 'Approve KYC Verification',
                    text: 'Are you sure you want to approve this KYC submission?',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745', // Green color to match success
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        this.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Approving...
                    `;
                        this.disabled = true;

                        // Submit the form
                        form.submit();
                    } else {
                        // Restore button if cancelled
                        this.innerHTML = originalText;
                    }
                });
            });
        });
    });
</script>
@endsection
