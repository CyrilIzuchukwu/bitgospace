<header class="app-topbar">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">

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

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button">
                <i class="ti ti-menu-deep fs-24"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="ti ti-menu-deep fs-22"></i>
            </button>


        </div>

        <div class="d-flex align-items-center gap-2">


            <!-- Light/Dark Mode Button -->
            <!-- <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon fs-22"></i>
                </button>
            </div> -->

            <!-- User Dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none pl-2" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('dashboard_assets/assets/images/users/avatar1.jpg') }}" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image">
                        <span class="d-lg-flex flex-column gap-1 d-none">
                            <h5 class="my-0">{{ Auth::user()->name }}</h5>
                            <h6 class="my-0 fw-normal">{{ Auth::user()->email }}</h6>
                        </span>
                        <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                            <span class="align-middle">My Account</span>
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
