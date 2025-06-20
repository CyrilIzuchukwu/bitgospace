@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">KYC Status</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">KYC Status</li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center kyc-status-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center text-md-start">Your KYC Verification Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="kyc-status-container text-center">
                            @if($kyc->status === 'pending')
                            <div class="status-pending">
                                <i class="ti ti-clock fs-48 text-warning mb-3"></i>
                                <h4 class="mb-2 mt-3">Verification Pending</h4>
                                <p class="text-muted">Your KYC submission is under review. Please check back later.</p>
                            </div>
                            @elseif($kyc->status === 'approved')
                            <div class="status-approved">
                                <i class="ti ti-circle-check fs-48 text-success mb-3"></i>
                                <h4 class="mb-2 mt-3">Verification Approved</h4>
                                <p class="text-muted">Your KYC has been successfully verified.</p>
                            </div>
                            @elseif($kyc->status === 'rejected')
                            <div class="status-rejected">
                                <i class="ti ti-alert-circle fs-48 text-danger mb-3"></i>
                                <h4 class="mb-2 mt-3">Verification Rejected</h4>
                                <p class="text-muted mb-3">{{ $kyc->rejection_reason }}</p>

                                @if($canResubmit)
                                <a href="{{ route('user.kyc') }}" class="btn btn-primary">
                                    Resubmit KYC
                                </a>
                                @else
                                <p class="text-muted">Please contact support for assistance.</p>
                                @endif
                            </div>
                            @elseif($kyc->status === 'in_review')
                            <div class="status-in-review">
                                <i class="ti ti-search fs-48 text-info mb-3"></i>
                                <h4 class="mb-2">Verification In Review</h4>
                                <p class="text-muted">Our team is currently reviewing your submission.</p>
                            </div>
                            @endif

                            <div class="kyc-details mt-4 text-start">
                                <h5 class="mb-3">Submission Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Document Type:</strong> {{ ucfirst(str_replace('_', ' ', $kyc->document_type)) }}</p>
                                        <p class="mt-1"><strong>Country:</strong>
                                            @if($kyc->country_flag)
                                            <img src="{{ $kyc->country_flag }}" alt="{{ $kyc->country }}" style="height: 20px;" class="me-2">
                                            @endif
                                            {{ $kyc->country }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 mt-2 mt-md-0 text-start text-md-end">
                                        <p class="mt-1 mt-md-0 "><strong>Submitted On:</strong> {{ $kyc->created_at->format('M j, Y H:i') }}</p>
                                        @if($kyc->status !== 'pending')
                                        <p class="mt-1 mt-md-0 "><strong>Last Updated:</strong> {{ $kyc->updated_at->format('M j, Y H:i') }}</p>
                                        @endif
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

@endsection
