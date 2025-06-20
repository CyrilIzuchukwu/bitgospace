@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="page-container">

        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Create Plan</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Plan</a></li>

                            <li class="breadcrumb-item active">Create Plan</li>
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
                        <h4 class="card-title mb-0">Create New Investment Plan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('plans.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Plan Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter plan name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Interest Rate (%)</label>
                                    <input type="number" name="interest_rate" class="form-control" placeholder="Enter interest rate" step="0.01" value="{{ old('interest_rate') }}">
                                    @error('interest_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Minimum Amount</label>
                                    <input type="number" name="minimum_amount" class="form-control" placeholder="Enter minimum amount" step="0.01" value="{{ old('minimum_amount') }}">
                                    @error('minimum_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Maximum Amount</label>
                                    <input type="number" name="maximum_amount" class="form-control" placeholder="Enter maximum amount" step="0.01" value="{{ old('maximum_amount') }}">
                                    @error('maximum_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Duration</label>
                                    <input type="number" name="duration" class="form-control"
                                        placeholder="Enter duration" value="{{ old('duration') }}" min="1">
                                    @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Duration Type</label>
                                    <select name="duration_type" class="form-select">
                                        <option value="" selected disabled>Select Duration Type</option>
                                        <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                                        <option value="months" {{ old('duration_type') == 'months' ? 'selected' : '' }}>Months</option>
                                        <option value="years" {{ old('duration_type') == 'years' ? 'selected' : '' }}>Years</option>
                                    </select>
                                    @error('duration_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Payout Frequency</label>
                                    <select name="payout_frequency" class="form-select">
                                        <option value="" selected disabled>Select Payout Frequency</option>
                                        <option value="daily" {{ old('payout_frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('payout_frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="monthly" {{ old('payout_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="end_of_term" {{ old('payout_frequency') == 'end_of_term' ? 'selected' : '' }}>End of Term</option>
                                    </select>
                                    @error('payout_frequency')
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
                                    <label for="address" class="form-label">Privileges</label>
                                    <textarea name="privileges" class="form-control" id="address" rows="7" style="height: 60px;" placeholder="List of benefits (JSON or comma-separated)"></textarea>
                                    <small class="text-muted">Enter comma-separated values (e.g., Bonus,Early Withdrawal,Insurance)</small>
                                    @error('privileges')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Create Plan</button>
                                    <a href="{{ route('plans.index') }}" class="btn btn-danger">Cancel</a>
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
@endsection
