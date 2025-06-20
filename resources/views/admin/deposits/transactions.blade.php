@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Deposit Transactions</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Deposits</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Deposit Requests</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all deposit requests from users
                    </p>
                </div>

                @if($transactions->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No deposit requests found</p>
                            <span class="text-gray-100">There are currently no pending deposit requests.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">All Deposits</h4>
                                <div class="w-auto">
                                    <select class="form-select form-select-sm filter-select">
                                        <option value="all" selected>All</option>
                                        <option value="completed">Completed</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Amount</th>
                                                <th scope="col" class="text-muted">Crypto Amount</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Currency</th>
                                                <th scope="col" class="text-muted">Payment Method</th>
                                                <th scope="col" class="text-muted">Date</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr data-status="{{ strtolower($transaction->status) }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs me-2">
                                                            <span class="avatar-title bg-primary-subtle text-primary fw-semibold rounded-circle">
                                                                {{ substr($transaction->user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $transaction->user->name }}</h6>
                                                            <small class="text-muted">{{ $transaction->user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-success">${{ number_format($transaction->amount, 2) }}</td>
                                                <td>{{ number_format($transaction->crypto_amount, 8) }}</td>
                                                <td>
                                                    @if($transaction->status == 'completed')
                                                    <span class="badge p-1 bg-success-subtle text-success">Completed</span>
                                                    @elseif($transaction->status == 'rejected')
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Rejected</span>
                                                    @else
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->currency }}</td>
                                                <td>{{ $transaction->deposit->payment_method ?? 'N/A' }}</td>
                                                <td>{{ $transaction->created_at->format('M j, Y') }}</td>
                                                <td class="text-center">
                                                    @if($transaction->status == 'pending')
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <form action="{{ route('deposit.approve', $transaction->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success approve-button">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('deposit.reject', $transaction->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger reject-button">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">Processed</span>
                                                    @endif
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
                                            Showing <span class="fw-semibold">{{ $transactions->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $transactions->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $transactions->total() }}</span> Deposits
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $transactions->links('vendor.pagination.bootstrap-5') }}
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
        // Filter deposits by status
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

        // Approval confirmation
        const approveButtons = document.querySelectorAll('.approve-button');
        approveButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Approve Deposit',
                    text: 'Are you sure you want to approve this deposit?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
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

        // Rejection confirmation
        const rejectButtons = document.querySelectorAll('.reject-button');
        rejectButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Reject Deposit',
                    text: 'Are you sure you want to reject this deposit?',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reject it!'
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
</script>

@endsection
