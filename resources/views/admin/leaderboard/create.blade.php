@extends('layouts.admin')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="row">
                <div class="col-12">
                    <div class="card position-relative deposit-wrapper">
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-12">
                                <!-- Title -->
                                <div class="text-center">
                                    <h3 class="mb-2">CREATE LEADERBOARD STAGE</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning text-center">
                                        <i class="ti ti-lock me-2"></i>
                                        <strong>Subscription Required</strong><br>
                                        You haven't subscribed to access the Leaderboard package.
                                        Please subscribe and unlock this feature.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <form action="{{ route('admin.leaderboard.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Stage Name</label>
                                        <input type="text" name="name" placeholder="Stage name" value="{{ old('name') }}" class="form-control" required>
                                        <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea name="description" placeholder="Stage description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                        <span class="text-danger">@error('description') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Image</label>
                                        <input type="file" style="height: 45px;" name="image" accept="image/*" class="form-control">
                                        <span class="text-danger">@error('image') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Target Amount</label>
                                        <input type="number" step="0.01" name="target_amount" placeholder="Target amount" value="{{ old('target_amount') }}" class="form-control" required>
                                        <span class="text-danger">@error('target_amount') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <span class="text-danger">@error('status') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="mb-3">
                                        <label>Order(Stage)</label>
                                        <input type="number" name="order" placeholder="Display order" value="{{ old('order', 0) }}" class="form-control">
                                        <span class="text-danger">@error('order') {{ $message }} @enderror</span>
                                    </div>

                                    <div class="pt-2">
                                        <button type="submit" class="submit-btn btn-default">Create Stage<i class="ti ti-chevron-right ms-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> --}}
                    </div>
                </div>
            </div>
        </div>

        @include('admin.snippets.footer')
    </div>
@endsection
