    <header class="rainbow-header header-default header-left-align header-not-transparent header-sticky">
        <div class="container position-relative">
            <div class="d-flex align-items-center justify-content-between">

                <div class="header-left">
                    <div class="logo">
                        <a href="index.html">
                            <img class="logo-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo">
                            <!-- <img class="logo-dark" src="assets/images/logo/logo-dark.png" alt="Corporate Logo"> -->
                        </a>
                    </div>
                </div>

                <div class="header-center">
                    <nav class="mainmenu-nav d-none d-lg-block">
                        <ul class="mainmenu">
                            <li class="{{ request()->is('/') ? 'active' : '' }}">
                                <a href="/">Home</a>
                            </li>
                            <li class="{{ request()->routeIs('about-us') ? 'active' : '' }}">
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>
                            <li class="{{ request()->is('meet-jarden') ? 'active' : '' }}">
                                <a href="{{ route('meet-jarden') }}">🧠Meet Jarden</a>
                            </li>
                            <li class="{{ request()->is('contact') ? 'active' : '' }}">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                        </ul>

                    </nav>
                </div>


                <div class="header-right">
                    <div class="header-btn">
                        @auth
                        @if (auth()->user()->role === 'admin')
                        <a class="default-btn" href="{{ route('admin.dashboard') }}">
                            Admin Dashboard
                        </a>
                        @elseif (auth()->user()->role === 'user')
                        <a class="default-btn" href="{{ route('user.dashboard') }}">
                            Dashboard
                        </a>
                        @endif
                        @else
                        <a class="default-btn" href="{{ route('login') }}">
                            Login
                        </a>
                        @endauth
                    </div>

                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar ml--5 d-block d-lg-none">
                        <div class="hamberger">
                            <button class="hamberger-button">
                                <i class="ri-menu-line"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                </div>

            </div>
        </div>
    </header>
