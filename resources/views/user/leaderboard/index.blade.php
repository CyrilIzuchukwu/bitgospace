@extends('layouts.dashboard')

@section('content')
    <style>
        .leaderboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            padding: 20px 0;
        }

        .stage-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            background: white;
        }

        .stage-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .stage-image {
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stage-icon {
            font-size: 48px;
            color: white;
            opacity: 0.9;
        }

        .stage-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .stage-content {
            padding: 24px;
            background: white;
        }

        .stage-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #2c3e50;
            line-height: 1.3;
        }

        .stage-description {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
            min-height: 42px;
        }

        .target-amount {
            background: #f1f5f9;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        .target-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .target-value {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
        }

        .progress-container {
            margin-bottom: 16px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .progress-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .progress-percentage {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .progress-bar {
            height: 10px;
            border-radius: 6px;
            background-color: #e2e8f0;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .current-progress {
            background: #f0f9ff;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #0ea5e9;
        }

        .current-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* Completed Stage */
        .completed {
            border-color: #10b981;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        }

        .completed .stage-image {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .completed .stage-badge {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .completed .progress-fill {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .completed .stage-icon {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* Current/Ongoing Stage */
        .current {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .current .stage-image {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }

        .current .stage-badge {
            background: rgba(14, 165, 233, 0.9);
            color: white;
            animation: pulse 2s infinite;
        }

        .current .progress-fill {
            background: linear-gradient(90deg, #0ea5e9, #0284c7);
        }

        /* Upcoming Stage */
        .upcoming {
            border-color: #e2e8f0;
            background: #f8fafc;
            opacity: 0.7;
        }

        .upcoming .stage-image {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        .upcoming .stage-badge {
            background: rgba(100, 116, 139, 0.9);
            color: white;
        }

        .upcoming .progress-fill {
            background: #e2e8f0;
        }

        .upcoming .stage-icon {
            opacity: 0.6;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4);
            }
            70% {
                box-shadow: 0 0 0 12px rgba(14, 165, 233, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(14, 165, 233, 0);
            }
        }

        .stats-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #1e293b 100%);
            color: white;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .stats-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .stats-header > * {
            position: relative;
            z-index: 1;
        }

        .stats-value {
            font-size: 36px;
            font-weight: 900;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stats-label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        .next-milestone {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .next-milestone::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .milestone-content {
            position: relative;
            z-index: 1;
        }

        .next-progress-bar {
            height: 12px;
            background: rgba(255,255,255,0.2);
            border-radius: 6px;
            overflow: hidden;
            margin: 12px 0;
        }

        .next-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ffffff, rgba(255,255,255,0.8));
            border-radius: 6px;
            transition: width 0.8s ease;
        }

        .stage-number {
            position: absolute;
            top: 16px;
            left: 16px;
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: white;
            backdrop-filter: blur(10px);
        }
    </style>

    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Referral Leaderboard</h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item d-none d-md-block"><a href="javascript: void(0);">BitGoSpace</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Referrals</a></li>
                    </ol>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="stats-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="text-white mb-3">Your Referral Journey</h3>
                                <p class="text-white-75 mb-0">Unlock rewards by reaching investment milestones through your referrals</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="stats-label">Total Referral Investments</div>
                                <div class="stats-value">${{ number_format(floatval($totalInvestments), 2) }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($nextStage)
                        <div class="next-milestone">
                            <div class="milestone-content">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h5 class="mb-1 fw-bold">🎯 Next Milestone: {{ $nextStage->name }}</h5>
                                        <p class="mb-0 opacity-90">You're {{ round($nextStage->progress_percent) }}% there!</p>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 mb-0 fw-bold">${{ number_format($nextStage->target_amount, 2) }}</div>
                                        <small class="opacity-90">Target Amount</small>
                                    </div>
                                </div>

                                <div class="next-progress-bar">
                                    <div class="next-progress-fill" style="width: {{ $nextStage->progress_percent }}%"></div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <span>${{ number_format($nextStage->current_amount, 2) }} raised</span>
                                    <span>${{ number_format($nextStage->target_amount - $nextStage->current_amount, 2) }} to go</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="leaderboard-container">
                        @foreach ($stages as $index => $stage)
                            @php
                                $statusClass = '';
                                $badgeText = '';
                                $iconClass = '';

                                if ($stage->is_completed) {
                                    $statusClass = 'completed';
                                    $badgeText = 'Completed';
                                    $iconClass = 'ti-check';
                                } elseif ($stage->is_current) {
                                    $statusClass = 'current';
                                    $badgeText = 'Ongoing';
                                    $iconClass = 'ti-target';
                                } else {
                                    $statusClass = 'upcoming';
                                    $badgeText = 'Locked';
                                    $iconClass = 'ti-lock';
                                }
                            @endphp

                            <div class="stage-card {{ $statusClass }}">
                                <div class="stage-number">{{ $index + 1 }}</div>

                                <div class="stage-image">
                                    <i class="ti {{ $iconClass }} stage-icon"></i>
                                    <span class="stage-badge">
                                        {{ $badgeText }}
                                    </span>
                                </div>

                                <div class="stage-content">
                                    <h3 class="stage-title">{{ $stage->name }}</h3>
                                    <p class="stage-description">{{ $stage->description ?? 'Complete this milestone to unlock exclusive rewards and benefits.' }}</p>

                                    <div class="target-amount">
                                        <div class="target-label">Target Amount</div>
                                        <div class="target-value">${{ number_format($stage->target_amount, 2) }}</div>
                                    </div>

                                    @if($stage->is_current)
                                        <div class="current-progress">
                                            <div class="progress-header">
                                                <span class="progress-label">Current Progress</span>
                                                <span class="progress-percentage">{{ round($stage->progress_percent) }}%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: {{ $stage->progress_percent }}%"></div>
                                            </div>

                                            <div class="current-stats">
                                                <div class="stat-item">
                                                    <div class="stat-value">${{ number_format($stage->current_amount, 2) }}</div>
                                                    <div class="stat-label">Current</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">${{ number_format($stage->target_amount - $stage->current_amount, 2) }}</div>
                                                    <div class="stat-label">Remaining</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($stage->is_completed)
                                        <div class="progress-container">
                                            <div class="progress-header">
                                                <span class="progress-label">Completed</span>
                                                <span class="progress-percentage">100%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="progress-container">
                                            <div class="progress-header">
                                                <span class="progress-label">Not Started</span>
                                                <span class="progress-percentage">0%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
