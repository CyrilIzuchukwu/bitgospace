@extends('layouts.auth')

@section('content')
<div class="slider-area slider-style-1 bg-transparent">
    <div class="container">
        <div class="log-wrapper">
            <div class="content">
                <div class="form-content">
                    <div class="header-text">
                        <h3 class="welcome-title">
                            Create an account 🚀
                        </h3>
                        <p class="subhead">Setting up an account takes less than one minute.</p>
                    </div>

                    <form action="{{ route('user.create') }}" method="POST" class="">
                        @csrf

                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-user-line"></i>
                                    </span>
                                    <input type="text" class="input" name="name" value="{{ old('name') }}" placeholder="Full name (Surname first)">
                                </div>

                                @error('name')
                                <span class="error-msg">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-mail-send-fill"></i>
                                    </span>
                                    <input type="email" class="input" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email address">
                                </div>
                                @error('email')
                                <span class="error-msg">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="make-input">
                            <div class="form-group">
                                <label for="">Password</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-key-2-fill"></i>
                                    </span>
                                    <input type="password" class="input password-input" name="password" value="" placeholder="Password" id="passwordInput">
                                    <span class="right-icon">
                                        <i class="ri-eye-fill password-eye" id="showEye" style="display: none;"></i>
                                        <i class="ri-eye-off-fill password-eye" id="hideEye"></i>
                                    </span>


                                </div>

                                <div id="passwordRequirements" class="password-requirements mt-2 small text-muted d-none">
                                    <ul class="mb-0 ps-3">
                                        <li id="lengthCheck" class="text-danger">At least 8 characters</li>
                                        <li id="uppercaseCheck" class="text-danger">At least 1 uppercase letter</li>
                                        <li id="numberCheck" class="text-danger">At least 1 number</li>
                                    </ul>
                                </div>
                                @error('password')
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

<style>
    .password-requirements ul {
        list-style: none;
        padding-left: 5px;
        margin-top: 5px;
    }

    .password-requirements li {
        position: relative;
        margin-bottom: 1px;
        font-size: 10px;
        margin-top: 2px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('passwordInput');
        const requirementsBox = document.getElementById('passwordRequirements');

        const lengthCheck = document.getElementById('lengthCheck');
        const uppercaseCheck = document.getElementById('uppercaseCheck');
        const numberCheck = document.getElementById('numberCheck');

        passwordInput.addEventListener('input', function() {
            const value = passwordInput.value;
            console.log('🔎 Current password input:', value);

            // ✅ Show requirements when user starts typing
            if (value.length > 0) {
                requirementsBox.classList.remove('d-none');
                requirementsBox.style.display = 'block'; // In case you're using inline style
            } else {
                requirementsBox.classList.add('d-none');
                requirementsBox.style.display = 'none';
            }

            // Check length
            if (value.length >= 8) {
                lengthCheck.classList.remove('text-danger');
                lengthCheck.classList.add('text-success');
            } else {
                lengthCheck.classList.remove('text-success');
                lengthCheck.classList.add('text-danger');
            }

            // Check for uppercase
            if (/[A-Z]/.test(value)) {
                uppercaseCheck.classList.remove('text-danger');
                uppercaseCheck.classList.add('text-success');
            } else {
                uppercaseCheck.classList.remove('text-success');
                uppercaseCheck.classList.add('text-danger');
            }

            // Check for number
            if (/\d/.test(value)) {
                numberCheck.classList.remove('text-danger');
                numberCheck.classList.add('text-success');
            } else {
                numberCheck.classList.remove('text-success');
                numberCheck.classList.add('text-danger');
            }
        });
    });
</script>



@endsection
