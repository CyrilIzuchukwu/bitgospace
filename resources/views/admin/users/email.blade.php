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
                                    <h3 class="mb-2">SEND EMAIL TO USER</h3>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning text-center">
                                        <i class="ti ti-lock me-2"></i>
                                        <strong>Subscription Required</strong><br>
                                        You haven't subscribed to send email to user.
                                        Please subscribe and unlock this feature.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <form action="{{ route('admin.users.email.send', $userEmail->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Recipient Email</label>
                                    <input type="email" name="email" value="{{ $userEmail->email }}"
                                        class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" placeholder="Email subject"
                                        value="{{ old('subject') }}" class="form-control" required>
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
                                    <input type="file" name="attachments[]" id="attachments" class="form-control"
                                        multiple>
                                    <small class="text-muted">You can select multiple files</small>
                                    <span class="text-danger">
                                        @error('attachments.*')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="submit-btn btn-default">Send Email <i
                                            class="ti ti-chevron-right ms-1"></i></button>
                                </div>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <style>
        .note-btn-group .note-btn {
            font-size: 10px !important;
            background-color: #1e1f27 !important;
        }
    </style> --}}

        @include('user.snippets.footer')
    </div>
@endsection
