@extends('layouts.dashboard')
@section('content')
    <div class="page-content">

        <div class="page-container ambassado-reward">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h3 class="fw-semibold mb-0 text-white">Ambassador Reward</h3>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">

                                    <!-- Pricing Title-->
                                    <div class="text-left">
                                        <h3 class="mb-2 text-white incentive-header-title">Ambassador Performance based
                                            incentive</h3>
                                        <p class="mb-2 text-left ambassador-text">
                                            The Ambassador shall be entitled to the following
                                            benefits upon achieving verified active referral milestones:
                                        </p>
                                    </div>


                                    <div class="ambassador-wrapper">

                                        <!-- Row 1 -->
                                        <div class="grid grid-row-1">
                                            <div class="amb-card">
                                                <img src="{{ asset('dashboard_assets/assets/images/amb/tag1.png') }}"
                                                    alt="Santorini" loading="lazy">
                                            </div>
                                            <div class="amb-card">
                                                <img src="{{ asset('dashboard_assets/assets/images/amb/tag2.png') }}"
                                                    alt="Dubai" loading="lazy">
                                            </div>
                                        </div>

                                        <!-- Row 2 -->
                                        <div class="grid grid-row-2">
                                            <div class="amb-card">
                                                <img src="{{ asset('dashboard_assets/assets/images/amb/tag3.png') }}"
                                                    alt="Luxury Bags" loading="lazy">
                                            </div>
                                            <div class="amb-card">
                                                <img src="{{ asset('dashboard_assets/assets/images/amb/tag4.png') }}"
                                                    alt="G Wagon" loading="lazy">
                                            </div>
                                        </div>

                                        <!-- Row 3 -->
                                        <div class="grid grid-row-3">
                                            <div class="amb-card">
                                                <img src="{{ asset('dashboard_assets/assets/images/amb/tag5.png') }}"
                                                    alt="Rolls Royce" loading="lazy">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Reward List Table -->
                                    <div class="reward-list-section mt-5">
                                        <div class="reward-header text-center mb-4">
                                            <h3 class="text-white">
                                                <span class="gift-icon">🎁</span> Reward List
                                            </h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="reward-table table">
                                                <thead>
                                                    <tr>
                                                        <th>Reward Titles</th>
                                                        <th>Verified Active Referrals</th>
                                                        <th>Entitlement / Reward</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($rewards as $index => $reward)
                                                        <tr
                                                            class="{{ $index % 2 == 0 ? 'reward-row-dark' : 'reward-row-light' }}">
                                                            <td data-label="Reward Title">{{ $reward->title }}</td>
                                                            <td data-label="Active Referrals">
                                                                {{ number_format($reward->required_referrals) }} Active
                                                                Referrals</td>
                                                            <td data-label="Reward">
                                                                @if ($reward->reward_type == 'cash' && $reward->cash_amount)
                                                                    Cash reward of USD
                                                                    ${{ number_format($reward->cash_amount, 2) }}
                                                                @elseif($reward->reward_type == 'mixed' && $reward->cash_amount)
                                                                    {{ $reward->description }}
                                                                @else
                                                                    {{ $reward->description }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr class="reward-row-dark">
                                                            <td colspan="3" class="text-center text-white py-4">
                                                                No rewards available at the moment. Check back soon!
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                                {{-- request button  --}}
                                <div class="mt-2">
                                    @if (auth()->user()->is_ambassador)
                                        <button class="submit-btn btn-success btn-default d-inline-block" disabled
                                            style="cursor: not-allowed;">
                                            ✓ You are an Ambassador
                                        </button>
                                    @elseif(auth()->user()->ambassador_request_status === 'pending')
                                        <button class="submit-btn btn-warning btn-default d-inline-block" disabled
                                            style="cursor: not-allowed;">
                                            ⏳ Awaiting Approval
                                        </button>
                                    @elseif(auth()->user()->ambassador_request_status === 'rejected')
                                        <button id="ambassadorRequestBtn" class="submit-btn btn-default d-inline-block">
                                            Request for Ambassadorship Again
                                        </button>
                                    @else
                                        <button id="ambassadorRequestBtn" class="submit-btn btn-default d-inline-block">
                                            Request for Ambassadorship
                                        </button>
                                    @endif
                                </div>


                                <div class="text-left mt-4">
                                    <h3 class="mb-2 text-white incentive-header-title">⚠️ Note</h3>
                                    <p class="mb-2 text-left ambassador-text text-white">
                                        Active Referrals means you have successfully referred people who have completed the
                                        required actions on the platform and are verified as active users, according to the
                                        company’s referral criteria.
                                    </p>
                                    <p class="mb-2 text-left ambassador-text text-white"> In short, it’s not just inviting
                                        people. It’s confirmed and active participants on
                                        the platform.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        @include('user.snippets.footer')
        <!-- end Footer -->

        <style>
            .card {
                margin-top: 0px;
            }

            .ambassador-text {
                font-size: 18px;
            }


            @media only screen and (max-width: 767px) {
                .incentive-header-title {
                    font-size: 18px;
                    line-height: 24px;
                }

                .ambassador-text {
                    font-size: 14px;
                }

            }

            .ambassador-wrapper {
                display: flex;
                flex-direction: column;
                gap: 20px;
                width: 100%;
                margin-top: 30px;
            }

            /* Row 1: Left narrower, Right wider */
            .grid-row-1 {
                display: grid;
                grid-template-columns: 55fr 45fr;
                gap: 20px;
            }

            /* Row 2: Left wider, Right narrower */
            .grid-row-2 {
                display: grid;
                grid-template-columns: 45fr 55fr;
                gap: 20px;
            }

            /* Row 3: 1 full-width column */
            .grid-row-3 {
                display: grid;
                grid-template-columns: 1fr;
                gap: 20px;
            }

            /* Card styling */
            .amb-card {
                width: 100%;
                height: 350px;
                overflow: hidden;
                border-radius: 12px;
            }

            .amb-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Responsive */
            @media (max-width: 768px) {

                .amb-card {
                    height: 200px;
                }

                .grid-row-1,
                .grid-row-2 {
                    grid-template-columns: 1fr;
                }
            }



            /* Reward List Table Styles */
            .reward-list-section {
                margin-top: 2rem;
            }

            .reward-header h3 {
                font-size: 24px;
                font-weight: 600;
            }

            .gift-icon {
                font-size: 32px;
                margin-right: 8px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .reward-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .reward-table thead tr {
                background: #F2F5FC;
            }

            .reward-table th {
                padding: 15px 20px;
                font-weight: 600;
                color: #000000;
                font-size: 14px;
                text-align: left;
            }

            .reward-table th:nth-child(1) {
                width: 25%;
            }

            .reward-table th:nth-child(2) {
                width: 25%;
            }

            .reward-table th:nth-child(3) {
                width: 50%;
            }

            .reward-table td {
                padding: 20px;
                font-size: 12px;
            }

            .reward-row-dark {
                color: #fff;
            }

            .reward-row-light {
                background: #F2F5FC80;
            }

            .reward-table td {
                color: #fff !important;
            }

            /* Responsive - Mobile View */
            @media (max-width: 768px) {
                .ambassado-reward .card-body {
                    padding: 1.5rem 0.9rem;
                }

                .reward-table thead {
                    display: none;
                }

                .reward-table,
                .reward-table tbody,
                .reward-table tr,
                .reward-table td {
                    display: block;
                    width: 100%;
                }

                .reward-table tr {
                    margin-bottom: 15px;
                    border-radius: 8px;
                    overflow: hidden;
                }

                .reward-table td {
                    text-align: left;
                    padding: 12px 15px;
                    position: relative;
                    border: none;
                }

                .reward-table td:before {
                    content: attr(data-label);
                    font-weight: 600;
                    display: block;
                    margin-bottom: 5px;
                    font-size: 13px;
                }

                .reward-table td:not(:last-child) {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                }
            }
        </style>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('ambassadorRequestBtn');

            submitBtn.addEventListener('click', function() {
                // Disable button
                submitBtn.disabled = true;
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Processing...
                `;

                // Send AJAX request
                fetch('{{ route('ambassador.request') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            alert(data.message);

                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.style.cursor = 'pointer';
                            submitBtn.innerHTML = 'Request for Ambassadorship';
                        } else {
                            // Show error message
                            alert(data.message);

                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.style.cursor = 'pointer';
                            submitBtn.innerHTML = 'Request for Ambassadorship';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');

                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.style.cursor = 'pointer';
                        submitBtn.innerHTML = 'Request for Ambassadorship';
                    });
            });
        });
    </script>
@endsection
