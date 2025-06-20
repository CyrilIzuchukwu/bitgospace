<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <base href="/public">
    <meta charset="utf-8" />
    <title>BitGoSpace Dashboard | User - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('dashboard_assets/assets/js/config.js') }}"></script>

    <!-- Vendor css -->
    <link href="{{ asset('dashboard_assets/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('dashboard_assets/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('dashboard_assets/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- remix icon  -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- custom css -->
    <link href="{{ asset('dashboard_assets/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- custom responsiveness -->
    <link href="{{ asset('dashboard_assets/assets/css/custom-responsiveness.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- <div id="preloader">
            <div class="loader"></div>
        </div> -->
        @include('partials.preloader')

        <!-- Sidenav Menu Start -->
        @include('user.snippets.sidebar')
        <!-- Sidenav Menu End -->


        <!-- Topbar Start -->
        @include('user.snippets.topbar')
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card mb-1">
                        @php
                        $referralLink = Auth::user()->referral_link ?? url('/register?ref=' . Auth::user()->id);
                        @endphp

                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ti ti-link fs-22"></i>
                            <input type="input" id="referralLinkInput" class="form-control border-0" value="{{ $referralLink }}" readonly>
                            <div class="d-flex gap-2 align-items-center">
                                <small class="text-success d-none" id="copyMessage">Copied!</small>
                                <button type="button" id="copyReferralLink" class=" btn p-0">Copy</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        @yield('content')

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->



    <!-- Vendor js -->
    <script src="{{ asset('dashboard_assets/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('dashboard_assets/assets/js/app.js') }}"></script>

    <!-- Apex Chart js -->
    <script src="{{ asset('dashboard_assets/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Projects Analytics Dashboard App js -->
    <script src="{{ asset('dashboard_assets/assets/js/pages/dashboard-sales.js') }}"></script>

    <!-- <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        });
    </script> -->


    <script>
        document.getElementById('copyReferralLink').addEventListener('click', function() {
            const input = document.getElementById('referralLinkInput');
            input.select();
            input.setSelectionRange(0, 99999); // For mobile
            document.execCommand('copy');

            const msg = document.getElementById('copyMessage');
            msg.classList.remove('d-none');
            setTimeout(() => msg.classList.add('d-none'), 2000);
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

    <style>
        @media only screen and (max-width: 767px) {
            body {
                width: 100%;
                overflow-x: hidden !important;
            }


            body {
                overflow: auto !important;
                overflow-y: scroll;
            }
        }

        body,
        html {
            overflow-x: hidden;
            overflow-y: auto !important;
            height: 100% !important;
        }

        body,
        html {
            overflow-x: hidden;
            overflow-y: auto !important;
            height: 100% !important;
        }

        .wrapper {
            min-height: 100vh;
            overflow-y: auto !important;
        }

        .page-content {
            overflow-y: auto !important;
            position: relative;
        }
    </style>

</body>

</html>
