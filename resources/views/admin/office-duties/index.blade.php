@extends('admin.includes.layout')

@section('title', 'Office Checklist')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Timeline History Styles */
        .history-timeline-container {
            position: relative;
            padding: 30px 40px;
            background: #fff;
        }

        .history-timeline-line {
            position: absolute;
            left: 55px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ffb400;
            opacity: 0.3;
        }

        .timeline-item {
            position: relative;
            display: flex;
            margin-bottom: 30px;
            align-items: flex-start;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            background: #ffb400;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            z-index: 1;
            flex-shrink: 0;
            margin-right: 25px;
            box-shadow: 0 0 0 5px #fff;
            margin-top: 15px;
        }

        .history-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 16px;
            padding: 20px 25px;
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
            width: 140px;
            flex-shrink: 0;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
            font-weight: 500;
        }

        .history-content {
            flex-grow: 1;
            padding: 0 25px;
        }

        .history-note {
            font-size: 15px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 4px;
        }

        .history-user {
            width: 150px;
            text-align: right;
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        /* Modal Refinement */
        #historyModal .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        #historyModal .modal-header {
            padding: 35px 40px 25px 40px;
            border-bottom: none !important;
        }

        #historyTaskTitle {
            font-size: 14px;
            color: #9ca3af !important;
            margin-top: 8px;
            display: block;
            font-weight: normal;
        }

        .btn-close-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff8e8;
            border: none;
            color: #ffb400;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s;
        }

        .btn-close-circle:hover {
            background: #ffb400;
            color: #fff;
        }

        .history-labels {
            display: flex;
            padding: 10px 40px;
            color: #9ca3af;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-yellow-rounded {
            background: #ffb400;
            color: #fff;
            border-radius: 12px;
            padding: 10px 35px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }

        .btn-yellow-rounded:hover {
            background: #e6a200;
            color: #fff;
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
                        
                        <div class="alert alert-info d-flex align-items-center mb-4 mx-4" role="alert" style="border-radius: 12px; font-size: 14px; background-color: #e0f2fe; border-color: #bae6fd; color: #0369a1;">
                            <i class="fas fa-info-circle me-3" style="font-size: 20px;"></i>
                            <div>
                                <strong>How it works:</strong> The "Mark Complete" button will automatically reappear when the task is due again, based on its <strong>Service Frequency</strong> (e.g., Daily tasks will become due again at midnight).
                            </div>
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start">
                            @forelse($duties as $duty)
                                @php
                                    $isCompleted = $duty->is_completed;
                                    $statusClass = $isCompleted ? 'status-pill-completed' : 'status-pill-due';
                                    $statusText = $isCompleted ? 'Completed' : 'Due';
                                @endphp
                                <div class="corp-section-card mt-3">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-column align-items-start">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="status-pill {{ $statusClass }}">{{ $statusText }}</span>
                                                <h4 class="mb-0" style="font-size: 18px;">
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
                                            <div class="d-flex gap-2 flex-wrap justify-content-end">
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
                                                @if(!$isCompleted)
                                                <button type="button" class="btn btn-sm btn-outline-success btn-complete-task py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-id="{{ $duty->id }}"
                                                        data-title="{{ $duty->title }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#completeTaskModal">
                                                    Mark Complete
                                                </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-outline-info btn-view-history py-1 px-3" 
                                                        style="border-radius: 6px;"
                                                        data-completions="{{ $duty->completions }}"
                                                        data-title="{{ $duty->title }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#historyModal">
                                                    View History
                                                </button>
                                            </div>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 13px; letter-spacing: 0.5px;">Description</h6>
                                        <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                            {{ $duty->description ?? 'No description provided.' }}
                                        </div>
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

<!-- History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="modal-title" id="historyModalLabel">Task History</h5>
                    <div id="historyTaskTitle"></div>
                </div>
                <button type="button" class="btn-close-circle" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="history-labels d-flex">
                <div style="width: 55px; margin-right: 25px;"></div> <!-- Icon Spacer -->
                <div style="width: 140px;">Date</div>
                <div class="flex-grow-1" style="padding: 0 25px;">Note</div>
                <div style="width: 150px;" class="text-end">Completed By</div>
            </div>

            <div class="modal-body p-0">
                <div class="history-timeline-container">
                    <div class="history-timeline-line"></div>
                    <div id="historyTimelineBody">
                        <!-- Dynamically populated -->
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn-yellow-rounded" data-bs-dismiss="modal">Close</button>
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

        // View History button clicked
        $(document).on('click', '.btn-view-history', function() {
            let title = $(this).data('title');
            let completionsRaw = $(this).attr('data-completions');
            let completions = [];
            
            try {
                completions = typeof completionsRaw === 'string' ? JSON.parse(completionsRaw) : completionsRaw;
            } catch (e) {
                console.error("Failed to parse completions", e);
                completions = [];
            }
            
            $('#historyTaskTitle').text(title);
            let container = $('#historyTimelineBody');
            container.empty();
            
            if (Array.isArray(completions) && completions.length > 0) {
                // sort by most recent first
                completions.sort((a, b) => new Date(b.completed_at) - new Date(a.completed_at));
                
                let html = completions.map(c => {
                    let dateObj = new Date(c.completed_at);
                    let formattedDate = dateObj.toLocaleDateString() + '<br><small class="text-muted">' + dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + '</small>';
                    let userName = c.user ? c.user.name : 'System';
                    let note = c.notes ? c.notes : '<span class="text-muted fst-italic">No note</span>';
                    
                    return `
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="history-card">
                                <div class="history-date">
                                    <div class="text-dark">${formattedDate}</div>
                                </div>
                                <div class="history-content">
                                    <div class="history-note">${note}</div>
                                </div>
                                <div class="history-user">
                                    ${userName}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                container.html(html);
            } else {
                container.html('<div class="text-center py-5 text-muted">No history found for this task.</div>');
            }
        });
    });
</script>
@endpush
