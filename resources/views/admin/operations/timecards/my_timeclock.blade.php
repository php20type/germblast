@extends('admin.includes.layout')

@section('title', 'My Time Clock')

@push('styles')
    <style>
        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-bottom: 1px solid #e5e7eb !important;
            border-right: 1px solid #e5e7eb !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table tbody td,
        .equipment-report-table tfoot td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #e5e7eb !important;
            border-right: 1px solid #e5e7eb !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Column specific alignment matching original logic */
        .equipment-report-table thead th:nth-child(1),
        .equipment-report-table tbody td:nth-child(1):not(.dataTables_empty) {
            text-align: left !important;
        }

        .dataTables_empty {
            text-align: center !important;
            padding: 50px !important;
            color: #6b7280 !important;
            font-size: 15px !important;
        }
        /* Calendar Navigation Button */
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
            @include('admin.operations.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">MY TIME SHEETS</h3>
                                <p class="text-muted mb-0">This page displays your time sheets</p>
                            </div>
                            <div class="right-part-sec d-flex align-items-center gap-2">
                                <a href="{{ route('admin.timecards.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> BACK
                                </a>
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#addPunchModal">
                                    + ADD PUNCH
                                </button>
                            </div>
                        </div>

                            <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div>
                                        <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                            Week of: {{ $start->format('M d, Y') }}
                                        </h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border" style="border-color: #e5e7eb !important;">
                                        <a href="{{ route('admin.my-timeclock', ['date' => $start->copy()->subWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Previous Week">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.my-timeclock', ['date' => now()->toDateString()]) }}" class="calendar-nav-btn {{ $start->toDateString() === now()->startOfWeek()->toDateString() ? 'btn-today' : '' }}">
                                            Current Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.my-timeclock', ['date' => $start->copy()->addWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Next Week">
                                            Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <!-- Detailed Timecard Punches Table -->
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Customer</th>
                                                <th>Date</th>
                                                <th>In</th>
                                                <th>Out</th>
                                                <th>Type</th>
                                                <th class="text-primary">Total Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employee->timecards as $timecard)
                                            @php
                                                $hrs = $timecard->calculated_hours ?? 0;
                                                $formattedHrs = $hrs > 0 ? number_format($hrs, 2) : '-';
                                            @endphp
                                            <tr>
                                                <td class="text-start">{{ $timecard->company->name ?? 'No Job Associated' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($timecard->work_date)->format('D m-d') }}</td>
                                                <td>{{ $timecard->clock_in ? \Carbon\Carbon::parse($timecard->clock_in)->format('h:iA') : '-' }}</td>
                                                <td>{{ $timecard->clock_out ? \Carbon\Carbon::parse($timecard->clock_out)->format('h:iA') : '-' }}</td>
                                                <td>{{ $timecard->clock_type_label }}</td>
                                                <td class="text-primary fw-semibold">{{ $formattedHrs }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light fw-bold">
                                                <td class="text-start" colspan="5">Grand Totals</td>
                                                <td class="text-primary">{{ isset($employee->totals['total']) && $employee->totals['total'] > 0 ? number_format($employee->totals['total'], 2) : '-' }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Punch Modal Start -->
<div class="modal fade" id="addPunchModal" tabindex="-1" aria-labelledby="addPunchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addPunchModalLabel">Add Punch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.timecards.store') }}" method="POST" class="punch-form" id="add-punch-form">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Customer</label>
                                <span class="text-danger">*</span>
                                <select name="customer" class="form-select">
                                    <option value="">-- Please Select --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Work Date</label>
                                <span class="text-danger">*</span>
                                <input type="date" name="work_date" class="form-control" value="{{ $start->toDateString() }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Clock In</label>
                                <span class="text-danger">*</span>
                                <input type="time" name="clock_in" class="form-control" value="08:00">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Clock Out</label>
                                <span class="text-danger">*</span>
                                <input type="time" name="clock_out" class="form-control" value="17:00">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Clock Type</label>
                                <span class="text-danger">*</span>
                                <select name="clock_type" class="form-select">
                                    @foreach($clock_types as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
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
<!-- Add Punch Modal End -->

    @endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#ffb400'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ffb400'
                });
            @endif
        });
    </script>
@endpush
