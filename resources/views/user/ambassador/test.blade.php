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

      <!-- Current Milestone Card -->
      <div class="dashboard-card referral-card">
          <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Current Milestone</h4>
                  <div class="card-icon glow-purple">
                      <i class="ti ti-trophy"></i>
                  </div>
              </div>
          </div>
          <div class="card-body">
              @if ($current_milestone)
                  <h2 class="balance-amount" style="font-size: 1.5rem;">{{ $current_milestone->title }}</h2>
                  <p class="text-white-50 mb-0 small mt-2">Achievement Unlocked</p>
              @else
                  <h2 class="balance-amount" style="font-size: 1.5rem;">No Milestone</h2>
                  <p class="text-white-50 mb-0 small mt-2">Keep referring!</p>
              @endif
          </div>
      </div>
  </div>



  <!-- Current Milestone Status Alert -->
  @if ($next_milestone)
      <div class="alert alert-info border-0 mb-4"
          style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea !important;">
          <div class="d-flex align-items-center">
              <i class="ti ti-target fs-3 text-primary me-3"></i>
              <div class="flex-grow-1">
                  <h5 class="alert-heading mb-1 text-white">Current Target: {{ $next_milestone->title }}</h5>
                  <p class="mb-0 text-white-50">
                      You need <strong
                          class="text-warning">{{ number_format($next_milestone->required_referrals - $active_referrals_count) }}
                          more active referrals</strong>
                      to unlock this reward!
                      ({{ number_format($active_referrals_count) }}/{{ number_format($next_milestone->required_referrals) }})
                  </p>
              </div>
          </div>
      </div>
  @else
      <div class="alert alert-success border-0 mb-4"
          style="background: linear-gradient(135deg, rgba(52, 211, 153, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); border-left: 4px solid #10b981 !important;">
          <div class="d-flex align-items-center">
              <i class="ti ti-crown fs-3 text-success me-3"></i>
              <div>
                  <h5 class="alert-heading mb-1 text-white">🎉 Congratulations!</h5>
                  <p class="mb-0 text-white-50">You've achieved all available milestones! You're a true champion!
                  </p>
              </div>
          </div>
      </div>
  @endif

  <!-- Milestone Progress Section - Redesigned -->
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

                          <div class="milestone-item-new mb-4">
                              <div class="milestone-card {{ $isAchieved ? 'achieved' : 'pending' }}">
                                  <!-- Header Section -->
                                  <div class="milestone-header">
                                      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
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
