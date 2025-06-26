@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
            <div class="flex-grow-1">
                <!-- <h4 class="fs-18 fw-semibold mb-0">Support Ticket</h4> -->
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="mb-2 section-title" style="text-transform: uppercase;">Support Tickets</h3>
                    <p class="text-muted w-100 m-auto">
                        Overview of all support tickets
                    </p>
                </div>

                @if($tickets->isEmpty())
                <div class="no-investment">
                    <div class="not-found card">
                        <div class="image-notfound">
                            <img src="{{ asset('dashboard_assets/assets/images/not-found.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="text-notfound">
                            <p class="text-dark">No Tickets Found</p>
                            <span class="text-gray-100">There are no support tickets yet.</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div class="w-auto">
                                    <select class="form-select form-select-sm filter-select">
                                        <option value="all" selected>All</option>
                                        <option value="open">Open</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-hover table-custom table-nowrap align-middle mb-0">
                                        <thead class="bg-light bg-opacity-50 thead-sm">
                                            <tr class="text-uppercase fs-10">
                                                <th scope="col" class="text-muted">User</th>
                                                <th scope="col" class="text-muted">Subject & Reference</th>
                                                <th scope="col" class="text-muted">Status</th>
                                                <th scope="col" class="text-muted">Messages</th>
                                                <th scope="col" class="text-muted">Last Reply</th>
                                                <th scope="col" class="text-muted">Created</th>
                                                <th scope="col" class="text-muted">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tickets as $ticket)
                                            <tr data-status="{{ strtolower($ticket->status) }}">
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @php
                                                        $profilePicture = $ticket->user->profile->profile_picture ?? null;
                                                        @endphp
                                                        <img src="{{ $profilePicture ? asset('storage/profile_pictures/' . $profilePicture) : asset('dashboard_assets/assets/images/users/user-avatar.jpg') }}"
                                                            style="width: 30px; height: 30px;"
                                                            class="rounded-circle"
                                                            alt="{{ $ticket->user->name }}">
                                                        <span>{{ $ticket->user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">{{ $ticket->subject }}</span>
                                                        <small class="text-muted">#{{ $ticket->reference_id }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($ticket->status == 'open')
                                                    <span class="badge p-1 bg-success-subtle text-success">Open</span>
                                                    @else
                                                    <span class="badge p-1 bg-danger-subtle text-danger">Closed</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->messages_count }}</td>
                                                <td>
                                                    @if($ticket->messages_count > 0)
                                                    {{ $ticket->messages->last()->created_at->diffForHumans() }}
                                                    @else
                                                    <span class="text-muted">No replies</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->created_at->format('M j, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.ticket.view', $ticket->reference_id) }}"
                                                        class="btn btn-sm btn-soft-primary"
                                                        title="View Ticket">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-top border-light">
                                <div class="align-items-center justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">{{ $tickets->firstItem() }}</span> to
                                            <span class="fw-semibold">{{ $tickets->lastItem() }}</span> of
                                            <span class="fw-semibold">{{ $tickets->total() }}</span> Tickets
                                        </div>
                                    </div>
                                    <div class="col-sm-auto mt-3 mt-sm-0">
                                        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter tickets by status
        const filterSelect = document.querySelector('.filter-select');
        filterSelect.addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        });
    });
</script>

@endsection
