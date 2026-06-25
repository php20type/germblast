@extends('admin.includes.layout')

@section('title', 'Change Request Detail')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Modern Tabs styling matching Fulfill Order */
        .navbar-tabs {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            overflow-x: auto !important;
            overflow-y: hidden !important;
        }

        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            white-space: nowrap !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
            border-radius: 10px 10px 0 0;
        }

        .navbar-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #ffb400;
        }

        /* Boxed Table System */
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

        .equipment-report-table tbody th {
            background-color: #fff !important;
            border-bottom: 1px solid #f3f4f6 !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 15px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td,
        .equipment-report-table tbody tr:last-child th {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child,
        .equipment-report-table tbody tr:last-child th:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child,
        .equipment-report-table tbody tr:last-child th:last-child {
            border-bottom-right-radius: 12px !important;
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

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
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

        .status-select {
            font-size: 13px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            padding: 4px 10px !important;
            cursor: pointer !important;
            border: 1px solid #ced4da !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
            outline: none !important;
        }

        .status-select:focus {
            border-color: #FFB81C !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 184, 28, 0.25) !important;
        }

        /* Timeline History Styles */
        .history-timeline-container {
            position: relative;
            padding: 20px 0;
            background: #fff;
        }

        .history-timeline-line {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ffb400;
            opacity: 0.3;
        }

        .timeline-item {
            position: relative;
            display: flex;
            margin-bottom: 25px;
            align-items: flex-start;
        }

        .timeline-icon {
            width: 28px;
            height: 28px;
            background: #ffb400;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            z-index: 1;
            flex-shrink: 0;
            margin-right: 20px;
            box-shadow: 0 0 0 5px #fff;
            margin-top: 10px;
        }

        .history-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            padding: 15px 20px;
            flex-grow: 1;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .history-card:hover {
            border-color: #ffb400;
            box-shadow: 0 5px 15px rgba(255, 180, 0, 0.05);
        }

        .history-date {
            width: 120px;
            flex-shrink: 0;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
            font-weight: 500;
        }

        .history-content {
            flex-grow: 1;
            padding: 0 15px;
        }

        .history-note {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .history-user {
            width: 140px;
            text-align: right;
            font-weight: 600;
            color: #111827;
            font-size: 13px;
        }

        .task-completed {
            text-decoration: line-through;
            color: #9ca3af;
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
                    
                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">CHANGE REQUEST DETAILS <span style="font-size: 24px;">🔄</span></h3>
                            <p class="text-muted mb-2">Request ID: #{{ $changeRequest->id }}</p>
                            
                            <div class="d-flex align-items-center gap-3 flex-wrap mt-2 mb-3">
                                <div class="d-flex align-items-center gap-2 mb-0">
                                    <label class="text-muted mb-0 fw-semibold" style="font-size: 14px;">Request Status:</label>
                                    <select name="status" id="changeRequestStatusSelect" class="status-select" style="width: auto; min-width: 140px;">
                                        <option value="Open" {{ $changeRequest->status === 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="Approved" {{ $changeRequest->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ $changeRequest->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="Closed" {{ $changeRequest->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <span class="status-pill status-pill-{{ strtolower($changeRequest->status) }}" id="statusPillBadge">
                                    {{ $changeRequest->status }}
                                </span>
                            </div>
                        </div>
                        <div class="right-part-sec">
                            <div>
                                <a class="btn btn-export" href="{{ route('admin.change-control.index') }}">
                                    BACK TO LIST
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- TABS -->
                    <div class="navbar-tabs px-4 mb-3">
                        <nav class="nav nav-tabs mb-0 flex-nowrap" id="changeRequestTabs" role="tablist">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                aria-selected="true">
                                Request Info
                            </button>
                            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab"
                                data-bs-target="#tasks" type="button" role="tab"
                                aria-controls="tasks" aria-selected="false">
                                Associated Tasks
                            </button>
                            <button class="nav-link" id="documentation-tab" data-bs-toggle="tab"
                                data-bs-target="#documentation" type="button" role="tab"
                                aria-controls="documentation" aria-selected="false">
                                Documentation & History
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Section -->
                    <div class="tab-content px-4" id="changeRequestTabContent">

                        <!-- Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header mb-3">
                                            <h5 class="section-title">Change Request Information</h5>
                                        </div>
                                        <table class="table table-hover equipment-report-table">
                                            <tbody>
                                                <tr>
                                                    <th class="w-25">Title</th>
                                                    <td class="fw-semibold">{{ $changeRequest->title }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>{{ $changeRequest->description ?? 'No description provided.' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Requester</th>
                                                    <td>{{ $changeRequest->requester->name ?? 'System' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td>{{ $changeRequest->created_at->format('M d, Y h:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Updated</th>
                                                    <td>{{ $changeRequest->updated_at->format('M d, Y h:i A') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Tab -->
                        <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="section-title">Associated Tasks Checklist</h5>
                                            <button class="btn btn-export btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                                + ADD TASK
                                            </button>
                                        </div>

                                        <table class="table table-hover equipment-report-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;"></th>
                                                    <th style="text-align: left !important;">Task Title</th>
                                                    <th>Assignee</th>
                                                    <th>Due Date</th>
                                                    <th style="width: 120px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($changeRequest->tasks as $task)
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <input type="checkbox" class="form-check-input task-checkbox" 
                                                                   data-url="{{ route('admin.change-control.task.status.update', [$changeRequest->id, $task->id]) }}"
                                                                   {{ $task->status === 'Completed' ? 'checked' : '' }}
                                                                   style="width: 18px; height: 18px; cursor: pointer;">
                                                        </td>
                                                        <td style="text-align: left !important;">
                                                            <span class="{{ $task->status === 'Completed' ? 'task-completed text-muted' : 'text-dark fw-medium' }}">
                                                                {{ $task->title }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                                        <td class="text-center">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : '-' }}</td>
                                                        <td class="text-center">
                                                            <span class="badge rounded-pill {{ $task->status === 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}" style="font-size: 11px; padding: 5px 10px;">
                                                                {{ $task->status }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">No tasks found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentation Tab -->
                        <div class="tab-pane fade" id="documentation" role="tabpanel" aria-labelledby="documentation-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <!-- Add Entry -->
                                    <div class="section-card">
                                        <div class="section-header mb-3">
                                            <h5 class="section-title">Add Documentation / Log Entry</h5>
                                        </div>
                                        <form id="addDocumentationForm" action="{{ route('admin.change-control.documentation.store', $changeRequest->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <textarea class="form-control" name="notes" id="docNotes" rows="4" placeholder="Write documentation notes or logs here..." required></textarea>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary px-4">Add Entry</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- History & Timeline Logs -->
                                    <div class="section-card">
                                        <div class="section-header mb-3">
                                            <h5 class="section-title">History & Timeline Logs</h5>
                                        </div>
                                        
                                        <div class="history-timeline-container">
                                            <div class="history-timeline-line"></div>
                                            <div id="historyTimelineBody">
                                                @forelse($changeRequest->documentations->sortByDesc('created_at') as $log)
                                                    <div class="timeline-item">
                                                        <div class="timeline-icon">
                                                            <i class="fas fa-history"></i>
                                                        </div>
                                                        <div class="history-card">
                                                            <div class="history-date">
                                                                {{ $log->created_at->format('M d, Y') }}<br>
                                                                <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                                            </div>
                                                            <div class="history-content">
                                                                <div class="history-note">
                                                                    {{ $log->notes }}
                                                                </div>
                                                            </div>
                                                            <div class="history-user">
                                                                {{ $log->user->name ?? 'System' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center text-muted py-4">No history logged yet.</div>
                                                @endforelse
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

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addTaskModalLabel">Add Associated Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm" action="{{ route('admin.change-control.task.store', $changeRequest->id) }}" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Task Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="e.g. Run tests on staging environment">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Assignee</label>
                                <select class="form-select" id="taskAssignee" name="assigned_to">
                                    <option value="">Unassigned</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="taskDueDate" name="due_date">
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
            // Status Update Handler
            $('#changeRequestStatusSelect').on('change', function() {
                const newStatus = $(this).val();
                
                $.ajax({
                    url: '{{ route('admin.change-control.status.update', $changeRequest->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Status updated successfully!');
                        
                        // Update pill classes and text
                        const pill = $('#statusPillBadge');
                        pill.text(newStatus);
                        pill.removeClass().addClass('status-pill status-pill-' + newStatus.toLowerCase());
                        
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                    }
                });
            });

            // Task Checkbox Toggle Handler
            $('.task-checkbox').on('change', function() {
                const checkbox = $(this);
                const url = checkbox.data('url');
                const isChecked = checkbox.is(':checked');
                const newStatus = isChecked ? 'Completed' : 'Pending';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Task status updated!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        checkbox.prop('checked', !isChecked); // revert checkbox state
                    }
                });
            });

            // Add Task Form Submit
            $('#addTaskForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Adding...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Task added successfully!');
                        $('#addTaskModal').modal('hide');
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

            // Add Documentation Form Submit
            $('#addDocumentationForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Adding...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Entry added successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        submitBtn.prop('disabled', false).text('Add Entry');
                    }
                });
            });
        });
    </script>
@endpush
