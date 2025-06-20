@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- Optional heading can go here -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.referrals') }}">Referrals</a></li>
                    <li class="breadcrumb-item active">Commissions</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Referral Commissions</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of commissions earned from your referrals
                    </p>
                </div>

                @if($commissions->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="not found image">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No commissions yet</p>
                            <span class="text-gray-100">You'll earn commissions when your referrals make investments</span>
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
                                        <option value="level1">Level 1</option>
                                        <option value="level2">Level 2</option>
                                        <option value="level3">Level 3</option>
                                    </select>
                                </div>
                                <div>
                                    <a href="{{ route('user.referrals') }}" class="btn btn-primary bg-gradient">
                                        <i class="ti ti-users me-1"></i>View Referrals
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">Date</th>
                                                <th scope="col" class="text-muted">From</th>
                                                <th scope="col" class="text-muted">Level</th>
                                                <th scope="col" class="text-muted">Investment</th>
                                                <th scope="col" class="text-muted text-center">Commission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commissions as $commission)
                                            <tr data-level="level{{ $commission->level }}">
                                                <td>{{ $commission->created_at->format('M j, Y') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ $commission->investor->profile_picture ? asset('storage/profile_pictures/' . $commission->investor->profile_picture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                                                alt="{{ $commission->investor->name }}"
                                                                class="rounded-circle me-2"
                                                                width="40">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $commission->investor->name }}</h6>
                                                            <small class="text-muted">{{ $commission->investor->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Level {{ $commission->level }}</td>
                                                <td>${{ number_format($commission->investment->amount, 2) }}</td>
                                                <td class="text-success text-center">+ ${{ number_format($commission->amount, 2) }}</td>

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
                                            Showing <span class="fw-semibold">{{ $commissions->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $commissions->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $commissions->total() }}</span> Commissions
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $commissions->links('vendor.pagination.bootstrap-5') }}
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
        // Filter commissions by level
        const filterSelect = document.querySelector('.filter-select');
        filterSelect.addEventListener('change', function() {
            const level = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (level === 'all') {
                    row.style.display = '';
                } else {
                    const rowLevel = row.getAttribute('data-level');
                    row.style.display = rowLevel === level ? '' : 'none';
                }
            });
        });
    });
</script>


@endsection
