@extends('layouts.admin')
@section('content')


<div class="page-content">

    <div class="page-container">


        <div class="row">

            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">

                            <!-- Pricing Title-->
                            <div class="text-center">
                                <h3 class="mb-2">CREATE WALLET ADDRESS</h3>
                            </div>

                        </div>
                    </div>

                    <form action="{{ route('wallets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">


                                    <div class="mb-3">
                                        <label>Wallet Name</label>
                                        <input type="text" name="name" placeholder="Wallet name" value="{{ old('name') }}" class="form-control" required>
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Wallet Address</label>
                                        <input type="text" name="address" placeholder="Wallet address" value="{{ old('address') }}" class="form-control" required>
                                        <span class="text-danger">@error('address') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Symbol (e.g., BTC, ETH)</label>
                                        <input type="text" name="symbol" placeholder="Symbol" value="{{ old('symbol') }}" class="form-control" required>
                                        <span class="text-danger">@error('symbol') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>QR Code (Image)</label>
                                        <input type="file" style="height: 45px;" name="qr_code" accept="image/*" class="form-control">
                                        <span class="text-danger">@error('qr_code') {{ $message }} @enderror</span>
                                    </div>



                                </div>


                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default">Create Wallet<i class="ti ti-chevron-right ms-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- container -->

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>




@endsection
