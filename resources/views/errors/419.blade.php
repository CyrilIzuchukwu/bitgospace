@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-icon mb-4">
                <i class="fas fa-clock fa-5x text-danger"></i>
            </div>
            <h1 class="display-4 text-danger mb-4">Session Expired</h1>
            <p class="lead">Your session has timed out due to inactivity. We ended your session to keep your account safe.</p>
            <p>Please refresh the page and try again.</p>
            <div class="mt-5">
                <a href="{{ url()->previous() }}" class="btn btn-primary mr-3">
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>
                <a href="/" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> Return Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Error Pages Styling */
    .error-icon {
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .error-actions .btn {
        min-width: 150px;
        margin: 5px;
    }
</style>
@endsection
