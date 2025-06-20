        <div class="sidenav-menu">

            <!-- Brand Logo -->
            <a href="index.html" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="dark logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span>
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
                <ul class="side-nav">
                    <li class="side-nav-title">Menu</li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                            <!-- <span class="badge bg-success rounded-pill">5</span> -->
                        </a>
                    </li>


                    <li class="side-nav-item">
                        <a href="{{ route('admin.users') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-users"></i></span>
                            <span class="menu-text"> Users </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#plans" aria-expanded="false" aria-controls="plans" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                            <span class="menu-text">Plans</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="plans">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('plans.create') }}" class="side-nav-link">
                                        <span class="menu-text">Create Plan</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('plans.index') }}" class="side-nav-link">
                                        <span class="menu-text">All Plans</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#wallets" aria-expanded="false" aria-controls="wallets" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-wallet"></i></span>
                            <span class="menu-text">Wallet Address</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="wallets">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('wallets.create') }}" class="side-nav-link">
                                        <span class="menu-text">Add Wallet Address</span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('wallets.index') }}" class="side-nav-link">
                                        <span class="menu-text">Address List</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="side-nav-item">
                        <a href="{{ route('admin.deposits.transactions') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-transfer-in"></i></span>
                            <span class="menu-text"> Deposit History </span>
                        </a>
                    </li>



                    <li class="side-nav-item">
                        <a href="{{ route('admin.investments.index') }}" class="side-nav-link">
                            <span class="menu-icon">
                                <i class="ti ti-stack"></i>
                            </span>
                            <span class="menu-text"> Investments </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.withdrawals') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-currency-dollar"></i></span>
                            <span class="menu-text"> Withdrawals </span>
                        </a>
                    </li>





                    <li class="side-nav-item">
                        <a href="dashboard-wallet.html" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-wallet"></i></span>
                            <span class="menu-text"> Referrals </span>
                        </a>
                    </li>



                    <li class="side-nav-item">
                        <a href="{{ route('admin.transactions.audits') }}" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-activity"></i></span>
                            <span class="menu-text"> All Transactions </span>
                        </a>
                    </li>




                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#media" aria-expanded="false" aria-controls="v" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-photo-video"></i></span>
                            <span class="menu-text">Media</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="media">
                            <ul class="sub-menu">
                                <li class="side-nav-item">
                                    <a href="{{ route('admin.add-video') }}" class="side-nav-link">
                                        <span class="menu-text">Add Video</span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('admin.media.list') }}" class="side-nav-link">
                                        <span class="menu-text">Media List</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.kyc') }}" aria-expanded="false" aria-controls="kyc" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-id"></i></span>
                            <span class="menu-text"> KYC</span>
                        </a>
                    </li>


                    <li class="side-nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-logout"></i></span>
                            <span class="menu-text"> Logout </span>
                        </a>
                    </li>




                    <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout-form2">
                        @csrf
                    </form>


                </ul>

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
