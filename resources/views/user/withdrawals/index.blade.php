@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative deposit-wrapper">
                    <div class="row justify-content-center mt-2 mt-md-3">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h3 class="mb-2 section-title">WITHDRAW FUNDS</h3>
                                <p class="text-muted w-100 w-md-50 m-auto">
                                    Withdraw your earnings to your preferred payment processor
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="withdrawalForm" action="{{ route('user.withdrawal.initiate') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <!-- Current Balance -->
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-info">
                                        <strong>Available Balance:</strong>
                                        ${{ number_format(auth()->user()->wallet->balance, 2) }}
                                    </div>
                                </div>

                                <!-- Amount -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Amount ($):</label>
                                    <input type="number" name="amount" step="0.01" min="10"
                                        class="form-control" placeholder="Enter amount"
                                        value="{{ old('amount') }}" required>
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div class="col-md-12">
                                    <div class="mb-3">
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

                                <!-- Wallet Address -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Your Wallet Address:</label>
                                    <input type="text" name="wallet_address" class="form-control"
                                        placeholder="Enter your wallet address"
                                        value="{{ old('wallet_address') }}" required>
                                    @error('wallet_address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                <div class="col-md-12 pt-2">
                                    <button type="submit" class="submit-btn btn-default d-flex align-items-center" id="submitBtn">
                                        <span id="submitText">Continue to Verification</span>
                                        <div id="spinner" class="spinner-border spinner-border-sm text-light ms-2 d-none" role="status"></div>
                                        <i class="ti ti-chevron-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('user.snippets.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('withdrawalForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            // Client-side validation
            if (!form.checkValidity()) {
                return;
            }

            submitBtn.disabled = true;
            submitText.textContent = 'Processing...';
            spinner.classList.remove('d-none');
        });
    });
</script>


@endsection
