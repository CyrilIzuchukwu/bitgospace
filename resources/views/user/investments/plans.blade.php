@extends('layouts.dashboard')
@section('content')

<div class="page-content">

    <div class="page-container">


        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0"> AI-driven Plans</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item d-none d-md-block"><a href="javascript: void(0);">BitGoSpace</a></li>
                    <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pricing</a></li> -->
                </ol>
            </div>
        </div>




        <div class="row justify-content-center">
            <div class="col-md-12">

                <!-- Pricing Title-->
                <div class="text-center">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Smart Trades</h3>
                    <p class="text-muted w-100 m-auto">
                        AI-driven plans built to grow your crypto — hands-free.
                    </p>
                </div>

                <div class="plans-grid  mb-3">
                    @forelse($plans as $plan)
                    <div class="invest-plan">
                        <p class="title text-uppercase text-center">{{ $plan->name }}</p>

                        <div class="profit-duration d-flex justify-content-between bg-white-100">
                            <div class="daily-profit">
                                <p class="top">Daily Profit</p>
                                <p class="bottom">{{ $plan->interest_rate }}%</p>
                            </div>

                            <div class="duration text-end">
                                <p class="top">Duration</p>
                                <p class="bottom">Daily </p>
                            </div>
                        </div>


                        <div class="min-max-amount d-flex justify-content-between">
                            <div class="min-max">
                                <p class="label text-gray-100">Min Amount</p>
                                <p class="value text-dark">{{ number_format($plan->minimum_amount) }} USD </p>
                            </div>

                            <div class="min-max text-end">
                                <p class="label text-gray-100">Max Amount</p>
                                <p class="value text-dark">{{ number_format($plan->maximum_amount) }} USD </p>
                            </div>
                        </div>

                        <div class="terms mt-20">
                            <div class="d-flex justify-content-between">
                                <p class=" label text-gray-100">Duration</p>
                                <p class="value text-dark">{{ $plan->duration }} days</p>
                            </div>


                            <div class="d-flex justify-content-between">
                                <p class="label text-gray-100">Capital Return</p>
                                <p class=" value text-dark">Yes
                                </p>
                            </div>

                            @php
                            $privileges = $plan->privileges ? json_decode($plan->privileges, true) : [];
                            @endphp
                            @foreach($privileges as $item)
                            <div class="d-flex justify-content-between">
                                <p class="label text-gray-100">{{ $item }}</p>
                                <p class=" value text-dark">
                                </p>
                            </div>
                            @endforeach



                        </div>

                        <div class="card-footer ">
                            <a href="{{ route('user.start-investment', $plan->slug) }}" class="btn btn-outline-primary w-100">Activate</a>
                        </div>
                    </div>

                    @empty
                    <p class="text-center">No active plans available at the moment.</p>
                    @endforelse

                </div>


            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>

@endsection
