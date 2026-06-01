@extends('admin.includes.layout')
@section('title', 'Scheduling Calendar')

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
            color: #ffffff !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
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
    </style>
@endpush

@section('content')

    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <div class="main-content">
                        <!-- Header (matching Warehouse calendar layout) -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">
                                    SCHEDULING CALENDAR <span style="font-size: 24px;">📅</span>
                                </h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">
                                    Manage upcoming schedules, service slot planning, and confirmed orders.
                                </p>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        <!-- Controls and Calendar in PX-4 wrapper matching Warehouse Calendar layout -->
                        <div class="px-4">

                            <!-- Status Legend Card -->
                            <div class="calendar-card">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark"
                                        style="font-size: 18px; letter-spacing: 0.5px; text-transform: uppercase;">
                                        Status Legend
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-flex gap-3 flex-wrap align-items-center">
                                        <span style="background-color:#6c757d; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(108,117,125,0.15);">
                                            ● Pending
                                        </span>
                                        <span style="background-color:#ffb81c; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(255,184,28,0.15);">
                                            ● Scheduled
                                        </span>
                                        <span style="background-color:#0d6efd; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(13,110,253,0.15);">
                                            ● Confirmed
                                        </span>
                                        <span style="background-color:#198754; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(25,135,84,0.15);">
                                            ● Completed
                                        </span>
                                        <span style="background-color:#dc3545; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(220,53,69,0.15);">
                                            ● Cancelled
                                        </span>
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

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background-color: #fafafa; border-bottom: 1px solid #e5e7eb; padding: 20px 24px;">
                    <h6 class="modal-title fw-bold text-dark" id="orderModalLabel" style="font-size: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fa-regular fa-calendar-check me-2 text-warning"></i>
                        Order Details
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderModalBody" style="padding: 24px;">
                    <!-- Loaded dynamically -->
                </div>
                <div class="modal-footer" style="background-color: #fafafa; border-top: 1px solid #e5e7eb; padding: 15px 24px;">
                    <button type="button" class="btn btn-secondary py-2 px-4 fw-semibold" style="border-radius: 40px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '{{ route('admin.scheduling_calendar.orders') }}',
                eventDisplay: 'block',

                eventClick: function (info) {
                    const props = info.event.extendedProps;

                    const statusColors = {
                        'pending':     '#6c757d',
                        'scheduled':   '#ffb81c',
                        'confirmed':   '#0d6efd',
                        'in_progress': '#ffb81c',
                        'completed':   '#198754',
                        'cancelled':   '#dc3545',
                    };
                    const color = statusColors[props.status] ?? '#6c757d';

                    const content = `
                        <table class="table align-middle mb-0" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; border-collapse: separate; border-spacing: 0;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600; width: 40%;">Order No</th>
                                    <td style="padding: 12px 15px; font-size: 13px;"><a href="${props.fulfill_url}" class="fw-bold text-decoration-none" style="color: #ffb400;">${props.order_no ?? '-'}</a></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">Service</th>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #555;">${props.service_name}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">Lead</th>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #555;">${props.lead_name}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">Company</th>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #555;">${props.company_name}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">PO Number</th>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #555;">${props.po_number}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">Price / Service</th>
                                    <td style="padding: 12px 15px; font-size: 13px; color: #374151; font-weight: 600;">$${props.price}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600;">Status</th>
                                    <td style="padding: 12px 15px;">
                                        <span class="badge text-white text-uppercase" style="background-color: ${color}; font-size: 10px; font-weight: 600; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px;">
                                            ${props.status.charAt(0).toUpperCase() + props.status.slice(1)}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    `;

                    document.getElementById('orderModalBody').innerHTML = content;

                    var modal = new bootstrap.Modal(document.getElementById('orderModal'));
                    modal.show();
                },

                // eventDidMount: function (info) {
                //     info.el.title = info.event.title;
                // },
                eventContent: function (info) {
                    const props = info.event.extendedProps;
                    const startTime = props.scheduled_start_time ?? null;

                    let timeStr = startTime
                        ? new Date(startTime).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })
                        : '';

                    return {
                        html: `
                            <div style="padding: 4px 6px; width: 100%; border-radius: 4px; overflow: hidden;">
                                <div style="font-weight: 600; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    ${info.event.title}
                                </div>
                                <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">
                                    #${props.order_no ?? '-'}
                                    ${timeStr ? '&nbsp;•&nbsp;' + timeStr : ''}
                                </div>
                            </div>
                        `
                    };
                },

                height: 'auto',
                aspectRatio: 1.8
            });

            calendar.render();
        });
    </script>
@endpush
