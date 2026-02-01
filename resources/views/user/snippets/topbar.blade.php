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
            <div class="topbar-search text-muted d-none d-xl-flex gap-2 align-items-center" data-bs-toggle="modal"
                data-bs-target="#searchModal" type="button">
                <i class="ti ti-link fs-18"></i>
                <span class="me-2">Referral Link</span>
            </div>

        </div>

        <div class="d-flex align-items-center gap-2">

            <!-- Search for small devices -->
            <div class="topbar-item d-flex d-xl-none">
                <button class="topbar-link" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-22"></i>
                </button>
            </div>

            <!-- Language Dropdown -->
            <div class="topbar-item">
                <div class="languageTranslate" id="google_translate_element">
                </div>
            </div>



            <!-- User Dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                        data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">

                        @php
                            $profilePicture = $user->profile->profile_picture ?? null;
                        @endphp

                        <div class="position-relative d-inline-block">

                            <img src="{{ $profilePicture ? asset('storage/profile_pictures/' . $profilePicture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                width="40" class="rounded-circle me-lg-2 d-flex image-profile" alt="user-image">

                            @if (Auth::user()->is_ambassador)
                                <span class="verified-badge">
                                    <i class="ti ti-check"></i>
                                </span>
                            @endif
                        </div>

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
                            <span class="align-middle">Wallet : <span
                                    class="fw-semibold text-success">${{ $walletBalance ?? '0.00' }}</span></span>
                        </a>



                        <!-- item-->
                        <a href="{{ route('user.kyc') }}" class="dropdown-item">
                            <i class="ti ti-lifebuoy me-1 fs-15 align-middle"></i>
                            <span class="align-middle">
                                KYC
                                @if (!$userKyc)
                                    <span class="badge p-1 fs-10 bg-secondary ms-2" style="font-size: 10px">Not
                                        Submitted</span>
                                @elseif ($userKyc->status === 'pending' || $userKyc->status === 'in_review')
                                    <span class="badge p-1 text-warning-subtle bg-warning ms-2"
                                        style="font-size: 10px">Under Review</span>
                                @elseif ($userKyc->status === 'approved')
                                    <span class="badge p-1 fs-10 bg-success ms-2"
                                        style="font-size: 10px">Verified</span>
                                @elseif ($userKyc->status === 'rejected')
                                    <span class="badge p-1 fs-10 bg-danger ms-2" style="font-size: 10px">Rejected</span>
                                @endif
                            </span>
                        </a>

                        @if (Auth::user()->is_ambassador)
                            <!-- item-->
                            <a href="javascript:void(0)" class="dropdown-item">
                                <i class="ti ti-award me-1 fs-17 align-middle"></i>
                                <span class="align-middle">
                                    Status
                                    <span class="badge p-1 fs-10 bg-info ms-2" style="font-size: 10px">
                                        <i class="ti ti-sparkles"></i> Ambassador
                                    </span>
                                </span>
                            </a>
                        @endif

                        <div class="dropdown-divider"></div>


                        <!-- item-->
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item active fw-semibold text-danger">
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

    .verified-badge {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 14px;
        height: 14px;
        background: #4986DB;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    .verified-badge i {
        font-size: 10px;
        color: #fff;
    }
</style>



<style type="text/css">
    .goog-logo-link {
        display: none !important;
    }

    .goog-te-gadget {
        color: transparent !important;
    }


    .goog-te-gadget .goog-te-combo {
        color: #b5b5b5 !important;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 1px solid #fff !important;
        padding: 5px !important;
        padding-left: 10px !important;
        border-radius: 3px !important;
        background-color: transparent !important;
        height: 40px !important;
        cursor: pointer !important;
        margin-top: 20px !important;

        background-repeat: no-repeat;
        background-position: right 8px center;
    }

    .goog-te-gadget .goog-te-combo:focus {
        outline: none;
        background-color: #2a2a2a !important;
    }

    .goog-te-banner-frame.skiptranslate {
        display: none !important;
    }

    #google_translate_element select {
        font-weight: 400;
        /* margin-top: 25px; */
    }

    .VIpgJd-ZVi9od-l4eHX-hSRGPd,
    .VIpgJd-ZVi9od-l4eHX-hSRGPd:link,
    .VIpgJd-ZVi9od-l4eHX-hSRGPd:visited,
    .VIpgJd-ZVi9od-l4eHX-hSRGPd:hover,
    .VIpgJd-ZVi9od-l4eHX-hSRGPd:active {
        display: none !important;
    }

    .goog-te-gadget img {
        display: none !important;
    }

    body>.skiptranslate {
        display: none;
    }

    body {
        top: 0px !important;
    }
</style>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en'
        }, 'google_translate_element');
    }
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
