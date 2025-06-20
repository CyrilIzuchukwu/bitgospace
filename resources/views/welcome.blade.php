@extends('layouts.app')
@section('content')

<!-- Start Slider Area  -->
<div class="slider-area slider-style-1 bg-transparent hero-section">

    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="inner text-center">
                    <h1 class="hero-text-header">Trade Smarter <br />
                        <span class="header-caption theme-gradient">
                            <span class="cd-headline clip is-full-width">
                                <span class="cd-words-wrapper">
                                    <b class="is-visible theme-gradient dynamic-text">With AI</b>
                                    <b class="is-hidden theme-gradient dynamic-text ">With BitGoSpace</b>
                                </span>
                            </span>
                        </span>
                    </h1>
                    <p class="hero-description">
                        No more staring at charts or stressing about when to buy or sell. Let BitGoSpace’s smart AI and arbitrage system trade for you.
                    </p>


                    <div class="hero-button">
                        <a class="default-btn" href="{{ route('login') }}">
                            Get Started
                        </a>

                        <a class="default-btn2" href="{{ route('meet-jarden') }}">
                            Meet Jarden
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="banner-img">
    </div>

    <div class="leading-feature">
        <p class="leading-tag theme-gradient">Leading the Future of Trusted Crypto Trading with BitGoSpace</p>
    </div>

</div>
<!-- End Slider Area  -->


<!-- Brand Area and Why us  -->
<div class="brand-section">

    <!-- brand  -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">


                <!-- <div class="logo-slider-container">
                    <div class="logo-slider-track">
                        <div class="logo-slide">
                            <img src="{{ asset('assets/images/brand/brand1.png') }}" alt="Brand 1">
                        </div>
                        <div class="logo-slide">
                            <img src="{{ asset('assets/images/brand/brand2.png') }}" alt="Brand 2">
                        </div>
                        <div class="logo-slide">
                            <img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 3">
                        </div>
                        <div class="logo-slide">
                            <img src="{{ asset('assets/images/brand/brand4.png') }}" alt="Brand 4">
                        </div>
                        <div class="logo-slide">
                            <img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 3">
                        </div>
                    </div>


                    <button class="slider-prev" aria-label="Previous">‹</button>
                    <button class="slider-next" aria-label="Next">›</button>
                </div> -->

                <div class="marquee-slider-container">
                    <div class="marquee-slider-track">
                        <div class="marquee-slide">
                            <img src="{{ asset('assets/images/brand/brand1.png') }}" alt="Brand 1">
                        </div>
                        <div class="marquee-slide">
                            <img src="{{ asset('assets/images/brand/brand2.png') }}" alt="Brand 2">
                        </div>
                        <div class="marquee-slide">
                            <img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 3">
                        </div>
                        <div class="marquee-slide">
                            <img src="{{ asset('assets/images/brand/brand4.png') }}" alt="Brand 4">
                        </div>
                        <div class="marquee-slide">
                            <img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Brand Area  -->


<!-- Start About area  -->
<div class="about-area">
    <div class="container">
        <div class="row row--40 align-items-center">

            <div class="col-lg-6 col-md-6 col-sm-12 mt_md--40 mt_sm--40">
                <div class="content">
                    <div class="inner">
                        <div class="section-title">
                            <span class="sub-title">About BitGoSpace</span>
                            <div class="title">
                                <p class="theme-gradient">Trade Smarter. Live Freer.</p>
                            </div>
                        </div>
                        <div class="about-inner">
                            <p>At BitGoSpace, we believe that crypto trading shouldn’t be complicated or reserved for experts. That’s why we built an intelligent, AI-driven platform that does the hard work for you spotting and executing profitable trades using arbitrage strategies.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="about-app-thumbnail">
                    <img class="" src="{{ asset('assets/images/banner/ai.png') }}" alt="Robot image">
                </div>
            </div>


        </div>
    </div>
</div>
<!-- End About area  -->


<div class="why-us">
    <!-- Why you choose us -->
    <div class="container">
        <!-- Start Section Title  -->
        <div class="row mt-5 mb-5">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">Why choose BitGoSpace</p>
                    <p class="title">Smarter. Faster. Simpler.</p>
                    <p class="sub-title">Let AI handle crypto arbitrage while you earn — no stress, no experience needed.</p>
                </div>

            </div>
        </div>
        <!-- End Section Title  -->

        <div class="row row--30 align-items-center">
            <div class="col-lg-12">

                <div class="why-us-content">
                    <div class="left">
                        <div class="left-image">
                            <img src="{{ asset('assets/images/banner/why-us-img.png') }}" alt="">
                        </div>
                    </div>
                    <div class="right-content">
                        <div class="rainbow-default-tab style-three">
                            <ul class="nav nav-tabs why-tabs tab-button" role="tablist">
                                <li class="nav-item tabs__tab" role="presentation">
                                    <button class="nav-link active" id="arbitrage-tab" data-bs-toggle="tab" data-bs-target="#arbitrage"
                                        type="button" role="tab" aria-controls="arbitrage" aria-selected="true">
                                        AI-Powered Arbitrage
                                    </button>
                                </li>
                                <li class="nav-item tabs__tab" role="presentation">
                                    <button class="nav-link" id="secure-tab" data-bs-toggle="tab" data-bs-target="#secure"
                                        type="button" role="tab" aria-controls="secure" aria-selected="false">
                                        Secure & Simple
                                    </button>
                                </li>
                                <li class="nav-item tabs__tab" role="presentation">
                                    <button class="nav-link" id="trading-tab" data-bs-toggle="tab" data-bs-target="#trading"
                                        type="button" role="tab" aria-controls="trading" aria-selected="false">
                                        24/7 Smart Trading
                                    </button>
                                </li>
                            </ul>

                            <div class="rainbow-tab-content tab-content">
                                <div class="tab-pane fade show active" id="arbitrage" role="tabpanel" aria-labelledby="arbitrage-tab">
                                    <div class="inner">
                                        <p><span>BitGoSpace</span> uses a smart AI arbitrage bot that watches multiple crypto exchanges at once. Whenever it sees a price difference say Bitcoin is cheaper on one platform and more expensive on another the bot quickly buys low and sells high.
                                        </p>
                                        <p>
                                            It does this automatically, without any input from you. No charts, no stress, just steady profit-making in the background.
                                            It’s like having a super-fast, tireless trader working for you 24/7 but without the salary.
                                        </p>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="secure" role="tabpanel" aria-labelledby="secure-tab">
                                    <div class="inner">
                                        <div class="inner">
                                            <p>With <span>BitGoSpace</span>, you fund your trading account, and our AI bot takes over from there. It automatically trades on your behalf using smart arbitrage strategies across exchanges.
                                                No technical skills needed just fund, activate, and let the bot do the work.
                                            </p>
                                            <p> After the bot has completed its trades and generated returns, you can then withdraw your profits.
                                                You're not left guessing everything is tracked, transparent, and in your control.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="trading" role="tabpanel" aria-labelledby="trading-tab">
                                    <div class="inner">
                                        <p>The AI arbitrage bot doesn’t sleep. It works around the clock, scanning the market nonstop, spotting price differences, and making trades in seconds.
                                        </p>
                                        <p>It keeps going while you sleep, relax, or focus on your day always looking for small, safe profits. Faster than any human trader, 100% automated.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>



<!-- How it works  -->
<div class="rainbow-service-area how-it-works">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">How it works</p>
                    <p class="title">From signups to profit</p>
                    <p class="sub-title">See how BitGoSpace simplifies crypto arbitrage with just a few easy steps.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mt--50">
                <div class="timeline-style-two ">
                    <div class="row row--0">
                        <div class="col-lg-3 col-md-3 rainbow-timeline-single dark-line">
                            <div class="rainbow-timeline">
                                <h6 class="title" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Create Your Account</h6>
                                <div class="progress-line">
                                    <div class="line-inner"></div>
                                </div>
                                <div class="progress-dot">
                                    <div class="dot-level">
                                        <div class="dot-inner"></div>
                                    </div>
                                </div>
                                <p class="description" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">Sign up quickly with
                                    your name, email, and password. no long forms.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 rainbow-timeline-single dark-line">
                            <div class="rainbow-timeline">
                                <h6 class="title" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Fund Your Trading Wallet</h6>
                                <div class="progress-line">
                                    <div class="line-inner"></div>
                                </div>
                                <div class="progress-dot">
                                    <div class="dot-level">
                                        <div class="dot-inner"></div>
                                    </div>
                                </div>
                                <p class="description" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">Deposit funds into your BitGoSpace wallet. That’s what the bot trades with.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 rainbow-timeline-single dark-line">
                            <div class="rainbow-timeline">
                                <h6 class="title" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Activate the AI Bot</h6>
                                <div class="progress-line">
                                    <div class="line-inner"></div>
                                </div>
                                <div class="progress-dot">
                                    <div class="dot-level">
                                        <div class="dot-inner"></div>
                                    </div>
                                </div>
                                <p class="description" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">Turn on your smart bot.
                                    It automatically finds and executes profitable trades.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 rainbow-timeline-single dark-line">
                            <div class="rainbow-timeline">
                                <h6 class="title" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Watch Profits Build</h6>
                                <div class="progress-line">
                                    <div class="line-inner"></div>
                                </div>
                                <div class="progress-dot">
                                    <div class="dot-level">
                                        <div class="dot-inner"></div>
                                    </div>
                                </div>
                                <p class="description" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">The bot works nonstop. Once trades are done, you can withdraw your earnings.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End How it Works  -->



<!-- Smart Feature  -->
<div class="rainbow-tab-area smart-feature">
    <div class="container">
        <div class="row mb--40">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">Smart Features</p>
                    <p class="title">Smarter Features, Better Trading.</p>
                    <p class="sub-title">Everything you need to trade smarter — whether you're just starting or scaling up.</p>
                </div>
            </div>
        </div>
        <div class="row smart-feature-content">
            <div class="col-lg-12">
                <div class="feature-grid">
                    <!-- Left Column -->
                    <div class="left-column">
                        <div class="feature-card ">
                            <img src="{{ asset('assets/images/banner/smart1.png') }}" alt="smart card 1">
                        </div>
                        <div class="feature-card">
                            <img src="{{ asset('assets/images/banner/smart2.png') }}" alt="smart card 2">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="right-column">
                        <div class="feature-card orange-card">
                            <img src="{{ asset('assets/images/banner/smart3.png') }}" alt="smart card 3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Smart Feature  -->



<!-- Start testimonial area  -->
<div class="rainbow-testimonial-area testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">
                    <p class="title-tag">What Real Users Say</p>
                    <p class="title">Trusted by everyday people</p>
                    <p class="sub-title">See how <span></span> is helping people grow their profits effortlessly with zero trading experience.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="">
                        <div class="rainbow-slick-dot testimonial-activation rainbow-slick-arrow slick-arrow-alignwide mt--60 testimonial-content">

                            <!-- Start single Testimonial -->
                            <div class="testimonial-style-two">
                                <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="thumbnail">
                                            <img class="" src="{{ asset('assets/images/testimonial/testimonial1.jpg') }}" alt="Testimonial image">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="content mt_sm--40">
                                            <span class="form">
                                                Spain
                                                <img src="https://flagcdn.com/w20/es.png" alt="Spain Flag" width="20" height="15" style=" vertical-align: middle;">

                                            </span>
                                            <p class="description">I’ve used other bots before, but <span>BitGoSpace</span> is on another level.
                                                It finds profitable trades fast, and I don't need to babysit it. I’ve seen consistent returns with zero stress.
                                            </p>
                                            <div class="client-info">
                                                <h4 class="title">Carlos M.</h4>
                                                <h6 class="rating">
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End single Testimonial -->

                            <!-- Start single Testimonial -->
                            <div class="testimonial-style-two">
                                <div class="row row--20 align-items-center">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="thumbnail"><img class="w-100" src="{{ asset('assets/images/testimonial/testimonial2.jpg') }}" alt="Corporate Template"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-8">
                                        <div class="content mt_sm--40">
                                            <span class="form">
                                                Canada
                                                <img src="https://flagcdn.com/w20/ca.png" alt="Canada Flag" width="20" height="15" style="vertical-align: middle;">
                                            </span>
                                            <p class="description">As someone new to crypto, I was nervous about trading. BitGoSpace made it incredibly easy. I just funded my wallet, turned on the bot, and started seeing small gains almost daily. The dashboard is clean, and I love how transparent everything is.
                                            </p>
                                            <div class="client-info">
                                                <h4 class="title">Charlotte R.</h4>
                                                <h6 class="rating">
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End single Testimonial -->

                            <!-- Start single Testimonial -->
                            <div class="testimonial-style-two">
                                <div class="row row--20 align-items-center">
                                    <div class="col-md-4">
                                        <div class="thumbnail"><img class="w-100" src="{{ asset('assets/images/testimonial/testimonial3.jpg') }}" alt="Corporate Template"></div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="content mt_sm--40">
                                            <span class="form">
                                                United Kingdom
                                                <img src="https://flagcdn.com/w20/gb.png" alt="UK Flag" width="20" height="15" style=" vertical-align: middle;">
                                            </span>
                                            <p class="description">I work full-time and don’t have hours to monitor charts. BitGoSpace runs silently in the background, making smart trades through arbitrage. The performance tracking is solid, and I stay in full control of my funds. It’s a brilliant system.
                                            </p>
                                            <div class="client-info">
                                                <h4 class="title">Liam T.</h4>
                                                <h6 class="rating">
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                    <i class="ri-star-s-fill"></i>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End single Testimonial -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End testimonial area  -->



<!-- Faq area  -->
<div class="rainbow-about-area faq-section">
    <div class="container">

        <div class="row  mb-0 mb-md-5">
            <div class="col-lg-12">
                <div class="section-box-title text-center sal-animate">

                    <p class="title">Got Questions?</p>
                    <p class="sub-title">Find quick, clear info about how BitGoSpace works from setup to withdrawals and everything in between.</p>
                </div>
            </div>
        </div>
        <div class="row row--30">
            <div class="col-lg-12 mt_md--40 mt_sm--40" data-sal="slide-left" data-sal-duration="700">
                <div class="content">

                    <div class="rainbow-accordion-style  accordion">
                        <div class="accordion" id="accordionExamplea">
                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is BitGoSpace?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        BitGoSpace is an AI-powered crypto arbitrage platform that helps you earn profits automatically by buying low and selling high across different exchanges.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Do I need trading experience to use BitGoSpace?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        Nope! BitGoSpace was built to be beginner-friendly. Just sign up, fund your wallet, and activate the bot. It handles the rest.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Is my money safe?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        Yes, Your funds are stored securely in your BitGoSpace wallet. Our platform uses encrypted connections, and the bot trades without needing access to your personal data.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        How does the AI bot make profit?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        It scans multiple exchanges 24/7, finds price differences (arbitrage opportunities), buys crypto at a lower price on one platform, and sells higher on another automatically.
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Can I withdraw my money anytime?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        Yes. Once the bot completes its trade cycles, your funds and profits are available for withdrawal straight from your dashboard.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        How often does the bot trade?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        The bot operates continuously day and night identifying multiple small-profit trades across exchanges throughout the day.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        Is there a minimum deposit?
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        Yes, we have a small minimum starting balance to activate your trading wallet. You’ll see the current amount when setting up your account.
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        Can I turn off the bot anytime?
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExamplea">
                                    <div class="accordion-body card-body">
                                        Absolutely. You can pause or stop your bot with a single click from your dashboard, giving you full control.
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Faq area ends  -->



<div class="explore-wrapper">
    <p class="explore-text theme-gradient">
        The fast, friendly, and powerful AI tool for automated crypto profits.
    </p>
    <a href="{{ route('meet-jarden') }}" class="default-btn">Explore all Smart Bots</a>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.marquee-slider-container');
        const track = document.querySelector('.marquee-slider-track');
        const slides = Array.from(document.querySelectorAll('.marquee-slide'));

        // Duplicate slides for seamless looping
        slides.forEach(slide => {
            const clone = slide.cloneNode(true);
            track.appendChild(clone);
        });

        const slideWidth = slides[0].getBoundingClientRect().width;
        let position = 0;
        const speed = 1; // pixels per frame (adjust for speed)
        let animationId;
        let isPaused = false;

        function animate() {
            if (!isPaused) {
                position -= speed;

                // When we've scrolled all original slides, reset position
                if (position <= -slideWidth * slides.length) {
                    position = 0;
                }

                track.style.transform = `translateX(${position}px)`;
            }

            animationId = requestAnimationFrame(animate);
        }

        // Start animation
        animate();

        // Pause on hover
        container.addEventListener('mouseenter', () => {
            isPaused = true;
            track.style.transition = 'transform 0.3s ease'; // Smooth pause
            track.style.transform = `translateX(${position}px)`; // Freeze at current position
        });

        container.addEventListener('mouseleave', () => {
            isPaused = false;
            track.style.transition = 'none'; // Remove transition for smooth resuming
        });

        // Clean up animation when leaving page
        window.addEventListener('beforeunload', () => {
            cancelAnimationFrame(animationId);
        });
    });
</script>

@endsection
