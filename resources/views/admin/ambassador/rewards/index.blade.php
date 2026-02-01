@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Ambassador Rewards</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ambassador Rewards</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Ambassador Rewards</h3>
                    <p class="text-muted w-100 m-auto">
                        Manage all ambassador reward tiers and benefits
                    </p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">Reward List</h4>
                                <div class="w-auto">
                                    <a href="{{ route('ambassador.rewards.create') }}" class="btn btn-primary bg-gradient">
                                        <i class="ti ti-plus me-1"></i> Add New Reward
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">#</th>
                                                <th scope="col" class="text-muted">Reward Title</th>
                                                <th scope="col" class="text-muted">Required Referrals</th>
                                                <th scope="col" class="text-muted">Reward Type</th>
                                                <th scope="col" class="text-muted">Cash Amount</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rewards as $reward)
                                            <tr style="font-size: 12px;">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <h6 class="mb-0">{{ $reward->title }}</h6>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">
                                                        {{ number_format($reward->required_referrals) }} Referrals
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        {{ ucwords(str_replace('_', ' ', $reward->reward_type)) }}
                                                    </span>
                                                </td>
                                                <td class="text-success fw-semibold">
                                                    @if($reward->cash_amount)
                                                        ${{ number_format($reward->cash_amount, 2) }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($reward->status == 'active')
                                                    <span class="badge p-1 bg-success-subtle text-success">Active</span>
                                                    @else
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('ambassador.rewards.edit', $reward->slug) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class="ti ti-edit fs-16"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger delete-reward"
                                                            data-id="{{ $reward->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="no-investment">
                                                        <div class="not-found">
                                                            <div class="image-notfound">
                                                                <img src="https://gekoinvests.com/theme/assets/dist/images/not-found.png" class="img-fluid" alt="">
                                                            </div>
                                                            <div class="text-notfound">
                                                                <p class="text-dark">No ambassador rewards found</p>
                                                                <span class="text-gray-100">You haven't created any ambassador rewards yet.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($rewards->hasPages())
                            <div class="card-footer border-top border-light">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">{{ $rewards->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $rewards->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $rewards->total() }}</span> Rewards
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $rewards->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.snippets.footer')
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-reward');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const rewardId = this.getAttribute('data-id');
                const row = this.closest('tr');

                Swal.fire({
                    text: "Are you sure you want to delete this ambassador reward?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const originalHTML = this.innerHTML;
                        this.innerHTML = `
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        `;
                        this.disabled = true;

                        fetch(`/admin/ambassador/rewards/${rewardId}/delete`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    row.style.opacity = 1;
                                    const fadeEffect = setInterval(() => {
                                        if (row.style.opacity > 0) {
                                            row.style.opacity -= 0.1;
                                        } else {
                                            clearInterval(fadeEffect);
                                            row.remove();

                                            showToast(data.message || 'Reward deleted successfully', 'success');

                                            if (document.querySelectorAll('tbody tr').length === 0) {
                                                document.querySelector('tbody').innerHTML = `
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
                                                        <div class="no-investment">
                                                            <div class="not-found">
                                                                <div class="image-notfound">
                                                                    <img src="https://gekoinvests.com/theme/assets/dist/images/not-found.png" class="img-fluid" alt="">
                                                                </div>
                                                                <div class="text-notfound">
                                                                    <p class="text-dark">No ambassador rewards found</p>
                                                                    <span class="text-gray-100">You haven't created any ambassador rewards yet.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                            }
                                        }
                                    }, 50);
                                } else {
                                    this.innerHTML = originalHTML;
                                    this.disabled = false;
                                    showToast(data.message || 'Failed to delete reward', 'error');
                                }
                            })
                            .catch(error => {
                                this.innerHTML = originalHTML;
                                this.disabled = false;
                                showToast('An error occurred while deleting the reward', 'error');
                                console.error('Error:', error);
                            });
                    }
                });
            });
        });

        function showToast(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    });
</script>

@endsection
