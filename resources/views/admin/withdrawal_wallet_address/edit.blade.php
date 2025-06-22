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
                                <h3 class="mb-2">EDIT WITHDRAWAL WALLET ADDRESS</h3>
                            </div>

                        </div>
                    </div>

                    <form action="{{ route('withdrawals.wallet.update', $wallet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label>Wallet Name</label>
                            <input type="text" name="name" value="{{ old('name', $wallet->name) }}" class="form-control" required>
                            <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3">
                            <label>Wallet Address</label>
                            <input type="text" name="address" value="{{ old('address', $wallet->address) }}" class="form-control" required>
                            <span class="text-danger">@error('address') {{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3">
                            <label>Symbol</label>
                            <input type="text" name="symbol" value="{{ old('symbol', $wallet->symbol) }}" class="form-control" required>
                            <span class="text-danger">@error('symbol') {{ $message }} @enderror</span>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="submit-btn btn-default">Update Address<i class="ti ti-chevron-right ms-1"></i></button>
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
