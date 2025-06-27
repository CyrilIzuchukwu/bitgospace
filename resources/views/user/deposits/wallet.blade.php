@extends('layouts.dashboard')
@section('content')


<div class="page-content">

    <div class="page-container">

        <div class="row">
            <div class="col-12">
                <div class="card deposit-wrapper position-relative">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">

                            <!-- Pricing Title-->
                            <div class="text-center">
                                <h3 class="mb-2">Confirm Your Deposit</h3>
                                <p class="mb-2 text-center">Step: 2 of 3</p>
                                <div class="text-center mb-2">
                                    <svg class="mt-18 nscaleX-1" width="314" height="6" viewBox="0 0 314 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                        <rect class="rect-B87" x="107" width="100" height="6" rx="3" fill="#DDD3FD"></rect>
                                        <rect class="rect-B87" x="214" width="100" height="6" rx="3" fill="#2f3a5f"></rect>
                                    </svg>
                                </div>
                                <p class="text-muted w-100 w-md-50 m-auto">
                                    Check the deposit information before confirmation
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="card-body confirm-deposit">

                        <form id="depositForm" action="{{ route('process.deposit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="deposit_id" value="{{ $deposit->id }}">
                            <input type="hidden" name="balance" id="balance" value="{{ $cryptoAmount }}">
                            <input type="hidden" name="amount" value="{{ $deposit->amount }}">



                            <div class="d-flex justify-content-between mt-32">
                                <span class="f-16 gilroy-medium text-gray-100">Time Remaining : </span>
                                <span class="f-16 gilroy-medium text-danger" id="timer">
                                    <span id="time-minutes">{{ $deposit->expires_at->diffInMinutes(now()) }}</span>m :
                                    <span id="time-seconds">{{ $deposit->expires_at->diffInSeconds(now()) % 60 }}</span>s
                                </span>
                            </div>

                            <div class="mb-3">
                                <div class="progress" style="height: 5px; background-color: #e9ecef;">
                                    <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%; background-color: #28a745;"></div>
                                </div>

                            </div>



                            <div class="exchange-send-get">
                                <!-- Crypto Send -->
                                <div class="send-left-box box">
                                    <p class="send-text">You'll send</p>

                                    <p class="btc-value">
                                        <span class="converted" id="converted">
                                            @if($cryptoAmount > 0)
                                            @if($cryptoAmount < 0.0001)
                                                {{ number_format($cryptoAmount, 12) }}
                                                @elseif($cryptoAmount < 1)
                                                {{ number_format($cryptoAmount, 8) }}
                                                @else
                                                {{ number_format($cryptoAmount, 4) }}
                                                @endif
                                                @else
                                                Rate unavailable
                                                @endif
                                                </span>
                                                <span class="currency">{{ $wallet->symbol }}</span>
                                    </p>
                                </div>

                                <!-- Crypto Get -->
                                <div class="get-right-box box">
                                    <p class="get-text">equivalently</p>
                                    <p class="usd-value">
                                        <span class="dollar-value">{{ number_format($deposit->amount, 2) }}</span>
                                        <span class="currency"> USD </span>
                                    </p>

                                    <div class="right-box-icon">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12.5" cy="12.5" r="12.5" fill="white"></circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5312 17.4705C10.2709 17.2102 10.2709 16.788 10.5312 16.5277L14.0598 12.9991L10.5312 9.47051C10.2708 9.21016 10.2708 8.78805 10.5312 8.5277C10.7915 8.26735 11.2137 8.26735 11.474 8.5277L15.474 12.5277C15.7344 12.788 15.7344 13.2102 15.474 13.4705L11.474 17.4705C11.2137 17.7309 10.7915 17.7309 10.5312 17.4705Z" fill="#6A6B87"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>


                            <div id="payment_details" class="payment-details">
                                <!-- Crypto Pay Amount -->
                                <div class="payout">
                                    <div class="left-merchant pt-20p">
                                        <p class="mb-0 f-16 gilroy-medium ">Please make payment of</p>
                                        <p class="mb-0 f-32 l gilroy-Semibold ">
                                            <span class="text-dark converted" id="converted">{{ number_format($cryptoAmount, 8) }}</span>
                                            <span class="text-primary">{{ $wallet->symbol }}</span>
                                        </p>
                                        <p class="f-16 leading-25 text-gray-100 gilroy-medium mt-6">to our company address below</p>
                                    </div>

                                    <!-- QR Code -->
                                    <div class="right-qr-code mt-24 user-profile-qr-code">
                                        @if ($wallet->qr_code)
                                        <img class="img-fluid" src="{{ asset('storage/'.$wallet->qr_code) }}" alt="QR Code" width="170" height="170">
                                        @else
                                        <p>No QR code available</p>
                                        @endif
                                        <p class="mt-1">Scan QR code on your mobile</p>

                                    </div>
                                </div>

                                <!-- Wallet Address -->
                                <div class="d-flex justify-content-between m-address">
                                    <p class="">Wallet Address</p>
                                    <p class="copy-message" id="copy-message" style="display: none;">Copied</p>
                                </div>

                                <div class="d-flex position-relative copy-div">
                                    <label for="walletAddress"></label>
                                    <input class="form-control input-form-control apply-bg not-focus-bg" type="text" id="walletAddress" value="{{ $wallet->address }}" readonly>



                                    <span onclick="copyToClipboard(document.getElementById('walletAddress'))" class="copy-btn" style="cursor: pointer;">
                                        <!-- Your SVG icon -->
                                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect class="rect-F30" width="36" height="36" rx="4" fill="#F5F6FA"></rect>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.2855 11.3759C21.7715 11.3339 21.1112 11.3333 20.1641 11.3333H14.2474C13.7872 11.3333 13.4141 10.9602 13.4141 10.5C13.4141 10.0397 13.7872 9.66663 14.2474 9.66663L20.1997 9.66663C21.1029 9.66662 21.8314 9.66661 22.4213 9.71481C23.0286 9.76443 23.5621 9.86928 24.0557 10.1208C24.8397 10.5202 25.4771 11.1577 25.8766 11.9417C26.1281 12.4352 26.2329 12.9687 26.2825 13.5761C26.3307 14.166 26.3307 14.8945 26.3307 15.7976V21.75C26.3307 22.2102 25.9576 22.5833 25.4974 22.5833C25.0372 22.5833 24.6641 22.2102 24.6641 21.75V15.8333C24.6641 14.8861 24.6634 14.2259 24.6214 13.7118C24.5802 13.2075 24.5034 12.9178 24.3916 12.6983C24.1519 12.2279 23.7694 11.8455 23.299 11.6058C23.0796 11.494 22.7898 11.4171 22.2855 11.3759ZM13.1319 12.5833H19.9462C20.3855 12.5833 20.7644 12.5833 21.0766 12.6088C21.406 12.6357 21.7337 12.6951 22.049 12.8558C22.5194 13.0955 22.9019 13.4779 23.1416 13.9483C23.3022 14.2636 23.3617 14.5913 23.3886 14.9208C23.4141 15.2329 23.4141 15.6119 23.4141 16.0512V22.8654C23.4141 23.3047 23.4141 23.6837 23.3886 23.9958C23.3617 24.3253 23.3022 24.653 23.1416 24.9683C22.9019 25.4387 22.5194 25.8211 22.049 26.0608C21.7337 26.2215 21.406 26.2809 21.0766 26.3078C20.7644 26.3333 20.3855 26.3333 19.9462 26.3333H13.1319C12.6926 26.3333 12.3137 26.3333 12.0015 26.3078C11.6721 26.2809 11.3444 26.2215 11.0291 26.0608C10.5587 25.8211 10.1762 25.4387 9.93655 24.9683C9.77589 24.653 9.71646 24.3253 9.68954 23.9958C9.66404 23.6837 9.66405 23.3047 9.66406 22.8654V16.0512C9.66405 15.6119 9.66404 15.2329 9.68954 14.9208C9.71646 14.5913 9.77589 14.2636 9.93655 13.9483C10.1762 13.4779 10.5587 13.0955 11.0291 12.8558C11.3444 12.6951 11.6721 12.6357 12.0015 12.6088C12.3137 12.5833 12.6927 12.5833 13.1319 12.5833ZM12.1373 14.2699C11.9109 14.2884 11.8269 14.3198 11.7857 14.3408C11.6289 14.4207 11.5015 14.5482 11.4216 14.705C11.4006 14.7462 11.3692 14.8301 11.3507 15.0565C11.3314 15.2926 11.3307 15.6028 11.3307 16.0833V22.8333C11.3307 23.3138 11.3314 23.624 11.3507 23.8601C11.3692 24.0865 11.4006 24.1704 11.4216 24.2116C11.5015 24.3684 11.6289 24.4959 11.7857 24.5758C11.8269 24.5968 11.9109 24.6282 12.1373 24.6467C12.3734 24.666 12.6836 24.6666 13.1641 24.6666H19.9141C20.3945 24.6666 20.7048 24.666 20.9409 24.6467C21.1673 24.6282 21.2512 24.5968 21.2924 24.5758C21.4492 24.4959 21.5767 24.3684 21.6566 24.2116C21.6776 24.1704 21.709 24.0865 21.7275 23.8601C21.7467 23.624 21.7474 23.3138 21.7474 22.8333V16.0833C21.7474 15.6028 21.7467 15.2926 21.7275 15.0565C21.709 14.8301 21.6776 14.7462 21.6566 14.705C21.5767 14.5482 21.4492 14.4207 21.2924 14.3408C21.2512 14.3198 21.1673 14.2884 20.9409 14.2699C20.7048 14.2506 20.3945 14.25 19.9141 14.25H13.1641C12.6836 14.25 12.3734 14.2506 12.1373 14.2699Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </div>

                                <div class="mt-3">
                                    <label for="transactionHash">Transaction hash</label>
                                    <input class="form-control input-form-control apply-bg" type="text" name="transaction_hash" required placeholder="Paste the transaction id hash" id="walletAddress" value="">
                                    <span class="text-danger">@error ('transaction_hash') {{ $message }} @enderror</span>
                                </div>
                            </div>



                            <div class="confirm-cancel">

                                <button type="submit" class="submit-btn btn-default">Confirm &amp; Deposit<i class="ti ti-chevron-right ms-1"></i></button>
                                <button type="button" id="cancelDepositBtn" class="btn btn-danger cancel-button">Cancel Deposit</button>
                            </div>



                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>

<script>
    // Timer countdown
    document.addEventListener('DOMContentLoaded', function() {
        const expiresAt = new Date("{{ $deposit->expires_at->toIso8601String() }}").getTime();
        const createdAt = new Date("{{ $deposit->created_at->toIso8601String() }}").getTime();
        const totalTime = (expiresAt - createdAt) / 1000; // total time in seconds

        function updateTimer() {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            const timerDisplay = document.getElementById("timer");
            const progressBar = document.getElementById("progressBar");

            if (distance <= 0) {
                timerDisplay.innerHTML = "EXPIRED";
                progressBar.style.width = "100%";
                progressBar.style.backgroundColor = "red";
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("time-minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("time-seconds").innerHTML = seconds.toString().padStart(2, '0');

            // Progress bar update
            const elapsed = totalTime - (distance / 1000);
            const percentage = (elapsed / totalTime) * 100;
            progressBar.style.width = percentage + "%";

            // Change color to red if 5 minutes or less remaining
            if (distance <= 5 * 60 * 1000) {
                progressBar.style.backgroundColor = "red";
            } else {
                progressBar.style.backgroundColor = "#28a745"; // Bootstrap green
            }
        }

        updateTimer(); // Call immediately on load
        setInterval(updateTimer, 1000); // Update every second
    });




    document.addEventListener('DOMContentLoaded', function() {
        const copyButtons = document.querySelectorAll('.copy-btn');

        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                copyToClipboard(input);
            });
        });

        function copyToClipboard(element) {
            // Select the text
            element.select();
            element.setSelectionRange(0, 99999); // For mobile devices

            try {
                // Copy the text
                document.execCommand('copy');

                // Show feedback
                const copyMessage = document.getElementById('copy-message');
                copyMessage.style.display = 'block';

                // Hide after 2 seconds
                setTimeout(() => {
                    copyMessage.style.display = 'none';
                }, 2000);
            } catch (err) {
                console.error('Failed to copy!', err);

                // Fallback for newer browsers
                navigator.clipboard.writeText(element.value).then(() => {
                    const copyMessage = document.getElementById('copy-message');
                    copyMessage.style.display = 'block';
                    setTimeout(() => {
                        copyMessage.style.display = 'none';
                    }, 2000);
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                });
            }
        }
    });
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration
        const config = {
            updateInterval: 30000, // 30 seconds
            depositAmount: {
                {
                    $deposit - > amount
                }
            },
            walletSymbol: '{{ $wallet->symbol }}'
        };

        // Coin mapping
        const coinMap = {
            'BTC': 'bitcoin',
            'ETH': 'ethereum',
            'USDT': 'tether',
            'USDC': 'usd-coin',
            'BNB': 'binancecoin',
            'XRP': 'ripple',
            'SOL': 'solana',
            'ADA': 'cardano',
            'DOGE': 'dogecoin',
            'DOT': 'polkadot',
            'SHIB': 'shiba-inu',
            'TRX': 'tron',
            'AVAX': 'avalanche-2',
            'MATIC': 'matic-network',
            'LINK': 'chainlink',
            'ATOM': 'cosmos',
            'XLM': 'stellar',
            'XMR': 'monero',
            'ETC': 'ethereum-classic',
            'BCH': 'bitcoin-cash',
            'LTC': 'litecoin'
        };

        // DOM Elements
        const elements = {
            convertedElements: document.querySelectorAll('.converted'),
            balanceInput: document.getElementById('balance')
        };

        // Main functions
        const CryptoUpdater = {
            init: function() {
                this.updateCryptoAmount();
                setInterval(() => this.updateCryptoAmount(), config.updateInterval);
            },

            getCoinId: function(symbol) {
                return coinMap[symbol.toUpperCase()] || null;
            },

            updateDisplayedAmount: function(amount) {
                const formattedAmount = amount.toFixed(8);
                elements.convertedElements.forEach(el => {
                    el.textContent = formattedAmount;
                });
                elements.balanceInput.value = formattedAmount;
            },

            updateCryptoAmount: async function() {
                try {
                    const coinId = this.getCoinId(config.walletSymbol);
                    if (!coinId) {
                        console.error('Coin not supported:', config.walletSymbol);
                        return;
                    }

                    const response = await fetch(
                        `https://api.coingecko.com/api/v3/simple/price?ids=${coinId}&vs_currencies=usd`
                    );

                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();
                    const price = data[coinId]?.usd;

                    if (price && price > 0) {
                        const cryptoAmount = config.depositAmount / price;
                        this.updateDisplayedAmount(cryptoAmount);
                    } else {
                        console.error('Invalid price data received');
                    }
                } catch (error) {
                    console.error('Error fetching crypto price:', error);
                    // You could add user-facing error handling here
                }
            }
        };

        // Initialize
        CryptoUpdater.init();
    });
</script> -->



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


<style>
    .copy-message {
        display: none;
        color: #fff;
        font-size: 12px;

    }

    .progress {
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.5s ease, background-color 0.5s ease;
    }

    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 0.15em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }

    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }

    .confirm-cancel {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        column-gap: 10px;
        margin-top: 40px;
    }

    @media only screen and (max-width: 767px) {
        .confirm-cancel {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            row-gap: 10px;
            margin-top: 40px;
        }
    }
</style>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButton = document.getElementById('cancelDepositBtn');

        if (cancelButton) {
            cancelButton.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Cancel Deposit',
                    text: "Are you sure you want to cancel this deposit request?",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const originalText = cancelButton.innerHTML;
                        cancelButton.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status"></span>
                        Processing...
                    `;
                        cancelButton.disabled = true;

                        // Make the API call
                        fetch('{{ route("cancel.deposit") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Cancelled!',
                                        text: data.message,
                                        confirmButtonColor: '#3085d6',
                                    }).then(() => {
                                        window.location.href = data.redirect;
                                    });
                                } else {
                                    throw new Error(data.message || 'Failed to cancel deposit');
                                }
                            })
                            .catch(error => {
                                // Restore button state
                                cancelButton.innerHTML = originalText;
                                cancelButton.disabled = false;

                                Swal.fire({
                                    title: 'Error!',
                                    text: error.message,
                                    confirmButtonColor: '#3085d6',
                                });
                            });
                    }
                });
            });
        }
    });
</script>


@endsection
