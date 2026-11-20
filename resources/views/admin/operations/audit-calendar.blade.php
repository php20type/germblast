@extends('admin.includes.layout')

@section('title', 'Audit Calendar')

@push('styles')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('css/operations.css') }}?v={{ filemtime(public_path('css/operations.css')) }}">
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
                                <p class="text-muted mb-0">
                                    This calendar shows the audit team's schedule
                                </p>
                            </div>
                        </div>

                        <!-- Controls and Calendar in PX-4 wrapper matching Warehouse Maintenance layout -->
                        <div class="px-4 py-2">
                            <!-- Status Legend Card -->
                            <div class="calendar-card mb-4 pb-4">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark"
                                        style="font-size: 18px; letter-spacing: 0.5px; text-transform: uppercase;">
                                        Status Legend
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="d-flex gap-3 flex-wrap align-items-center">
                                        <span style="background-color:#069697; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(6,150,151,0.15);">
                                            ● Open
                                        </span>
                                        <span style="background-color:#e63946; color:#fff; padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border: none; box-shadow: 0 2px 4px rgba(230,57,70,0.15);">
                                            ● Finalized
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
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
                events: '{{ route('admin.operations.audit-calendar.orders') }}',
                eventDisplay: 'block',
                
                eventClick: function (info) {
                    const props = info.event.extendedProps;
                    window.location.href = '/admin/operations/audits/' + info.event.id;
                },

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
                                ${timeStr ? `<div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">${timeStr}</div>` : ''}
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

