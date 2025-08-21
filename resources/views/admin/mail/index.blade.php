@extends('layouts.admin')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="row">
                <div class="col-12">
                    <div class="card position-relative deposit-wrapper">
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h3 class="mb-2">SEND EMAIL TO USER(S)</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning text-center">
                                        <i class="ti ti-lock me-2"></i>
                                        <strong>Subscription Required</strong><br>
                                        You haven't subscribed to send email to users.
                                        Please contact support to subscribe and unlock this feature.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="recipientType">Select Recipient Type</label>
                                    <select id="recipientType" class="form-control">
                                        <option value="">-- Select Recipient Type --</option>
                                        <option value="single">Single User</option>
                                        <option value="all">All Users</option>
                                    </select>
                                </div>
                            </div>


                            <form id="singleUserForm" action="" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="recipient_type" value="single">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="user_id">Select User</label>
                                            <select name="user_id" id="user_id" class="form-control" required>
                                                <option value="">-- Select User --</option>

                                            </select>
                                            <span class="text-danger">
                                                @error('user_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="single_subject">Subject</label>
                                            <input type="text" name="subject" id="single_subject"
                                                placeholder="Email subject" value="{{ old('subject') }}"
                                                class="form-control" required>
                                            <span class="text-danger">
                                                @error('subject')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Message</label>
                                            <textarea id="summernote" name="message" class=" form-control bg-transparent" rows="5"
                                                placeholder="Enter text ...">{{ old('message') }}</textarea>

                                            <span class="text-danger">
                                                @error('message')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                    </div>


                                    <div class="pt-2">
                                        <button type="submit" class="submit-btn btn-default">
                                            Send Email <i class="ti ti-chevron-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>


                            <form id="allUsersForm" action="{{ route('admin.users.email.bulk') }}" method="POST"
                                style="display: none;" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="recipient_type" value="all">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="ti ti-info-circle me-2"></i>
                                            This email will be sent to all registered users with role "user".
                                        </div>

                                        <div class="mb-3">
                                            <label for="all_subject">Subject</label>
                                            <input type="text" name="subject" id="all_subject"
                                                placeholder="Email subject" value="{{ old('subject') }}"
                                                class="form-control" required>
                                            <span class="text-danger">
                                                @error('subject')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Message</label>
                                            <textarea id="summernote" name="message" class=" form-control bg-transparent" rows="5"
                                                placeholder="Enter text ...">{{ old('message') }}</textarea>

                                            <span class="text-danger">
                                                @error('message')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="mb-3">
                                            <label for="attachments" class="form-label">Attachments (Optional)</label>
                                            <input type="file" name="attachments[]" id="attachments"
                                                class="form-control" multiple>
                                            <small class="text-muted">You can select multiple files (Max 15MB
                                                total)</small>
                                            <span class="text-danger">
                                                @error('attachments.*')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <button type="submit" class="submit-btn btn-default">
                                            Send to All Users <i class="ti ti-chevron-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        @include('user.snippets.footer')
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipientType = document.getElementById('recipientType');
            const singleUserForm = document.getElementById('singleUserForm');
            const allUsersForm = document.getElementById('allUsersForm');

            // Handle form display based on recipient type selection
            recipientType.addEventListener('change', function() {
                // Hide both forms first
                singleUserForm.style.display = 'none';
                allUsersForm.style.display = 'none';

                // Show the selected form
                if (this.value === 'single') {
                    singleUserForm.style.display = 'block';
                    // Focus on user selection
                    document.getElementById('user_id').focus();
                } else if (this.value === 'all') {
                    allUsersForm.style.display = 'block';
                    // Focus on subject field
                    document.getElementById('all_subject').focus();
                }
            });

            // Handle form submissions with loading states
            const forms = [singleUserForm, allUsersForm];
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    // Add loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="ti ti-loader ti-spin me-2"></i>Sending...';

                    // Re-enable button after 5 seconds (in case of errors)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 5000);
                });
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                }, 5000);
            });
        });
    </script>
@endsection
