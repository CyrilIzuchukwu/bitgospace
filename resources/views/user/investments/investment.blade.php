@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Investment History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">BitGoSpace</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Investment Portfolio</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all your current and completed investments
                    </p>
                </div>

                @if($investments->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="https://gekoinvests.com/theme/assets/dist/images/not-found.png" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No active investments found</p>
                            <span class="text-gray-100">You currently don't have any investments. Start investing to see them here.</span>
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
                                        <option value="active">Active</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('user.trades') }}" class="btn btn-primary bg-gradient"><i class="ti ti-file-import me-1"></i>New Investment</a>
                                </div>

                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">Plan</th>
                                                <th scope="col" class="text-muted">Amount</th>
                                                <th scope="col" class="text-muted">Daily Profit</th>
                                                <th scope="col" class="text-muted">Profit</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Start Date</th>
                                                <th scope="col" class="text-muted">End Date</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($investments as $investment)
                                            <tr data-status="{{ $investment->due ? 'completed' : 'active' }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar-xs bg-primary-subtle text-primary rounded p-1">
                                                                <i class="ti ti-pig-money fs-4"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h6 class="mb-0">{{ $investment->plan->name }}</h6>
                                                            <small class="text-muted">{{ $investment->plan->duration }} days</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>${{ number_format($investment->amount, 2) }}</td>
                                                <td>${{ number_format($investment->amount * $investment->plan->interest_rate / 100, 2) }}</td>
                                                <td>${{ number_format($investment->profit, 2) }}</td>
                                                <td>
                                                    @if($investment->due)
                                                    <span class="badge p-1 bg-success-subtle text-success">Completed</span>
                                                    @else
                                                    <span class="badge p-1 bg-primary-subtle text-primary">Running</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($investment->start_date)->format('M j, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($investment->end_date)->format('M j, Y') }}</td>
                                                <td class="text-center">
                                                    @if($investment->due && !$investment->withdrawn)
                                                    <form action="{{ route('user.investment.withdraw', $investment->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success withdraw-button">
                                                            <i class="ti ti-cash me-1"></i> Withdraw
                                                        </button>
                                                    </form>
                                                    @elseif(!$investment->due)
                                                    <span class="text-muted">Ongoing</span>
                                                    @else
                                                    <span class="badge bg-secondary-subtle p-1 text-secondary">Withdrawn</span>
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
                                            Showing <span class="fw-semibold">{{ $investments->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $investments->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $investments->total() }}</span> Investments
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $investments->links('vendor.pagination.bootstrap-5') }}
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
        // Filter investments by status
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const withdrawButtons = document.querySelectorAll('.withdraw-button');

        withdrawButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const investmentName = this.closest('tr').querySelector('h6').textContent;
                const profitAmount = this.closest('tr').querySelectorAll('td')[3].textContent;

                Swal.fire({
                    title: 'Withdraw Profit',
                    html: `Are you sure you want to withdraw <strong>${profitAmount}</strong> from <strong>${investmentName}</strong>?`,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, withdraw it!',
                    cancelButtonText: 'Cancel'
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
