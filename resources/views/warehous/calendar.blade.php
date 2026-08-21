@extends('admin.includes.layout')

@section('title', 'Warehouse Calendar')

@push('styles')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        /* Consistent styles matching other premium calendars in the workspace */
        .fc {
            background: #fff !important;
            border: none !important;
            border-radius: 12px !important;
            overflow: hidden !important;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid #f3f4f6 !important;
        }

        .fc-col-header-cell {
            background-color: #fafafa !important;
            padding: 12px 0 !important;
        }

        .fc-col-header-cell-cushion {
            color: #4b5563 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            text-decoration: none !important;
        }

        .fc-daygrid-day-number {
            color: #374151 !important;
            font-weight: 500 !important;
            padding: 8px !important;
            text-decoration: none !important;
            font-size: 13px;
        }

        .fc-event {
            border: none !important;
            border-radius: 6px !important;
            padding: 5px 8px !important;
            margin: 2px 4px !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            cursor: pointer !important;
            transition: transform 0.15s ease !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
        }

        .event-regular-service {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            border-left: 4px solid #0369a1 !important;
        }

        .event-time-off {
            background-color: #d97706 !important;
            color: #ffffff !important;
            border-left: 4px solid #b45309 !important;
        }

        /* Gold/Yellow Buttons consistent with Warehouse Maintenance */
        .btn-yellow-rounded {
            background: #ffb400 !important;
            color: #fff !important;
            border-radius: 40px !important;
            padding: 12px 40px !important;
            font-weight: 600 !important;
            border: none !important;
            transition: all 0.2s !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            font-size: 13px !important;
        }

        .btn-yellow-rounded:hover {
            background: #e6a200 !important;
            color: #fff !important;
        }

        /* Custom Card layout consistent with site structures */
        .calendar-card {
            background: #ffffff !important;
            border-radius: 12px !important;
            padding: 30px !important;
            margin-bottom: 24px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid #e5e7eb !important;
        }

        /* Consistent form label styling matching standard site forms */
        .company-form .form-label {
            color: #121212 !important;
            font-size: 14px !important;
            text-transform: uppercase !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
        }

        .company-form .form-control,
        .company-form .form-select {
            border: 1px solid #CFCFCF !important;
            background-color: #fff !important;
            border-radius: 8px !important;
            padding: 0.8rem 1rem !important;
            font-size: 14px !important;
            transition: border-color 0.2s;
        }

        .company-form .form-control:focus,
        .company-form .form-select:focus {
            border-color: #ffb400 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 180, 0, 0.15) !important;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">

                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">
                                    Warehouse Calendar
                                </h3>
                                <p class="text-muted mb-0">
                                    Manage schedules and view logs for all warehouse personnel.
                                </p>
                            </div>
                        </div>

                        <!-- Controls and Calendar in PX-4 wrapper matching Warehouse Maintenance layout -->
                        <div class="px-4 py-2">

                            <!-- Controls Card -->
                            <div class="calendar-card">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark"
                                        style="font-size: 18px; letter-spacing: 0.5px; text-transform: uppercase;">
                                        Warehouse Calendar Controls
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="row">
                                        <!-- LEFT COLUMN: CONTROLS FORM -->
                                        @can('warehouse_calendar.edit')
                                        <div class="col-lg-7 border-end pe-lg-5">
                                            <form id="createScheduleForm" class="company-form">
                                                <div class="form-group mb-4">
                                                    <label for="employee_select" class="form-label">Employee <span class="text-danger">*</span></label>
                                                    <select id="employee_select" name="employee" class="form-select" required>
                                                        <option value="" disabled selected>Select Employee</option>
                                                        @foreach($employees as $emp)
                                                            <option value="{{ $emp->name }}">{{ $emp->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label for="start_time_input" class="form-label">Start Time <span class="text-danger">*</span></label>
                                                            <input type="datetime-local" id="start_time_input" name="start_time" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label for="end_time_input" class="form-label">End Time <span class="text-danger">*</span></label>
                                                            <input type="datetime-local" id="end_time_input" name="end_time" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="duty_type_select" class="form-label">Type <span class="text-danger">*</span></label>
                                                    <select id="duty_type_select" name="type" class="form-select" required>
                                                        <option value="1">Regular Service</option>
                                                        <option value="2">Call</option>
                                                    </select>
                                                </div>

                                                <div class="mt-2">
                                                    <button type="submit" class="btn btn-yellow-rounded">
                                                        Add Schedule
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endcan

                                        <!-- RIGHT COLUMN: CALL LOG TIMELINE (Rendered cleanly via Blade forelse) -->
                                        <div class="col-lg-5 ps-lg-5 mt-4 mt-lg-0">
                                            <div class="section-header mb-3">
                                                <h6 class="fw-bold text-dark"
                                                    style="font-size: 16px; letter-spacing: 0.5px; text-transform: uppercase;">
                                                    Call Duties Log</h6>
                                            </div>
                                            <div id="timeOffList" class="d-flex flex-column gap-3"
                                                style="max-height: 420px; overflow-y: auto; padding-right: 5px;">
                                                @forelse($schedules->where('type', 'Call') as $t)
                                                    @php
                                                        $startObj = \Carbon\Carbon::parse($t['start']);
                                                        $endObj = \Carbon\Carbon::parse($t['end']);
                                                        $formatStart = $startObj->format('m/d/Y, h:i A');
                                                        $formatEnd = $endObj->format('m/d/Y, h:i A');
                                                    @endphp
                                                    <div class="p-3 rounded-3 position-relative" style="background-color: rgba(255, 180, 0, 0.05); border: 1px solid rgba(255, 180, 0, 0.15); color: #8a6d3b;">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="fw-bold text-dark"><i class="fas fa-phone-alt me-2 text-warning"></i>{{ $t['employee'] }}</span>
                                                            <span class="badge bg-warning text-dark fw-bold text-uppercase" style="font-size: 9px; padding: 4px 8px;">Call</span>
                                                        </div>
                                                        <div style="font-size: 13px; color: #555;">Start: {{ $formatStart }}</div>
                                                        <div style="font-size: 13px; color: #555;">End: {{ $formatEnd }}</div>
                                                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top" style="border-top: 1px dashed rgba(255, 180, 0, 0.15) !important;">
                                                            <span style="font-size: 11px; color: #777;">Ref ID: <span class="fw-bold">#SCH-{{ $t['id'] }}</span></span>
                                                            @can('warehouse_calendar.edit')
                                                            <button class="btn btn-sm btn-outline-danger btn-delete-sch-quick py-1 px-2" data-id="{{ $t['id'] }}" style="font-size: 11px; border-radius: 4px;">
                                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                                            </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="p-4 text-center text-muted rounded-3" style="background-color: #f9fafb; border: 1px dashed #e5e7eb;">
                                                        No active Call duties logged at the moment.
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar Card -->
                            <div class="calendar-card mt-4">
                                <div id="calendar"></div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Details Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background-color: #fafafa; border-bottom: 1px solid #e5e7eb; padding: 20px 24px;">
                    <h6 class="modal-title fw-bold text-dark" id="scheduleModalLabel" style="font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa-regular fa-calendar-check me-2 text-warning"></i>
                        Schedule Details
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="scheduleModalBody" style="padding: 24px; font-size: 14px;">
                    <!-- Loaded dynamically -->
                </div>
                <div class="modal-footer d-flex justify-content-between" style="background-color: #fafafa; border-top: 1px solid #e5e7eb; padding: 15px 24px;">
                    @can('warehouse_calendar.edit')
                    <button type="button" class="btn btn-outline-danger py-2 px-4 fw-semibold" id="btnDeleteScheduleModal" style="border-radius: 40px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Delete</button>
                    @else
                    <div></div>
                    @endcan
                    <button type="button" class="btn btn-secondary py-2 px-4 fw-semibold" style="border-radius: 40px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        $(document).ready(function () {
            // Retrieve dynamic schedules seeded and loaded from the database
            let rawSchedules = @json($schedules);

            // Map and format backend dates directly
            let schedules = rawSchedules.map(s => {
                return {
                    id: s.id,
                    title: s.title,
                    start: s.start,
                    end: s.end,
                    type: s.type,
                    employee: s.employee
                };
            });

            // ==========================================
            // FRONTEND VALIDATION SYSTEMS (jQuery Validation)
            // ==========================================
            $("#createScheduleForm").validate({
                ignore: [],
                rules: {
                    employee: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    type: {
                        required: true
                    }
                },
                messages: {
                    employee: {
                        required: "Please select an employee."
                    },
                    start_time: {
                        required: "Please select a start time."
                    },
                    end_time: {
                        required: "Please select an end time."
                    },
                    type: {
                        required: "Please select a schedule type."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function (error, element) {
                    if (element.closest('.input-group').length) {
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Initialize FullCalendar dynamically based on current date
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: function (info, successCallback, failureCallback) {
                    const fcEvents = schedules.map(s => {
                        let className = 'event-regular-service';
                        if (s.type === 'Call') className = 'event-time-off';

                        return {
                            id: s.id,
                            title: `[#${s.id}] ${s.title}`,
                            start: s.start,
                            end: s.end,
                            classNames: [className]
                        };
                    });
                    successCallback(fcEvents);
                },
                eventClick: function (info) {
                    const id = info.event.id;
                    const index = schedules.findIndex(s => s.id == id);
                    if (index === -1) return;
                    const scheduleItem = schedules[index];

                    const startObj = new Date(scheduleItem.start);
                    const endObj = new Date(scheduleItem.end);
                    const formatStart = startObj.toLocaleString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });
                    const formatEnd = endObj.toLocaleString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true });

                    const html = `
                        <div class="mb-3">
                            <span class="text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">Employee</span>
                            <div class="fw-bold text-dark" style="font-size: 16px;">${scheduleItem.employee}</div>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">Type</span>
                            <div class="text-dark">${scheduleItem.type}</div>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">Start Time</span>
                            <div class="text-dark">${formatStart}</div>
                        </div>
                        <div class="mb-0">
                            <span class="text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; font-weight: 600;">End Time</span>
                            <div class="text-dark">${formatEnd}</div>
                        </div>
                    `;

                    $('#scheduleModalBody').html(html);

                    $('#btnDeleteScheduleModal').off('click').on('click', function() {
                        $('#scheduleModal').modal('hide');
                        deleteSchedule(id);
                    });

                    $('#scheduleModal').modal('show');
                },
                height: 'auto',
                aspectRatio: 1.6
            });

            calendar.render();

            // Quick delete handler for list buttons
            $(document).on('click', '.btn-delete-sch-quick', function () {
                const id = $(this).data('id');
                deleteSchedule(id);
            });

            // Master schedule delete helper
            function deleteSchedule(id) {
                const index = schedules.findIndex(s => s.id == id);
                if (index === -1) {
                    toastr.error(`Schedule #${id} not found!`);
                    return;
                }

                const scheduleItem = schedules[index];

                Swal.fire({
                    title: 'Delete Schedule?',
                    text: `Are you sure you want to delete the schedule for ${scheduleItem.employee}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffb400',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/warehouse/calendar/delete/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: "json",
                            success: function (response) {
                                if (response.success) {
                                    toastr.success(`Schedule #${id} has been successfully deleted.`);
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function (xhr) {
                                toastr.error(
                                    xhr.responseJSON?.message ||
                                    'Error deleting schedule.'
                                );
                            }
                        });
                    }
                });
            }

            // Submit Create Schedule Form
            $('#createScheduleForm').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);

                if (!form.valid()) {
                    return;
                }

                const employee = $('#employee_select').val();
                const startTimeVal = $('#start_time_input').val();
                const endTimeVal = $('#end_time_input').val();
                const type = $('#duty_type_select').val();

                if (new Date(startTimeVal) > new Date(endTimeVal)) {
                    toastr.error('Start time must be prior to or equal to end time!');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.warehouse.calendar.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        employee: employee,
                        start_time: startTimeVal,
                        end_time: endTimeVal,
                        type: type
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            toastr.success(`Schedule #${response.schedule.id} created successfully!`);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function (field, messages) {
                                messages.forEach(function (message) {
                                    toastr.error(message);
                                });
                            });
                            return;
                        }
                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Error creating schedule.'
                        );
                    }
                });
            });
        });
    </script>
@endpush