        @extends('layouts.admin')
        @section('content')
        <div class="page-content">
            <div class="page-container">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="d-flex card-header justify-content-between align-items-center">
                                        <h4 class="header-title">Wallet Balance</h4>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle bg-light-subtle rounded drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <h2 class="fw-bold">$92,652.36 <a href="#!" class="text-muted"><i class="ti ti-eye"></i></a></h2>

                                        <div class="row g-2 mt-2 pt-1">
                                            <div class="col">
                                                <a href="{{ route('user.deposit') }}" class="btn btn-primary w-100"><i class="ti ti-coin me-1"></i> Deposit</a>
                                            </div>
                                            <div class="col">
                                                <a href="#!" class="btn btn-info w-100"><i class="ti ti-coin me-1"></i>Withdraw</a>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body -->
                                </div>
                            </div>


                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row justify-content-between">
                                            <div class="col-sm-5">
                                                <iconify-icon icon="solar:hand-money-bold-duotone" class="fs-36 text-muted"></iconify-icon>
                                                <h3 class="mb-0 fw-bold mt-2 mb-1">$78.32k</h3>
                                                <p class="text-muted">Total Expense</p>
                                                <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 8.72%</span>
                                            </div> <!-- end col -->

                                            <div class="col-sm-7 text-end d-flex flex-column">
                                                <a href="javascript:void(0);" class="link-reset text-decoration-underline link-offset-2 fw-medium pb-2">
                                                    View Details
                                                </a>
                                                <div class="text-end mt-auto">
                                                    <div id="expenses-chart" data-colors="#465dff"></div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div>


                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="d-flex card-header justify-content-between align-items-center">
                                        <h4 class="header-title">Referral Bonus</h4>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle bg-light-subtle rounded drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <h2 class="fw-bold">$92,652.36 <a href="#!" class="text-muted"><i class="ti ti-eye"></i></a></h2>

                                        <div class="row g-2 mt-2 pt-1">
                                            <div class="col">
                                                <a href="#!" class="btn btn-primary w-100"><i class="ti ti-coin me-1"></i> Transfer</a>
                                            </div>
                                            <div class="col">
                                                <a href="#!" class="btn btn-info w-100"><i class="ti ti-coin me-1"></i> Request</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- container -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © BitGoSpace <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        @endsection
