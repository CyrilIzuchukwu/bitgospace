@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Your Referred Users</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.referrals') }}">Referrals</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Referred Users</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of users who joined through your referral link
                    </p>
                </div>
                @if($users->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="Not found image">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No referred users yet</p>
                            <span class="text-gray-100">Share your referral link to invite others</span>
                            <div class="mt-3">
                                <a href="{{ route('user.referrals') }}" class="btn btn-primary">Get Referral Link</a>
                            </div>
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
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Joined</th>
                                                <th scope="col" class="text-muted">Investments</th>
                                                <th scope="col" class="text-muted">Total Invested</th>
                                                <th scope="col" class="text-muted">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr data-status="{{ $user->investments_count > 0 ? 'active' : 'pending' }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                                                alt="{{ $user->name }}"
                                                                class="rounded-circle me-2"
                                                                width="40">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                                            <small class="text-muted">{{ $user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->created_at->format('M j, Y') }}</td>
                                                <td>{{ $user->investments_count }}</td>
                                                <td>${{ number_format($user->investments_sum_amount, 2) }}</td>
                                                <td>
                                                    @if($user->investments_count > 0)
                                                    <span class="badge p-1 bg-success-subtle text-success">Active</span>
                                                    @else
                                                    <span class="badge p-1 bg-warning-subtle text-warning">Pending</span>
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
                                            Showing <span class="fw-semibold">{{ $users->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $users->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $users->total() }}</span> Referred Users
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $users->links('vendor.pagination.bootstrap-5') }}
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
        // Filter users by status
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
