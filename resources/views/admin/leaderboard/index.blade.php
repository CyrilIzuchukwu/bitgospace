@extends('layouts.admin')
@section('content')

    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <!-- <h4 class="fs-18 fw-semibold mb-0">Leaderboard Stages</h4> -->
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaderboard Stages</li>
                    </ol>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="text-center mb-4">
                        <h3 class="mb-2" style="text-transform: uppercase;">Leaderboard Stages</h3>
                        <p class="text-muted w-100 m-auto">
                            Manage stages and requirements for user progression
                        </p>
                    </div>

                    @if ($stages->isEmpty())
                        <div class="no-investment">
                            <div class="not-found card">
                                <div class="image-notfound">
                                    <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="text-notfound">
                                    <p class="text-dark">No Leaderboard Stages found</p>
                                    <span class="text-gray-100">There are no leaderboard stages configured yet.</span>

                                    <div class="mt-3">
                                        <a href="{{ route('admin.leaderboard.create') }}"
                                            class="btn btn-primary bg-gradient">
                                            <i class="ti ti-plus me-1"></i>Create First Stage
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div
                                        class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <h4 class="header-title me-auto">Stage List</h4>
                                        <div class="w-auto">
                                            <a href="{{ route('admin.leaderboard.create') }}"
                                                class="btn btn-primary bg-gradient">
                                                <i class="ti ti-plus me-1"></i>Add Stage
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive table-card">
                                            <table
                                                class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                                <thead class="bg-light bg-opacity-50 thead-sm">
                                                    <tr class="text-uppercase fs-10">
                                                        <th scope="col" class="text-muted">#</th>
                                                        <th scope="col" class="text-muted">Order</th>
                                                        <th scope="col" class="text-muted">Name</th>
                                                        <th scope="col" class="text-muted">Target Amount</th>
                                                        <th scope="col" class="text-muted">Status</th>
                                                        <th scope="col" class="text-muted text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($stages as $stage)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $stage->order }}</td>
                                                            <td>{{ $stage->name }}</td>

                                                            <td>${{ number_format($stage->target_amount, 2) }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge p-1 bg-{{ $stage->status === 'active' ? 'success' : 'secondary' }}">
                                                                    {{ ucfirst($stage->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex gap-2 align-items-center justify-content-center">
                                                                    <a href="{{ route('admin.leaderboard.show', $stage->id) }}"
                                                                        class="btn btn-sm btn-info">
                                                                        <i class="ti ti-eye fs-16"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.leaderboard.edit', $stage->id) }}"
                                                                        class="btn btn-sm btn-success">
                                                                        <i class="ti ti-edit fs-16"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('admin.leaderboard.destroy', $stage->id) }}"
                                                                        method="POST" class="delete-form">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger delete-button">
                                                                            <i class="ti ti-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if ($stages->hasPages())
                                        <div class="card-footer border-top border-light">
                                            <div
                                                class="align-items-center justify-content-between row text-center text-sm-start">
                                                <div class="col-sm">
                                                    <div class="text-muted">
                                                        Showing <span class="fw-semibold">{{ $stages->firstItem() }}</span>
                                                        to
                                                        <span class="fw-semibold">{{ $stages->lastItem() }}</span> of
                                                        <span class="fw-semibold">{{ $stages->total() }}</span> Stages
                                                    </div>
                                                </div>
                                                <div class="col-sm-auto mt-3 mt-sm-0">
                                                    {{ $stages->links('vendor.pagination.bootstrap-5') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
        document.addEventListener("DOMContentLoaded", function() {
            // Delete confirmation
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        text: "Are you sure you want to delete this stage?",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            const originalText = this.innerHTML;
                            this.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            Deleting...
                        `;
                            this.disabled = true;
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
