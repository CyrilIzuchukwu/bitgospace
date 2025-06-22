@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Deposit History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Deposits</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Deposit Records</h3>
                    <p class="text-muted w-100 m-auto">
                        Complete history of all your deposit transactions
                    </p>
                </div>

                @if($transactions->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No deposit transactions found</p>
                            <span class="text-gray-100">You currently don't have any deposit history.</span>
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
                                    <select class="form-select form-select-sm status-select">
                                        <option value="all" selected>All Statuses</option>
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
                                                <td class="text-success">${{ number_format($transaction->amount, 2) }}</td>
                                                <td>{{ number_format($transaction->crypto_amount, 8) }}</td>
                                                <td>
                                                    @if($transaction->status == 'completed')
                                                    <span class="badge bg-success-subtle text-success p-1">Completed</span>
                                                    @elseif($transaction->status == 'rejected')
                                                    <span class="badge bg-danger-subtle text-danger p-1">Rejected</span>
                                                    @else
                                                    <span class="badge bg-warning-subtle text-warning p-1">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->currency }}</td>
                                                <td>{{ $transaction->deposit->payment_method ?? 'N/A' }}</td>
                                                <td>{{ $transaction->created_at->format('M j, Y') }}</td>
                                                <td class="text-center">
                                                    @if($transaction->status == 'pending')
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <form action="{{ route('deposit.cancel', $transaction->id) }}" class="cancel-form" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger cancel-button">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">No actions available</span>
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

    @include('user.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter transactions by status
        const statusSelect = document.querySelector('.status-select');

        statusSelect.addEventListener('change', function() {
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

        // Cancel confirmation
        const cancelButtons = document.querySelectorAll('.cancel-button');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Cancel Deposit',
                    text: "Are you sure you want to cancel this deposit request?",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const originalText = this.innerHTML;
                        this.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Processing...
                        `;
                        this.disabled = true;

                        // Submit the form
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>

@endsection
