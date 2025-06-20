@extends('layouts.app')
@section('content')

<section class="about-hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header-text">
                    <h1>Smarter Crypto.</h1>
                    <h2 class="text-gradient">Effortless Profits.</h2>

                    <p class="sub-text">Building a world where anyone can trade like a pro</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="about-banner">
                    <img src="{{ asset('assets/images/banner/about-banner.png') }}" alt="">
                </div>
            </div>
        </div>


    </div>
</section>


<section class="mission-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mission-header">
                    <h2 class="title">Our Mission</h2>
                    <p class="sub-title">To empower anyone, anywhere, to earn passively through secure, intelligent crypto automation.</p>
                </div>

                <div class="mission-content">
                    <div class="left-content">
                        <img src="{{ asset('assets/images/banner/mission-img.png') }}" alt="Mision image">
                    </div>
                    <div class="right-content">
                        <h2>To empower anyone anywhere to earn passively through secure, intelligent crypto automation.</h2>
                        <p>We believe financial opportunities shouldn’t be limited by experience, location, or access to complicated tools. That’s why BitGoSpace simplifies crypto trading with smart automation — helping anyone earn, even while they sleep. Whether you’re new to crypto or already experienced, BitGoSpace makes passive income possible through trusted, AI-powered arbitrage.</p>
                    </div>
                </div>

                <div class="mission-card-wrapper">
                    <div class="mission-card">
                        <div class="mission-number">
                            <h2 class="numberone">01</h2>
                        </div>
                        <p class="mission-header">Make Crypto Simple for Everyone</p>
                        <span>We remove the complexity of charts and trading jargon, making it easy for beginners to start earning with just a few clicks.</span>
                    </div>

                    <div class="mission-card">
                        <div class="mission-number">
                            <h2 class="numbertwo">02</h2>
                        </div>
                        <p class="mission-header">Keep Users in Full Control</p>
                        <span>Your funds always stay in your wallet. We use secure API connections, so you're in charge while the bot does the heavy lifting.</span>
                    </div>

                    <div class="mission-card">
                        <div class="mission-number">
                            <h2 class="numberthree">03</h2>
                        </div>
                        <p class="mission-header">Automate for Real Results</p>
                        <span>Our AI bots work 24/7 to spot market opportunities and execute smart arbitrage trades delivering consistent, hands-free income.</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="vision-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mission-content">
                    <div class="header-cell">
                        <div class="mission-header">
                            <h2 class="title">Our Vision</h2>
                            <p class="sub-title">To lead a future where smart, automated crypto trading is accessible, trusted, and rewarding for everyone.</p>
                        </div>
                    </div>
                    <div class="right-cell">
                        <img src="{{ asset('assets/images/vision/right-img.png') }}" alt="">

                    </div>

                    <div class="first-image">
                        <img src="{{ asset('assets/images/vision/image1.png') }}" alt="">
                    </div>

                    <div class="pink vision-writeup">
                        <div class="vision-icon">
                            <img src="{{ asset('assets/images/vision/visionicon1.png') }}" alt="">
                        </div>
                        <p>A world where anyone can earn from crypto</p>
                        <span>We’re building tools that remove the barriers and simplify automated trading for everyday people.</span>
                    </div>
                </div>
            </div>



            <!-- vision-grid  -->
            <div class="col-md-12">
                <div class="vision-grid-section">
                    <div class="vision-writeup">
                        <div class="vision-icon">
                            <img src="{{ asset('assets/images/vision/visionicon2.png') }}" alt="">
                        </div>
                        <p>To redefine crypto trading through trust and transparency</p>
                        <span>BitGoSpace is setting a new standard where users stay in control and profits are made smartly.</span>
                    </div>

                    <div class="pink vision-writeup">
                        <div class="vision-icon">
                            <img src="{{ asset('assets/images/vision/visionicon3.png') }}" alt="">
                        </div>
                        <p>To make passive income from crypto easily</p>
                        <span>From funding your wallet to activating your bot, we make the entire journey seamless.</span>
                    </div>

                    <div class="pink vision-writeup">
                        <div class="vision-icon">
                            <img src="{{ asset('assets/images/vision/visionicon4.png') }}" alt="">
                        </div>
                        <p>To empower global users to trade with confidence using AI</p>
                        <span>Our bots don’t panic or hesitate. They analyze, act, and earn 24/7. No emotions, just logic and results.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- video section  -->
<div class="about-style-4 video-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="video-btn">
                    <div class="video-popup icon-center">
                        <div class="overlay-content">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/banner/video-banner.png') }}" alt="Video banner">
                            </div>

                            <div class="video-icon">
                                <!-- <a class="play-button rounded-player popup-video" href="https://www.youtube.com/watch?v=tj9-MGHCs38">
                                    <span><i class="ri-play-large-line"></i></span>
                                </a> -->

                                <a class="play-button rounded-player popup-video" href="https://www.youtube.com/watch?v=u3T110SCl88">
                                    <span><i class="ri-play-large-line"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- video section ends  -->


<!-- Faq area  -->
<div class="rainbow-about-area faq-section">
    <div class="container">

        <div class="row mb-0 mb-md-5">
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
                                        After purchasing the product need you any support you can be share with
                                        us with sending mail to rainbowit10@gmail.com.
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
                                        Yes, We will get update the Trydo. And you can get it any time. Next
                                        time we will comes with more feature. You can be get update for
                                        unlimited times. Our dedicated team works for update.
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
                                        You can run doob easily. First You'll need to have node and npm on your
                                        machine. So Please open your command prompt then check your node -v and
                                        npm -v Version. Goes To Your your command prompt: then First: npm
                                        install At Last: npm run start. By the following way you can be run your
                                        project easily.
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
                                        Yes, you can withdraw your funds anytime without restrictions.
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
                                        The AI bot trades automatically multiple times a day, based on market opportunities.
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
                                        Yes, the minimum deposit to start is $100.
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
                                        Absolutely! You can pause or stop the bot whenever you choose.
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


<div class="explore-about explore-wrapper">
    <p class="explore-text theme-gradient">
        Leading the Future of Trusted Crypto Trading with BitGoSpace
    </p>
    <!-- <div class="containr">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand1.png') }}" alt="Brand 1"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand2.png') }}" alt="Brand 2"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 3"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand2.png') }}" alt="Brand 2"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand4.png') }}" alt="Brand 4"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand1.png') }}" alt="Brand 1"></div>
                <div class="swiper-slide"><img src="{{ asset('assets/images/brand/brand3.png') }}" alt="Brand 3"></div>
            </div>
        </div>
    </div> -->
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 4
            }
        }
    });
</script>


@endsection
