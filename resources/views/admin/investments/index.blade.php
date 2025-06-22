@extends('layouts.admin')
@section('content')

<div class="page-content">

    <div class="page-container">


        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Investments</h4> -->
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">BitGoSpace</a></li>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Investments</h2>

                    <div class="d-flex gap-2">
                        <form class="d-flex" method="GET">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search users..." value="{{ request('search') }}">
                            <select name="status" class="form-select me-2">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr class="text-uppercase fs-10 text-nowrap">
                                <th>User</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Profit</th>
                                <th>Status</th>
                                <th>Dates</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($investments as $investment)
                            <tr>
                                <td>
                                    <a href="">
                                        {{ $investment->user->name }}
                                    </a>
                                </td>
                                <td>{{ $investment->plan->name }} ({{ $investment->plan->duration }} days)</td>
                                <td>${{ number_format($investment->amount, 2) }}</td>
                                <td>${{ number_format($investment->profit, 2) }}</td>
                                <td>
                                    @if($investment->withdrawn)
                                    <span class="badge bg-secondary">Withdrawn</span>
                                    @elseif($investment->due)
                                    <span class="badge bg-success">Completed</span>
                                    @else
                                    <span class="badge bg-primary">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ $investment->start_date->format('M d') }} -
                                        {{ $investment->end_date->format('M d, Y') }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.investments.show', $investment) }}" class="btn btn-sm btn-info">
                                        <i class="ti ti-eye"></i>
                                    </a>

                                    <!-- @if(!$investment->due)
                                    <form action="{{ route('admin.investments.cancel', $investment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this investment?')">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </form>
                                    @endif -->
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No investments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer border-top border-light">
                <div class="align-items-center justify-content-between row text-center text-sm-start">
                    <div class="col-sm">
                        <div class="text-muted">
                            Showing <span class="fw-semibold text-body">{{ $investments->firstItem() }}</span> to
                            <span class="fw-semibold text-body">{{ $investments->lastItem() }}</span> of
                            <span class="fw-semibold">{{ $investments->total() }}</span> Transactions
                        </div>
                    </div>
                    <div class="col-sm-auto mt-3 mt-sm-0">
                        {{ $investments->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>



        <!-- end row -->

    </div>

    @include('admin.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectFilter = document.querySelector('.form-select');
        const tableRows = document.querySelectorAll('.table-card tbody tr[data-status]');
        const noTransactionsRow = document.querySelector('.no-transactions-message.d-none');

        selectFilter.addEventListener('change', function() {
            const selected = this.value.toLowerCase();
            let hasVisible = false;

            tableRows.forEach(row => {
                const status = row.getAttribute('data-status').toLowerCase();

                if (selected === 'all' || selected === status) {
                    row.classList.remove('d-none');
                    hasVisible = true;
                } else {
                    row.classList.add('d-none');
                }
            });

            // Show or hide the "No transactions found" row
            if (hasVisible) {
                noTransactionsRow.classList.add('d-none');
            } else {
                noTransactionsRow.classList.remove('d-none');
            }
        });
    });
</script>
@endsection
