@extends('admin.includes.layout')
@section('title', 'Calendar')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
@endpush

@section('content')

    <div class="companies-section my-4">
        <div class="container-fluid">

            <div class="sales-dashboard">
                <div class="section-card mt-3">
                    <div id="calendar"></div>
                </div>

                {{-- Badge Clarification --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-card">
                            <div class="section-header mb-3">
                                <h6 class="section-title">Status Legend</h6>
                            </div>
                            <div class="d-flex gap-3 flex-wrap align-items-center">
                                <span style="background-color:#6c757d; color:#fff; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                    ● Pending
                                </span>
                                <span style="background-color:#0d6efd; color:#fff; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                    ● Scheduled
                                </span>
                                <span style="background-color:#198754; color:#fff; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                    ● Completed
                                </span>
                                <span style="background-color:#dc3545; color:#fff; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                    ● Cancelled
                                </span>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="orderModalLabel">
                        <i class="fa-regular fa-calendar-check me-2"></i>
                        Order Details
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderModalBody">
                    <!-- Loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
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

                eventClick: function (info) {
                    const props = info.event.extendedProps;

                    const statusColors = {
                        'pending':     'secondary',
                        'scheduled':   'warning',
                        'confirmed':   'primary',
                        'in_progress': 'warning',
                        'completed':   'success',
                        'cancelled':   'danger',
                    };
                    const badgeColor = statusColors[props.status] ?? 'secondary';

                    const content = `
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th>Order No</th>
                                    <td><a href="${props.fulfill_url}">${props.order_no ?? '-'}</a></td>
                                </tr>
                                <tr>
                                    <th>Service</th>
                                    <td>${props.service_name}</td>
                                </tr>
                                <tr>
                                    <th>Lead</th>
                                    <td>${props.lead_name}</td>
                                </tr>
                                <tr>
                                    <th>Company</th>
                                    <td>${props.company_name}</td>
                                </tr>
                                <tr>
                                    <th>PO Number</th>
                                    <td>${props.po_number}</td>
                                </tr>
                                <tr>
                                    <th>Price / Service</th>
                                    <td>$${props.price}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-${badgeColor}">
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
