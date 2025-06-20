@extends('layouts.admin')
@section('content')

<div class="page-content">

    <div class="page-container">

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Investment Details #{{ $investment->id }}</h2>
                    <a href="{{ route('admin.investments.index') }}" class="btn btn-sm btn-secondary">
                        <i class="ti ti-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Investment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">User</th>
                                    <td>
                                        <a href="">
                                            {{ $investment->user->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <td>{{ $investment->plan->name }} ({{ $investment->plan->duration }} days)</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>${{ number_format($investment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Daily Profit</th>
                                    <td>${{ number_format($investment->amount * $investment->plan->interest_rate / 100, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total ROI</th>
                                    <td>${{ number_format($investment->roi, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Accumulated Profit</th>
                                    <td>${{ number_format($investment->profit, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($investment->withdrawn)
                                        <span class="badge bg-secondary">Withdrawn</span>
                                        @elseif($investment->due)
                                        <span class="badge bg-success">Completed</span>
                                        @else
                                        <span class="badge bg-primary">Active</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-point"></div>
                                <div class="timeline-content">
                                    <h6>Started</h6>
                                    <p class="text-muted mb-0">
                                        {{ $investment->start_date->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-point"></div>
                                <div class="timeline-content">
                                    <h6>Scheduled End</h6>
                                    <p class="text-muted mb-0">
                                        {{ $investment->end_date->format('M d, Y h:i A') }}
                                    </p>
                                    <small class="text-muted">
                                        ({{ $investment->end_date->diffForHumans() }})
                                    </small>
                                </div>
                            </div>

                            @if($investment->due)
                            <div class="timeline-item">
                                <div class="timeline-point"></div>
                                <div class="timeline-content">
                                    <h6>Completed</h6>
                                    <p class="text-muted mb-0">
                                        {{ $investment->updated_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
