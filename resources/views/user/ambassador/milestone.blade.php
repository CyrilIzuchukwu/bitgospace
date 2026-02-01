@extends('layouts.dashboard')
@section('content')
    <div class="page-content">
        <div class="page-container ambassado-reward">

            <!-- Page Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2 mt-2">
                <div class="flex-grow-1">
                    <h3 class="fw-semibold mb-0 text-white">Reward Milestone</h3>
                    {{-- <p class="text-white-50 mb-0">Track your progress and active referrals</p> --}}
                </div>
                <div>
                    <a href="{{ route('user.ambassador') }}" class="btn btn-outline-light btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back to Rewards
                    </a>
                </div>
            </div>

            <!-- Stats Overview Cards - Dashboard Style -->
            <div class="user-dashboard-grid crypto-style mb-4">
                <!-- Active Referrals Card -->
                <div class="dashboard-card balance-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Active Referrals</h4>
                            <div class="card-icon glow-blue">
                                <i class="ti ti-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="balance-amount">{{ number_format($active_referrals_count) }}</h2>
                    </div>
                </div>

                <!-- Total Referrals Card -->
                <div class="dashboard-card deposit-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Total Referrals</h4>
                            <div class="card-icon glow-green">
                                <i class="ti ti-user-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="balance-amount">{{ number_format($total_referrals) }}</h2>
                    </div>
                </div>

                <!-- Inactive Referrals Card -->
                <div class="dashboard-card withdrawal-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Inactive Referrals</h4>
                            <div class="card-icon glow-red">
                                <i class="ti ti-user-x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="balance-amount">{{ number_format($inactive_referrals) }}</h2>
                    </div>
                </div>


            </div>

            @if ($next_milestone)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body mb-3">
                                <div class="mb-4">
                                    <h4 class="text-white mb-1">
                                        Milestone Progress
                                    </h4>
                                    <p class="text-white-50 mb-0">Track your progress and active referrals</p>
                                </div>

                                {{-- milestone progress bar section --}}
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="milestone-circle" style="--progress: {{ $progress_percentage }};">
                                        <div class="milestone-center">
                                            <img src="{{ asset('dashboard_assets/assets/images/amb/point' . $current_milestone_level . '.png') }}"
                                                alt="Level {{ $current_milestone_level }}" class="milestone-level">

                                            <p class="milestone-label">Total Referrals</p>
                                            <h2 class="milestone-value">{{ number_format($active_referrals_count) }}</h2>
                                            <span class="milestone-sub">
                                                <i
                                                    class="ti ti-users me-1"></i>{{ number_format($next_milestone->required_referrals ?? 0) }}
                                                AR
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Check if there are ANY milestones in the system --}}
                @php
                    $total_milestones = \App\Models\AmbassadorReward::where('status', 'active')->count();
                @endphp

                @if ($total_milestones > 0)
                    {{-- User has completed all milestones --}}
                    <div class="alert alert-success border-0 mb-4"
                        style="background: linear-gradient(135deg, rgba(52, 211, 153, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); border-left: 4px solid #10b981 !important;">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-crown fs-3 text-success me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1 text-white">🎉 Congratulations!</h5>
                                <p class="mb-0 text-white-50">You've achieved all available milestones! You're a true
                                    champion!</p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- No milestones configured in the system --}}
                    <div class="alert alert-info border-0 mb-4"
                        style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%); border-left: 4px solid #3b82f6 !important;">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-info-circle fs-3 text-info me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1 text-white">No Milestones Available</h5>
                                <p class="mb-0 text-white-50">Milestone rewards are currently being configured. Check back
                                    soon!</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Milestone Progress Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <h4 class="text-white mb-1">
                                    <i class="ti ti-chart-line me-2"></i>All Milestones
                                </h4>
                                <p class="text-white-50 mb-0">Track your journey through all reward levels</p>
                            </div>

                            <div class="milestone-progress-wrapper">
                                @forelse($all_milestones as $index => $milestone)
                                    @php
                                        $reward = $milestone['reward'];
                                        $isAchieved = $milestone['is_achieved'];
                                        $progress = $milestone['progress'];
                                        $remaining = $milestone['remaining'];
                                    @endphp

                                    <div class="milestone-item-new">
                                        <div class="milestone-card {{ $isAchieved ? 'achieved' : 'pending' }}">
                                            <!-- Header Section -->
                                            <div class="milestone-header">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                                    <div class="d-flex align-items-center flex-grow-1">
                                                        <div class="milestone-icon me-3">
                                                            @if ($isAchieved)
                                                                <div class="icon-wrapper achieved">
                                                                    <i class="ti ti-check"></i>
                                                                </div>
                                                            @else
                                                                <div class="icon-wrapper pending">
                                                                    <i class="ti ti-lock"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="milestone-info">
                                                            <h5 class="milestone-title mb-1">{{ $reward->title }}</h5>
                                                            <p class="milestone-subtitle mb-0">
                                                                <i
                                                                    class="ti ti-users me-1"></i>{{ number_format($reward->required_referrals) }}
                                                                Active Referrals Required
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="milestone-reward">
                                                        @if ($reward->reward_type == 'cash' && $reward->cash_amount)
                                                            <div class="reward-badge cash">
                                                                <i class="ti ti-coin me-1"></i>
                                                                <span>${{ number_format($reward->cash_amount, 2) }}</span>
                                                            </div>
                                                        @else
                                                            <div class="reward-badge gift">
                                                                <i class="ti ti-gift me-1"></i>
                                                                <span>{{ $reward->description }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Progress Section -->
                                            <div class="milestone-progress mt-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="progress-label">
                                                        @if ($isAchieved)
                                                            <i class="ti ti-circle-check me-1 text-success"></i>
                                                            <span class="text-success">Milestone Achieved!</span>
                                                        @else
                                                            <span class="text-white-50">{{ number_format($remaining) }}
                                                                more referrals needed</span>
                                                        @endif
                                                    </span>
                                                    <span class="progress-percentage">{{ $progress }}%</span>
                                                </div>
                                                <div class="progress-bar-wrapper">
                                                    <div class="progress-bar-bg">
                                                        <div class="progress-bar-fill {{ $isAchieved ? 'achieved' : 'pending' }}"
                                                            style="width: {{ $progress }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="ti ti-package text-white-50" style="font-size: 4rem;"></i>
                                        <h5 class="text-white mt-3">No Milestones Available</h5>
                                        <p class="text-white-50">Check back later for new rewards!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>






            <!-- Referrals List Section -->
            <div class="row mt-1">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <h4 class="text-white mb-1">
                                    <i class="ti ti-users-group me-2"></i>Your Referrals
                                </h4>
                                <p class="text-white-50 mb-0">Monitor your referrals and their activity status</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr style="background: rgba(255, 255, 255, 0.05);">
                                            <th class="text-white border-0">#</th>
                                            <th class="text-white border-0">Name</th>
                                            <th class="text-white border-0">Email</th>
                                            <th class="text-white border-0 text-center">Status</th>
                                            <th class="text-white border-0 text-center">Investments</th>
                                            <th class="text-white border-0">Joined Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($referrals_list as $index => $referral)
                                            <tr
                                                style="background: {{ $index % 2 == 0 ? 'rgba(255, 255, 255, 0.02)' : 'transparent' }};">
                                                <td class="text-white-50">{{ $index + 1 }}</td>
                                                <td class="text-white">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                            style="background: {{ $referral['is_active'] ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #6b7280 0%, #4b5563 100%)' }};">
                                                            <span
                                                                class="text-white fw-bold small">{{ strtoupper(substr($referral['name'], 0, 1)) }}</span>
                                                        </div>
                                                        {{ $referral['name'] }}
                                                    </div>
                                                </td>
                                                <td class="text-white-50 small">{{ $referral['email'] }}</td>
                                                <td class="text-center">
                                                    @if ($referral['is_active'])
                                                        <span
                                                            class="badge bg-success bg-opacity-25 text-success px-3 py-2">
                                                            <i class="ti ti-circle-check me-1"></i>Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-25 text-warning px-3 py-2">
                                                            <i class="ti ti-clock me-1"></i>Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $referral['investment_count'] > 0 ? 'bg-info' : 'bg-secondary' }} px-3 py-2">
                                                        {{ $referral['investment_count'] }}
                                                    </span>
                                                </td>
                                                <td class="text-white-50 small">
                                                    <i class="ti ti-calendar me-1"></i>{{ $referral['joined_date'] }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="ti ti-user-off text-white-50"
                                                            style="font-size: 3rem;"></i>
                                                        <h5 class="text-white mt-3">No Referrals Yet</h5>
                                                        <p class="text-white-50 mb-3">Start inviting people to grow your
                                                            network!</p>
                                                        <a href="{{ route('user.ambassador') }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="ti ti-share me-1"></i>Share Your Referral Link
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($referrals_list->count() > 0)
                                <div class="mt-4 p-3 rounded"
                                    style="background: rgba(102, 126, 234, 0.1); border-left: 4px solid #667eea;">
                                    <div class="row">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <p class="mb-0 text-white-50 small">
                                                <i class="ti ti-info-circle me-1"></i>
                                                <strong class="text-white">Note:</strong> Only referrals with at least one
                                                investment count as "Active"
                                            </p>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-0 text-white-50 small">
                                                Showing <strong class="text-white">{{ $referrals_list->count() }}</strong>
                                                total referrals
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        @include('user.snippets.footer')
    </div>
    <style>
        .milestone-circle {
            /* main size */
            width: 340px;
            height: 340px;
            border-radius: 50%;

            /* dotted outline */
            outline: 2px dashed rgba(255, 255, 255, 0.2);
            outline-offset: 14px;

            /* progress ring */
            background: conic-gradient(#F7CA4A 0%,
                    #B876FD calc(var(--progress) * 1%),
                    #16120F 0);

            display: flex;
            align-items: center;
            justify-content: center;
            /* transform: rotate(-90deg); */
        }



        /* inner dark circle */
        .milestone-center {
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: #171717;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* transform: rotate(90deg); */
        }

        /* level image */
        .milestone-level {
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
        }

        /* text */
        .milestone-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .milestone-value {
            color: #ffffff;
            font-size: 42px;
            font-weight: 700;
            margin: 6px 0;
        }

        .milestone-sub {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* ===============================
       MOBILE RESPONSIVENESS
    ================================ */
        @media only screen and (max-width: 768px) {
            .milestone-circle {
                width: 260px;
                height: 260px;
                outline-offset: 10px;
            }

            .milestone-center {
                width: 210px;
                height: 210px;
            }

            .milestone-level {
                width: 48px;
                height: 48px;
                margin-bottom: 10px;
            }

            .milestone-label {
                font-size: 13px;
            }

            .milestone-value {
                font-size: 34px;
            }

            .milestone-sub {
                font-size: 16px;
            }
        }

        /* Extra small devices */
        @media (max-width: 480px) {
            .milestone-circle {
                width: 220px;
                height: 220px;
                outline-offset: 8px;
            }

            .milestone-center {
                width: 180px;
                height: 180px;
            }

            .milestone-level {
                width: 42px;
                height: 42px;
            }

            .milestone-label {
                font-size: 12px;
            }

            .milestone-value {
                font-size: 30px;
            }

            .milestone-sub {
                font-size: 14px;
            }
        }
    </style>

    {{-- all milestone section   --}}
    <style>
        /* ===============================
                   MILESTONE PROGRESS WRAPPER
                ================================ */
        .milestone-progress-wrapper {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ===============================
                   MILESTONE CARD
                ================================ */
        .milestone-card {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.06),
                    rgba(255, 255, 255, 0.02));
            border-radius: 16px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .milestone-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .milestone-card.achieved {
            border-color: rgba(16, 185, 129, 0.5);
        }

        .milestone-card.pending {
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* ===============================
                   HEADER SECTION
                ================================ */
        .milestone-header {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Icon */
        .milestone-icon .icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-wrapper.achieved {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .icon-wrapper.pending {
            background: rgba(255, 255, 255, 0.15);
            color: #9ca3af;
        }

        /* Title & subtitle */
        .milestone-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 18px;
            line-height: 1.3;
        }

        .milestone-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        /* ===============================
                   REWARD BADGE
                ================================ */
        .milestone-reward {
            max-width: 100%;
        }

        .reward-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 500;
            white-space: normal;
            /* allows long text */
            line-height: 1.4;
        }

        .reward-badge.cash {
            background: rgba(247, 202, 74, 0.2);
            color: #f7ca4a;
        }

        .reward-badge.gift {
            background: rgba(139, 92, 246, 0.2);
            color: #c4b5fd;
        }

        /* Ensure long reward descriptions wrap nicely */
        .reward-badge span {
            word-break: break-word;
            max-width: 100%;
        }

        /* ===============================
                   PROGRESS SECTION
                ================================ */
        .milestone-progress {
            margin-top: 18px;
        }

        .progress-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .progress-percentage {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
        }

        /* Progress bar */
        .progress-bar-wrapper {
            margin-top: 8px;
        }

        .progress-bar-bg {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            width: 0;
            border-radius: 999px;
            transition: width 0.6s ease;
        }

        .progress-bar-fill.pending {
            background: linear-gradient(90deg,
                    #F7CA4A,
                    #B876FD);
        }


        .progress-bar-fill.achieved {
            background: linear-gradient(90deg,
                    #10b981,
                    #34d399);
        }

        /* ===============================
                   RESPONSIVENESS
                ================================ */
        @media (max-width: 768px) {
            .milestone-card {
                padding: 18px;
            }

            .milestone-title {
                font-size: 16px;
            }

            .reward-badge {
                font-size: 12px;
            }
        }
    </style>
@endsection
