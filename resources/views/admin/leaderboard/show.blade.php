@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">{{ $leaderboard->name }}</h4>
            </div>
          
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2" style="text-transform: uppercase;">Stage Details</h3>
                    <p class="text-muted w-100 m-auto">
                        View and manage leaderboard stage information
                    </p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="header-title me-auto">{{ $leaderboard->name }}</h4>
                                <div class="w-auto">
                                    <!-- Mobile: Stack buttons vertically -->
                                    <div class="d-block d-sm-none">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('admin.leaderboard.edit', $leaderboard->id) }}"
                                               class="btn btn-success bg-gradient btn-sm">
                                                <i class="ti ti-edit me-1"></i>Edit
                                            </a>
                                            <a href="{{ route('admin.leaderboard.index') }}"
                                               class="btn btn-secondary bg-gradient btn-sm">
                                                <i class="ti ti-arrow-left me-1"></i>Back
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Desktop: Side by side -->
                                    <div class="d-none d-sm-flex gap-2">
                                        <a href="{{ route('admin.leaderboard.edit', $leaderboard->id) }}"
                                           class="btn btn-success bg-gradient">
                                            <i class="ti ti-edit me-1"></i>Edit Stage
                                        </a>
                                        <a href="{{ route('admin.leaderboard.index') }}"
                                           class="btn btn-secondary bg-gradient">
                                            <i class="ti ti-arrow-left me-1"></i>Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Stage Image -->
                                    @if($leaderboard->image)
                                    <div class="col-md-4 mb-4">
                                        <div class="text-center">
                                            <img src="{{ asset('storage/'.$leaderboard->image) }}"
                                                 alt="{{ $leaderboard->name }}"
                                                 class="img-fluid rounded border"
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Stage Information -->
                                    <div class="col-md-{{ $leaderboard->image ? '8' : '12' }}">
                                        <!-- Mobile-friendly card layout -->
                                        <div class="d-block d-md-none">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="border rounded p-3">
                                                        <h6 class="text-muted mb-1">Stage Name</h6>
                                                        <p class="fw-medium mb-0">{{ $leaderboard->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="border rounded p-3">
                                                        <h6 class="text-muted mb-1">Description</h6>
                                                        <p class="fw-medium mb-0">
                                                            @if($leaderboard->description)
                                                                {{ $leaderboard->description }}
                                                            @else
                                                                <span class="text-muted">No description provided</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-3 text-center">
                                                        <h6 class="text-muted mb-2">Target Amount</h6>
                                                        <span class="badge bg-primary bg-gradient fs-12 px-2 py-1">
                                                            ${{ number_format($leaderboard->target_amount, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-3 text-center">
                                                        <h6 class="text-muted mb-2">Order</h6>
                                                        <span class="badge bg-info bg-gradient fs-12 px-2 py-1">
                                                            {{ $leaderboard->order }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-3 text-center">
                                                        <h6 class="text-muted mb-2">Status</h6>
                                                        <span class="badge bg-{{ $leaderboard->status === 'active' ? 'success' : 'secondary' }} bg-gradient fs-12 px-2 py-1">
                                                            {{ ucfirst($leaderboard->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-3 text-center">
                                                        <h6 class="text-muted mb-2">Created</h6>
                                                        <p class="fw-medium mb-0 fs-13">{{ $leaderboard->created_at->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Desktop table layout -->
                                        <div class="d-none d-md-block">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-custom">
                                                    <tbody>
                                                        <tr>
                                                            <td class="fw-semibold text-muted" style="width: 200px;">Stage Name:</td>
                                                            <td class="fw-medium">{{ $leaderboard->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Description:</td>
                                                            <td class="fw-medium">
                                                                @if($leaderboard->description)
                                                                    {{ $leaderboard->description }}
                                                                @else
                                                                    <span class="text-muted">No description provided</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Target Amount:</td>
                                                            <td class="fw-medium">
                                                                <span class="badge bg-primary bg-gradient fs-14 px-3 py-2">
                                                                    ${{ number_format($leaderboard->target_amount, 2) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Order Position:</td>
                                                            <td class="fw-medium">
                                                                <span class="badge bg-info bg-gradient fs-14 px-3 py-2">
                                                                    {{ $leaderboard->order }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Status:</td>
                                                            <td class="fw-medium">
                                                                <span class="badge bg-{{ $leaderboard->status === 'active' ? 'success' : 'secondary' }} bg-gradient fs-14 px-3 py-2">
                                                                    {{ ucfirst($leaderboard->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Created Date:</td>
                                                            <td class="fw-medium">{{ $leaderboard->created_at->format('M d, Y h:i A') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-semibold text-muted">Last Updated:</td>
                                                            <td class="fw-medium">{{ $leaderboard->updated_at->format('M d, Y h:i A') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin.snippets.footer')
</div>

@endsection
