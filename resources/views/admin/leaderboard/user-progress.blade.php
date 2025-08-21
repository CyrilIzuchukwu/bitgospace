@extends('layouts.admin')
@section('content')

<style>
    .admin-progress-dashboard {
        background: #f8fafc;
        min-height: 100vh;
        padding: 20px 0;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: dashboardRotate 30s linear infinite;
    }

    @keyframes dashboardRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .dashboard-stats {
        position: relative;
        z-index: 1;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #667eea, #764ba2);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 24px;
        color: #667eea;
        opacity: 0.3;
    }

    .progress-table-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
    }

    .table-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 25px 30px;
        border-bottom: 2px solid #e5e7eb;
    }

    .table-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .table-subtitle {
        color: #6b7280;
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    .filters-row {
        padding: 20px 30px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-input {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 8px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .progress-table {
        width: 100%;
        margin: 0;
    }

    .progress-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .progress-table th {
        padding: 20px 25px;
        color: white;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .progress-table td {
        padding: 20px 25px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .progress-table tbody tr {
        transition: all 0.3s ease;
    }

    .progress-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .user-details {
        min-width: 0;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 3px 0;
        font-size: 15px;
    }

    .user-email {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .progress-visual {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 200px;
    }

    .progress-bar-admin {
        flex: 1;
        height: 8px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill-admin {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
        border-radius: 10px;
        transition: width 0.8s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-fill-admin::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: adminProgressShimmer 2s infinite;
    }

    @keyframes adminProgressShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .progress-text {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        min-width: 40px;
    }

    .stage-info {
        text-align: center;
        min-width: 120px;
    }

    .stage-current {
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 3px 0;
        font-size: 16px;
    }

    .stage-total {
        font-size: 12px;
        color: #6b7280;
        margin: 0;
    }

    .amount-display {
        text-align: right;
        min-width: 100px;
    }

    .amount-value {
        font-weight: 700;
        color: #059669;
        font-size: 16px;
        margin: 0 0 3px 0;
    }

    .amount-label {
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .referral-count {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #4b5563;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        border: none;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #667eea;
        color: white;
    }

    .btn-view:hover {
        background: #5a6fd8;
        transform: translateY(-1px);
    }

    .pagination-container {
        padding: 25px 30px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .empty-state {
        text-align: center;
        padding: 60px 30px;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 48px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }

        .progress-table {
            font-size: 14px;
        }

        .progress-table th,
        .progress-table td {
            padding: 15px 10px;
        }

        .user-info {
            flex-direction: column;
            text-align: center;
        }
    }

    .top-performer-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: linear-gradient(45deg, #ffd700, #ffed4e);
        color: #92400e;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
    }
</style>

<div class="page-content">
    <div class="page-container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="dashboard-stats">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="mb-3" style="font-weight: 800;">📊 User Progress Analytics</h1>
                        <p class="mb-0 opacity-90">Monitor and analyze all user referral progress across leaderboard stages</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <button class="btn btn-light btn-lg" onclick="exportData()">
                            <i class="ti ti-download me-2"></i>Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="ti ti-users stat-icon"></i>
                <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <i class="ti ti-currency-dollar stat-icon"></i>
                <div class="stat-value">${{ number_format($stats['total_referral_volume'], 0) }}</div>
                <div class="stat-label">Total Volume</div>
            </div>
            <div class="stat-card">
                <i class="ti ti-chart-line stat-icon"></i>
                <div class="stat-value">${{ number_format($stats['average_referral'], 0) }}</div>
                <div class="stat-label">Average Referral</div>
            </div>
            <div class="stat-card">
                <i class="ti ti-trophy stat-icon"></i>
                <div class="stat-value">{{ $stats['stages_count'] }}</div>
                <div class="stat-label">Total Stages</div>
            </div>
        </div>

        <!-- Progress Table -->
        <div class="progress-table-container">
            <div class="table-header">
                <h2 class="table-title">User Progress Leaderboard</h2>
                <p class="table-subtitle">Real-time tracking of all user referral milestones and achievements</p>
            </div>

            <div class="filters-row">
                <input type="text" class="filter-input" id="searchUsers" placeholder="🔍 Search users...">
                <select class="filter-input" id="filterStage">
                    <option value="">All Stages</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
                <select class="filter-input" id="filterStatus">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            @if($users->count() > 0)
                <table class="progress-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>User</th>
                            <th>Progress</th>
                            <th>Stage</th>
                            <th>Referral Amount</th>
                            <th>Referrals</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @foreach($users as $index => $user)
                            <tr data-user-id="{{ $user->id }}">
                                <td>
                                    <div class="d-flex align-items-center position-relative">
                                        <span class="fw-bold" style="font-size: 18px; color: #667eea;">
                                            #{{ $index + 1 }}
                                        </span>
                                        @if($index === 0)
                                            <div class="top-performer-badge">👑</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->first_name ?? $user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <h6 class="user-name">
                                                {{ $user->first_name }} {{ $user->last_name ?? '' }}
                                            </h6>
                                            <p class="user-email">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress-visual">
                                        <div class="progress-bar-admin">
                                            <div class="progress-fill-admin"
                                                 style="width: {{ $user->progress_percentage }}%">
                                            </div>
                                        </div>
                                        <span class="progress-text">{{ round($user->progress_percentage) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="stage-info">
                                        <h6 class="stage-current">{{ $user->completed_stages }}</h6>
                                        <p class="stage-total">of {{ $user->total_stages }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="amount-display">
                                        <h6 class="amount-value">${{ number_format($user->referral_total, 2) }}</h6>
                                        <p class="amount-label">Total Referrals</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="referral-count">
                                        {{ $user->referred_count }} {{ Str::plural('referral', $user->referred_count) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $status = 'inactive';
                                        if ($user->referral_total > 0) {
                                            $status = $user->completed_stages == $user->total_stages ? 'completed' : 'active';
                                        }
                                    @endphp
                                    <span class="status-badge status-{{ $status }}">
                                        @if($status === 'completed') ✅ Completed
                                        @elseif($status === 'active') 🔥 Active
                                        @else 😴 Inactive
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view"
                                                onclick="viewUserDetails({{ $user->id }})"
                                                title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">
                                Showing {{ $users->count() }} of {{ $users->count() }} users
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted">
                                Last updated: {{ now()->format('M d, Y H:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📊</div>
                    <h3>No User Progress Data</h3>
                    <p>No users have started their referral journey yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">👤 User Progress Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <!-- User details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Search and filter functionality
document.getElementById('searchUsers').addEventListener('input', filterUsers);
document.getElementById('filterStage').addEventListener('change', filterUsers);
document.getElementById('filterStatus').addEventListener('change', filterUsers);

function filterUsers() {
    const searchTerm = document.getElementById('searchUsers').value.toLowerCase();
    const stageFilter = document.getElementById('filterStage').value;
    const statusFilter = document.getElementById('filterStatus').value;

    const rows = document.querySelectorAll('#usersTableBody tr');

    rows.forEach(row => {
        const userName = row.querySelector('.user-name').textContent.toLowerCase();
        const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
        const statusBadge = row.querySelector('.status-badge').className;

        let showRow = true;

        // Search filter
        if (searchTerm && !userName.includes(searchTerm) && !userEmail.includes(searchTerm)) {
            showRow = false;
        }

        // Status filter
        if (statusFilter && !statusBadge.includes(`status-${statusFilter}`)) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    });
}

function viewUserDetails(userId) {
    // You can implement this to show detailed user progress
    const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    document.getElementById('userDetailsContent').innerHTML = `
        <div class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading user details...</p>
        </div>
    `;
    modal.show();

    // Here you would typically make an AJAX request to load user details
    // For now, we'll just show a placeholder
    setTimeout(() => {
        document.getElementById('userDetailsContent').innerHTML = `
            <div class="alert alert-info">
                <h6>Feature Coming Soon</h6>
                <p class="mb-0">Detailed user progress view will be implemented here.</p>
            </div>
        `;
    }, 1000);
}

function exportData() {
    // Implement export functionality
    alert('Export functionality will be implemented here.');
}

// Auto-refresh data every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);
</script>

@endsection
