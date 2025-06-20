@extends('layouts.app')
@section('content')


<section class="jarden-hero-section">

    <div class="">
        <div class="row">
            <div class="col-md-12">

                <div class="jarden-hero-image">
                    <img src="{{ asset('assets/images/jarden/jarden-banner.png') }}" alt="">
                </div>

                <div class="section-header-text">
                    <h1>Your intelligent</h1>
                    <h2 class="text-gradient">Crypto AI bot</h2>

                    <p class="sub-text">Designed to spot price gaps, and built to trade automatically</p>

                    <div class="get-started">
                        <a href="{{ route('login') }}" class="default-btn">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="sub-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="contact-text">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="resused-side">
                                <h3 class="theme-gradient">Who is Jarden, the AI bot?</h3>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="who-is-jarden">
                                <p>Jarden is an AI-powered trading bot built for crypto arbitrage it scans over 30 exchanges in real-time, detects price differences across platforms, and automatically buys low and sells high within seconds.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="how-jarden-works">

    <div class="container">
        <!-- Start Section Title  -->
        <div class="row mt-5 mb-5">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">How Jarden Works</p>
                    <p class="title">Earn without lifting a finger.</p>
                    <p class="sub-title">Jarden scans over 30+ exchanges in real time, identifies profitable price gaps, and executes trades instantly.</p>
                </div>

            </div>
        </div>
        <!-- End Section Title  -->


        <div class="row row--15 service-wrapper">

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700">
                <div class="service service__style--1 icon-circle-style with-working-process text-center">
                    <div class="icon">
                        <div class="line"></div>1
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#">Fund Your Wallet</a></h4>
                        <p class="description b1 color-gray mb--0">Deposit crypto into your BitGoSpace wallet that’s what Jarden uses.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                <div class="service service__style--1 icon-circle-style with-working-process text-center">
                    <div class="icon">
                        <div class="line"></div>2
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#">Activate the Bot</a></h4>
                        <p class="description b1 color-gray mb--0">One click to go live. Jarden starts trading immediately.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">
                <div class="service service__style--1 icon-circle-style with-working-process text-center">
                    <div class="icon">
                        <div class="line"></div>3
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#">Earn Automatically</a></h4>
                        <p class="description b1 color-gray mb--0">It buys and sells crypto across exchanges, generating profit.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="300">
                <div class="service service__style--1 icon-circle-style with-working-process text-center">
                    <div class="icon">
                        <div class="line"></div>4
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="#">Withdraw Anytime</a></h4>
                        <p class="description b1 color-gray mb--0">Once trades settle, your profit is available. No delays.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- What makes jarden smart  -->
<section class="smart-jarden">

    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">What Makes Jarden Smart?</p>
                    <p class="title">Built with intelligence</p>
                    <p class="sub-title">With real-time market scanning, instant decision-making, and zero emotional bias.</p>
                </div>

            </div>
        </div>

        <div class="smart-jarden-grid">
            <div class="item itemone">
                <div class="top-layer">
                    <img src="{{ asset('assets/images/jarden/top-layer.png') }}" alt="Image">
                </div>

                <div class="abs abs1">
                    <img src="{{ asset('assets/images/jarden/abs1.png') }}" alt="Smart Image">
                </div>

                <div class="text-content">
                    <div class="icon">
                        <img src="{{ asset('assets/images/jarden/icon1.png') }}" alt="icon">
                    </div>
                    <p>Ultra-Fast Trading Engine</p>
                    <span>Executes hundreds of trades daily</span>
                </div>
            </div>

            <div class="item itemtwo">
                <div class="top-layer">
                    <img src="{{ asset('assets/images/jarden/top-layer.png') }}" alt="Image">
                </div>

                <div class="abs abs2">
                    <img src="{{ asset('assets/images/jarden/abs2.png') }}" alt="Smart Image">
                </div>

                <div class="text-content">
                    <div class="icon">
                        <img src="{{ asset('assets/images/jarden/icon2.png') }}" alt="icon">
                    </div>
                    <p>Emotion-Free Decisions</p>
                    <span>Pure logic, no stress, no panic</span>
                </div>
            </div>

            <div class="item itemthree">
                <div class="top-layer">
                    <img src="{{ asset('assets/images/jarden/top-layer.png') }}" alt="Image">
                </div>

                <div class="abs abs3">
                    <img src="{{ asset('assets/images/jarden/abs3.png') }}" alt="Smart Image">
                </div>

                <div class="text-content">
                    <div class="icon">
                        <img src="{{ asset('assets/images/jarden/icon3.png') }}" alt="icon">
                    </div>
                    <p>Bank-Level Security</p>
                    <span>Your funds stay in your control</span>
                </div>
            </div>

            <div class="item itemfour">
                <div class="top-layer">
                    <img src="{{ asset('assets/images/jarden/top-layer.png') }}" alt="Image">
                </div>

                <div class="abs abs4">
                    <img src="{{ asset('assets/images/jarden/abs4.png') }}" alt="Smart Image">
                </div>

                <div class="text-content">
                    <div class="icon">
                        <img src="{{ asset('assets/images/jarden/icon4.png') }}" alt="icon">
                    </div>
                    <p>Full Transparency</p>
                    <span>Track every move Jarden makes</span>
                </div>
            </div>
        </div>


    </div>


</section>


<!-- trading strategy starts here  -->
<section class="trading-strategy">
    <div class="container">
        <div class="content">
            <div class="list-content">
                <h2 class="text-header">Jarden’s Trading Strategy</h2>
                <div class="list-item">
                    <div class="item item-1">
                        <p>Cross-Exchange Arbitrage</p>
                        <span>Spots price differences across platforms and profits instantly.</span>
                    </div>

                    <div class="item item-2">
                        <p>Triangular Arbitrage</p>
                        <span>Trades within a single exchange using crypto pairs (e.g., BTC-ETH-USDT) for small gains.</span>
                    </div>

                    <div class="item item-3">
                        <span>💸 Small profits, big consistency — repeated hundreds of times a day.</span>
                    </div>
                </div>
            </div>

            <div class="ts-image">
                <img src="{{ asset('assets/images/jarden/ts-img.png') }}" alt="AI Bot">
            </div>
        </div>
    </div>
</section>
<!-- trading strategy ends here  -->



<!-- side video starts  -->
<section class="side-video">
    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">Always Getting Smarter</p>
                    <p class="title">Jarden evolves with the market.</p>
                    <p class="sub-title">It learns from every move, adjusts in real time, and keeps trading strategies sharp</p>
                </div>
            </div>
        </div>


        <div class="side-video-content ">

            <div class="video-btn">
                <div class="video-popup icon-center">
                    <div class="overlay-content">
                        <div class="thumbnail">
                            <img class="radius-small" src="assets/images/jarden/side-video-img.png" alt="Image Overlay">
                        </div>
                        <div class="video-icon">
                            <a class=" play-button rounded-player popup-video" href="https://www.youtube.com/watch?v=iZbd9uWO820">
                                <span><i class="ri-play-large-line"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content">
                <div class="inner">
                    <h3 class="title">Stay ahead effortlessly.</strong>
                    </h3>
                    <ul class="feature-list">
                        <li>
                            <div class="title-wrapper">
                                <h4>🔄 Learns from Live Trades</h4>
                                <p class="text">Jarden constantly analyzes the outcome of each trade to improve future decisions and sharpen performance in real time.</p>
                            </div>
                        </li>

                        <li>
                            <div class="title-wrapper">
                                <h4>📈 Adapts to Trends & Volatility</h4>
                                <p class="text">Whether the market is calm or chaotic, Jarden adjusts its strategy on the fly to capture the best opportunities.</p>
                            </div>
                        </li>

                        <li>
                            <div class="title-wrapper">
                                <h4>⚙️ Updates Automatically to Stay Effective</h4>
                                <p class="text">Jarden evolves with the market using auto-updates that keep it smart, current, and profitable.</p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- side video ends  -->


<!-- ready to let jarden work starts -->
<section class="ready">
    <div class="container">
        <div class="ready-content">
            <p class="explore-text theme-gradient">
                Ready to Let Jarden Work for You?
            </p>
            <span>Join thousands earning passively with the world’s smartest crypto AI bot.</span>
            <a href="" class="default-btn">Get Started</a>
        </div>
    </div>
</section>
<!-- ready to let jarden work ends  -->

@endsection