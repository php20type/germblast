@extends('admin.includes.layout')

@section('title', 'Change Control')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Equipment Report Table Boxed Styling from EQ / Driver Report */
        .equipment-report-table {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            border-bottom: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px !important;
        }

        /* Status Pills styling matching Fulfill Order */
        .status-pill {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
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
    </style>
@endpush

@section('content')
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
                                <h3 class="mb-1">CHANGE CONTROL <span style="font-size: 24px;">🔄</span></h3>
                                <p class="text-muted mb-0">Create and track change requests, status approvals, and task tasks.</p>
                            </div>
                            @can('change_control.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#createRequestModal">
                                    + CREATE REQUEST
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="changeControlTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Change Request</th>
                                            <th>Requester</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th class="text-center" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requests as $request)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.change-control.show', $request->id) }}" class="text-decoration-none text-dark fw-semibold">
                                                        {{ $request->title }}
                                                    </a>
                                                    <div class="small text-muted" style="font-size: 12px;">
                                                        {{ $request->description ?? 'No description provided.' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ $request->requester->name ?? 'System' }}</span>
                                                    <div class="small text-muted" style="font-size: 12px;">{{ $request->requester->email ?? '' }}</div>
                                                </td>
                                                <td>
                                                    <span class="status-pill status-pill-{{ strtolower($request->status) }}">
                                                        {{ $request->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                                <td class="text-center">
                                                    @can('change_control.edit')
                                                    <button type="button" class="btn btn-sm btn-outline-dark edit-request-btn" 
                                                            style="border-radius: 6px; padding: 6px 14px;"
                                                            data-id="{{ $request->id }}" 
                                                            data-title="{{ $request->title }}" 
                                                            data-description="{{ $request->description }}">
                                                        Edit
                                                    </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                    <div class="modal-footer">
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
                    <div class="modal-footer">
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#changeControlTable').DataTable({
                pageLength: 25,
                ordering: true,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search requests...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            });

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
                            window.location.href = response.redirect;
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
