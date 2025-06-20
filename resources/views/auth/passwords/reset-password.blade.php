@extends('layouts.auth')

@section('content')
<div class="slider-area slider-style-1 bg-transparent">
    <div class="container">
        <div class="log-wrapper">
            <div class="content">
                <div class="form-content">
                    <div class="header-text">
                        <h3 class="welcome-title">
                            Reset Password
                        </h3>
                        <p class="subhead">Create a new secure password for your account.</p>
                    </div>

                    <form action="{{ route('reset.password.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="make-input">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-key-2-fill"></i>
                                    </span>
                                    <input type="password" class="input password-input" name="password" id="passwordInput"
                                        placeholder="Enter new password" required>
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

                        <div class="make-input">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <span class="left-icon">
                                        <i class="ri-key-2-fill"></i>
                                    </span>
                                    <input type="password" class="input password-input" name="password_confirmation"
                                        id="passwordConfirmation" placeholder="Confirm new password" required>
                                </div>
                                @error('password_confirmation')
                                <span class="error-msg">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="auth-buttons">
                            <button type="submit" class="default-btn auth-button">Reset Password <i class="ri-arrow-right-line"></i></button>
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

    .error-msg {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('passwordInput');
        const requirementsBox = document.getElementById('passwordRequirements');
        const lengthCheck = document.getElementById('lengthCheck');
        const uppercaseCheck = document.getElementById('uppercaseCheck');
        const numberCheck = document.getElementById('numberCheck');
        const hideEye = document.getElementById('hideEye');
        const showEye = document.getElementById('showEye');
        const passwordConfirmation = document.getElementById('passwordConfirmation');

        // Toggle password visibility
        hideEye.addEventListener('click', function() {
            passwordInput.type = 'text';
            hideEye.style.display = 'none';
            showEye.style.display = 'block';
        });

        showEye.addEventListener('click', function() {
            passwordInput.type = 'password';
            showEye.style.display = 'none';
            hideEye.style.display = 'block';
        });

        // Password validation
        passwordInput.addEventListener('input', function() {
            const value = passwordInput.value;

            if (value.length > 0) {
                requirementsBox.classList.remove('d-none');
            } else {
                requirementsBox.classList.add('d-none');
            }

            // Check length
            toggleClass(lengthCheck, value.length >= 8);

            // Check uppercase
            toggleClass(uppercaseCheck, /[A-Z]/.test(value));

            // Check number
            toggleClass(numberCheck, /\d/.test(value));
        });

        function toggleClass(element, condition) {
            if (condition) {
                element.classList.remove('text-danger');
                element.classList.add('text-success');
            } else {
                element.classList.remove('text-success');
                element.classList.add('text-danger');
            }
        }
    });
</script>
@endsection
