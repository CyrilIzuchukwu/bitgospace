@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">KYC History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">KYC Verifications</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">KYC Verification History</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all your KYC verification Request
                    </p>
                </div>

                @if($kycs->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No KYC history found</p>
                            <span class="text-gray-100">No KYC verification requests yet.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div class="w-auto">
                                    <select class="form-select form-select-sm filter-select">
                                        <option value="all" selected>All</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_review">In Review</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <!-- <a href="{{ route('user.kyc') }}" class="btn btn-primary bg-gradient"><i class="ti ti-plus me-1"></i>New KYC Request</a> -->
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <!-- <th scope="col" class="text-muted">User</th> -->
                                                <th scope="col" class="text-muted">Document Type</th>
                                                <th scope="col" class="text-muted">Country</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Submitted At</th>
                                                <!-- <th scope="col" class="text-muted">Reviewed At</th> -->
                                                <th scope="col" class="text-muted">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kycs as $kyc)
                                            <tr data-status="{{ strtolower($kyc->status) }}">
                                                <!-- <td>{{ $kyc->user->name }}<br><small>{{ $kyc->user->email }}</small></td> -->
                                                <td>{{ ucfirst(str_replace('_', ' ', $kyc->document_type)) }}</td>
                                                <td>
                                                    @if($kyc->country_flag)
                                                    <img src="{{ $kyc->country_flag }}" alt="{{ $kyc->country }}" class="me-2" style="height: 20px;">
                                                    @endif
                                                    {{ $kyc->country }}
                                                </td>
                                                <td>
                                                    @if($kyc->status == 'pending')
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
                                                    @elseif($kyc->status == 'approved')
                                                    <span class="badge p-1 bg-success-subtle text-success">Approved</span>
                                                    @elseif($kyc->status == 'rejected')
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Rejected</span>
                                                    @else
                                                    <span class="badge p-1 bg-info-subtle text-info">In Review</span>
                                                    @endif
                                                </td>
                                                <td>{{ $kyc->created_at->format('M j, Y H:i') }}</td>
                                                <!-- <td>
                                                    @if($kyc->reviewed_at)
                                                    {{ $kyc->reviewed_at->format('M j, Y H:i') }}
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td> -->
                                                <td>
                                                    <a href="{{ route('admin.kyc.show', $kyc->id) }}" class="btn btn-sm btn-outline-primary">
                                                        Review
                                                    </a>
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
                                            Showing <span class="fw-semibold">{{ $kycs->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $kycs->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $kycs->total() }}</span> KYC Requests
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $kycs->links('vendor.pagination.bootstrap-5') }}
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
        // Filter KYC by status
        const filterSelect = document.querySelector('.filter-select');
        filterSelect.addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        });
    });
</script>

@endsection
