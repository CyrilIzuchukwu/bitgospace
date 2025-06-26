@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="page-container" style="width: 100%; overflow-x: hidden;">

        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Admin Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="">
                <div class="quick-actions-top  mb-3">
                    <div class="">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary"><i class="ti ti-users me-1"></i> Manage Users</a>
                    </div>
                    <div class="">
                        <a href="{{ route('admin.deposits.transactions') }}" class="btn btn-success"><i class="ti ti-coin me-1"></i> Deposits</a>
                    </div>
                    <div class="">
                        <a href="{{ route('admin.withdrawals') }}" class="btn btn-warning"><i class="ti ti-cash me-1"></i> Withdrawals</a>
                    </div>
                    <div class="">
                        <a href="{{ route('admin.investments.index') }}" class="btn btn-info"><i class="ti ti-trending-up me-1"></i> Investments</a>
                    </div>
                </div>

                <div class="admin-dashboard-grid crypto-style">

                    <!-- Total Users Card -->
                    <div class="dashboard-card users-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Total Users</h4>
                                <div class="card-icon glow-blue">
                                    <i class="ti ti-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">{{ $totalUsers }}</h2>
                            <div class="user-stats">
                                <span class="stat-badge active">{{ number_format($activeUsers) }} Active</span>
                                <span class="stat-badge inactive">{{ number_format($inactiveUsers) }} Inactive</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Platform Balance -->
                    <div class="dashboard-card platform-balance-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Platform Balance</h4>
                                <div class="card-icon glow-green">
                                    <i class="ti ti-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ number_format($platformBalance, ) }}</h2>
                            <div class="balance-trend">
                                <span class="trend-up">
                                    <i class="ti ti-trending-up"></i>
                                    +12.5% this month
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Deposits Card -->
                    <div class="dashboard-card total-deposits-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Total Deposits</h4>
                                <div class="card-icon glow-success">
                                    <i class="ti ti-arrow-down-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ number_format($totalDepositsAdmin, 2) }}</h2>
                            <div class="deposit-stats">
                                <span class="stat-badge success">{{ $completedDepositsCountAdmin }} Completed</span>
                                <span class="stat-badge pending">{{ $pendingDepositsCountAdmin }} Pending</span>
                                <span class="stat-badge rejected">{{ $rejectedDepositsCountAdmin }} rejected</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Withdrawals Card -->
                    <div class="dashboard-card total-withdrawals-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Total Withdrawals</h4>
                                <div class="card-icon glow-warning">
                                    <i class="ti ti-arrow-up-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ number_format($totalWithdrawalsAdmin, 2) }}</h2>
                            <div class="withdrawal-stats">
                                <span class="stat-badge success">{{ $approvedWithdrawalsCountAdmin }} Approved</span>
                                <span class="stat-badge pending">{{ $pendingWithdrawalsCountAdmin }} Pending</span>
                                <span class="stat-badge rejected">{{ $rejectedWithdrawalsCountAdmin }} Rejected</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Investments Card -->
                    <div class="dashboard-card total-investments-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Total Investments</h4>
                                <div class="card-icon glow-purple">
                                    <i class="ti ti-trending-up"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ $totalInvestmentsAdmin }}</h2>
                            <div class="investment-breakdown">
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Active:</span>
                                    <span class="breakdown-value">${{ $activeInvestmentsAdmin }}</span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="breakdown-label">Completed:</span>
                                    <span class="breakdown-value">${{ $completedInvestmentsAdmin }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Referral Commissions Card -->
                    <div class="dashboard-card referral-commissions-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Referral Commissions</h4>
                                <div class="card-icon glow-orange">
                                    <i class="ti ti-network"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ $totalReferralCommissionsAdmin }}</h2>
                            <div class="referral-levels">
                                <div class="level-badge">L1: ${{ $level1CommissionsAdmin }}</div>
                                <div class="level-badge">L2: ${{ $level2CommissionsAdmin }}</div>
                                <div class="level-badge">L3: ${{ $level3CommissionsAdmin }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals Card -->
                    <div class="dashboard-card pending-approvals-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Pending Approvals</h4>
                                <div class="card-icon glow-red">
                                    <i class="ti ti-clock-pause"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">{{ $totalPendingApprovalsAdmin }}</h2>
                            <div class="approval-breakdown">
                                <div class="approval-item">
                                    <span class="approval-label">Withdrawals:</span>
                                    <span class="approval-count">{{ $pendingWithdrawalsCountAdmin }}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="approval-label">Deposits:</span>
                                    <span class="approval-count">{{ $pendingDepositsCountAdmin }}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="approval-label">KYC Docs:</span>
                                    <span class="approval-count">{{ $pendingKycCountAdmin }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Revenue Card -->
                    <div class="dashboard-card system-revenue-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">System Revenue</h4>
                                <div class="card-icon glow-teal">
                                    <i class="ti ti-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="balance-amount">${{ $totalInvestmentProfitsAdmin }}</h2>
                            <div class="revenue-breakdown">
                                <div class="revenue-item">
                                    <span class="revenue-label">Investment Profits:</span>
                                    <span class="revenue-value">${{ $totalInvestmentProfitsAdmin }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Card -->
                    <div class="dashboard-card recent-activity-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Recent Activity</h4>
                                <div class="card-icon glow-indigo">
                                    <i class="ti ti-activity"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                @if($latestUser)
                                <div class="activity-item">
                                    <span class="activity-type new-user">New User</span>
                                    <span class="activity-time">{{ $latestUser->created_at->diffForHumans() }}</span>
                                </div>
                                @endif

                                @if($latestDeposit)
                                <div class="activity-item">
                                    <span class="activity-type deposit">Deposit</span>
                                    <span class="activity-time">{{ $latestDeposit->created_at->diffForHumans() }}</span>
                                </div>
                                @endif
                                @if($latestWithdrawal)
                                <div class="activity-item">
                                    <span class="activity-type withdrawal">Withdrawal</span>
                                    <span class="activity-time">{{ $latestWithdrawal->created_at->diffForHumans() }}</span>
                                </div>
                                @endif

                                @if($latestInvestment)
                                <div class="activity-item">
                                    <span class="activity-type investment">Investment</span>
                                    <span class="activity-time">{{ $latestInvestment->created_at->diffForHumans() }}</span>
                                </div>
                                @endif

                                @if(!$latestUser && !$latestDeposit && !$latestWithdrawal && !$latestInvestment)
                                <div class="no-activities">
                                    <i class="ti ti-alert-circle"></i>
                                    <span>No recent activities found</span>
                                </div>
                                @endif
                            </div>
                            <!-- <a href="" class="card-action-link">
                                <i class="ti ti-external-link"></i>
                                View All Activity
                            </a> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RECENT TRANSACTION  -->

    </div>

    @include('admin.snippets.footer')
</div>

<style>
    /* Admin Dashboard Specific Styles */

    .quick-actions-top {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        column-gap: 20px;
    }

    .quick-actions-top div {
        width: 100%;
    }

    .quick-actions-top a {
        width: 100%;
    }

    @media only screen and (max-width: 767px) {
        .quick-actions-top {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            row-gap: 20px;
        }
    }

    .admin-dashboard-grid.crypto-style {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin: 0 auto;
        margin-bottom: 40px;
    }

    .admin-dashboard-grid .dashboard-card {
        background: #1e1f27;
        border-radius: 12px;
        border: 1px solid #2d3748;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .admin-dashboard-grid .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-color: #3b82f6;
    }

    .admin-dashboard-grid .dashboard-card .card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #2d3748;
    }

    .admin-dashboard-grid .dashboard-card .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #94a3b8;
        margin: 0;
    }

    .admin-dashboard-grid .dashboard-card .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .admin-dashboard-grid .dashboard-card .glow-blue {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .admin-dashboard-grid .dashboard-card .glow-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .admin-dashboard-grid .dashboard-card .glow-success {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }

    .admin-dashboard-grid .dashboard-card .glow-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .admin-dashboard-grid .dashboard-card .glow-purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .admin-dashboard-grid .dashboard-card .glow-orange {
        background: linear-gradient(135deg, #f97316, #ea580c);
    }

    .admin-dashboard-grid .dashboard-card .glow-red {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .admin-dashboard-grid .dashboard-card .glow-teal {
        background: linear-gradient(135deg, #14b8a6, #0d9488);
    }

    .admin-dashboard-grid .dashboard-card .glow-indigo {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
    }

    .admin-dashboard-grid .dashboard-card .card-body {
        padding: 20px;
    }

    .admin-dashboard-grid .dashboard-card .balance-amount {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-dashboard-grid .dashboard-card .card-action-link {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #3b82f6;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        margin-top: 10px;
    }

    .admin-dashboard-grid .dashboard-card .card-action-link:hover {
        color: #60a5fa;
    }

    /* User Stats */
    .admin-dashboard-grid .dashboard-card .user-stats {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .admin-dashboard-grid .dashboard-card .stat-badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 500;
    }

    .admin-dashboard-grid .dashboard-card .active {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .admin-dashboard-grid .dashboard-card .inactive {
        background: rgba(107, 114, 128, 0.2);
        color: #9ca3af;
    }

    .admin-dashboard-grid .dashboard-card .success {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .admin-dashboard-grid .dashboard-card .pending {
        background: rgba(234, 179, 8, 0.2);
        color: #eab308;
    }

    .admin-dashboard-grid .dashboard-card .rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    /* Balance Trend */
    .admin-dashboard-grid .dashboard-card .balance-trend {
        margin-top: 10px;
    }

    .admin-dashboard-grid .dashboard-card .trend-up {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #22c55e;
        font-size: 12px;
        font-weight: 500;
    }

    /* Investment Breakdown */
    .admin-dashboard-grid .dashboard-card .investment-breakdown,
    .admin-dashboard-grid .dashboard-card .revenue-breakdown {
        margin-top: 15px;
    }

    .admin-dashboard-grid .dashboard-card .breakdown-item,
    .admin-dashboard-grid .dashboard-card .revenue-item {
        display: flex;
        justify-content: between;
        align-items: center;
        padding: 4px 0;
        font-size: 12px;
    }

    .admin-dashboard-grid .dashboard-card .breakdown-label,
    .admin-dashboard-grid .dashboard-card .revenue-label {
        color: #94a3b8;
        flex: 1;
    }

    .admin-dashboard-grid .dashboard-card .breakdown-value,
    .admin-dashboard-grid .dashboard-card .revenue-value {
        color: white;
        font-weight: 600;
    }

    /* Referral Levels */
    .admin-dashboard-grid .dashboard-card .referral-levels {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .admin-dashboard-grid .dashboard-card .level-badge {
        font-size: 12px;
        padding: 4px 8px;
        background: rgba(139, 92, 246, 0.2);
        color: #8b5cf6;
        border-radius: 4px;
        font-weight: 500;
    }

    /* Approval Breakdown */
    .admin-dashboard-grid .dashboard-card .approval-breakdown {
        margin-top: 15px;
    }

    .admin-dashboard-grid .dashboard-card .approval-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 0;
        font-size: 12px;
    }

    .admin-dashboard-grid .dashboard-card .approval-label {
        color: #94a3b8;
    }

    .admin-dashboard-grid .dashboard-card .approval-count {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Activity List */
    .admin-dashboard-grid .dashboard-card .activity-list {
        margin-top: 10px;
    }

    .admin-dashboard-grid .dashboard-card .activity-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        font-size: 12px;
        border-bottom: 1px solid #2d3748;
    }

    .admin-dashboard-grid .dashboard-card .activity-item:last-child {
        border-bottom: none;
    }

    .admin-dashboard-grid .dashboard-card .activity-type {
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 11px;
    }

    .admin-dashboard-grid .dashboard-card .activity-type.new-user {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .admin-dashboard-grid .dashboard-card .activity-type.deposit {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }

    .admin-dashboard-grid .dashboard-card .activity-type.withdrawal {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }

    .admin-dashboard-grid .dashboard-card .activity-type.investment {
        background: rgba(139, 92, 246, 0.2);
        color: #8b5cf6;
    }

    .admin-dashboard-grid .dashboard-card .activity-time {
        color: #94a3b8;
        font-size: 11px;
    }

    /* Quick Actions Section */
    .quick-actions-section {
        background: #1e1f27;
        border-radius: 12px;
        border: 1px solid #2d3748;
        padding: 20px;
    }

    .quick-actions-section .section-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
        margin-bottom: 15px;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .quick-action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 15px;
        background: #2d3748;
        border-radius: 8px;
        text-decoration: none;
        color: #94a3b8;
        transition: all 0.3s ease;
    }

    .quick-action-item:hover {
        background: #374151;
        color: #3b82f6;
        transform: translateY(-2px);
    }

    .quick-action-item .action-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #3b82f6;
    }

    .quick-action-item span {
        font-size: 12px;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .admin-dashboard-grid.crypto-style {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .admin-dashboard-grid.crypto-style {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection