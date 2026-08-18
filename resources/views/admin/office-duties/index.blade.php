@extends('admin.includes.layout')

@section('title', 'Office Checklist')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
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

        .status-pill-due {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pill-completed {
            background: #d1fae5;
            color: #059669;
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
                                <h3 class="mb-1">OFFICE CHECKLIST <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">Track and perform office duties and checklists.</p>
                            </div>
                            @can('office_duties.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export btn-create-task-trigger" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                    + CREATE TASK
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start">
                            @forelse($duties as $duty)
                                @php
                                    $isCompleted = !is_null($duty->last_performed_on);
                                    $statusClass = $isCompleted ? 'status-pill-completed' : 'status-pill-due';
                                    $statusText = $isCompleted ? 'Completed' : 'Due';
                                @endphp
                                <div class="section-card mt-3">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-column align-items-start">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="status-pill {{ $statusClass }}">{{ $statusText }}</span>
                                                <h4 class="mb-0" style="font-size: 18px; font-weight: 600; color: #111827;">
                                                    {{ $duty->title }}
                                                </h4>
                                            </div>
                                            <div class="text-muted small mt-1">
                                                Service Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency }}</span>
                                            </div>
                                            @if($isCompleted)
                                            <div class="text-muted small mt-1">
                                                Last Performed: By <span class="fw-semibold text-dark">{{ $duty->lastPerformedBy->name ?? 'System' }}</span> on <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($duty->last_performed_on)->format('M d, Y g:i A') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            @can('office_duties.edit')
                                            @if(!$isCompleted)
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-dark btn-edit-task py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-id="{{ $duty->id }}"
                                                        data-title="{{ $duty->title }}"
                                                        data-description="{{ $duty->description }}"
                                                        data-frequency="{{ $duty->frequency }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#createTaskModal">
                                                     Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success btn-complete-task py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-id="{{ $duty->id }}"
                                                        data-title="{{ $duty->title }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#completeTaskModal">
                                                    Mark Complete
                                                </button>
                                            </div>
                                            @else
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-warning btn-reopen-task py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-id="{{ $duty->id }}">
                                                    <i class="fa-solid fa-rotate-left"></i> Reopen
                                                </button>
                                            </div>
                                            @endif
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 13px; letter-spacing: 0.5px;">Description</h6>
                                        <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                            {{ $duty->description ?? 'No description provided.' }}
                                        </div>
                                        @if($isCompleted && $duty->notes)
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2 mt-3" style="font-size: 13px; letter-spacing: 0.5px;">Completion Note</h6>
                                        <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                            {{ $duty->notes }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No office duties found.</div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Task Modal (Matches Add Company Modal structure) -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="createTaskModalLabel">Create New Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTaskForm" class="company-form" action="{{ route('admin.office-duties.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="title" id="taskTitle" placeholder="Enter task name" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="taskDescription" placeholder="Add some description..." rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Frequency</label>
                                <span class="text-danger">*</span>
                                <select class="form-select" name="frequency" id="taskFrequency">
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
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

<!-- Complete Task Modal (Matches Add Company Modal structure) -->
<div class="modal fade" id="completeTaskModal" tabindex="-1" aria-labelledby="completeTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="completeTaskModalLabel">Mark as Completed</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="completeTaskForm" class="company-form" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="completeTaskTitleDisplay" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Short Note</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="description" id="completeTaskDescription" placeholder="Enter notes or description..." required>
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
<script>
    $(document).ready(function() {
        // Plus button clicked
        $('.btn-create-task-trigger').on('click', function() {
            $('#createTaskModalLabel').text('Create New Task');
            $('#createTaskForm')[0].reset();
            $('#createTaskForm').attr('action', '{{ route('admin.office-duties.store') }}');
            $('#formMethod').val('POST');
        });

        // Edit button clicked
        $(document).on('click', '.btn-edit-task', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let description = $(this).data('description');
            let frequency = $(this).data('frequency');

            $('#createTaskModalLabel').text('Edit Task');
            $('#taskTitle').val(title);
            $('#taskDescription').val(description || '');
            $('#taskFrequency').val(frequency);
            
            $('#createTaskForm').attr('action', '{{ url('admin/office-duties/update') }}/' + id);
            $('#formMethod').val('PUT');
        });

        // Create/Edit Submit (AJAX)
        $('#createTaskForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            $.ajax({
                url: form.attr('action'),
                method: 'POST', // standard POST wrapper for Laravel PUT spoofing
                data: form.serialize(),
                beforeSend: function() {
                    submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    toastr.success(response.message || 'Task saved successfully!');
                    $('#createTaskModal').modal('hide');
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

        // Complete icon clicked
        $(document).on('click', '.btn-complete-task', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            
            $('#completeTaskModalLabel').text('Mark as Completed');
            $('#completeTaskTitleDisplay').val(title);
            $('#completeTaskForm').attr('action', '{{ url('admin/office-duties/complete') }}/' + id);
            $('#completeTaskDescription').val('');
        });

        // Complete Submit (AJAX)
        $('#completeTaskForm').on('submit', function(e) {
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
                    toastr.success(response.message || 'Task completed successfully!');
                    $('#completeTaskModal').modal('hide');
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

        // Reopen button clicked
        $(document).on('click', '.btn-reopen-task', function() {
            let id = $(this).data('id');
            let btn = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to reopen this task.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reopen it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/office-duties/reopen') }}/' + id,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');
                        },
                        success: function(response) {
                            toastr.success(response.message || 'Task reopened successfully!');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                            btn.prop('disabled', false).html('<i class="fa-solid fa-rotate-left"></i> Reopen');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
