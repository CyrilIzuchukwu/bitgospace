@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Transaction History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Transaction Records</h3>
                    <p class="text-muted w-100 m-auto">
                        Complete history of all your financial transactions
                    </p>
                </div>

                @if($transactions->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No transactions found</p>
                            <span class="text-gray-100">You currently don't have any transaction history.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-md-center align-items-start gap-2">

                                <h4 class="header-title me-auto">All Transactions</h4>

                                <div class="flex align-items-center gap-2">
                                    <div class="w-auto">
                                        <select class="form-select form-select-sm filter-select">
                                            <option value="all" selected>All</option>
                                            <option value="deposit">Deposits</option>
                                            <option value="withdrawal">Withdrawals</option>
                                            <option value="investment">Investments</option>
                                            <option value="profit">Profits</option>
                                        </select>
                                    </div>

                                    <div class="w-auto">
                                        <select class="form-select form-select-sm status-select">
                                            <option value="all" selected>All Statuses</option>
                                            <option value="completed">Completed</option>
                                            <option value="pending">Pending</option>
                                            <option value="failed">Failed</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">Date</th>
                                                <th scope="col" class="text-muted">Type</th>
                                                <th scope="col" class="text-muted">Amount</th>
                                                <!-- <th scope="col" class="text-muted">Description</th>
                                                <th scope="col" class="text-muted">Reference</th> -->
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted text-center text-md-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr data-type="{{ $transaction->type }}" data-status="{{ $transaction->status }}">
                                                <td>{{ $transaction->created_at->format('M j, Y h:i A') }}</td>
                                                <td>
                                                    @switch($transaction->type)
                                                    @case('deposit')
                                                    <span class="badge p-1 bg-info-subtle text-info">Deposit</span>
                                                    @break
                                                    @case('withdrawal')
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Withdrawal</span>
                                                    @break
                                                    @case('investment')
                                                    <span class="badge p-1 bg-primary-subtle text-primary">Investment</span>
                                                    @break
                                                    @case('investment_withdrawal')
                                                    <span class="badge p-1 bg-success-subtle text-success">Profit</span>
                                                    @break
                                                    @default
                                                    <span class="badge p-1 bg-secondary-subtle text-secondary">{{ $transaction->type }}</span>
                                                    @endswitch
                                                </td>
                                                <td class="{{ $transaction->type === 'investment_withdrawal' ? 'text-success' : ($transaction->type === 'investment' ? 'text-danger' : 'text-success') }}">
                                                    ${{ number_format($transaction->amount, 2) }}
                                                </td>
                                                <!-- <td>{{ $transaction->description }}</td>
                                                <td><small class="text-muted">{{ $transaction->reference }}</small></td> -->
                                                <td>
                                                    @switch($transaction->status)
                                                    @case('completed')
                                                    <span class="badge p-1 bg-success-subtle text-success">Completed</span>
                                                    @break
                                                    @case('pending')
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
                                                    @break
                                                    @case('failed')
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Failed</span>
                                                    @break
                                                    @default
                                                    <span class="badge p-1 bg-secondary-subtle text-secondary">{{ $transaction->status }}</span>
                                                    @endswitch
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-outline-primary view-details"
                                                        data-description="{{ $transaction->description }}"
                                                        data-amount="${{ number_format($transaction->amount, 2) }}"
                                                        data-date="{{ $transaction->created_at->format('M j, Y h:i A') }}"
                                                        data-status="{{ $transaction->status }}"
                                                        data-reference="{{ $transaction->reference }}"
                                                        data-type="{{ $transaction->type }}">
                                                        <i class="ti ti-eye"></i> Details
                                                    </button>
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
                                            <span class="fw-semibold">{{ $transactions->total() }}</span> Transactions
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

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="30%">Reference</th>
                                <td id="detail-reference"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td id="detail-date"></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td id="detail-type"></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td id="detail-amount"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detail-status"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="detail-description"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter transactions by type
        const filterSelect = document.querySelector('.filter-select');
        const statusSelect = document.querySelector('.status-select');

        function filterTransactions() {
            const type = filterSelect.value;
            const status = statusSelect.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const rowType = row.getAttribute('data-type');
                const rowStatus = row.getAttribute('data-status');

                const typeMatch = type === 'all' || rowType === type ||
                    (type === 'profit' && rowType === 'investment_withdrawal');
                const statusMatch = status === 'all' || rowStatus === status;

                row.style.display = typeMatch && statusMatch ? '' : 'none';
            });
        }

        filterSelect.addEventListener('change', filterTransactions);
        statusSelect.addEventListener('change', filterTransactions);

        // Transaction details modal
        const detailsModal = new bootstrap.Modal('#transactionDetailsModal');
        const viewButtons = document.querySelectorAll('.view-details');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('detail-reference').textContent = this.dataset.reference;
                document.getElementById('detail-date').textContent = this.dataset.date;
                document.getElementById('detail-amount').textContent = this.dataset.amount;
                document.getElementById('detail-description').textContent = this.dataset.description;

                // Format type
                let type = this.dataset.type;
                if (type === 'investment_withdrawal') type = 'Profit Withdrawal';
                document.getElementById('detail-type').textContent = type.charAt(0).toUpperCase() + type.slice(1);

                // Format status
                const status = this.dataset.status;
                let statusBadge = '';
                if (status === 'completed') {
                    statusBadge = '<span class="badge bg-success-subtle text-success">Completed</span>';
                } else if (status === 'pending') {
                    statusBadge = '<span class="badge bg-warning-subtle text-warning">Pending</span>';
                } else if (status === 'failed') {
                    statusBadge = '<span class="badge bg-danger-subtle text-danger">Failed</span>';
                } else {
                    statusBadge = `<span class="badge bg-secondary-subtle text-secondary">${status}</span>`;
                }
                document.getElementById('detail-status').innerHTML = statusBadge;

                detailsModal.show();
            });
        });
    });
</script>

@endsection
