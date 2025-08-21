@extends('layouts.dashboard')

@section('content')
    <style>
        .referral-milestones-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            padding: 20px 0;
        }

        @media (max-width: 992px) {
            .referral-milestones-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {
            .referral-milestones-container {
                grid-template-columns: 1fr;
            }

            .referral-header {
                padding: 20px;
                margin-bottom: 30px;
            }

        }

        .milestone-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            position: relative;
            background: white;
        }

        .milestone-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .milestone-image-container {
            height: 180px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .milestone-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .milestone-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 30%, rgba(0, 0, 0, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(0, 0, 0, 0.2) 0%, transparent 50%);
            z-index: 1;
        }

        .milestone-icon {
            position: absolute;
            font-size: 40px;
            color: white;
            opacity: 0.95;
            z-index: 2;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .milestone-status-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 10px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .milestone-content {
            padding: 14px;
            background: white;
        }

        .milestone-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
            color: #2c3e50;
            line-height: 1.3;
        }

        .milestone-description {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 20px !important;
            line-height: 1.5;
        }

        .milestone-target {
            background: #f1f5f9;
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 15px;
            text-align: center;
        }

        .target-label {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .target-value {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
        }

        .milestone-progress-container {
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
            height: 6px;
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: progressShimmer 2s infinite;
        }

        @keyframes progressShimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .current-progress-container {
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
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* Completed Stage */
        .milestone-completed {
            border-color: #10b981;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
            transform: scale(1.02);
        }

        .milestone-completed .milestone-image-container {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.8) 0%, rgba(5, 150, 105, 0.9) 100%);
        }

        .milestone-completed .milestone-status-badge {
            background: rgba(16, 185, 129, 0.95);
            color: white;
            font-weight: 700;
        }

        .milestone-completed .progress-fill {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .milestone-completed .milestone-icon {
            animation: milestoneCompletedPulse 3s ease-in-out infinite;
        }

        @keyframes milestoneCompletedPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Current/Ongoing Stage */
        .milestone-current {
            border-color: #0ea5e9;
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1), 0 8px 32px rgba(14, 165, 233, 0.15);
        }

        .milestone-current .milestone-image-container {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.8) 0%, rgba(2, 132, 199, 0.9) 100%);
        }

        .milestone-current .milestone-status-badge {
            background: rgba(14, 165, 233, 0.95);
            color: white;
            animation: milestoneBadgePulse 2s infinite;
            font-weight: 700;
        }

        .milestone-current .progress-fill {
            background: linear-gradient(90deg, #0ea5e9, #0284c7);
        }

        /* Upcoming/Locked Stage */
        .milestone-upcoming {
            border-color: #e2e8f0;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            opacity: 0.4;
        }

        .milestone-upcoming .milestone-image-container {
            background: linear-gradient(135deg, rgba(100, 116, 139, 0.8) 0%, rgba(55, 65, 81, 0.9) 100%);
        }

        .milestone-upcoming .milestone-status-badge {
            background: rgba(100, 116, 139, 0.9);
            color: white;
            font-weight: 600;
        }

        .milestone-upcoming .progress-fill {
            background: linear-gradient(90deg, #cbd5e1, #94a3b8);
        }

        .milestone-upcoming .milestone-icon {
            opacity: 0.7;
        }

        @keyframes milestoneBadgePulse {
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

        .referral-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #1e293b 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        @media only screen and (max-width: 767px) {

            .referral-header {
                padding: 20px !important;
                margin-bottom: 30px;
            }

            .referral-stats-label {
                margin-top: 16px;
            }

        }

        .referral-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 1;
        }

        .referral-header>* {
            position: relative;
            z-index: 1;
        }

        .referral-stats-value {
            font-size: 28px;
            font-weight: 900;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .referral-stats-label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        .next-milestone-container {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .next-milestone-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotateBackground 20s linear infinite;
        }

        @keyframes rotateBackground {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .next-milestone-content {
            position: relative;
            z-index: 1;
        }

        .next-milestone-progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            overflow: hidden;
            margin: 12px 0;
        }

        .next-milestone-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ffffff, rgba(255, 255, 255, 0.8));
            border-radius: 6px;
            transition: width 0.8s ease;
        }

        .milestone-number {
            position: absolute;
            top: 16px;
            left: 16px;
            width: 32px;
            height: 32px;
            background: rgba(0, 0, 0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
            color: white;
            backdrop-filter: blur(10px);
            z-index: 99;
        }
    </style>

    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Referral Milestones</h4>
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
                    <div class="referral-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="text-white mb-3">Your Referral Journey</h3>
                                <p class="text-white-75 mb-0">Unlock rewards by reaching milestones through your
                                    referrals</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="referral-stats-label">Total Referral Investments</div>
                                <div class="referral-stats-value">${{ number_format(floatval($referralTotal), 2) }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($nextStage && $nextStage->current_amount > 0)
                        <div class="next-milestone-container">
                            <div class="next-milestone-content">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h5 class="mb-1 fw-bold">🎯 Current Milestone: {{ $nextStage->name }}</h5>
                                        <p class="mb-0 opacity-90">You're {{ round($nextStage->progress_percent) }}% there!
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 mb-0 fw-bold">${{ number_format($nextStage->target_amount, 2) }}
                                        </div>
                                        <small class="opacity-90">Target Amount</small>
                                    </div>
                                </div>

                                <div class="next-milestone-progress">
                                    <div class="next-milestone-progress-fill"
                                        style="width: {{ $nextStage->progress_percent }}%"></div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <span>${{ number_format($nextStage->current_amount, 2) }} raised</span>
                                    <span>${{ number_format($nextStage->target_amount - $nextStage->current_amount, 2) }} to
                                        go</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="next-milestone-container">
                            <div class="next-milestone-content text-center py-2">
                                <h5 class="fw-bold">🚀 Ready to Start Earning?</h5>
                                <p class="opacity-90 ">
                                    You haven’t started earning yet. To begin, refer someone and ensure they make an
                                    investment. Only then will your referral earnings start counting.
                                </p>
                                <a href="{{ route('user.referrals') }}" class="btn mt-2 relative text-white"  style=" z-index: 22; background: #4986DB; ">Get
                                    Your Referral
                                    Link</a>
                            </div>
                        </div>
                    @endif


                    <div class="referral-milestones-container">
                        @foreach ($stages as $index => $stage)
                            @php
                                $statusClass = '';
                                $badgeText = '';
                                $iconClass = 'ti-star'; // Default icon
                                $imageUrl = $stage->image_url ?? asset('images/default-milestone.jpg');

                                $currentAmount = floatval($referralTotal ?? 0);
                                $targetAmount = floatval($stage->target_amount ?? 1);
                                $progressPercent =
                                    $targetAmount > 0 ? min(100, ($currentAmount / $targetAmount) * 100) : 0;

                                if ($currentAmount >= $targetAmount) {
                                    $statusClass = 'milestone-completed';
                                    $badgeText = 'Completed';
                                    $iconClass = 'ti-trophy';
                                    $progressPercent = 100;
                                } elseif (
                                    $stage->is_current ||
                                    ($currentAmount > 0 && $currentAmount < $targetAmount && $index == 0) ||
                                    ($index > 0 &&
                                        $currentAmount >= floatval($stages[$index - 1]->target_amount ?? 0) &&
                                        $currentAmount < $targetAmount)
                                ) {
                                    $statusClass = 'milestone-current';
                                    $badgeText = 'In Progress';
                                    $iconClass = 'ti-target';
                                } else {
                                    $statusClass = 'milestone-upcoming';
                                    $badgeText = 'Locked';
                                    $iconClass = 'ti-lock';
                                    $progressPercent = 0;
                                }
                            @endphp

                            <div class="milestone-card {{ $statusClass }}">
                                <div class="milestone-number">{{ $index + 1 }}</div>

                                <div class="milestone-image-container">
                                    <img src="{{ asset('storage/' . $stage->image) }}" alt="{{ $stage->name }}">
                                    <i class="ti {{ $iconClass }} milestone-icon"></i>
                                    <span class="milestone-status-badge">{{ $badgeText }}</span>
                                </div>

                                <div class="milestone-content">
                                    <h3 class="milestone-title">{{ $stage->name }}</h3>
                                    <p class="milestone-description">
                                        {{ $stage->description ?? 'Complete this milestone to unlock exclusive rewards and benefits.' }}
                                    </p>

                                    <div class="milestone-target">
                                        <div class="target-label">Target Amount</div>
                                        <div class="target-value">${{ number_format($stage->target_amount, 2) }}</div>
                                    </div>

                                    @if ($statusClass == 'milestone-current')
                                        <div class="current-progress-container">
                                            <div class="progress-header">
                                                <span class="progress-label">Current Progress</span>
                                                <span class="progress-percentage">{{ round($progressPercent) }}%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                                            </div>

                                            <div class="current-stats">
                                                <div class="stat-item">
                                                    <div class="stat-value">${{ number_format($referralTotal, 2) }}</div>
                                                    <div class="stat-label">Current</div>
                                                </div>
                                                <div class="stat-item">
                                                    <div class="stat-value">
                                                        ${{ number_format(max(0, $stage->target_amount - $referralTotal), 2) }}
                                                    </div>
                                                    <div class="stat-label">Remaining</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($statusClass == 'milestone-completed')
                                        <div class="milestone-progress-container">
                                            <div class="progress-header">
                                                <span class="progress-label">✨ Completed</span>
                                                <span class="progress-percentage">100%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <small class="text-success fw-semibold">🎉 Milestone Achieved!</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="milestone-progress-container">
                                            <div class="progress-header">
                                                <span class="progress-label">🔒 Locked</span>
                                                <span class="progress-percentage">0%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 0%"></div>
                                            </div>
                                            <div class="text-center mt-3">
                                                @if ($index === 0)
                                                    <small class="text-primary">Start your journey here</small>
                                                @else
                                                    <small class="text-muted">Complete previous stages to unlock</small>
                                                @endif
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
