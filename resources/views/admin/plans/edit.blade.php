@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Plan</h4>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Plan</a></li>
                            <li class="breadcrumb-item active">Edit Plan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('plans.update', $plan->slug) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="card-title mb-0">Update Investment Plan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Plan Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Interest Rate (%)</label>
                                    <input type="number" name="interest_rate" step="0.01" class="form-control" value="{{ old('interest_rate', $plan->interest_rate) }}">
                                    @error('interest_rate') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Minimum Amount</label>
                                    <input type="number" name="minimum_amount" step="0.01" class="form-control" value="{{ old('minimum_amount', $plan->minimum_amount) }}">
                                    @error('minimum_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Maximum Amount</label>
                                    <input type="number" name="maximum_amount" step="0.01" class="form-control" value="{{ old('maximum_amount', $plan->maximum_amount) }}">
                                    @error('maximum_amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Duration</label>
                                    <input type="number" name="duration" class="form-control" min="1" value="{{ old('duration', $plan->duration) }}">
                                    @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Duration Type</label>
                                    <select name="duration_type" class="form-select">
                                        <option value="days" {{ old('duration_type', $plan->duration_type) == 'days' ? 'selected' : '' }}>Days</option>
                                        <option value="months" {{ old('duration_type', $plan->duration_type) == 'months' ? 'selected' : '' }}>Months</option>
                                        <option value="years" {{ old('duration_type', $plan->duration_type) == 'years' ? 'selected' : '' }}>Years</option>
                                    </select>
                                    @error('duration_type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Payout Frequency</label>
                                    <select name="payout_frequency" class="form-select">
                                        <option value="daily" {{ old('payout_frequency', $plan->payout_frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('payout_frequency', $plan->payout_frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ old('payout_frequency', $plan->payout_frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="end_of_term" {{ old('payout_frequency', $plan->payout_frequency) == 'end_of_term' ? 'selected' : '' }}>End of Term</option>
                                    </select>
                                    @error('payout_frequency') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $plan->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Privileges</label>
                                    <textarea name="privileges" class="form-control" rows="4">{{ old('privileges', is_array(json_decode($plan->privileges)) ? implode(', ', json_decode($plan->privileges)) : '') }}</textarea>
                                    <small class="text-muted">Enter comma-separated values (e.g., Bonus, Early Withdrawal, Insurance)</small>
                                    @error('privileges') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Update Plan</button>
                                    <a href="{{ route('plans.index') }}" class="btn btn-danger">Cancel</a>
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
@endsection
