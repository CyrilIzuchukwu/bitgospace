@extends('layouts.dashboard')
@section('content')

<div class="page-content">
    <div class="page-container">

        <div class="row justify-content-center profile-wrapper">
            <div class="col-md-12 col-lg-12">

                <!-- Title and Description -->
                <div class="text-center mb-4">
                    <h3 class="">YOUR PROFILE</h3>
                    <p class="text-muted">
                        You have full control to manage your own account setting
                    </p>
                </div>

                <div class="card  profile-content shadow-sm border-0">
                    <div class="card-body main-card">
                        <div class="row">
                            <!-- Left Column - Profile Picture and Basic Info -->
                            <div class="col-md-4  border-end pe-md-4">
                                <div class="text-center mb-4">
                                    <form id="profilePictureForm" action="{{ route('profile.update.picture') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="position-relative d-inline-block">
                                            <!-- <img src="{{ $user->profile && $user->profile->profile_picture ? asset('storage/profile_pictures/' . $user->profile->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}" class="rounded-circle shadow" width="120" height="120" alt="Profile" id="profileImage"> -->

                                            <img src="{{ $user->profile && $user->profile->profile_picture ? asset('storage/profile_pictures/' . $user->profile->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=240&background=random' }}" class="rounded-circle shadow" width="120" height="120" style="object-fit: cover;" alt=" Profile " id="profileImage">

                                            <label for="profile_picture" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-pill cursor-pointer">
                                                <i class="ti ti-camera"></i>
                                                <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*">
                                            </label>
                                        </div>
                                    </form>
                                    <h5 class="mt-3 mb-1 fw-bold">{{ $user->name }}</h5>
                                    <p class="text-muted small">{{ $user->email }}</p>

                                    <!-- Withdrawal Pin Status Section -->
                                    <div class="mt-3">
                                        @if($user->wallet && $user->wallet->pin_set)
                                        <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                                            <span class="badge bg-success rounded-sm p-1">
                                                <i class="ti ti-lock"></i> PIN Set
                                            </span>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updatePinModal">
                                                    <i class="ti ti-pencil"></i> Change PIN
                                                </button>
                                                <a href="{{ route('user.forgot.pin') }}" class="btn btn-sm btn-outline-danger" id="forgotPinBtn">
                                                    <i class="ti ti-help me-1"></i> Forgot PIN
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>



                                <div class="mb-4">
                                    <h6 class="fw-bold text-uppercase small text-center text-muted mb-3">Referral Link</h6>
                                    <div class="text-center p-3 bg-light rounded">
                                        <!-- <img width="120" height="120" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://example.com/ref/123" alt="QR Code" class="img-fluid mb-2"> -->
                                        <p class="small text-muted">Use the link to invite your friends</p>
                                        @php
                                        $referralLink = Auth::user()->referral_link ?? url('/register?ref=' . Auth::user()->id);
                                        @endphp

                                        <div class="d-flex justify-content-center gap-2 mt-2">
                                            <input type="text" id="referral_link_input" class="form-control d-none form-control-sm w-75" value="{{ $referralLink }}" readonly>
                                            <button class="btn btn-sm btn-outline-info" id="copy_referral_btn">Copy Link</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Profile Details -->
                            <div class="col-md-8 ps-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold mb-0">Profile Information</h5>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                                </div>

                                <!-- Change Password -->
                                <div class="card mb-4 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-1">Change Password</h6>
                                                <p class="small text-muted mb-0">*************</p>
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="card mb-4 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-1">Phone</h6>
                                                <p id="userPhone" class=" small text-muted mb-0">{{ $user->profile->phone ?? 'N/A' }}</p>
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePhoneModal">Change</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold mb-3">Personal Information</h6>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">Name</label>
                                                <p class="fw-bold">{{ $user->name }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">Email</label>
                                                <p class="fw-bold">{{ $user->email }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">Country</label>
                                                <p class="fw-bold">{{ $user->profile->country ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">State</label>
                                                <p class="fw-bold">{{ $user->profile->state ?? 'N/A' }}</p>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">City</label>
                                                <p class="fw-bold">{{ $user->profile->city ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small text-muted">Address</label>
                                                <p class="fw-bold">{{ $user->profile->address ?? 'N/A' }}</p>
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

<style>
    .flag-icon {
        width: 20px;
        height: 15px;
        border-radius: 3px;
    }
</style>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', $user->profile->country ?? '') }}">
                        @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $user->profile->state ?? '') }}">
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $user->profile->city ?? '') }}">
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->profile->address ?? '') }}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
@push('scripts')
<script>
    $(document).ready(function() {
        $('#editProfileModal').modal('show');
    });
</script>
@endpush
@endif



<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="changePasswordForm" action="{{ route('profile.update.password') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="formStatus" class="alert d-none" role="alert"></div>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" placeholder="Enter current password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback" id="current_password_error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" placeholder="Enter new password" class="form-control" id="new_password" name="new_password" required>
                        <div class="invalid-feedback" id="new_password_error"></div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" placeholder="Confirm password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Change Phone Modal -->
<div class="modal fade" id="changePhoneModal" tabindex="-1" aria-labelledby="changePhoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="changePhoneForm" action="{{ route('profile.update.phone') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="changePhoneModalLabel">Change Phone Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="phoneFormStatus" class="alert d-none" role="alert"></div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                        <div class="invalid-feedback" id="phone_error"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="phoneSubmitBtn" class="btn btn-primary">Update Phone</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Update PIN Modal -->
<div class="modal fade" id="updatePinModal" tabindex="-1" aria-labelledby="updatePinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added modal-dialog-centered here -->
        <div class="modal-content">
            <form action="{{ route('profile.update.pin') }}" method="POST">
                @if(session('show_update_pin_modal'))
                <input type="hidden" id="pinModalErrorTrigger" value="true">
                @endif
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePinModalLabel">Change Withdrawal PIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="current_pin" class="form-label">Current PIN</label>
                        <input type="password" placeholder="Enter old pin"
                            class="form-control @error('current_pin') is-invalid @enderror"
                            id="current_pin" name="current_pin" maxlength="4" pattern="\d{4}" value="{{ old('current_pin') }}"
                            required>
                        @error('current_pin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_pin" class="form-label">New 4-digit PIN</label>
                        <input type="password" placeholder="Enter new pin"
                            class="form-control @error('pin') is-invalid @enderror"
                            id="new_pin" name="pin"
                            maxlength="4"
                            pattern="\d{4}"
                            value="{{ old('pin') }}"
                            required>
                        @error('pin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confirm_pin" class="form-label">Confirm PIN</label>
                        <input type="password" placeholder="Confirm pin"
                            class="form-control @error('pin_confirmation') is-invalid @enderror"
                            id="confirm_pin"
                            name="pin_confirmation"
                            maxlength="4"
                            pattern="\d{4}"
                            required>
                        @error('pin_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update PIN</button>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- script for profile  -->
<script>
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) return;

        // Validate file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file');
            return;
        }

        // Show preview immediately
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('profileImage').src = event.target.result;
        };
        reader.readAsDataURL(file);

        // Submit form automatically
        document.getElementById('profilePictureForm').submit();
    });
</script>


<!-- copy referral link  -->
<script>
    document.getElementById('copy_referral_btn').addEventListener('click', function() {
        const input = document.getElementById('referral_link_input');
        input.select();
        input.setSelectionRange(0, 99999); // Mobile fix

        navigator.clipboard.writeText(input.value).then(() => {
            const button = document.getElementById('copy_referral_btn');
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.remove('btn-outline-info');
            button.classList.add('btn-info');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('btn-info');
                button.classList.add('btn-outline-info');
            }, 3000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    });
</script>


<!-- script for password  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('changePasswordForm');
        const submitBtn = document.getElementById('submitBtn');
        const formStatus = document.getElementById('formStatus');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Reset UI
            formStatus.classList.add('d-none');
            clearErrors();

            // Button loading spinner
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`;

            try {
                const formData = new FormData(form);

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    formStatus.classList.remove('d-none', 'alert-danger');
                    formStatus.classList.add('alert-success');
                    formStatus.textContent = data.message || 'Password updated successfully.';

                    // Close modal after 2s
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                        modal.hide();
                        form.reset();

                        formStatus.classList.add('d-none');
                        formStatus.classList.remove('alert-success', 'alert-danger');
                        formStatus.textContent = '';
                    }, 1500);
                } else {
                    if (data.errors) {
                        showErrors(data.errors);
                    }
                    formStatus.classList.remove('d-none', 'alert-success');
                    formStatus.classList.add('alert-danger');
                    formStatus.textContent = data.message || 'Please fix the errors below.';
                }
            } catch (error) {
                console.error(error);
                formStatus.classList.remove('d-none', 'alert-success');
                formStatus.classList.add('alert-danger');
                formStatus.textContent = 'An unexpected error occurred.';
            } finally {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Change Password';
            }
        });

        function showErrors(errors) {
            Object.keys(errors).forEach(field => {
                const input = document.getElementById(field);
                const errorDiv = document.getElementById(`${field}_error`);
                if (input && errorDiv) {
                    input.classList.add('is-invalid');
                    errorDiv.textContent = errors[field][0];
                }
            });
        }

        function clearErrors() {
            ['current_password', 'new_password'].forEach(field => {
                const input = document.getElementById(field);
                const errorDiv = document.getElementById(`${field}_error`);
                if (input && errorDiv) {
                    input.classList.remove('is-invalid');
                    errorDiv.textContent = '';
                }
            });
        }
    });
</script>


<!-- script for phone number -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneForm = document.getElementById('changePhoneForm');
        const phoneSubmitBtn = document.getElementById('phoneSubmitBtn');
        const phoneFormStatus = document.getElementById('phoneFormStatus');
        const phoneModal = document.getElementById('changePhoneModal');

        // ✅ Update the phone input every time the modal is shown
        phoneModal.addEventListener('show.bs.modal', () => {
            const phoneDisplay = document.getElementById('userPhone');
            const phoneInput = document.getElementById('phone');
            if (phoneDisplay && phoneInput) {
                phoneInput.value = phoneDisplay.textContent.trim(); // Always up-to-date
            }
            clearPhoneErrors(); // Optional: clear validation errors when opening modal
            phoneFormStatus.classList.add('d-none'); // Optional: hide success/error alerts
        });


        phoneForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            phoneFormStatus.classList.add('d-none');
            clearPhoneErrors();

            // Loading Spinner
            phoneSubmitBtn.disabled = true;
            phoneSubmitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`;

            try {
                const formData = new FormData(phoneForm);

                const response = await fetch(phoneForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': phoneForm.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    phoneFormStatus.classList.remove('d-none', 'alert-danger');
                    phoneFormStatus.classList.add('alert-success');
                    phoneFormStatus.textContent = data.message || 'Phone updated successfully.';

                    const phoneDisplay = document.getElementById('userPhone');
                    if (phoneDisplay) {
                        phoneDisplay.textContent = formData.get('phone');
                    }

                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('changePhoneModal'));
                        modal.hide();
                        phoneForm.reset();
                        phoneFormStatus.classList.add('d-none');
                        phoneFormStatus.classList.remove('alert-success', 'alert-danger');
                        phoneFormStatus.textContent = '';
                    }, 1500);
                } else {
                    if (data.errors) showPhoneErrors(data.errors);
                    phoneFormStatus.classList.remove('d-none', 'alert-success');
                    phoneFormStatus.classList.add('alert-danger');
                    phoneFormStatus.textContent = data.message || 'Please fix the errors below.';
                }
            } catch (error) {
                console.error(error);
                phoneFormStatus.classList.remove('d-none', 'alert-success');
                phoneFormStatus.classList.add('alert-danger');
                phoneFormStatus.textContent = 'An unexpected error occurred.';
            } finally {
                phoneSubmitBtn.disabled = false;
                phoneSubmitBtn.innerHTML = 'Update Phone';
            }
        });

        function showPhoneErrors(errors) {
            if (errors.phone) {
                const phoneInput = document.getElementById('phone');
                const phoneError = document.getElementById('phone_error');
                phoneInput.classList.add('is-invalid');
                phoneError.textContent = errors.phone[0];
            }
        }

        function clearPhoneErrors() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phone_error');
            phoneInput.classList.remove('is-invalid');
            phoneError.textContent = '';
        }
    });
</script>



<!-- script for pin  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var trigger = document.getElementById('pinModalErrorTrigger');
        if (trigger && (trigger.dataset.show === 'true' || trigger.value === 'true')) {
            var pinModal = new bootstrap.Modal(document.getElementById('updatePinModal'));
            pinModal.show();
        }
    });
</script>



<!-- script for forget password button   -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forgotPinBtn = document.getElementById('forgotPinBtn');

        forgotPinBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Change button content to spinner + Redirecting text
            forgotPinBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Redirecting...
            `;

            // Disable the button
            forgotPinBtn.classList.add('disabled');
            forgotPinBtn.style.pointerEvents = 'none';
            forgotPinBtn.style.cursor = 'not-allowed';

            // Redirect after slight delay for UX (optional)
            window.location.href = forgotPinBtn.getAttribute('href');
        });
    });
</script>




@endsection