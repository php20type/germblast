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

    .status-pill-rejected {
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

    /* Calendar Navigation Button from Vehicle Planning / All Schedules */
    .calendar-nav-btn {
        color: #4b5563 !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 8px 16px !important;
        border-radius: 6px !important;
        transition: all 0.15s ease;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
    }

    .calendar-nav-btn:hover {
        background-color: #f3f4f6 !important;
        color: #1f2937 !important;
    }

    .calendar-nav-btn.btn-today {
        background-color: #ffb400 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(255, 180, 0, 0.15) !important;
    }

    .calendar-nav-btn.btn-today:hover {
        background-color: #e6a200 !important;
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">TIME OFF REQUESTS</h3>
                                <p class="text-muted mb-0">
                                    Request time off, manage approval requests, and track balances.
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#requestTimeOffModal">
                                    + REQUEST TIME OFF
                                </button>
                            </div>
                        </div>

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

                        <!-- Year-wise Toggle Navigation Bar (Matching All Schedules Page Layout) -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 16px;">
                                        Year: {{ $selectedYear }}
                                    </h4>
                                </div>
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    @if($selectedYear > 2026)
                                        <a href="{{ route('admin.hr.time-off.index', ['year' => $selectedYear - 1]) }}"
                                            class="calendar-nav-btn" title="Previous Year">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Year
                                        </a>
                                    @else
                                        <span class="calendar-nav-btn text-muted opacity-50" style="cursor: not-allowed;" title="Previous Year">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Year
                                        </span>
                                    @endif

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.hr.time-off.index', ['year' => $currentYear]) }}"
                                         class="calendar-nav-btn {{ $selectedYear == $currentYear ? 'btn-today' : '' }}">
                                         Current Year
                                     </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    @if($selectedYear < $currentYear)
                                        <a href="{{ route('admin.hr.time-off.index', ['year' => $selectedYear + 1]) }}"
                                            class="calendar-nav-btn" title="Next Year">
                                            Next Year <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    @else
                                        <span class="calendar-nav-btn text-muted opacity-50" style="cursor: not-allowed;" title="Next Year">
                                            Next Year <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Summary Cards --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="section-subtitle text-muted mb-0" style="font-size: 13px;">My Requests Metrics - Year {{ $selectedYear }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="metric-card new-lead mb-0">
                                            <h3>APPROVED LEAVES</h3>
                                            <div class="metric-value green">{{ $approvedCount }}</div>
                                            <div class="metric-change text-muted">Total approved leave requests</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="metric-card open-leads mb-0">
                                            <h3>PENDING LEAVES</h3>
                                            <div class="metric-value blue">{{ $pendingCount }}</div>
                                            <div class="metric-change text-muted">Leave requests awaiting review</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="metric-card sales mb-0">
                                            <h3>REJECTED LEAVES</h3>
                                            <div class="metric-value red">{{ $rejectedCount }}</div>
                                            <div class="metric-change text-muted">Rejected or cancelled requests</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 1: My Requests --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="section-title">My Requests</div>
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

                        {{-- Section 2: Company-wide Requests --}}
                        @can('time_off_request.edit')
                            <div class="px-4 pb-4">
                                <div class="section-card">
                                    <div class="section-title">All Requests</div>
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
                                                         @if($request->status === 'approved' || $request->status === 'rejected')
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
                                                                     <button type="button" class="btn btn-sm btn-outline-danger inline-reject-btn flex-fill" data-id="{{ $request->id }}">
                                                                         Reject
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
                        @endcan

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
                                <span class="text-danger">*</span>
                                <textarea class="form-control" id="reason" name="reason" rows="6" placeholder="Enter reason for time off..." required></textarea>
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

    /* ===============================
       Validation & AJAX Submission
    =============================== */
    $('#request-time-off-form').validate({
        rules: {
            start_date: "required",
            end_date: "required",
            reason: "required"
        },
        messages: {
            start_date: "Please select a start date.",
            end_date: "Please select an end date.",
            reason: "Please provide a reason for your time off."
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback d-block',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });

    $('#request-time-off-form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);

        if (!form.valid()) {
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(response) {
                toastr.success(response.message || 'Time off request submitted successfully.');
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        messages.forEach(function(message) {
                            toastr.error(message);
                        });
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while submitting the request.'
                );
            }
        });
    });

    // Inline Approve Button Click Action
    $(document).on('click', '.inline-approve-btn', function () {
        var id = $(this).data('id');
        var notes = $('#notes-input-' + id).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to approve this time off request.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/hr/time-off/' + id + '/approve',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin_notes: notes
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Time off request approved successfully.');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to approve request.');
                    }
                });
            }
        });
    });

    // Inline Reject Button Click Action
    $(document).on('click', '.inline-reject-btn', function () {
        var id = $(this).data('id');
        var notes = $('#notes-input-' + id).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to reject this time off request.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/hr/time-off/' + id + '/reject',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin_notes: notes
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Time off request rejected successfully.');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to reject request.');
                    }
                });
            }
        });
    });

});
</script>
@endpush
