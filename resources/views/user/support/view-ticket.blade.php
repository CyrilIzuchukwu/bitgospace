@extends('layouts.dashboard')
@section('content')
<div class="page-content">


    <div class="page-container">


        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold mb-0">Support Ticket</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item active">{{ $ticket->reference_id }}</li>
                </ol>
            </div>
        </div>


        @php
        $profilePicture = $user->profile->profile_picture ?? null;
        @endphp


        <div class="card">
            <div class="chat d-flex">
                <div class="chat-content card rounded-0 shadow-none mb-0">
                    <div class="card-header py-1 px-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between py-1">
                            <div class="d-flex align-items-center gap-2">

                                <img src="{{ $profilePicture ? asset('storage/profile_pictures/' . $profilePicture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}" style="width: 40px; height: 40px;" class="avatar-lg rounded-circle" alt="">

                                <div>
                                    <h5 class="my-0 lh-base">
                                        <a href="javascript:void(0)" class="text-reset">{{ $user->name }}</a>
                                    </h5>
                                    <p class="mb-0 text-muted">
                                        <small class="ti ti-circle-filled {{ $ticket->status === 'open' ? 'text-success' : 'text-danger' }}"></small>
                                        {{ ucfirst($ticket->status) }}
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                @if($ticket->status === 'open')
                                <!-- <form action="{{ route('user.ticket.close', $ticket->reference_id) }}" class="close-ticket-form" id="closeTicketForm" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Close Ticket</button>
                                </form> -->
                                <button type="button"
                                    class="btn btn-sm btn-danger close-ticket-btn"
                                    data-reference-id="{{ $ticket->reference_id }}">
                                    Close Ticket
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div id="chat-scroll-container" class="chat-scroll p-3" data-simplebar>
                            <ul class="chat-list" data-apps-chat="messages-list">
                                @foreach($ticket->messages->sortBy('created_at') as $index => $message)
                                @php
                                $isAdmin = $message->is_admin;
                                $messageTime = $message->created_at->format('h:i A');
                                $userPhoto = $message->user->profile->profile_picture ?? null;
                                $userPhotoUrl = $userPhoto ? asset('storage/profile_pictures/' . $userPhoto) : asset('dashboard_assets/assets/images/users/user-avatar.jpg');
                                @endphp


                                <li class="chat-group {{ $isAdmin ? '' : 'odd' }}" id="{{ $isAdmin ? 'even' : 'odd' }}-{{ $index }}">
                                    <!-- @if(!$isAdmin)
                                    <img src="{{ $userPhotoUrl }}" style="width: 30px; height: 30px;" class="avatar-sm rounded-circle" alt="avatar-1" />
                                    @endif -->
                                    @if(!$isAdmin)
                                    @if($message->attachment_path)
                                    <button type="button" class="btn btn-sm btn-outline-primary view-attachment-btn"
                                        data-file="{{ asset('storage/' . $message->attachment_path) }}"
                                        data-file-type="{{ pathinfo($message->attachment_path, PATHINFO_EXTENSION) }}">
                                        <i class="ri-attachment-line fs-16 text-white"></i>
                                    </button>
                                    @endif
                                    @endif





                                    <div class="chat-body">
                                        <div>
                                            <h6 class="d-inline-flex">{{ $isAdmin ? 'Support' : 'You' }}</h6>
                                            <h6 class="d-inline-flex text-muted">{{ $messageTime }}</h6>
                                        </div>

                                        <div class="chat-message">
                                            <p>{!! nl2br(e($message->message)) !!}</p>

                                            @if($message->attachment_path)
                                            <div class="">
                                                <!-- <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="ri-attachment-line fs-16 text-white" ></i>
                                                </a> -->
                                                <!-- <button type="button" class="btn btn-sm btn-outline-primary view-attachment-btn"
                                                    data-file="{{ asset('storage/' . $message->attachment_path) }}"
                                                    data-file-type="{{ pathinfo($message->attachment_path, PATHINFO_EXTENSION) }}">
                                                    <i class="ri-attachment-line fs-16 text-white"></i>
                                                </button> -->
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </div>

                        @if($ticket->status === 'open')
                        <div class="p-3 border-top position-sticky bottom-form-chat bottom-0 w-100 mb-0 bg-light">
                            <form class="row align-items-center g-2" action="{{ route('user.ticket.message', $ticket->reference_id) }}" method="POST" enctype="multipart/form-data" id="chat-form">
                                @csrf

                                <!-- Preview section -->
                                <div class="col-12 mt-2" id="file-preview-container" style="display: none;">
                                    <div class="border p-2 rounded d-flex justify-content-between align-items-center">
                                        <div id="file-preview-content" class="d-flex align-items-center gap-2">
                                            <div id="file-preview-icon" class="flex-shrink-0"></div>
                                            <div id="file-preview-name" class="text-truncate" style="max-width: 200px;"></div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-danger ms-2" id="remove-preview">
                                            <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                </div>


                                <div class="col-auto">
                                    <!-- Attachment input -->
                                    <label class="btn btn-icon btn-soft-primary mb-0" style="cursor:pointer;">
                                        <i class="ri-attachment-line fs-20"></i>
                                        <input type="file" name="attachment" id="file-input" class="d-none" accept="image/*,.pdf,.doc,.docx,.txt">
                                    </label>
                                </div>

                                <div class="col">
                                    <input type="text" name="message" class="form-control" placeholder="Type Message..." required>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex align-items-center gap-1">
                                        <button type="submit" class="btn btn-icon btn-success">
                                            <i class='ti ti-send'></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <div class="p-3  text-center bg-light">
                            <p class="mb-0 text-muted " style="color: #fff !important;">This ticket is closed. You can no longer reply.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Start -->
    @include('user.snippets.footer')
    <!-- end Footer -->

</div>
<style>
    .chat-scroll {
        height: calc(100vh - 200px);
    }

    .bottom-form-chat {
        background: #1e1e26;
    }


    .chat-list .chat-group .chat-message {
        position: relative;
        max-width: 650px;
        margin-bottom: 8px;
    }


    .chat-list .chat-group .chat-message p {
        font-size: 12px;
    }

    @media only screen and (max-width: 767px) {
        .chat-list .chat-group .chat-message p {
            font-size: 9px;
        }
    }

    .chat-group {
        display: flex;
        align-items: center !important;
        gap: 6px !important;
    }

    .chat-group .view-attachment-btn {
        width: 10px;
        height: 10px;
        padding: 10px;

    }

    .chat-group .view-attachment-btn i {
        font-size: 10px !important;
    }
</style>

<!-- Attachment Modal -->
<div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="attachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="attachmentModalLabel">Attachment Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="attachmentPreviewContent">
                <!-- Content will be injected here -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File preview functionality
        const fileInput = document.getElementById('file-input');
        const previewContainer = document.getElementById('file-preview-container');
        const previewContent = document.getElementById('file-preview-content');
        const previewIcon = document.getElementById('file-preview-icon');
        const previewName = document.getElementById('file-preview-name');
        const removePreviewBtn = document.getElementById('remove-preview');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (!file) return;

            // Clear previous preview
            previewIcon.innerHTML = '';
            previewName.textContent = '';

            // Set file name
            previewName.textContent = file.name;

            // Set appropriate icon based on file type
            let iconClass = 'ti ti-file';
            if (file.type.startsWith('image/')) {
                iconClass = 'ti ti-photo';
            } else if (file.type.includes('pdf')) {
                iconClass = 'ti ti-file-text';
            } else if (file.type.includes('document') || file.type.includes('word')) {
                iconClass = 'ti ti-file-document';
            }

            const icon = document.createElement('i');
            icon.className = iconClass + ' fs-3';
            previewIcon.appendChild(icon);

            previewContainer.style.display = 'block';
        });

        removePreviewBtn.addEventListener('click', function() {
            fileInput.value = '';
            previewContainer.style.display = 'none';
        });

        // Auto-scroll to bottom of chat
        const scrollContainer = document.querySelector('#chat-scroll-container');
        if (scrollContainer) {
            scrollContainer.scrollTop = scrollContainer.scrollHeight;
        }

    });
</script>



<!-- submit message  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chat-form');

        if (!chatForm) return;

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(chatForm);
            const submitBtn = chatForm.querySelector('button[type="submit"]');
            const messageInput = chatForm.querySelector('input[name="message"]');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ti ti-circle-dashed fs-16 animate-spin"></i>';

            fetch(chatForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        appendNewMessage(res.data);
                        messageInput.value = '';
                        document.getElementById('file-input').value = '';
                        document.getElementById('file-preview-container').style.display = 'none';

                        const scrollContainer = document.querySelector('#chat-scroll-container');
                        if (scrollContainer) scrollContainer.scrollTop = scrollContainer.scrollHeight;

                        // Re-attach attachment button listeners
                        bindAttachmentPreview();
                    } else {
                        alert(res.message);
                    }
                })
                .catch(() => alert('An error occurred. Please try again.'))
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="ti ti-send"></i>';
                });
        });

        function appendNewMessage(data) {
            const chatList = document.querySelector('.chat-list');
            if (!chatList) return;

            const li = document.createElement('li');
            li.className = 'chat-group odd';

            li.innerHTML = `
                ${data.attachment_path ? `
                    <button type="button" class="btn btn-sm btn-outline-primary view-attachment-btn"
                        data-file="${data.attachment_path}"
                        data-file-type="${data.attachment_extension}">
                        <i class="ri-attachment-line fs-16 text-white"></i>
                    </button>` : ''
                }

                <div class="chat-body">
                    <div>
                        <h6 class="d-inline-flex">You</h6>
                        <h6 class="d-inline-flex text-muted">${data.time}</h6>
                    </div>
                    <div class="chat-message">
                        <p>${data.message.replace(/\n/g, '<br>')}</p>
                    </div>
                </div>
            `;

            chatList.appendChild(li);
        }

        // 🧠 DRY: bind attachment preview logic in one place
        function bindAttachmentPreview() {
            document.querySelectorAll('.view-attachment-btn').forEach(button => {
                button.onclick = function() {
                    const fileUrl = this.dataset.file;
                    const fileType = this.dataset.fileType.toLowerCase();
                    const previewContainer = document.getElementById('attachmentPreviewContent');

                    // Clear previous content
                    previewContainer.innerHTML = '';

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileType)) {
                        previewContainer.innerHTML = `<img src="${fileUrl}" class="img-fluid rounded" alt="Attachment">`;
                    } else if (['pdf'].includes(fileType)) {
                        previewContainer.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px" class="border-0 rounded"></iframe>`;
                    } else {
                        previewContainer.innerHTML = `<p>Preview not supported for this file type.<br><a href="${fileUrl}" target="_blank">Download</a></p>`;
                    }

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('attachmentModal'));
                    modal.show();
                };
            });
        }

        // Initial bind
        bindAttachmentPreview();
    });
</script>



<!-- close ticket script  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.close-ticket-btn').forEach(button => {
            button.addEventListener('click', function() {
                const referenceId = this.dataset.referenceId;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to close this ticket. You won't be able to send more messages.",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, close it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/user/ticket/${referenceId}/close`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire({
                                        title: 'Closed!',
                                        text: 'The ticket has been successfully closed.',
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        document.getElementById('chat-form')?.classList.add('d-none');

                                        const bottomForm = document.querySelector('.bottom-form-chat');
                                        if (bottomForm) {
                                            bottomForm.outerHTML = `
        <div class="p-3 border-top text-center bg-light">
            <p class="mb-0 text-muted" style="color: #fff !important;">This ticket is closed. You can no longer reply.</p>
        </div>
    `;
                                        }

                                        // Disable the close button
                                        this.disabled = true;
                                        this.innerText = 'Ticket Closed';
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Failed',
                                        text: 'Failed to close the ticket.'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                });
                            });
                    }
                });
            });
        });
    });
</script>

@endsection
