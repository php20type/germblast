@extends('admin.includes.layout')

@section('title', 'Audit Calendar')

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
                <!-- Sidebar -->
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">
                                    Audit Calendar
                                </h3>
<p class="text-danger fw-bold mb-0" style="font-size: 13px;">(This is a static page, it's a work in progress)</p>
                                <p class="text-muted mb-0">
                                    This calendar shows the audit team's schedule
                                </p>
                            </div>
                        </div>

                        <!-- Controls and Calendar in PX-4 wrapper matching Warehouse Maintenance layout -->
                        <div class="px-4 py-2">
                            <div class="calendar-card">
                                <div id="calendar" class="w-100"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day'
                },
                height: 700,
                events: [
                    {
                        title: 'Team Alpha - Safety Audit',
                        start: '2026-08-04',
                        color: '#0d6efd'
                    },
                    {
                        title: 'Equipment Verification',
                        start: '2026-08-11',
                        end: '2026-08-13',
                        color: '#ffb81c'
                    },
                    {
                        title: 'Quarterly Compliance',
                        start: '2026-08-18',
                        color: '#069697'
                    },
                    {
                        title: 'Facility Inspection',
                        start: '2026-08-25',
                        color: '#0d6efd'
                    }
                ],
                eventDisplay: 'block',
                eventContent: function (info) {
                    return {
                        html: `
                            <div style="padding: 4px 6px; width: 100%; border-radius: 4px; overflow: hidden;">
                                <div style="font-weight: 600; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    ${info.event.title}
                                </div>
                                <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">09:00 AM</div>
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

