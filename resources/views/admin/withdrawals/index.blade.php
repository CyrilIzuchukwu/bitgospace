@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Withdrawal History</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Withdrawals</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Withdrawal Requests</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all withdrawal requests from users
                    </p>
                </div>

                @if($withdrawals->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No withdrawal requests found</p>
                            <span class="text-gray-100">There are currently no pending withdrawal requests.</span>
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
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Amount</th>
                                                <th scope="col" class="text-muted">Method</th>
                                                <th scope="col" class="text-muted">Wallet Address</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Date Requested</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($withdrawals as $withdrawal)
                                            <tr data-status="{{ strtolower($withdrawal->status) }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $withdrawal->user->name }}</h6>
                                                            <small class="text-muted">{{ $withdrawal->user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>${{ number_format($withdrawal->amount, 2) }}</td>
                                                <td>{{ strtoupper($withdrawal->payment_method) }}</td>
                                                <td class="" style="max-width: 150px; text-wrap: wrap; word-break: break;">
                                                    <span class="wallet-address" style="cursor: pointer;" data-wallet="{{ $withdrawal->wallet_address }}">
                                                        {{ $withdrawal->wallet_address }}
                                                    </span>
                                                    <button type="button" class="btn btn-link btn-sm p-0 ms-1 copy-wallet" data-wallet="{{ $withdrawal->wallet_address }}" title="Copy">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    @if($withdrawal->status == 'pending')
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
                                                    @elseif($withdrawal->status == 'completed')
                                                    <span class="badge p-1 bg-success-subtle text-success">Completed</span>
                                                    @else
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>{{ $withdrawal->created_at->format('M j, Y') }}</td>
                                                <td class="text-center">
                                                    @if($withdrawal->status == 'pending')
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success approve-button">
                                                                <!-- <i class="ti ti-check me-1"></i> -->
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger reject-button">
                                                                <!-- <i class="ti ti-x me-1"></i> -->
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

    @include('admin.snippets.footer')
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

        // Approval confirmation
        const approveButtons = document.querySelectorAll('.approve-button');
        approveButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Approve Withdrawal',
                    text: 'Are you sure you want to approve this withdrawal?',
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
                    title: 'Reject Withdrawal',
                    text: 'Are you sure you want to reject this withdrawal?',
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

<!-- script to copy  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to copy wallet address
        function copyWalletAddress(walletAddress, button) {
            // Create a temporary input element
            const tempInput = document.createElement('input');
            tempInput.value = walletAddress;
            document.body.appendChild(tempInput);

            // Select the text
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices

            try {
                // Copy the text
                document.execCommand('copy');

                // Change icon to checkmark
                const icon = button.querySelector('i');
                icon.classList.remove('ti-copy');
                icon.classList.add('ti-check');

                // Revert back after 3 seconds
                setTimeout(() => {
                    icon.classList.remove('ti-check');
                    icon.classList.add('ti-copy');
                }, 3000);

                // Optional: Show a tooltip or notification
                // You can implement a toast notification here if needed
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }

            // Remove the temporary input
            document.body.removeChild(tempInput);
        }

        // Add click event to all copy buttons
        document.querySelectorAll('.copy-wallet').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const walletAddress = this.getAttribute('data-wallet');
                copyWalletAddress(walletAddress, this);
            });
        });

        // Add click event to wallet address text for mobile users
        document.querySelectorAll('.wallet-address').forEach(wallet => {
            wallet.addEventListener('click', function() {
                const walletAddress = this.getAttribute('data-wallet');
                const copyButton = this.nextElementSibling;
                copyWalletAddress(walletAddress, copyButton);
            });
        });
    });
</script>

@endsection