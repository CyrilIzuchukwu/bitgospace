@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">Users Management</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Users List</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all registered users
                    </p>
                </div>

                @if($users->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No users found</p>
                            <span class="text-gray-100">There are currently no registered users.</span>
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
                                        <option value="banned">Banned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card user-list-table">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Phone</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Balance</th>
                                                <th scope="col" class="text-muted">Last Login</th>
                                                <th scope="col" class="text-muted text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr data-status="{{ $user->active ? 'active' : 'banned' }}" onclick="window.location='{{ route('admin.users.show', $user->id) }}'" style="cursor: pointer;">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{ $user->profile && $user->profile->profile_picture ? asset('storage/profile_pictures/' . $user->profile->profile_picture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}" class="rounded-circle profile" width="40" alt="User">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                                            <small class="text-muted">{{ $user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                                <td>
                                                    @if($user->active)
                                                    <span class="badge p-1 bg-success-subtle text-success">Active</span>
                                                    @else
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Banned</span>
                                                    @endif
                                                </td>
                                                <td>${{ number_format($user->balance, 2) }}</td>
                                                <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        @if($user->active)
                                                        <form action="{{ route('admin.users.ban', $user->id) }}" method="POST" class="ban-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-warning ban-button">
                                                                <i class="ti ti-user-off me-1"></i> Ban
                                                            </button>
                                                        </form>
                                                        @else
                                                        <form action="{{ route('admin.users.unban', $user->id) }}" method="POST" class="unban-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success unban-button">
                                                                <i class="ti ti-user-check me-1"></i> Unban
                                                            </button>
                                                        </form>
                                                        @endif
                                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger delete-button">
                                                                <i class="ti ti-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
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
                                            <span class="fw-semibold">{{ $users->total() }}</span> Users
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

    @include('admin.snippets.footer')
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

        // Confirmation dialogs
        const actions = [{
                selector: '.ban-button',
                text: 'ban this user',
                confirmText: 'Yes, Ban!'
            },
            {
                selector: '.unban-button',
                text: 'unban this user',
                confirmText: 'Yes, Unban!'
            },
            {
                selector: '.delete-button',
                text: 'delete this user',
                confirmText: 'Yes, Delete!'
            }
        ];

        actions.forEach(action => {
            document.querySelectorAll(action.selector).forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: `Are you sure?`,
                        text: `You are about to ${action.text}`,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: action.confirmText
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
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.ban-button, .unban-button, .delete-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .user-list-table tbody td .profile{
        width: 40px !important;
        height: 40px !important;
        object-fit: cover;
        border-radius: 50%;
    }

</style>

@endsection
