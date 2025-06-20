        <div class="sidenav-menu">

            <!-- Brand Logo -->
            <a href="/" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" width="150" alt="logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span>
                <!--
                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="dark logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span> -->
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <button class="button-sm-hover">
                <i class="ti ti-circle align-middle"></i>
            </button>

            <!-- Full Sidebar Menu Close Button -->
            <button class="button-close-fullsidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            <div data-simplebar>

                <!--- Sidenav Menu -->
                <ul class="side-nav mt-4">
                    <!-- <li class="side-nav-title">Dashboard</li> -->

                    <li class="side-nav-item">
                        <a href="{{ route('user.dashboard') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                            <!-- <span class="badge bg-success rounded-pill">5</span> -->
                        </a>
                    </li>


                    <li class="side-nav-title mt-3">STAKES</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#investement" aria-expanded="false" aria-controls="investement" class="side-nav-link">
                            <span class="menu-icon">
                                <i class="ti ti-stack"></i>
                            </span>

                            <span class="menu-text"> Smart trade</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="investement">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('user.trades') }}" class="side-nav-link">
                                        <span class="menu-text">Trades (Plans) </span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('user.investment-list') }}" class="side-nav-link">
                                        <span class="menu-text">History </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>



                    <li class="side-nav-title mt-3">Transactions</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#deposits" aria-expanded="false" aria-controls="deposits" class="side-nav-link">
                            <span class="menu-icon">
                                <i class="ti ti-credit-card"></i>

                            </span>
                            <span class="menu-text"> Deposits</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="deposits">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('user.deposit') }}" class="side-nav-link">
                                        <span class="menu-text">Deposit Money</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('user.deposit-list') }}" class="side-nav-link">
                                        <span class="menu-text">Deposit List </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#withdraw" aria-expanded="false" aria-controls="withdraw" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-currency-dollar"></i></span>
                            <span class="menu-text"> Withdrawals</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="withdraw">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('user.withdrawal') }}" class="side-nav-link">
                                        <span class="menu-text">Withdraw Money</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('user.withdrawal.history') }}" class="side-nav-link">
                                        <span class="menu-text">Withdrawal List </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('user.transactions') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-activity"></i></span>
                            <span class="menu-text"> Transactions </span>
                        </a>
                    </li>


                    <li class="side-nav-title mt-3">Referrals</li>



                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#referrals" aria-expanded="false" aria-controls="referrals" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-users"></i></span>
                            <span class="menu-text"> Referrals </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="referrals">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('user.referrals') }}" class="side-nav-link ">
                                        <span class="menu-text">Referrals</span>
                                    </a>
                                </li>

                                <li class="side-nav-item ">
                                    <a href="{{ route('user.referrals.users') }}" class="side-nav-link">
                                        <span class="menu-text">Referred users</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('user.referrals.commissions') }}" class="side-nav-link">
                                        <span class="menu-text">Referral commission</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title mt-3">Settings</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-settings"></i></span>
                            <span class="menu-text"> Settings</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('user.profile') }}" class="side-nav-link ">
                                        <span class="menu-text">Profile</span>
                                    </a>
                                </li>

                                <li class="side-nav-item ">
                                    <a href="{{ route('user.kyc') }}" class="side-nav-link">
                                        <span class="menu-text">KYC Verfication</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('user.kyc-list') }}" class="side-nav-link">
                                        <span class="menu-text">KYC List</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-title mt-3">Documentations</li>
                    <li class="side-nav-item">
                        <a href="{{ route('user.media') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-photo-video"></i></span>
                            <span class="menu-text"> Media </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('user.pdf') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-file-type-pdf"></i></span>
                            <span class="menu-text"> PDF </span>
                        </a>
                    </li>



                    <li class="side-nav-title mt-3">Markets & Apps</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#markets" aria-expanded="false" aria-controls="markets" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-medical-cross"></i></span>
                            <span class="menu-text"> Markets</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="markets">
                            <ul class="sub-menu">

                                <li class="side-nav-item">
                                    <a href="{{ route('markets.overview') }}" class="side-nav-link">
                                        <span class="menu-text">Market Overview</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('markets.livePrice') }}" class="side-nav-link">
                                        <span class="menu-text">Market Live Price</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();" class="side-nav-link text-danger">
                            <span class="menu-icon"> <i class="ti ti-logout fs-17 align-middle"></i></span>
                            <span class="menu-text"> Logout </span>
                        </a>
                    </li>

                </ul>

                <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout-form2">
                    @csrf
                </form>

                <!-- Help Box -->
                <!-- <div class="help-box text-center">
                    <img src="dashboard_assets/assets/images/coffee-cup.svg" height="90" alt="Helper Icon Image" />
                    <h5 class="mt-3 fw-semibold fs-16">Unlimited Access</h5>
                    <p class="mb-3 text-muted">Upgrade to plan to get access to unlimited reports</p>
                    <a href="javascript: void(0);" class="btn btn-danger btn-sm">Upgrade</a>
                </div> -->

                <div class="clearfix"></div>
            </div>
        </div>
