@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Ambassador Reward</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Ambassador</a></li>
                            <li class="breadcrumb-item active">Edit Reward</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('ambassador.rewards.update', $reward->slug) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="card-title mb-0">Update Ambassador Reward</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Reward Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $reward->title) }}">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Required Referrals</label>
                                    <input type="number" name="required_referrals" class="form-control" min="1" value="{{ old('required_referrals', $reward->required_referrals) }}">
                                    @error('required_referrals') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Reward Type</label>
                                    <select name="reward_type" class="form-select" id="reward_type">
                                        <option value="cash" {{ old('reward_type', $reward->reward_type) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="trip" {{ old('reward_type', $reward->reward_type) == 'trip' ? 'selected' : '' }}>Trip</option>
                                        <option value="luxury_item" {{ old('reward_type', $reward->reward_type) == 'luxury_item' ? 'selected' : '' }}>Luxury Item</option>
                                        <option value="mixed" {{ old('reward_type', $reward->reward_type) == 'mixed' ? 'selected' : '' }}>Mixed (Cash + Other)</option>
                                    </select>
                                    @error('reward_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3" id="cash_amount_field">
                                    <label class="form-label">Cash Amount (USD)</label>
                                    <input type="number" name="cash_amount" class="form-control" step="0.01" min="0" value="{{ old('cash_amount', $reward->cash_amount) }}">
                                    <small class="text-muted">Leave empty if reward type is not cash-related</small>
                                    @error('cash_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status', $reward->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $reward->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Description / Reward Details</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="Enter detailed description of the reward">{{ old('description', $reward->description) }}</textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Reward</button>
                                    <a href="{{ route('ambassador.rewards.index') }}" class="btn btn-danger">Cancel</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @include('admin.snippets.footer')
    </div>
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

        // Initial check on page load
        toggleCashAmountField();

        // Listen for changes
        rewardTypeSelect.addEventListener('change', toggleCashAmountField);
    });
</script>
@endsection
