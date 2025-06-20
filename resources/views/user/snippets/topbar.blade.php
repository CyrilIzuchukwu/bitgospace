<header class="app-topbar">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">

            <!-- Brand Logo -->
            <a href="/" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="dark logo"></span>
                    <span class="logo-sm"><img src="dashboard_assets/assets/images/logo-sm.png" alt="small logo"></span>
                </span>
            </a>

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button">
                <i class="ti ti-menu-deep fs-24"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="ti ti-menu-deep fs-22"></i>
            </button>

            <!-- Button Trigger Search Modal -->
            <div class="topbar-search text-muted d-none d-xl-flex gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                <i class="ti ti-link fs-18"></i>
                <span class="me-2">Referral Link</span>
            </div>

            <!-- Mega Menu Dropdown -->
            <!-- <div class="topbar-item d-none d-md-flex">
                <div class="dropdown">
                    <a href="#" class="topbar-link btn btn-link px-2 dropdown-toggle drop-arrow-none fw-medium" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-offset="0,17" aria-haspopup="false" aria-expanded="false">
                        Pages <i class="ti ti-chevron-down ms-1"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-md p-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="p-3">
                                    <h5 class="mb-2 fw-semibold">UI Components</h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <a href="#!">Widgets</a>
                                        </li>
                                        <li>
                                            <a href="extended-dragula.html">Dragula</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="d-flex align-items-center gap-2">

            <!-- Search for small devices -->
            <div class="topbar-item d-flex d-xl-none">
                <button class="topbar-link" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-22"></i>
                </button>
            </div>

            <!-- Language Dropdown -->
            <!-- <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                        <img src="dashboard_assets/assets/images/flags/us.svg" alt="user-image" class="w-100 rounded" height="18" id="selected-language-image">
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">

                        <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en">
                            <img src="dashboard_assets/assets/images/flags/us.svg" alt="user-image" class="me-1 rounded" height="18" data-translator-image> <span class="align-middle">English</span>
                        </a>
                    </div>
                </div>
            </div> -->





            <!-- Light/Dark Mode Button -->
            <!-- <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon fs-22"></i>
                </button>
            </div> -->

            <!-- User Dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">

                        @php
                        $profilePicture = $user->profile->profile_picture ?? null;
                        @endphp

                        <img src="{{ $profilePicture ? asset('storage/profile_pictures/' . $profilePicture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}" width="40" class="rounded-circle me-lg-2 d-flex image-profile" alt="user-image">
                        <span class="d-lg-flex flex-column gap-1 d-none">
                            <h5 class="my-0">{{ Auth::user()->name }}</h5>
                            <h6 class="my-0 fw-normal">{{ Auth::user()->email }}</h6>
                        </span>
                        <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="{{ route('user.profile') }}" class="dropdown-item">
                            <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                            <span class="align-middle">My Profile</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-wallet me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Wallet : <span class="fw-semibold text-success">${{ $walletBalance ?? '0.00' }}</span></span>
                        </a>



                        <!-- item-->
                        <a href="{{ route('user.kyc') }}" class="dropdown-item">
                            <i class="ti ti-lifebuoy me-1 fs-15 align-middle"></i>
                            <span class="align-middle">
                                KYC
                                @if (!$userKyc)
                                <span class="badge p-1 fs-10 bg-secondary ms-2" style="font-size: 10px">Not Submitted</span>
                                @elseif ($userKyc->status === 'pending' || $userKyc->status === 'in_review')
                                <span class="badge p-1 text-warning-subtle bg-warning ms-2" style="font-size: 10px">Under Review</span>
                                @elseif ($userKyc->status === 'approved')
                                <span class="badge p-1 fs-10 bg-success ms-2" style="font-size: 10px">Verified</span>
                                @elseif ($userKyc->status === 'rejected')
                                <span class="badge p-1 fs-10 bg-danger ms-2" style="font-size: 10px">Rejected</span>
                                @endif
                            </span>
                        </a>

                        <div class="dropdown-divider"></div>


                        <!-- item-->
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item active fw-semibold text-danger">
                            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Sign Out</span>
                        </a>


                        <form action="{{ route('logout') }}" method="post" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .image-profile {
        width: 40px !important;
        height: 40px !important;
        object-fit: cover !important;
        border-radius: 50%;
    }
</style>
