@extends('admin.includes.layout')

@section('title', 'Time Sheet Details')

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
                                    <h3 class="mb-1 text-uppercase">{{ $employee->name }}'S TIME SHEETS</h3>
                                    <p class="text-muted mb-0">This page displays time sheets for {{ $employee->name }}</p>
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
                                        <a href="{{ route('admin.timecards.details', ['id' => $employee->id, 'date' => $start->copy()->subWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Previous Week">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.timecards.details', ['id' => $employee->id, 'date' => now()->toDateString()]) }}" class="calendar-nav-btn {{ $start->toDateString() === now()->startOfWeek()->toDateString() ? 'btn-today' : '' }}">
                                            Current Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.timecards.details', ['id' => $employee->id, 'date' => $start->copy()->addWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Next Week">
                                            Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Reg</th>
                                                <th>Drive</th>
                                                <th>Ride</th>
                                                <th>OT</th>
                                                <th>Train</th>
                                                <th>Floor</th>
                                                <th>Covid</th>
                                                <th>mRGB</th>
                                                <th>WH</th>
                                                <th class="text-primary">Total</th>
                                                <th>Break</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $employee->name }}
                                                </td>
                                                <td>{{ isset($employee->totals['reg']) && $employee->totals['reg'] > 0 ? number_format($employee->totals['reg'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['drive']) && $employee->totals['drive'] > 0 ? number_format($employee->totals['drive'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['ride']) && $employee->totals['ride'] > 0 ? number_format($employee->totals['ride'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['ot']) && $employee->totals['ot'] > 0 ? number_format($employee->totals['ot'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['train']) && $employee->totals['train'] > 0 ? number_format($employee->totals['train'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['floor']) && $employee->totals['floor'] > 0 ? number_format($employee->totals['floor'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['covid']) && $employee->totals['covid'] > 0 ? number_format($employee->totals['covid'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['mrgb']) && $employee->totals['mrgb'] > 0 ? number_format($employee->totals['mrgb'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['wh']) && $employee->totals['wh'] > 0 ? number_format($employee->totals['wh'], 2) : '-' }}</td>
                                                <td class="text-primary fw-bold">{{ isset($employee->totals['total']) && $employee->totals['total'] > 0 ? number_format($employee->totals['total'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['break']) && $employee->totals['break'] > 0 ? number_format($employee->totals['break'], 2) : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

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
                                                <th>Reg</th>
                                                <th>Drive</th>
                                                <th>Ride</th>
                                                <th>OT</th>
                                                <th>Floor</th>
                                                <th>Covid</th>
                                                <th>mRGB</th>
                                                <th>WH</th>
                                                <th>Train</th>
                                                <th class="text-primary">Total</th>
                                                <th>Break</th>
                                                <th>Action</th>
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
                                                <td>{{ in_array($timecard->clock_type, [2, 4]) ? $formattedHrs : '-' }}</td>
                                                <td>-</td>
                                                <td>{{ $timecard->clock_type == 1 ? $formattedHrs : '-' }}</td>
                                                <td>-</td>
                                                <td>{{ $timecard->clock_type == 7 ? $formattedHrs : '-' }}</td>
                                                <td>{{ $timecard->clock_type == 8 ? $formattedHrs : '-' }}</td>
                                                <td>-</td>
                                                <td>{{ $timecard->clock_type == 5 ? $formattedHrs : '-' }}</td>
                                                <td>{{ $timecard->clock_type == 6 ? $formattedHrs : '-' }}</td>
                                                <td class="text-primary fw-semibold">{{ $formattedHrs }}</td>
                                                <td>{{ $timecard->clock_type == 3 ? $formattedHrs : '-' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPunchModal{{ $timecard->id }}">Edit</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light fw-bold">
                                                <td class="text-start" colspan="5">Grand Totals</td>
                                                <td>{{ isset($employee->totals['reg']) && $employee->totals['reg'] > 0 ? number_format($employee->totals['reg'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['drive']) && $employee->totals['drive'] > 0 ? number_format($employee->totals['drive'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['ride']) && $employee->totals['ride'] > 0 ? number_format($employee->totals['ride'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['ot']) && $employee->totals['ot'] > 0 ? number_format($employee->totals['ot'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['floor']) && $employee->totals['floor'] > 0 ? number_format($employee->totals['floor'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['covid']) && $employee->totals['covid'] > 0 ? number_format($employee->totals['covid'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['mrgb']) && $employee->totals['mrgb'] > 0 ? number_format($employee->totals['mrgb'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['wh']) && $employee->totals['wh'] > 0 ? number_format($employee->totals['wh'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['train']) && $employee->totals['train'] > 0 ? number_format($employee->totals['train'], 2) : '-' }}</td>
                                                <td class="text-primary">{{ isset($employee->totals['total']) && $employee->totals['total'] > 0 ? number_format($employee->totals['total'], 2) : '-' }}</td>
                                                <td>{{ isset($employee->totals['break']) && $employee->totals['break'] > 0 ? number_format($employee->totals['break'], 2) : '-' }}</td>
                                                <td>-</td>
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

@foreach($employee->timecards as $timecard)
<!-- Edit Punch Modal Start -->
<div class="modal fade" id="editPunchModal{{ $timecard->id }}" tabindex="-1" aria-labelledby="editPunchModalLabel{{ $timecard->id }}" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editPunchModalLabel{{ $timecard->id }}">Edit Punch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.timecards.update', $timecard->id) }}" method="POST" class="punch-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Customer</label>
                                <span class="text-danger">*</span>
                                <select name="customer" class="form-select">
                                    <option value="">-- Please Select --</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $timecard->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Work Date</label>
                                <span class="text-danger">*</span>
                                <input type="date" name="work_date" class="form-control" value="{{ \Carbon\Carbon::parse($timecard->work_date)->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Clock In</label>
                                <span class="text-danger">*</span>
                                <input type="time" name="clock_in" class="form-control" value="{{ $timecard->clock_in ? \Carbon\Carbon::parse($timecard->clock_in)->format('H:i') : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Clock Out</label>
                                <span class="text-danger">*</span>
                                <input type="time" name="clock_out" class="form-control" value="{{ $timecard->clock_out ? \Carbon\Carbon::parse($timecard->clock_out)->format('H:i') : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Clock Type</label>
                                <span class="text-danger">*</span>
                                <select name="clock_type" class="form-select">
                                    @foreach($clock_types as $key => $label)
                                        <option value="{{ $key }}" {{ $timecard->clock_type == $key ? 'selected' : '' }}>{{ $label }}</option>
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
<!-- Edit Punch Modal End -->
@endforeach

@endsection
