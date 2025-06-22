        @extends('layouts.dashboard')
        @section('content')
        <div class="page-content">
            <div class="page-container">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                            </div>
                            <!-- <span>Dashboard</span> -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="">
                                <a href="{{ route('user.deposit') }}" class="btn btn-primary"><i class="ti ti-coin me-1"></i> Deposit</a>
                            </div>
                            <div class="">
                                <a href="{{ route('user.withdrawal') }}" class="btn btn-info "><i class="ti ti-coin me-1"></i>Withdraw</a>
                            </div>
                        </div>

                        <div class="user-dashboard-grid crypto-style">

                            <!-- Balance Card -->
                            <div class="dashboard-card balance-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Wallet Balance</h4>
                                        <div class="card-icon glow-blue">
                                            <i class="ti ti-wallet"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="balance-amount">
                                            <span id="balance-amount">${{ $walletBalance ?? '0.00' }}</span>
                                            <a href="#!" class="visibility-toggle" id="toggle-visibility">
                                                <i class="ti ti-eye" id="visibility-icon"></i>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <!-- Deposit Card -->
                            <div class="dashboard-card deposit-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Total Deposits</h4>
                                        <div class="card-icon glow-green">
                                            <i class="ti ti-arrow-down-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="balance-amount">${{ $totalDeposits ?? '0.00' }}</h2>
                                </div>
                            </div>

                            <!-- Withdrawal Card -->
                            <div class="dashboard-card withdrawal-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Total Withdrawals</h4>
                                        <div class="card-icon glow-red">
                                            <i class="ti ti-arrow-up-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="balance-amount">${{ $totalWithdrawals }}</h2>
                                    <div class="withdrawal-stats">
                                        <span class="stat-badge success">{{ $successfulWithdrawalsCount }} Successful</span>
                                        <span class="stat-badge pending">{{ $pendingWithdrawalsCount }} Pending</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Referral Card -->
                            <div class="dashboard-card referral-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Referral Earnings</h4>
                                        <div class="card-icon glow-purple">
                                            <i class="ti ti-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="balance-amount">${{ $totalReferralBonus }}</h2>
                                    <div class="referral-levels">
                                        <div class="level-badge">L1: ${{ $level1Commissions }}</div>
                                        <div class="level-badge">L2: ${{ $level2Commissions }}</div>
                                        <div class="level-badge">L3: ${{ $level3Commissions }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Investment Card -->
                            <div class="dashboard-card investment-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Total Investment</h4>
                                        <div class="card-icon glow-orange">
                                            <i class="ti ti-trending-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="balance-amount">${{ $totalInvestments }}</h2>
                                </div>
                            </div>

                            <!-- Active Investments Card -->
                            <div class="dashboard-card active-investment-card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Active Investments</h4>
                                        <div class="card-icon glow-teal">
                                            <i class="ti ti-clock-play"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="balance-amount">${{ $runningInvestments }}</h2>
                                    <div class="active-investments">
                                        @if($runningInvestments > 0)
                                        @else
                                        <div class="no-investments">
                                            <i class="ti ti-alert-circle"></i>
                                            <span>No active investments</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- live chart board  -->
                <div class="row sm-gutters">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="{{ asset('dashboard_assets/assets/embeded/embed-widget-screener.js' ) }}"
                            async>
                            {
                                "width": "100%",
                                "height": 400,
                                "defaultColumn": "overview",
                                "screener_type": "crypto_mkt",
                                "displayCurrency": "USD",
                                "colorTheme": "dark",
                                "locale": "en"
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>

                <!-- chart scrolling  -->
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="{{ asset('dashboard_assets/assets/embeded/embed-widget-ticker-tape.js' ) }}"
                                async>
                                {
                                    "symbols": [{
                                            "description": "",
                                            "proName": "BINANCE:SOLUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:BTCUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:GRTUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:BNBUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:AXSUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BITFINEX:BTCUSD"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:DOTUSDT"
                                        },
                                        {
                                            "description": "",
                                            "proName": "BINANCE:ICPUSDT"
                                        }
                                    ],
                                    "showSymbolLogo": true,
                                    "displayMode": "compact",
                                    "colorTheme": "dark",
                                    "locale": "en"
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div> <!-- container -->

            <!-- Footer Start -->
            @include('user.snippets.footer')
            <!-- end Footer -->

        </div>

        <script>
            const balanceText = document.getElementById('balance-amount');
            const toggleBtn = document.getElementById('toggle-visibility');
            const icon = document.getElementById('visibility-icon');

            // Load state from localStorage
            let isHidden = localStorage.getItem('balanceHidden') === 'true';

            const applyBlur = () => {
                balanceText.classList.add('blurred');
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            };

            const removeBlur = () => {
                balanceText.classList.remove('blurred');
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            };

            const updateUI = () => {
                if (isHidden) {
                    applyBlur();
                } else {
                    removeBlur();
                }
            };

            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                isHidden = !isHidden;
                localStorage.setItem('balanceHidden', isHidden);
                updateUI();
            });

            // Initial setup
            updateUI();
        </script>

        @endsection
