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
                                <h3 class="theme-gradient">We're here to help — anytime.</h3>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="contact-address">
                                <p>Have questions about Jarden, your wallet, or how BitGoSpace works? Our support team is ready to assist you.</p>
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <h6>ADDRESS</h6>
                                        <span>British Virgin Island</span>
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
            <div style="width: 100%"><iframe width="100%" height="450ox" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=450&amp;hl=en&amp;q=British%20Virgin%20Island+(Bitgospace)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.mapsdirections.info/calcular-la-población-en-un-mapa">Mapa de población</a></iframe></div>
        </div>
    </div>
</section>


<section class="contact-form-wrapper">
    <div class="container">

        <div class="contact-section">
            <h2 class="contact-title">Get in Touch</h2>
            <p class="contact-subtitle">Fill out the form below and our team will get back to you as soon as possible.</p>

            <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" id="name" placeholder="Your Name"
                                   value="{{ old('name') }}" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" id="email" placeholder="Email Address"
                                   value="{{ old('email') }}" required>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                   name="subject" id="subject" placeholder="Subject"
                                   value="{{ old('subject') }}" required>
                            <div class="invalid-feedback" id="subjectError"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                      id="message" placeholder="Enter Message" required>{{ old('message') }}</textarea>
                            <div class="invalid-feedback" id="messageError"></div>
                        </div>
                    </div>

                    <div class="contact-submit-btn">
                        <button type="submit" class="default-btn" id="submitBtn">
                            <span id="submitText">Get in touch</span>
                            <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<style>
    .invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);

}

.spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.2em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border .75s linear infinite;
}

@keyframes spinner-border {
    to { transform: rotate(360deg); }
}

.d-none {
    display: none !important;
}

#formOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    z-index: 9998;
    display: none;
    backdrop-filter: blur(2px);
}

/* Optional: Add a spinner to the overlay */
#formOverlay::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin-top: -20px;
    margin-left: -20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Add overlay div for disabling interaction
    const overlay = $('<div id="formOverlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.1);z-index:9998;display:none;"></div>');
    $('body').append(overlay);

    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        // Disable page interaction
        overlay.show();

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        // Show loading state
        $('#submitBtn').prop('disabled', true);
        $('#submitText').text('Sending...');
        $('#submitSpinner').removeClass('d-none');

        // Get form data
        let formData = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: formData,
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    $('#contactForm')[0].reset();
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}Error`).text(errors[field][0]);
                    }
                    showToast('Please fix the errors in the form', 'error');
                } else {
                    // Other errors
                    showToast(xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            },
            complete: function() {
                // Re-enable page interaction
                overlay.hide();

                // Reset button state
                $('#submitBtn').prop('disabled', false);
                $('#submitText').text('Get in touch');
                $('#submitSpinner').addClass('d-none');
            }
        });
    });

    function showToast(message, type) {
        // Remove existing toasts to prevent stacking
        $('.alert-toast').remove();

        // Create new toast
        const toast = $(`
            <div class="alert-toast alert alert-${type}" id="toastAlert">
                <strong>${message}</strong>
                <div class="progress-bar ${type === 'success' ? '' : 'error'}"></div>
            </div>
        `).appendTo('body');

        // Show and animate toast
        toast.css('display', 'block').css('opacity', 1);

        // Hide after 7 seconds
        setTimeout(() => {
            toast.css('opacity', 0);
            setTimeout(() => toast.remove(), 500);
        }, 7000);
    }
});
</script>

@endsection
