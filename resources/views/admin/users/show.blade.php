@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">User Details</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                    <li class="breadcrumb-item active">User Details</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <!-- Combined Profile and Wallet Card -->
            <div class="col-md-12 user-details">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center align-items-center">
                            <!-- Left Side - Profile Info -->
                            <div class="col-md-5">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <img src="{{ $viewedUser->profile && $viewedUser->profile->profile_picture ? asset('storage/profile_pictures/' . $viewedUser->profile->profile_picture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                        alt="Profile" class="avatar-xl rounded-circle border border-light border-2 profile">
                                    <div>
                                        <h4 class="text-dark fw-medium">{{ $viewedUser->name }}</h4>
                                        <span class="badge {{ $viewedUser->active ? 'bg-success' : 'bg-danger' }} px-2 py-1 fs-12">
                                            {{ $viewedUser->active ? 'Active' : 'Banned' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fs-15">Contact Details:</h4>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="ti ti-mail fs-20 text-primary"></i>
                                            <p class="mb-0 text-dark">{{ $viewedUser->email }}</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="ti ti-phone fs-20 text-primary"></i>
                                            <p class="mb-0 text-dark">{{ $viewedUser->profile->phone ?? 'N/A' }}</p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-map-pin fs-20 text-primary"></i>
                                            <p class="mb-0 text-dark">
                                                {{ $viewedUser->profile->address ?? 'N/A' }},
                                                {{ $viewedUser->profile->city ?? '' }}
                                                {{ $viewedUser->profile->state ?? '' }},
                                                {{ $viewedUser->profile->country ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fs-15">KYC Status:</h4>
                                    @php
                                    $latestKyc = $viewedUser->kycVerifications()->latest()->first();
                                    @endphp
                                    @if($latestKyc)
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <span class="badge p-1
                                        @if($latestKyc->status == 'approved') bg-success
                                        @elseif($latestKyc->status == 'rejected') bg-danger
                                        @else bg-warning @endif">
                                            {{ ucfirst($latestKyc->status) }}
                                        </span>
                                        <small class="text-muted">
                                            @if($latestKyc->status == 'rejected' && $latestKyc->rejection_reason)
                                            Reason: {{ $latestKyc->rejection_reason }}
                                            @endif
                                        </small>
                                    </div>
                                    <p class="mb-0 text-muted fs-13 mt-1">
                                        @if($latestKyc->status == 'approved')
                                        Approved on {{ $latestKyc->updated_at->format('M j, Y') }}
                                        @elseif($latestKyc->status == 'rejected')
                                        Rejected on {{ $latestKyc->updated_at->format('M j, Y') }}
                                        @else
                                        Submitted on {{ $latestKyc->created_at->format('M j, Y') }}
                                        @endif
                                    </p>
                                    @else
                                    <p class="text-muted fs-13 mt-2">No KYC submission found</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Side - Wallet Info -->
                            <div class="col-md-7  wallet-details">
                                <div class="button-header">
                                    <h4 class="card-title mb-0">Wallet Details</h4>
                                    @if($viewedUser->wallet)
                                    <div class="wallet-buttons">
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#fundWalletModal">
                                            <i class="ti ti-plus me-1"></i> Fund
                                        </button>
                                        <button class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#deductWalletModal">
                                            <i class="ti ti-minus me-1"></i> Deduct
                                        </button>
                                    </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center mb-4">
                                    <div class="me-4">
                                        <h3 class="fw-bold">${{ number_format($balance, 2) }}</h3>
                                        <p class="text-muted mb-0">Available Balance</p>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="badge p-1 {{ $viewedUser->wallet ? ($viewedUser->wallet->status ? 'bg-success' : 'bg-danger') : 'bg-secondary' }}">
                                            {{ $viewedUser->wallet ? ($viewedUser->wallet->status ? 'Active' : 'Suspended') : 'No Wallet' }}
                                        </span>
                                    </div>
                                </div>


                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Last Updated</span>
                                        <span class="fw-medium">
                                            {{ $viewedUser->wallet ? $viewedUser->wallet->updated_at->diffForHumans() : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Wallet Created</span>
                                        <span class="fw-medium">
                                            {{ $viewedUser->wallet ? $viewedUser->wallet->created_at->format('M j, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center gap-3 mt-4">

                                    {{-- Wallet Activate / Deactivate --}}
                                    @if($viewedUser->wallet)
                                    <div>
                                        @if($viewedUser->wallet->status)
                                        <form action="{{ route('admin.users.wallet.deactivate', $viewedUser->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100 wallet-action-btn deactivate-wallet-btn">
                                                <i class="ti ti-ban me-1"></i> Deactivate Wallet
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.users.wallet.activate', $viewedUser->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100 wallet-action-btn activate-wallet-btn">
                                                <i class="ti ti-check me-1"></i> Activate Wallet
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    @endif

                                    {{-- Ban / Unban User --}}
                                    <div>
                                        @if($viewedUser->active)
                                        <form action="{{ route('admin.users.ban', $viewedUser->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100 user-action-btn ban-user-btn">
                                                <i class="ti ti-ban me-1"></i> Ban User
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('admin.users.unban', $viewedUser->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100 user-action-btn unban-user-btn">
                                                <i class="ti ti-check me-1"></i> Unban User
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Card (Full Width Below) -->
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Transaction History</h4>
                            <!-- <div class="dropdown">
                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ti ti-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">All Transactions</a></li>
                                    <li><a class="dropdown-item" href="#">Deposits</a></li>
                                    <li><a class="dropdown-item" href="#">Withdrawals</a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body user-transaction-card">
                        <div class="table-responsive">
                            <table class="table table-sm table-nowrap mb-0">
                                <thead class="bg-light bg-opacity-25">
                                    <tr>
                                        <th class="">S/N</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $index => $transaction)
                                    <tr>
                                        <td class="">#{{ $index + 1 }}</td>
                                        <td>{{ ucfirst($transaction->type) }}</td>
                                        <td>${{ number_format($transaction->amount, 2) }}</td>
                                        <td>{{ $transaction->created_at->format('M j, Y H:i') }}</td>
                                        <td>
                                            <span class="badge
                                        @if($transaction->status == 'completed') bg-success
                                        @elseif($transaction->status == 'failed') bg-danger
                                        @else bg-warning @endif p-1 fs-11">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No transactions found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top border-light">
                        {{ $transactions->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Fund Wallet Modal -->
<div class="modal fade" id="fundWalletModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="fundWalletForm" action="{{ route('admin.users.fund-wallet', $viewedUser->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $viewedUser->wallet ? 'Fund Wallet' : 'Create & Fund Wallet' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="fundWalletAlert" class="alert d-none"></div>

                    @if(!$viewedUser->wallet)
                    <div class="alert alert-info">
                        This user doesn't have a wallet account. One will be created automatically.
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="fundAmount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="fundAmount" name="amount"
                                min="0.01" step="0.01" required>
                            <span class="input-group-text">Min: $0.01</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="fundWalletBtn">
                        <span class="submit-text">Fund Wallet</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Deduct Wallet Modal -->
<div class="modal fade" id="deductWalletModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @if($viewedUser->wallet)
            <form id="deductWalletForm" action="{{ route('admin.users.deduct-wallet', $viewedUser->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Deduct From Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deductAmount" class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="deductAmount" name="amount"
                                min="0.01" step="0.01" max="{{ $viewedUser->wallet->balance }}" required>
                            <span class="input-group-text">Max: ${{ number_format($viewedUser->wallet->balance, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Deduct Funds</button>
                </div>
            </form>
            @else
            <div class="modal-body text-center py-4">
                <i class="ti ti-alert-circle fs-1 text-warning"></i>
                <h4 class="mt-3">No Wallet Found</h4>
                <p class="text-muted">This user doesn't have a wallet account yet.</p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Config for confirmation modals
    const actionConfigs = {
        'ban-user-btn': {
            actionText: 'ban this user',
            confirmText: 'Yes, Ban!',
            loadingText: 'Banning...'
        },
        'unban-user-btn': {
            actionText: 'unban this user',
            confirmText: 'Yes, Unban!',
            loadingText: 'Unbanning...'
        },
        'activate-wallet-btn': {
            actionText: 'activate this wallet',
            confirmText: 'Yes, Activate!',
            loadingText: 'Activating...'
        },
        'deactivate-wallet-btn': {
            actionText: 'deactivate this wallet',
            confirmText: 'Yes, Deactivate!',
            loadingText: 'Deactivating...'
        }
    };

    // Handle confirmation for all action buttons
    document.querySelectorAll('.user-action-btn, .wallet-action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const buttonClass = [...this.classList].find(cls => cls in actionConfigs);
            const config = actionConfigs[buttonClass];

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to ${config.actionText}`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: config.confirmText,
                backdrop: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                        ${config.loadingText}
                    `;
                    this.disabled = true;
                    setTimeout(() => form.submit(), 300);
                }
            });
        });
    });
</script>



<script>
    document.getElementById('deductWalletForm').addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "This will deduct funds from the user's wallet!",
            showCancelButton: true,
            confirmButtonText: "Yes, deduct it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });
</script>
<style>
    .user-details .profile {
        width: 80px !important;
        height: 80px !important;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

@endsection
