@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">Referral Program</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Referral Program</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row referral-top-grid">

                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Your Referral Link</h5>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="referralInput" value="{{ $referralLink }}" readonly>
                                        <button class="btn btn-primary" onclick="copyLink()">Copy</button>
                                    </div>
                                    <small class="text-muted">Share this link to earn commissions</small>

                                    <div id="copiedMessage" class="text-success mt-2 d-none">Copied to clipboard!</div>
                                </div>
                            </div>
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Referral Stats</h5>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <h4 class="mb-0">{{ $totalReferrals }}</h4>
                                                <small>Total Referrals</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <h4 class="mb-0">{{ $activeReferrals }}</h4>
                                                <small>Active Referrals</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-box">
                                                <h4 class="mb-0">${{ number_format($totalCommissions, 2) }}</h4>
                                                <small>Total Earned</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mt-md-3">
                            <div class="col-md-12">
                                <h5 class="mb-2">How It Works</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-body text-center">
                                                <div class="level-badge bg-primary mb-3">1</div>
                                                <h5>Level 1</h5>
                                                <p>6% commission from direct referrals' investments</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-body text-center">
                                                <div class="level-badge bg-success mb-3">2</div>
                                                <h5>Level 2</h5>
                                                <p>2.5% commission from your referrals' referrals</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-body text-center">
                                                <div class="level-badge bg-info mb-3">3</div>
                                                <h5>Level 3</h5>
                                                <p>1% commission from third-level referrals</p>
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
    </div>
</div>

<script>
    function copyLink() {
        const input = document.getElementById('referralInput');
        console.log('Input value:', input.value); // Debug line

        if (!input.value || input.value.trim() === '') {
            alert('No referral link to copy');
            return;
        }

        navigator.clipboard.writeText(input.value).then(() => {
            const msg = document.getElementById('copiedMessage');
            msg.classList.remove('d-none');
            setTimeout(() => msg.classList.add('d-none'), 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
            // Fallback for older browsers
            input.select();
            document.execCommand('copy');
            const msg = document.getElementById('copiedMessage');
            msg.classList.remove('d-none');
            setTimeout(() => msg.classList.add('d-none'), 2000);
        });
    }
</script>

<style>
    .level-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        margin: 0 auto;
    }

    .stat-box {
        padding: 10px;
    }
</style>

@endsection
