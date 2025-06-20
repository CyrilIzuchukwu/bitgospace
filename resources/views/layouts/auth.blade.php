<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1"> <!-- 0 == light, 1 == dark -->

    <title>Bit-Go-Space</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- CSS ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/feature.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/authResponsiveness.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <main class="page-wrapper">


        @include('partials.preloader')


        @include('snippets.header')



        <!-- Start Theme Style  -->
        <div>
            <div class="rainbow-gradient-circle"></div>
            <div class="rainbow-gradient-circle theme-pink"></div>
        </div>
        <!-- End Theme Style  -->



        @include('snippets.mobile-header')

        <!-- Start Slider Area  -->
        @yield('content')
        <!-- End Slider Area  -->

        <!-- Start Seperator Area  -->
        <!-- <div class="rbt-separator-mid">
            <div class="container">
                <hr class="rbt-separator m-0">
            </div>
        </div> -->
        <!-- End Seperator Area  -->


        @include('snippets.footer')

    </main>

    <!-- All Scripts  -->
    <!-- Start Top To Bottom Area  -->
    <div class="rainbow-back-top">
        <i class="feather-arrow-up"></i>
    </div>
    <!-- End Top To Bottom Area  -->
    <!-- JS
============================================ -->
    <script src="{{ asset('assets/js/vendor/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoint.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sal.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/masonry.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/imageloaded.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/magnify.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/lightbox.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/easypie.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/text-type.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.style.swicher.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-one-page-nav.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#passwordInput').attr('type', 'password');


            $('#hideEye').click(function() {
                $('#passwordInput').attr('type', 'text');
                $(this).hide();
                $('#showEye').show();
            });


            $('#showEye').click(function() {
                $('#passwordInput').attr('type', 'password');
                $(this).hide();
                $('#hideEye').show();
            });
        });
    </script>


    <style>
        .alert-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 250px;
            max-width: 400px;
            z-index: 9999;
            display: none;
        }

        .progress-bar {
            height: 4px;
            background-color: #28a745;
            /* Green for success */
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            animation: progress 7s linear forwards;
        }

        .progress-bar.error {
            background-color: #dc3545;
            /* Red for error */
        }

        @keyframes progress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>

    @if(session('success') || session('error'))
    <div class="alert-toast alert alert-{{ session('success') ? 'success' : 'danger' }}" id="toastAlert">
        <strong>{{ session('success') ?? session('error') }}</strong>
        <div class="progress-bar {{ session('success') ? '' : 'error' }}"></div>
    </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let alertBox = document.getElementById("toastAlert");
            if (alertBox) {
                alertBox.style.display = "block";
                setTimeout(() => {
                    alertBox.style.opacity = "0";
                    setTimeout(() => {
                        alertBox.remove();
                    }, 500); // Fade-out effect
                }, 4000); // 3 seconds
            }
        });
    </script>


    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 800);
        });
    </script>
</body>

</html>
