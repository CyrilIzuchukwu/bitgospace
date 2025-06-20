@extends('layouts.app')
@section('content')


<section class="contact-hero-section">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header-text">
                    <h2 class="text-gradient">Contact us</h2>
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
                                <img src="{{ asset('assets/images/star.png') }}" alt="">
                                <h3 class="theme-gradient">We’re here to help — anytime.</h3>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="contact-address">
                                <p>Have questions about Jarden, your wallet, or how BitGoSpace works? Our support team is ready to assist you.</p>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <h6>ADDRESS</h6>
                                        <span>430 California St San Francisco, CA 94104 United States</span>
                                    </div>

                                    <div class="col-md-6 mt-4 mt-md-0">
                                        <h6>EMAIL</h6>
                                        <span>hello@bitgospace.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact-map">
    <div class="row">
        <div class="col-md-12">
            <div style="width: 100%"><iframe width="100%" height="450px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=450&amp;hl=en&amp;q=430%20California%20St%20San%20Francisco,%20CA%2094104%20United%20States+(BitGoSpace)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.mapsdirections.info/calcular-la-población-en-un-mapa">Mapa de población</a></iframe></div>
        </div>
    </div>
</section>


<section class="contact-form-wrapper">
    <div class="container">

        <div class="contact-section">
            <h2 class="contact-title">Get in Touch</h2>
            <p class="contact-subtitle">Fill out the form below and our team will get back to you as soon as possible.</p>

            <form action="" class="contact-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea name="message" class="form-control" id="message" placeholder="Enter Message"></textarea>
                        </div>
                    </div>


                    <div class="contact-submit-btn">
                        <button type="submit" class="default-btn">
                            Get in touch
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
