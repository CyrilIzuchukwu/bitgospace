<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <title>BitGoSpace | AI-Powered Crypto Arbitrage Trading Platform</title> -->
    <title>BitGoSpace | AI-Powered Crypto Investing with Jarden</title>
    <meta name="description" content="At BitGoSpace, we simplify crypto earnings by using advanced AI to scan global exchanges for the best price differences — so you can earn passively through smart, automatic trades. Jarden does the hard work; you enjoy the returns..">
    <meta name="theme-style-mode" content="1">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.bitgospace.com/">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.bitgospace.com/">
    <meta property="og:title" content="BitGoSpace | AI-Powered Crypto Arbitrage Trading Platform">

    <meta property="og:description" content="At BitGoSpace, we simplify crypto earnings by using advanced AI to scan global exchanges for the best price differences — so you can earn passively through smart, automatic trades. Jarden does the hard work; you enjoy the returns.">
    <meta property="og:image" content="https://www.bitgospace.com/assets/images/logo/logo.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">


    <meta name="google-site-verification" content="ErJsMbwiF245k2p5tzpJFI45r2Bi810lR4Th3dAwVzM" />


    <!-- Favicon -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}g">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon.png') }}">


    <!-- Primary Favicon (32x32) -->
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.bitgospace.com/assets/images/favicon.png">

    <!-- Apple Touch Icon (180x180 for iOS) -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">


    <!-- Legacy ICO Format (16x16, for old browsers) -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">


    <!-- Structured Data / Schema Markup -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "BitGoSpace",
            "url": "https://www.bitgospace.com",
            "logo": "https://www.bitgospace.com/assets/images/logo/logo.png",
            "image": "https://www.bitgospace.com/assets/images/logo/logo.png",
            "description": "AI-powered crypto arbitrage trading platform",

        }
    </script>


    <!-- Additional SEO Meta Tags -->
    <meta name="keywords" content="crypto arbitrage, AI trading bot, passive crypto income, Jarden trading bot, cryptocurrency automation, bitcoin arbitrage, ethereum trading, automated crypto trading">
    <meta name="author" content="BitGoSpace">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">




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

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-responsiveness.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!--  -->
    <link rel="preload" href="{{ asset('assets/fonts/cabinet/CabinetGrotesk-Extrabold.otf') }}" as="font" type="font/otf" crossorigin>


    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <main class="page-wrapper">

        <!-- Start Theme Style  -->
        <div>
            <div class="rainbow-gradient-circle"></div>
            <div class="rainbow-gradient-circle theme-pink"></div>
        </div>
        <!-- End Theme Style  -->

        <!-- <div id="preloader">
            <div class="loader"></div>
        </div> -->
        @include('partials.preloader')

        @include('snippets.header')


        @include('snippets.mobile-header')


        @yield('content')



        @include('snippets.footer-main')

    </main>

    <!-- All Scripts  -->
    <!-- Start Top To Bottom Area  -->
    <div class="rainbow-back-top">
        <i class="ri-arrow-up-line"></i>
    </div>
    <!-- End Top To Bottom Area  -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        .rainbow-back-top {
            transition: opacity 0.3s ease;
            /* Other styles... */
        }
    </style>
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
                }, 7000); // 3 seconds
            }
        });
    </script>


    <script>
        // window.addEventListener('load', function() {
        //     const preloader = document.getElementById('preloader');
        //     preloader.style.display = 'none';
        // });


        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 800);
        });
    </script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success') || session('error') || session('info'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: @json(session('success') ? 'success' : (session('error') ? 'error' : 'info')),
                title: @json(session('success') ?? session('error') ?? session('info')),
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        });
    </script>
    @endif


    <style>
        .swal2-toast {
            font-size: 14px !important;
            padding: 0.75rem 1.25rem !important;
            padding-left: 0.8rem;
            color: #4985d3 !important;
            /* Changed from #000 to #333 */
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: flex !important;
            justify-content: start !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .swal2-container .swal2-title {
            font-size: 15px !important;
            font-weight: 500 !important;
            color: #4985d3 !important;
            /* Changed from #000 to #333 */
            margin: 0 !important;
        }

        /* For dark modals, you might want to add this */
        .swal2-popup {
            color: #4985d3 !important;
        }

        .swal2-icon {
            width: 18px !important;
            height: 18px !important;
            margin: 0 4px 0 0 !important;
            margin-bottom: 4px !important;
        }

        .swal2-icon-content {
            font-size: 16px !important;
        }
    </style>



    <div class="languageTranslate" id="google_translate_element">
    </div>

    <style type="text/css">
        .languageTranslate {
            position: fixed;
            bottom: 20px;
            left: 20px;
            content: "";
            z-index: 999999;
        }

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

</body>

</html>
