@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Withdrawal History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Withdrawals</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title"  style="text-transform: uppercase;">Withdrawal History</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all your withdrawal requests
                    </p>
                </div>

                @if($withdrawals->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No withdrawal history found</p>
                            <span class="text-gray-100">You haven't made any withdrawal requests yet.</span>
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
                                        <option value="completed">Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('user.withdrawal') }}" class="btn btn-primary bg-gradient"><i class="ti ti-plus me-1"></i>New Withdrawal</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <!-- <th scope="col" class="text-muted">Reference</th> -->
                                                <th scope="col" class="text-muted">Amount</th>
                                                <th scope="col" class="text-muted">Method</th>
                                                <th scope="col" class="text-muted">Wallet Address</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Date Requested</th>
                                                <th scope="col" class="text-muted">Date Processed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($withdrawals as $withdrawal)
                                            <tr data-status="{{ strtolower($withdrawal->status) }}">
                                                <!-- <td>{{ $withdrawal->reference }}</td> -->
                                                <td>${{ number_format($withdrawal->amount, 2) }}</td>
                                                <td>{{ strtoupper($withdrawal->payment_method) }}</td>
                                                <td class="text-truncate" style="max-width: 150px;">{{ $withdrawal->wallet_address }}</td>
                                                <td>
                                                    @if($withdrawal->status == 'pending')
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
                                                    @elseif($withdrawal->status == 'completed')
                                                    <span class="badge p-1 bg-success-subtle text-success">Completed</span>
                                                    @else
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M j, Y') }}</td>
                                                <td>
                                                    @if($withdrawal->status != 'pending')
                                                    {{ \Carbon\Carbon::parse($withdrawal->updated_at)->format('M j, Y') }}
                                                    @else
                                                    <span class="text-muted">-</span>
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
                                            Showing <span class="fw-semibold">{{ $withdrawals->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $withdrawals->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $withdrawals->total() }}</span> Withdrawals
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $withdrawals->links('vendor.pagination.bootstrap-5') }}
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
        // Filter withdrawals by status
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
