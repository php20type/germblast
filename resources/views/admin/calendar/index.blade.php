@extends('admin.includes.layout')
@section('title', 'Calendar')

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
            border-width: 2px !important;
            border-style: solid !important;
            border-radius: 4px !important;
            padding: 2px 4px !important;
            margin: 1px 2px !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            cursor: pointer !important;
            transition: transform 0.15s ease !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
        }

        /* Combined status overrides for border colors or shadows */
        .fc-event.has-no-staff.is-confirmed:not(.is-meet-job) {
            border-color: #007bff !important;
        }

        .fc-event.has-no-staff.is-confirmed.is-meet-job {
            border-color: #fd7e14 !important;
            box-shadow: inset 4px 0 0 0 #007bff !important;
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
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">
                                    SERVICE CALENDAR <span style="font-size: 24px;">📅</span>
                                </h3>
                                <p class="text-muted mb-0">
                                    Manage, schedule, and view upcoming service orders across all locations.
                                </p>
                            </div>
                        </div>

                        <!-- Controls and Calendar in PX-4 wrapper matching Warehouse Calendar layout -->
                        <div class="px-4 py-2">
                             <!-- Status Legend Card -->
                             <div class="calendar-card" style="padding: 20px !important; margin-bottom: 20px !important;">
                                 <div class="section-header mb-2">
                                     <h6 class="text-muted mb-2" style="font-size: 14px; font-weight: 500;">
                                         Legend
                                     </h6>
                                 </div>
                                 <div class="card-body p-0">
                                     <div class="d-flex gap-2 flex-wrap align-items-center">
                                         <!-- No Staff -->
                                         <div style="background-color: #dc3545; border: 2px solid #dc3545; color: #ffffff; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: none; letter-spacing: 0.5px;">
                                             No Staff
                                         </div>
                                         <!-- Not Confirmed -->
                                         <div style="background-color: #28a745; border: 2px solid #28a745; color: #ffffff; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: none; letter-spacing: 0.5px;">
                                             Not Confirmed
                                         </div>
                                         <!-- Confirmed -->
                                         <div style="background-color: #007bff; border: 2px solid #007bff; color: #ffffff; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: none; letter-spacing: 0.5px;">
                                             Confirmed
                                         </div>
                                         <!-- Meet At Job -->
                                         <div style="background-color: #ffffff; border: 2px solid #fd7e14; color: #000000; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: none; letter-spacing: 0.5px;">
                                             Meet At Job
                                         </div>
                                         <!-- Completed -->
                                         <div style="background-color: #343a40; border: 2px solid #343a40; color: #ffffff; padding: 6px 14px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: none; letter-spacing: 0.5px;">
                                             Completed
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
                events: '{{ route('admin.calendar.orders') }}',
                eventDisplay: 'block',

                eventClick: function (info) {
                    const props = info.event.extendedProps;

                    let badgesHtml = '';
                    if (props.status === 'completed') {
                        badgesHtml = `<span class="badge text-uppercase" style="background-color: #343a40; color: #ffffff; font-size: 10px; font-weight: 600; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px;">Completed</span>`;
                    } else {
                        const isConfirmed = info.event.classNames.includes('is-confirmed');
                        const isMeetJob = info.event.classNames.includes('is-meet-job');
                        const hasNoStaff = info.event.classNames.includes('has-no-staff') || info.event.classNames.includes('no-staff') || props.status === 'no-staff';

                        if (isConfirmed) {
                            badgesHtml += `<span class="badge text-uppercase me-1" style="background-color: #007bff; color: #ffffff; font-size: 10px; font-weight: 600; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px;">Confirmed</span>`;
                            if (hasNoStaff) {
                                badgesHtml += `<span class="badge text-uppercase me-1" style="background-color: #dc3545; color: #ffffff; font-size: 10px; font-weight: 600; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px;">No Staff</span>`;
                            }
                        } else {
                            badgesHtml += `<span class="badge text-uppercase me-1" style="background-color: #28a745; color: #ffffff; font-size: 10px; font-weight: 600; padding: 6px 14px; border-radius: 30px; letter-spacing: 0.5px;">Not Confirmed</span>`;
                        }

                        if (isMeetJob) {
                            badgesHtml += `<span class="badge text-uppercase me-1" style="background-color: #ffffff; color: #000000; border: 2px solid #fd7e14; font-size: 10px; font-weight: 600; padding: 4px 12px; border-radius: 30px; letter-spacing: 0.5px;">Meet At Job</span>`;
                        }
                    }

                    const content = `
                        <table class="table align-middle mb-0" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; border-collapse: separate; border-spacing: 0;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <th style="background-color: #fafafa; padding: 12px 15px; font-size: 13px; font-weight: 600; width: 40%;">Order No</th>
                                    <td style="padding: 12px 15px; font-size: 13px;"><a href="${props.service_dashboard_url}" class="fw-bold text-decoration-none" style="color: #ffb400;">${props.order_no ?? '-'}</a></td>
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
                                        <div class="d-flex flex-wrap gap-1">
                                            ${badgesHtml}
                                        </div>
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

                    let timeStr = '';
                    if (startTime) {
                        const dateObj = new Date(startTime);
                        let hours = dateObj.getHours();
                        const minutes = dateObj.getMinutes();
                        const ampm = hours >= 12 ? 'p' : 'a';
                        hours = hours % 12;
                        hours = hours ? hours : 12;
                        const minutesStr = minutes === 0 ? '' : ':' + (minutes < 10 ? '0' + minutes : minutes);
                        timeStr = hours + minutesStr + ampm;
                    }

                    const textColor = info.event.textColor ?? '#000000';

                    return {
                        html: `
                            <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 12px; font-weight: 700; color: ${textColor} !important; width: 100%;">
                                <span style="margin-right: 4px; font-weight: 700;">${timeStr}</span>${info.event.title}
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
