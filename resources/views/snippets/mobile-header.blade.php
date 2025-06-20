        <div class="popup-mobile-menu">
            <div class="inner">
                <div class="header-top">
                    <div class="logo">
                        <a href="index.html">
                            <img class="logo-light" src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo">
                            <img class="logo-dark" src="{{ asset('assets/images/logo/logo-dark.png' ) }}" alt="Logo">
                        </a>
                    </div>
                    <div class="close-menu">
                        <button class="close-button">
                            <i class="ri-close-fill"></i>
                        </button>
                    </div>
                </div>
                <ul class="mainmenu">

                    <li class="{{ request()->is('/') ? 'active' : '' }} position-relative">
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
            </div>
        </div>
