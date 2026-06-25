@extends('admin.includes.layout')

@section('title', 'Office Checklist')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Equipment Report Table Boxed Styling from Consumable & Driver Reports */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }

        .equipment-report-table tr:last-child td:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tr:last-child td:last-child {
            border-bottom-right-radius: 12px !important;
        }

        /* Action link color matching default system action links */
        a.text-action {
            color: #337ab7 !important;
        }

        /* Status Pills (matches project standard) */
        .status-pill {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
            text-align: center;
        }

        .status-pill-due {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pill-completed {
            background: #d1fae5;
            color: #059669;
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
                            <div class="right-part-sec">
                                <button class="btn btn-export btn-create-task-trigger" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                    + CREATE TASK
                                </button>
                            </div>
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="officeChecklistTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important;">Duty / Checklist</th>
                                            <th style="text-align: center !important; width: 150px;">Status</th>
                                            <th class="text-end" style="width: 150px; padding-right: 35px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dutiesTableBody">
                                        @foreach($duties as $duty)
                                            @php
                                                $isCompleted = !is_null($duty->last_performed_on);
                                            @endphp
                                            <tr>
                                                <td style="text-align: left !important; padding: 20px !important; border-top: none;">
                                                    <div style="font-size: 18px; color: #374151; margin-bottom: 5px; font-weight: 500;">
                                                        {{ $duty->title }}
                                                    </div>
                                                    <div style="font-size: 13px; color: #6b7280; margin-bottom: 5px;">
                                                        <span class="fw-bold">Service Frequency:</span> {{ $duty->frequency }} {{ $duty->description ? '- ' . $duty->description : '' }}
                                                    </div>
                                                    <div style="font-size: 13px; color: #6b7280; margin-bottom: 5px;">
                                                        <span class="fw-bold">Description:</span> {{ $duty->description ?? '-' }}
                                                    </div>
                                                    @if($isCompleted)
                                                        <div style="font-size: 13px; color: #6b7280;">
                                                            <span class="fw-bold">Last performed by/on:</span> {{ $duty->lastPerformedBy ? ($duty->lastPerformedBy->name . ' ' . $duty->last_performed_on) : '' }} notes: {{ $duty->notes ?? '' }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="text-align: center !important; vertical-align: middle; border-top: none;">
                                                    @if($isCompleted)
                                                        <span class="status-pill status-pill-completed">Completed</span>
                                                    @else
                                                        <span class="status-pill status-pill-due">Due</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: right !important; padding: 20px !important; padding-right: 35px !important; border-top: none; vertical-align: middle;">
                                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                                        <a href="#" class="text-action btn-edit-task" 
                                                           data-id="{{ $duty->id }}"
                                                           data-title="{{ $duty->title }}"
                                                           data-description="{{ $duty->description }}"
                                                           data-frequency="{{ $duty->frequency }}"
                                                           style="font-size: 18px;" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#createTaskModal">
                                                            <i class="fa-solid fa-gear"></i>
                                                        </a>
                                                        <a href="#" class="text-action btn-complete-task" 
                                                           data-id="{{ $duty->id }}"
                                                           data-title="{{ $duty->title }}"
                                                           style="font-size: 18px;" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#completeTaskModal">
                                                            <i class="fa-solid fa-play"></i>
                                                        </a>
                                                    </div>
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
                <h1 class="modal-title" id="completeTaskModalLabel">Daily - Answer Phones</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="completeTaskForm" class="company-form" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
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
            
            $('#completeTaskModalLabel').text(title);
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
    });
</script>
@endpush
