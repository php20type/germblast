@extends('admin.includes.layout')

@section('title', 'Change Control')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Status Pills styling */
        .status-pill {
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 4px 10px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-open {
            background-color: rgba(13, 110, 253, 0.12) !important;
            color: #0d6efd !important;
            border-color: rgba(13, 110, 253, 0.2) !important;
        }

        .status-pill-approved {
            background-color: rgba(6, 150, 151, 0.12) !important;
            color: #069697 !important;
            border-color: rgba(6, 150, 151, 0.25) !important;
        }

        .status-pill-rejected {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
        }

        .status-pill-closed {
            background-color: rgba(134, 134, 134, 0.12) !important;
            color: #636363 !important;
            border-color: rgba(134, 134, 134, 0.2) !important;
        }



        /* Section Cards */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }
    </style>
@endpush

@section('content')
@php
    $sortedRequests = $requests->sortByDesc('created_at');
@endphp

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">
                        
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">CHANGE CONTROL <span style="font-size: 24px;">🔄</span></h3>
                                <p class="text-muted mb-0">Create and track change requests, status approvals, and tasks.</p>
                            </div>
                            @can('change_control.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#createRequestModal">
                                    + CREATE REQUEST
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start">
                            @forelse ($sortedRequests as $request)
                                <div class="section-card mt-3">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-column align-items-start">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="status-pill status-pill-{{ strtolower($request->status) }}">{{ $request->status }}</span>
                                                <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                    {{ $request->title }}
                                                </h4>
                                            </div>
                                            <div class="text-muted small mt-1">
                                                Requested by <span class="fw-semibold text-dark">{{ $request->requester->name ?? 'System' }}</span> ({{ $request->requester->email ?? '' }}) on <span class="fw-semibold text-dark">{{ $request->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex gap-2">
                                                @can('change_control.edit')
                                                <button type="button" class="btn btn-sm btn-outline-dark edit-request-btn py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-id="{{ $request->id }}" 
                                                        data-title="{{ $request->title }}" 
                                                        data-description="{{ $request->description }}">
                                                    Edit
                                                </button>
                                                @endcan
                                                <a href="{{ route('admin.change-control.show', $request->id) }}" class="btn btn-sm btn-outline-primary py-1 px-3" style="border-radius: 6px;">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                        <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                            {{ $request->description ?? 'No description provided.' }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No change requests found.</div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Change Request Modal -->
<div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="createRequestModalLabel">Create Change Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createRequestForm" action="{{ route('admin.change-control.store') }}" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="requestTitle" name="title" required placeholder="e.g. Upgrade PHP Version to 8.2">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="requestDescription" name="description" rows="6" placeholder="Explain the reasons and details of the proposed change..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Change Request Modal -->
<div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editRequestModalLabel">Edit Change Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRequestForm" action="" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="editRequestTitle" name="title" required placeholder="e.g. Upgrade PHP Version to 8.2">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="editRequestDescription" name="description" rows="6" placeholder="Explain the reasons and details of the proposed change..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Form Submit (AJAX)
            $('#createRequestForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Creating...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Change request created successfully!');
                        $('#createRequestModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        submitBtn.prop('disabled', false).text('Save changes');
                    }
                });
            });

            // Edit Button Click Handler
            $(document).on('click', '.edit-request-btn', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');

                const form = $('#editRequestForm');
                let actionUrl = "{{ route('admin.change-control.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                form.attr('action', actionUrl);

                $('#editRequestTitle').val(title);
                $('#editRequestDescription').val(description);

                $('#editRequestModal').modal('show');
            });

            // Edit Form Submit (AJAX)
            $('#editRequestForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Change request updated successfully!');
                        $('#editRequestModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        submitBtn.prop('disabled', false).text('Save changes');
                    }
                });
            });
        });
    </script>
@endpush
