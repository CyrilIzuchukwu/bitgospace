@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="page-container">

        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Create Ambassador Reward</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ambassador</a></li>
                            <li class="breadcrumb-item active">Create Reward</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed">
                        <h4 class="card-title mb-0">Create New Ambassador Reward</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ambassador.rewards.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Reward Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter reward title" value="{{ old('title') }}">
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Required Referrals</label>
                                    <input type="number" name="required_referrals" class="form-control" placeholder="Enter required referrals" min="1" value="{{ old('required_referrals') }}">
                                    @error('required_referrals')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Reward Type</label>
                                    <select name="reward_type" class="form-select" id="reward_type">
                                        <option value="" selected disabled>Select Reward Type</option>
                                        <option value="cash" {{ old('reward_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="trip" {{ old('reward_type') == 'trip' ? 'selected' : '' }}>Trip</option>
                                        <option value="luxury_item" {{ old('reward_type') == 'luxury_item' ? 'selected' : '' }}>Luxury Item</option>
                                        <option value="mixed" {{ old('reward_type') == 'mixed' ? 'selected' : '' }}>Mixed (Cash + Other)</option>
                                    </select>
                                    @error('reward_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3" id="cash_amount_field">
                                    <label class="form-label">Cash Amount (USD)</label>
                                    <input type="number" name="cash_amount" class="form-control" placeholder="Enter cash amount" step="0.01" min="0" value="{{ old('cash_amount') }}">
                                    <small class="text-muted">Leave empty if reward type is not cash-related</small>
                                    @error('cash_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="" selected disabled>Select status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label for="description" class="form-label">Description / Reward Details</label>
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Enter detailed description of the reward (e.g., 'An all-expenses-paid trip to Dubai, plus a Birkin bag valued at $10,000')">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Create Reward</button>
                                    <a href="{{ route('ambassador.rewards.index') }}" class="btn btn-danger">Cancel</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Start -->
    @include('admin.snippets.footer')
    <!-- end Footer -->

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rewardTypeSelect = document.getElementById('reward_type');
        const cashAmountField = document.getElementById('cash_amount_field');

        // Show/hide cash amount field based on reward type
        function toggleCashAmountField() {
            const selectedType = rewardTypeSelect.value;
            if (selectedType === 'cash' || selectedType === 'mixed') {
                cashAmountField.style.display = 'block';
            } else {
                cashAmountField.style.display = 'none';
            }
        }

        // Initial check
        toggleCashAmountField();

        // Listen for changes
        rewardTypeSelect.addEventListener('change', toggleCashAmountField);
    });
</script>
@endsection
