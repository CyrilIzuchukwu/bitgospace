@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Wallet Addresses</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Wallet Addresses</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Wallet Addresses</h3>
                    <p class="text-muted w-100 m-auto">
                        Manage cryptocurrency wallet addresses for deposits
                    </p>
                </div>

                @if($wallets->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No Wallet address found</p>
                            <span class="text-gray-100">There are no cryptocurrency wallet address found.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">Address List</h4>
                                <div class="w-auto">
                                    <a href="{{ route('wallets.create') }}" class="btn btn-primary bg-gradient">
                                        <i class="ti ti-plus me-1"></i>Add Wallet
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">#</th>
                                                <th scope="col" class="text-muted">Wallet Name</th>
                                                <th scope="col" class="text-muted">Symbol</th>
                                                <th scope="col" class="text-muted">Wallet Address</th>
                                                <th scope="col" class="text-muted">QR Code</th>
                                                <th scope="col" class="text-muted text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($wallets as $wallet)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $wallet->name }}</td>
                                                <td>{{ $wallet->symbol }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="text-truncate" style="max-width: 200px;">{{ $wallet->address }}</span>
                                                        <button class="btn btn-sm btn-link copy-address" data-address="{{ $wallet->address }}">
                                                            <i class="ti ti-copy"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($wallet->qr_code)
                                                    <img src="{{ asset('storage/'.$wallet->qr_code) }}" alt="QR Code" width="40" height="40" class="rounded">
                                                    @else
                                                    <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('wallets.edit', $wallet->slug) }}"
                                                            class="btn btn-sm btn-success edit-wallet">
                                                            <i class="ti ti-edit fs-16"></i>
                                                        </a>
                                                        <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger delete-button">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="no-investment">
                                                        <div class="not-found">
                                                            <div class="image-notfound">
                                                                <img src="https://gekoinvests.com/theme/assets/dist/images/not-found.png" class="img-fluid" alt="">
                                                            </div>
                                                            <div class="text-notfound">
                                                                <p class="text-dark">No wallet addresses found</p>
                                                                <span class="text-gray-100">You haven't added any wallet addresses yet.</span>
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
                            @if($wallets->hasPages())
                            <div class="card-footer border-top border-light">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">{{ $wallets->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $wallets->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $wallets->total() }}</span> Wallets
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $wallets->links('vendor.pagination.bootstrap-5') }}
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
                    text: "Are you sure you want to delete this wallet address?",
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

        // Copy address functionality
        const copyButtons = document.querySelectorAll('.copy-address');
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const address = this.getAttribute('data-address');
                navigator.clipboard.writeText(address).then(() => {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="ti ti-check"></i>';
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                    }, 2000);
                });
            });
        });
    });
</script>

@endsection
