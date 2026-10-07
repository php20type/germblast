@extends('admin.includes.layout')

@section('title', 'SIT Progress')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .section-card {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .sit-body {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }
        .sit-section {
            margin-bottom: 16px;
        }
        .sit-section strong {
            color: rgba(55, 65, 81, 1);
            font-weight: 700;
        }
        .sit-empty-message {
            font-size: 22px;
            font-weight: 300;
            color: #6b7280;
        }
        .nav-tabs .nav-link {
            color: #6b7280;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #111827;
            font-weight: 700;
            border-bottom: 2px solid #111827;
        }

        /* Equipment Report Table Boxed Styling */
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
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.operations.sidebar')

            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        <!-- Header -->
                        <div class="heading-area-sec mb-4 px-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">SIT PROGRESS</h3>
                                <p class="text-muted mb-0">Track the progress of current and past Supervisors In Training.</p>
                            </div>
                        </div>

                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="px-4">
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif

                        <div class="px-4 pb-4">
                            <div class="section-card sit-body">

                                <!-- Program Overview -->
                                <div class="mb-4 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">PROGRAM OVERVIEW</h5>
                                </div>

                                <div class="sit-section">
                                    <strong>Description:</strong> The Supervisor In Training (SIT) Program is a probationary period used for necessary training to become a GermBlast Service Supervisor. The SIT Program does not guarantee a supervisory position but is merited by the success and performance of the training program of each individual.
                                </div>

                                <div class="sit-section">
                                    <strong>Duration:</strong> The Supervisor in Training Program is conducted over a 90-day period but can be extended to accommodate necessary training deemed by Service Supervisors and Operations Managers. The training program will be divided into modules that will differ in time depending on the knowledge and understanding of each SIT. Supervisors and Operations Managers will sign off in ICIMatrix when each task has been successfully completed.
                                </div>

                                <div class="sit-section">
                                    <strong>Requirements:</strong> The Supervisor In Training Program requirements that will need to be met in order to begin:
                                    <ul class="mt-2 mb-0">
                                        <li>Employment for a minimum of 90 days</li>
                                        <li>Must be 21 years of age or older (MVR Requirements)</li>
                                    </ul>
                                </div>

                                <div class="sit-section">
                                    <strong>Process:</strong> Once an employee has met the requirements for the SIT Training Program, the OM and SIT will begin training on the modules within ICIMatrix. Each module will need to be completed before moving onto the next. Once the SIT has successfully completed all modules, the OM will reach out to Risk Management for an audit.
                                </div>

                                <!-- Tabs -->
                                <div class="mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                                    <ul class="nav nav-tabs mb-3" id="sitProgressTabs">
                                        <li class="nav-item">
                                            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#activeTrainees" type="button">
                                                Active Trainees
                                                @if($activePrograms->count() > 0)
                                                    <span class="badge bg-primary ms-1">{{ $activePrograms->count() }}</span>
                                                @endif
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completedTrainees" type="button">
                                                Completed
                                                @if($completedPrograms->count() > 0)
                                                    <span class="badge bg-success ms-1">{{ $completedPrograms->count() }}</span>
                                                @endif
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="sitProgressTabContent">

                                        <!-- Active Trainees Tab -->
                                        <div class="tab-pane fade show active" id="activeTrainees">
                                            @if($activePrograms->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover w-100 equipment-report-table" id="activeTraineesTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Technician Name</th>
                                                                <th>Start Date</th>
                                                                <th>Initiated By</th>
                                                                <th>Progress</th>
                                                                <th>Modules Completed</th>
                                                                <th class="text-center" style="width: 160px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($activePrograms as $program)
                                                                @php
                                                                    $total = $program->programModules->count();
                                                                    $completed = $program->programModules->where('status', 'completed')->count();
                                                                    $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                                                                @endphp
                                                                <tr>
                                                                    <td class="fw-semibold text-dark">{{ $program->user->name }}</td>
                                                                    <td>{{ $program->started_at->format('M d, Y') }}</td>
                                                                    <td>{{ $program->initiatedBy?->name ?? '—' }}</td>
                                                                    <td style="min-width: 160px;">
                                                                        <div class="progress" style="height: 10px; border-radius: 10px;">
                                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                                style="width: {{ $percentage }}%; border-radius: 10px;"
                                                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted mt-1 d-block fw-semibold">{{ $percentage }}% Complete</small>
                                                                    </td>
                                                                    <td>{{ $completed }} / {{ $total }}</td>
                                                                    <td class="text-center">
                                                                        <div class="d-flex justify-content-center gap-1">
                                                                            <button class="btn btn-sm btn-outline-dark"
                                                                                style="border-radius: 6px; padding: 6px 14px;"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#ManageProgress{{ $program->id }}">
                                                                                Manage
                                                                            </button>
                                                                            <button class="btn btn-sm btn-outline-danger drop-program-btn"
                                                                                style="border-radius: 6px; padding: 6px 14px;"
                                                                                data-id="{{ $program->id }}"
                                                                                data-name="{{ $program->user->name }}">Drop</button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Manage Progress Modals (outside table) -->
                                                @foreach($activePrograms as $program)
                                                    <div class="modal fade" id="ManageProgress{{ $program->id }}" tabindex="-1" aria-labelledby="manageProgressLabel{{ $program->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-fullscreen">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title" id="manageProgressLabel{{ $program->id }}">Manage SIT Progress</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row mx-0">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label fw-bold">Technician</label>
                                                                                <input type="text" class="form-control" value="{{ $program->user->name }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $sortedModules = $program->programModules->sortBy(fn($pm) => $pm->module?->order_index ?? 999);
                                                                    @endphp
                                                                    <div>
                                                                        <ul class="list-group mt-3">
                                                                            @foreach($sortedModules as $pm)
                                                                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 module-list-item">
                                                                                    <div>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <span class="badge bg-secondary me-2">{{ $pm->module?->order_index ?? '-' }}</span>
                                                                                            <strong class="text-dark">{{ $pm->module?->name ?? 'Unknown Module' }}</strong>
                                                                                        </div>
                                                                                        @if($pm->module?->description)
                                                                                            <div class="text-muted mt-1" style="font-size: 13px; padding-left: 32px;">
                                                                                                {{ $pm->module->description }}
                                                                                            </div>
                                                                                        @endif
                                                                                        <small class="text-muted mt-1 d-block module-status-text" style="padding-left: 32px;">
                                                                                            @if($pm->status == 'completed')
                                                                                                <span class="text-success fw-semibold">Completed:</span> {{ $pm->completed_at ? $pm->completed_at->format('M d, Y h:i A') : '—' }}
                                                                                                | <strong>Signed off by:</strong> {{ $pm->completedBy?->name ?? '—' }}
                                                                                            @else
                                                                                                <span class="text-warning text-dark fw-semibold">Status:</span> Pending
                                                                                            @endif
                                                                                        </small>
                                                                                    </div>
                                                                                    <div class="module-action-area text-end flex-shrink-0 ms-3">
                                                                                        @if($pm->status != 'completed')
                                                                                            <button class="btn btn-sm btn-success sign-off-btn text-nowrap"
                                                                                                data-program-id="{{ $program->id }}"
                                                                                                data-module-id="{{ $pm->id }}">Sign Off</button>
                                                                                        @else
                                                                                            <span class="text-success fw-bold text-nowrap"><i class="fa-solid fa-check"></i> Signed Off</span>
                                                                                        @endif
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <h4 class="sit-empty-message mt-4">There is no one currently in the SIT Program for this location.</h4>
                                            @endif
                                        </div>

                                        <!-- Completed Tab -->
                                        <div class="tab-pane fade" id="completedTrainees">
                                            @if($completedPrograms->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover w-100 equipment-report-table" id="completedTraineesTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Technician Name</th>
                                                                <th>Start Date</th>
                                                                <th>Completed Date</th>
                                                                <th>Initiated By</th>
                                                                <th>Duration</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($completedPrograms as $program)
                                                                <tr>
                                                                    <td class="fw-semibold text-dark">{{ $program->user->name }}</td>
                                                                    <td>{{ $program->started_at->format('M d, Y') }}</td>
                                                                    <td>{{ $program->completed_at ? $program->completed_at->format('M d, Y') : '—' }}</td>
                                                                    <td>{{ $program->initiatedBy?->name ?? '—' }}</td>
                                                                    <td>
                                                                        @if($program->started_at && $program->completed_at)
                                                                            {{ $program->completed_at->diffForHumans($program->started_at, true) }}
                                                                        @else
                                                                            —
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($program->status === 'dropped')
                                                                            <span class="badge bg-danger" style="border-radius: 20px; padding: 5px 12px;">Dropped</span>
                                                                        @else
                                                                            <span class="badge bg-success" style="border-radius: 20px; padding: 5px 12px;">Completed</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <h4 class="sit-empty-message mt-4">No completed SIT Programs yet.</h4>
                                            @endif
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
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Setup CSRF
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            // DataTables logic
            const dataTableConfig = {
                pageLength: 10,
                ordering: false,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            };

            if ($('#activeTraineesTable').length) {
                $('#activeTraineesTable').DataTable(dataTableConfig);
            }
            if ($('#completedTraineesTable').length) {
                $('#completedTraineesTable').DataTable(dataTableConfig);
            }

            // AJAX Drop Program
            $(document).on('click', '.drop-program-btn', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Drop " + name + " from the SIT Program? This cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, drop",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/operations/sit-progress/' + id + '/drop',
                            method: 'POST',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dropped!',
                                    text: response.message || 'Program dropped.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                setTimeout(() => location.reload(), 2000);
                            },
                            error: function (xhr) {
                                Swal.fire('Error', 'Failed to drop program.', 'error');
                            }
                        });
                    }
                });
            });

            // AJAX Sign Off Module
            $(document).on('click', '.sign-off-btn', function () {
                let btn = $(this);
                let programId = btn.data('program-id');
                let moduleId = btn.data('module-id');
                let listItem = btn.closest('.list-group-item');

                $.ajax({
                    url: '/admin/operations/sit-progress/' + programId + '/update',
                    method: 'POST',
                    data: { module_id: moduleId },
                    beforeSend: function () {
                        btn.prop('disabled', true).text('Signing Off...');
                    },
                    success: function (response) {
                        toastr.success(response.message || 'Module signed off.');
                        
                        // Update DOM dynamically
                        listItem.find('.module-action-area').html('<span class="text-success fw-bold text-nowrap"><i class="fa-solid fa-check"></i> Signed Off</span>');
                        
                        listItem.find('.module-status-text').html(
                            '<span class="text-success fw-semibold">Completed:</span> ' + response.completed_at_formatted + 
                            ' | <strong>Signed off by:</strong> ' + response.completed_by_name
                        );

                        if (response.program_completed) {
                            setTimeout(() => location.reload(), 1500); // Reload if the entire program is finished
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to sign off.');
                        btn.prop('disabled', false).text('Sign Off');
                    }
                });
            });
        });
    </script>
@endpush
