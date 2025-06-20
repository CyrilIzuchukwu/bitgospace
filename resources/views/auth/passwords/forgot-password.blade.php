@extends('layouts.auth')
@section('content')

<div class="slider-area slider-style-1 bg-transparent">
    <div class="container">
        <div class="log-wrapper">
            <div class="content">
                <div class="form-content">
                    <div class="header-text">
                        <h3 class="welcome-title">
                            Forgot Your Password?
                        </h3>
                        <p class="subhead">To reset your password, please enter the email address associated with your account.</p>
                    </div>

                    <form action="{{ route('email.submit') }}" method="POST" class="">
                        @csrf
                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-mail-send-fill"></i>
                                    </span>
                                    <input type="email" class="input" name="email" value="{{ old('email') }}" autofocus autocomplete="email" placeholder="Email address">
                                </div>
                                @error('email')
                                <span class="error-msg">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="auth-buttons">
                            <button type="submit" class="default-btn auth-button">Continue <i class="ri-arrow-right-line"></i></button>
                        </div>
                    </form>

                    <div class="log-footer">
                        <p>We use <span>OAuth 2.0 + JWT</span> security tokens to manage sessions safely across your devices.</p>
                    </div>

                </div>

                <div class="log-image">
                    <img src="{{ asset('assets/images/log-image.png') }}" alt="Log image">
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
