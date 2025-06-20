@extends('layouts.dashboard')
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
                                <h3 class="mb-2">DEPOSIT MONEY</h3>
                                <p class="mb-2 text-center">Step: 1 of 3</p>
                                <div class="text-center mb-2">
                                    <svg class="mt-18 nscaleX-1" width="314" height="6" viewBox="0 0 314 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                        <rect class="rect-B87" x="107" width="100" height="6" rx="3" fill="#2f3a5f"></rect>
                                        <rect class="rect-B87" x="214" width="100" height="6" rx="3" fill="#2f3a5f"></rect>
                                    </svg>
                                </div>
                                <p class="text-muted w-100 w-md-50 m-auto">
                                    You can fund your wallets using our various payments methods. Fill the details correctly & the amount you want to deposit
                                </p>
                            </div>

                        </div>
                    </div>

                    <form id="depositForm" action="{{ route('deposit.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label">Amount:</label>
                                        <input type="text" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="Enter amount">
                                        <span class="text-danger">@error('amount') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-2 mt-2 mt-md-2">
                                        <label for="InvoicePaymentStatus" class="form-label">Payment Method</label>
                                        <select name="payment_method" class="form-select">
                                            <option selected disabled>Select Payment Method</option>
                                            @foreach($wallets as $wallet)
                                            <option value="{{ $wallet->name }}" {{ old('payment_method') == $wallet->name ? 'selected' : '' }}>
                                                {{ $wallet->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('payment_method') {{ $message }} @enderror</span>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default">Proceed<i class="ti ti-chevron-right ms-1"></i></button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('depositForm');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.style.cursor = 'not-allowed'; // explicitly set cursor
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Processing...
            `;
        });
    });
</script>


@endsection
