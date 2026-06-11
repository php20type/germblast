@extends('admin.includes.layout')

@section('title', 'Time Off Requests')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    /* Premium Boxed Table System */
    .equipment-report-table {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border: 1px solid #f3f4f6 !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        background: #fff !important;
        width: 100% !important;
    }

    .equipment-report-table thead th {
        background-color: rgba(255, 184, 28, 0.4) !important;
        color: #374151 !important;
        font-weight: 600 !important;
        padding: 16px 20px !important;
        border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
        font-size: 13px !important;
        text-align: left;
        white-space: nowrap;
    }

    .equipment-report-table tbody td {
        padding: 14px 20px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f3f4f6 !important;
        border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
        font-size: 13px !important;
        text-align: left;
    }

    .equipment-report-table thead th:last-child,
    .equipment-report-table tbody td:last-child {
        border-right: none !important;
    }

    .equipment-report-table tr:last-child td {
        border-bottom: none !important;
    }

    .dataTables_empty {
        text-align: center !important;
        padding: 40px !important;
        color: #6b7280 !important;
        font-size: 14px !important;
    }

    /* Status badges */
    .status-pill {
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 11px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pill-submitted {
        background: #fef3c7;
        color: #d97706;
    }

    .status-pill-approved {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pill-denied {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Metric Cards matching Sales Dashboard */
    .sales-dashboard .metric-card {
        background: white;
        border-radius: 8px;
        padding: 1.25rem !important;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        height: 130px !important;
        position: relative;
        cursor: default !important;
    }

    .sales-dashboard .metric-card h3 {
        font-size: 0.8rem !important;
        font-weight: 700 !important;
        color: #495057 !important;
        margin-bottom: 0.5rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .sales-dashboard .metric-card .metric-value {
        font-size: 2.2rem !important;
        font-weight: 700 !important;
        margin: 0.2rem 0 !important;
        line-height: 1.2 !important;
    }

    .sales-dashboard .metric-card.new-lead {
        background-color: #d4f6d4 !important;
        border-color: #c3e6c3 !important;
    }

    .sales-dashboard .metric-card.open-leads {
        background-color: #e6f3ff !important;
        border-color: #cce7ff !important;
    }

    .sales-dashboard .metric-card.sales {
        background-color: #ffe6e6 !important;
        border-color: #ffcccc !important;
    }

    .sales-dashboard .metric-value.green {
        color: #28a745 !important;
    }

    .sales-dashboard .metric-value.blue {
        color: #007bff !important;
    }

    .sales-dashboard .metric-value.red {
        color: #dc3545 !important;
    }

    .sales-dashboard .metric-change {
        font-size: 0.8rem !important;
        color: #6c757d !important;
    }

    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .btn-warning-brand {
        background: #ffb400;
        color: #fff;
        font-weight: 600;
        border: none;
    }
    .btn-warning-brand:hover {
        background: #e5a200;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div class="sales-dashboard rounded-4 shadow-sm overflow-hidden">

                        {{-- Header --}}
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">TIME OFF REQUESTS</h3>
                                <p class="text-muted mb-0" style="font-size: 15px;">
                                    Request time off, manage approval requests, and track balances.
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#requestTimeOffModal">
                                    + REQUEST TIME OFF
                                </button>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: .1;">

                        {{-- Alert Notifications --}}
                        @if(session('success'))
                            <div class="px-4">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="px-4">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        {{-- Summary Cards --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h2 class="section-title" style="margin-bottom: 0px; padding-bottom: 0px;">TIME OFF METRICS</h2>
                                        <p class="section-subtitle text-muted mb-0" style="font-size: 13px;">Metrics - Year - to - date</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="{{ $isAdminOrManager ? 'col-md-3' : 'col-md-12' }}">
                                        <div class="metric-card open-leads mb-0">
                                            <h3>MY APPROVED DAYS</h3>
                                            <div class="metric-value blue">{{ $myApprovedDays }}</div>
                                            <div class="metric-change text-muted">Days approved this calendar year</div>
                                        </div>
                                    </div>
                                    @if($isAdminOrManager)
                                        <div class="col-md-3">
                                            <div class="metric-card sales mb-0">
                                                <h3>SUBMITTED COMPANY REQUESTS</h3>
                                                <div class="metric-value red">{{ $submittedCount }}</div>
                                                <div class="metric-change text-muted">Awaiting manager review</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="metric-card new-lead mb-0">
                                                <h3>APPROVED COMPANY REQUESTS</h3>
                                                <div class="metric-value green">{{ $approvedCount }}</div>
                                                <div class="metric-change text-muted">Approved company-wide requests</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="metric-card open-leads mb-0">
                                                <h3>TOTAL CO. APPROVED DAYS</h3>
                                                <div class="metric-value blue">{{ $totalApprovedDaysCompany }}</div>
                                                <div class="metric-change text-muted">Total days approved company-wide</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Section 1: My Requests --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="section-title">My Time Off Requests</div>
                                <table id="myRequestsTable" class="table w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Date Range</th>
                                            <th>Duration</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th>Admin Notes</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myRequests as $request)
                                            <tr>
                                                <td>
                                                    <strong>{{ $request->start_date->format('M d, Y') }}</strong>
                                                    to
                                                    <strong>{{ $request->end_date->format('M d, Y') }}</strong>
                                                </td>
                                                <td>
                                                    {{ $request->duration_days }} {{ Str::plural('Day', $request->duration_days) }}
                                                </td>
                                                <td class="text-secondary">{{ $request->reason ?? '—' }}</td>
                                                <td>
                                                    <span class="status-pill status-pill-{{ $request->status }}">
                                                        {{ $request->status }}
                                                    </span>
                                                </td>
                                                <td class="text-secondary">{{ $request->admin_notes ?? '—' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Section 2: Company-wide Requests (Admin Only) --}}
                        @if($isAdminOrManager)
                            <div class="px-4 pb-4">
                                <div class="section-card">
                                    <div class="section-title">Company-Wide Requests (Admin Control)</div>
                                    <table id="companyRequestsTable" class="table w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date Range</th>
                                                <th>Duration</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Processed By</th>
                                                <th class="text-center" style="width: 250px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($companyRequests as $request)
                                                <tr>
                                                     <td>
                                                         <strong>{{ $request->user->name ?? 'Unknown Employee' }}</strong>
                                                     </td>
                                                     <td>
                                                         <strong>{{ $request->start_date->format('M d, Y') }}</strong>
                                                         to
                                                         <strong>{{ $request->end_date->format('M d, Y') }}</strong>
                                                     </td>
                                                     <td>
                                                         {{ $request->duration_days }} {{ Str::plural('Day', $request->duration_days) }}
                                                     </td>
                                                     <td class="text-secondary">{{ $request->reason ?? '—' }}</td>
                                                     <td>
                                                         <span class="status-pill status-pill-{{ $request->status }}">
                                                             {{ $request->status }}
                                                         </span>
                                                     </td>
                                                     <td>
                                                         @if($request->status === 'approved' || $request->status === 'denied')
                                                             <small class="text-secondary">{{ ucfirst($request->status) }} by {{ $request->manager->name ?? 'System' }}</small>
                                                         @else
                                                             <span class="text-muted">—</span>
                                                         @endif
                                                     </td>
                                                     <td class="text-center">
                                                         @if($request->status === 'submitted')
                                                             <div style="max-width: 220px; margin: 0 auto;">
                                                                 <div class="mb-2">
                                                                     <input type="text" class="form-control form-control-sm admin-notes-input w-100" id="notes-input-{{ $request->id }}" placeholder="Add admin note...">
                                                                 </div>
                                                                 <div class="d-flex gap-2">
                                                                     <button type="button" class="btn btn-sm btn-outline-success inline-approve-btn flex-fill" data-id="{{ $request->id }}">
                                                                         Approve
                                                                     </button>
                                                                     <button type="button" class="btn btn-sm btn-outline-danger inline-deny-btn flex-fill" data-id="{{ $request->id }}">
                                                                         Deny
                                                                     </button>
                                                                 </div>
                                                             </div>
                                                         @else
                                                             <div class="text-start" style="font-size: 13px;">
                                                                 <div><strong>Notes:</strong> {{ $request->admin_notes ?? '—' }}</div>
                                                             </div>
                                                         @endif
                                                     </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal 1: Request Time Off --}}
<div class="modal fade" id="requestTimeOffModal" tabindex="-1" aria-labelledby="requestTimeOffLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="requestTimeOffLabel">Request Time Off</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.hr.time-off.store') }}" method="POST" class="company-form" id="request-time-off-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Start Date</label>
                                <span class="text-danger">*</span>
                                <input type="date" class="form-control" id="start_date" name="start_date" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">End Date</label>
                                <span class="text-danger">*</span>
                                <input type="date" class="form-control" id="end_date" name="end_date" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Reason / Notes</label>
                                <textarea class="form-control" id="reason" name="reason" rows="6" placeholder="Enter reason for time off..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    // Initialize DataTables
    $('#myRequestsTable').DataTable({
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
    });

    if ($('#companyRequestsTable').length) {
        $('#companyRequestsTable').DataTable({
            pageLength: 10,
            ordering: false,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"ip>',
            language: {
                search: '',
                searchPlaceholder: 'Search...',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            }
        });
    }

    // Date validation for submit request
    $('#start_date').on('change', function () {
        var startDate = $(this).val();
        $('#end_date').attr('min', startDate);
    });

    // Inline Approve Button Click Action
    $(document).on('click', '.inline-approve-btn', function () {
        var id = $(this).data('id');
        var notes = $('#notes-input-' + id).val();
        
        var form = $('<form>', {
            method: 'POST',
            action: '/admin/hr/time-off/' + id + '/approve'
        });
        form.append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
        form.append($('<input>', { type: 'hidden', name: 'admin_notes', value: notes }));
        $('body').append(form);
        form.submit();
    });

    // Inline Deny Button Click Action
    $(document).on('click', '.inline-deny-btn', function () {
        var id = $(this).data('id');
        var notes = $('#notes-input-' + id).val();
        
        var form = $('<form>', {
            method: 'POST',
            action: '/admin/hr/time-off/' + id + '/deny'
        });
        form.append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
        form.append($('<input>', { type: 'hidden', name: 'admin_notes', value: notes }));
        $('body').append(form);
        form.submit();
    });

});
</script>
@endpush
