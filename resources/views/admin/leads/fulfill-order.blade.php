@extends('admin.includes.layout')

@section('title', 'Fulfill Order')

@php
    $canEdit = auth()->user()->can('service.fulfill_order.edit');
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        .navbar-tabs {
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 5px;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            transition: scrollbar-color 0.3s ease;
        }

        .navbar-tabs:hover {
            scrollbar-color: #cbd5e1 transparent;
        }

        .navbar-tabs::-webkit-scrollbar {
            height: 5px;
        }

        .navbar-tabs::-webkit-scrollbar-thumb {
            background-color: transparent;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .navbar-tabs:hover::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
        }

        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            white-space: nowrap !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
            /* Soft yellow background from image */
            border-radius: 10px 10px 0 0;
        }

        .navbar-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #ffb400;
            /* Yellow indicator */
        }

        .navbar-tabs .badge {
            background-color: #6b7280 !important;
            font-weight: 500;
            padding: 4px 8px;
            font-size: 11px;
            vertical-align: middle;
        }

        /* Equipment Report Table Boxed Styling */
        .equipment-report-table {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            border-bottom: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px !important;
        }

        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }
        
        /* Custom Premium Status Badges & Selectors */
        .status-pill {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-pending {
            background-color: rgba(134, 134, 134, 0.12) !important;
            color: #636363 !important;
            border-color: rgba(134, 134, 134, 0.2) !important;
        }

        .status-pill-scheduled {
            background-color: rgba(255, 184, 28, 0.12) !important;
            color: #d39100 !important;
            border-color: rgba(255, 184, 28, 0.25) !important;
        }

        .status-pill-confirmed,
        .status-pill-open {
            background-color: rgba(13, 110, 253, 0.12) !important;
            color: #0d6efd !important;
            border-color: rgba(13, 110, 253, 0.2) !important;
        }

        .status-pill-in_progress {
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #926d00 !important;
            border-color: rgba(255, 193, 7, 0.3) !important;
        }

        .status-pill-completed {
            background-color: rgba(6, 150, 151, 0.12) !important;
            color: #069697 !important;
            border-color: rgba(6, 150, 151, 0.25) !important;
        }

        .status-pill-cancelled {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
        }

        .status-select {
            font-size: 13px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            padding: 4px 10px !important;
            cursor: pointer !important;
            border: 1px solid #ced4da !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
            outline: none !important;
        }
        .status-select:focus {
            border-color: #FFB81C !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 184, 28, 0.25) !important;
        }
    </style>
@endpush

@section('content')


    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">FULFILL ORDER <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">Order ID: {{ $order->order_no ?? '' }}</p>
                                
                                <div class="d-flex align-items-center gap-3 flex-wrap mt-2 mb-3">
                                    {{--
                                    <form action="{{ route('admin.lead.service.order.update_status', $order->id) }}" method="POST" class="d-flex align-items-center gap-2 mb-0">
                                        @csrf
                                        <label class="text-muted mb-0 fw-semibold" style="font-size: 14px;">Order Status:</label>
                                        <select name="status" class="status-select" onchange="this.form.submit()" style="width: auto; min-width: 140px;">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="scheduled" {{ $order->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                    --}}
                                    @php
                                        $displayOrderStatus = strtolower($order->status ?? 'open');
                                    @endphp
                                    <span class="status-pill status-pill-{{ $displayOrderStatus }}">
                                        {{ ucfirst(str_replace('_', ' ', $displayOrderStatus)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="right-part-sec">
                                <div class="d-flex gap-2">
                                    <a class="btn btn-outline-dark"
                                        href="javascript:history.back()">
                                        <i class="fas fa-arrow-left me-1"></i> Back
                                    </a>
                                    <a class="btn btn-export"
                                        href="{{ route('admin.lead.service.service_dashboard', $order->id) }}">
                                        SERVICE VIEW 
                                    </a>

                                    <a class="btn btn-export"
                                        href="{{ route('admin.company.show', $order->service->lead->company->id) }}">
                                        TO CUSTOMER
                                    </a>
                                </div>
                            </div>
                        </div>

                        


                        <!-- TABS -->
                        <div class="navbar-tabs px-4">
                            <nav class="nav nav-tabs mb-0 flex-nowrap" id="fulfillOrderTabs" role="tablist">
                                <button class="nav-link active" id="scheduling-tab" data-bs-toggle="tab"
                                    data-bs-target="#scheduling" type="button" role="tab" aria-controls="scheduling"
                                    aria-selected="true">
                                    Scheduling
                                </button>
                                <button class="nav-link" id="confirmations-tab" data-bs-toggle="tab"
                                    data-bs-target="#confirmations" type="button" role="tab"
                                    aria-controls="confirmations" aria-selected="false">
                                    Confirmations
                                </button>
                                <!-- <button class="nav-link" id="pre-checklist-tab" data-bs-toggle="tab"
                                    data-bs-target="#pre-checklist" type="button" role="tab"
                                    aria-controls="pre-checklist" aria-selected="false">
                                    Pre-Checklist
                                </button> -->
                                <button class="nav-link" id="facilities-tab" data-bs-toggle="tab"
                                    data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities"
                                    aria-selected="false">
                                    Facilities
                                </button>
                                <button class="nav-link" id="staffing-tab" data-bs-toggle="tab" data-bs-target="#staffing"
                                    type="button" role="tab" aria-controls="staffing" aria-selected="false">
                                    Staffing
                                </button>
                                <button class="nav-link" id="vehicle-planning-tab" data-bs-toggle="tab"
                                    data-bs-target="#vehicle-planning" type="button" role="tab"
                                    aria-controls="vehicle-planning" aria-selected="false">
                                    Vehicle Planning
                                </button>
                                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes"
                                    type="button" role="tab" aria-controls="notes" aria-selected="false">
                                    Notes
                                </button>
                                <button class="nav-link" id="invoicing-tab" data-bs-toggle="tab" data-bs-target="#invoicing"
                                    type="button" role="tab" aria-controls="invoicing" aria-selected="false">
                                    Invoicing
                                </button>
                                <button class="nav-link" id="schedule-view-tab" data-bs-toggle="tab"
                                    data-bs-target="#schedule-view" type="button" role="tab"
                                    aria-controls="schedule-view" aria-selected="false">
                                    Job Clocks
                                </button>
                                {{-- <button class="nav-link" id="job-clocks-tab" data-bs-toggle="tab"
                                    data-bs-target="#job-clocks" type="button" role="tab" aria-controls="job-clocks"
                                    aria-selected="false">
                                    Job Clocks
                                </button> --}}
                                <!-- <button class="nav-link" id="employee-performance-tab" data-bs-toggle="tab"
                                    data-bs-target="#employee-performance" type="button" role="tab"
                                    aria-controls="employee-performance" aria-selected="false">
                                    Employee Performance
                                </button>
                                <button class="nav-link" id="post-checklist-tab" data-bs-toggle="tab"
                                    data-bs-target="#post-checklist" type="button" role="tab"
                                    aria-controls="post-checklist" aria-selected="false">
                                    Post Checklist
                                </button> -->
                                {{-- <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports"
                                    type="button" role="tab" aria-controls="reports" aria-selected="false">
                                    Reports
                                </button> --}}
                            </nav>
                        </div>

                        <hr class="mb-4 mt-0" style="opacity: 0.1;">


                        <!-- Tab Content Section -->
                        <div class="tab-content px-4 pb-4" id="fulfillOrderTabContent">


                            <!-- Scheduling Tab -->
                            <div class="tab-pane fade show active" id="scheduling" role="tabpanel"
                                aria-labelledby="scheduling-tab">

                                <!-- Scheduling Slots -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Schedule Service for the Following Time</h5>
                                            </div>

                                            <form action="{{ route('admin.lead.service.fulfill_order.book',$order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_order_id" value="{{ $order->id }}">

                                                <table class="table table-hover equipment-report-table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Start Time</th>
                                                            <td><input type="datetime-local" class="form-control" name="scheduled_start_time" {{ !$canEdit ? 'disabled' : '' }}></td>
                                                        </tr>
                                                        <tr>
                                                            <th>End Time</th>
                                                            <td><input type="datetime-local" class="form-control" name="scheduled_end_time" {{ !$canEdit ? 'disabled' : '' }}></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Arrival Time</th>
                                                            <td><input type="time" class="form-control" name="scheduled_arrival_time" {{ !$canEdit ? 'disabled' : '' }}></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Office</th>
                                                            <td>
                                                                <select class="form-select" name="scheduled_office" {{ !$canEdit ? 'disabled' : '' }}>
                                                                    @foreach($territories as $territory)
                                                                        <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Recurrence</th>
                                                            <td>
                                                                <select class="form-select" name="scheduled_recurrence_rule" {{ !$canEdit ? 'disabled' : '' }}>
                                                                    <option value="N/A">N/A</option>
                                                                    <option>Daily</option>
                                                                    <option>Weekly</option>
                                                                    <option>Monthly</option>
                                                                    <option>Quarterly</option>
                                                                    <option>Annually</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Meet</th>
                                                            <td>
                                                                <select class="form-select" name="meet" {{ !$canEdit ? 'disabled' : '' }}>
                                                                    <option value="office">Meet @ Office</option>
                                                                    <option value="facility">Meet @ Facility</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Overnight</th>
                                                            <td>
                                                                <select class="form-select" name="overnight" {{ !$canEdit ? 'disabled' : '' }}>
                                                                    <option value="0">Not Overnight</option>
                                                                    <option value="1">Overnight</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-end">
                                                                @if($canEdit)
                                                                    <button type="submit" class="btn btn-success">Book It</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <!-- Booked Slots -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Scheduled Slots</h5>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover equipment-report-table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Start Time</th>
                                                            <th>End Time</th>
                                                            <th>Arrival Time</th>
                                                            <th>Office</th>
                                                            <th>Hours</th>
                                                            <th>Meet</th>
                                                            <th>Overnight</th>
                                                            <th>Recurrence</th>
                                                            <!-- <th>Clock In</th>
                                                            <th>Clock Out</th> -->
                                                            {{-- <th>Status</th> --}}
                                                            {{-- <th>Action</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($order->orderSlots as $slot)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $slot->scheduled_start_time }}</td>
                                                                <td>{{ $slot->scheduled_end_time }}</td>
                                                                <td>{{ $slot->scheduled_arrival_time }}</td>
                                                                {{-- <td>{{ $slot->scheduled_office }}</td> --}}
                                                                <td>{{ $slot->office->name ?? 'N/A' }}</td>
                                                                <td>{{ $slot->scheduled_hours }}</td>
                                                                <td>{{ ucfirst($slot->meet) }}</td>
                                                                <td>{{ $slot->overnight ? 'Yes' : 'No' }}</td>
                                                                <td>{{ $slot->scheduled_recurrence_rule }}</td>
                                                                <!-- <td>{{ $slot->clocked_in_at ?? '-' }}</td>
                                                                <td>{{ $slot->clocked_out_at ?? '-' }}</td> -->
                                                                {{--
                                                                <td>
                                                                    <span class="status-pill status-pill-{{ $slot->status ?? 'scheduled' }}">
                                                                        {{ ucfirst(str_replace('_', ' ', $slot->status ?? 'scheduled')) }}
                                                                    </span>
                                                                </td>
                                                                --}}
                                                                {{--
                                                                <td>
                                                                    <form action="{{ route('admin.lead.service.slot.update_status', $slot->id) }}" method="POST" class="d-flex align-items-center gap-1 mb-0">
                                                                        @csrf
                                                                        <select name="status" class="status-select" onchange="this.form.submit()" style="width: auto; min-width: 120px;">
                                                                            <option value="pending" {{ $slot->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="scheduled" {{ $slot->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                                            <option value="confirmed" {{ $slot->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                                            <option value="completed" {{ $slot->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                                            <option value="cancelled" {{ $slot->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                        </select>
                                                                    </form>
                                                                </td>
                                                                --}}
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="11" class="text-center text-muted">No slots booked yet.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Summary Footer --}}
                                            @php
                                                $totalOrderHours = 0;
                                                foreach($order->orderSlots as $s) {
                                                    $sStaffCount = $s->staff->count();
                                                    $sScheduledHrs = $s->scheduled_hours ?? 0;
                                                    $totalOrderHours += ($sScheduledHrs * $sStaffCount);
                                                }
                                                
                                                $orderInvoiceAmount = $order->service->price_per_service ?? 0;
                                                $orderTotalCost     = 28.78 * $totalOrderHours;
                                                $orderPeoplePct     = $orderInvoiceAmount > 0 ? round(($orderTotalCost * 100) / $orderInvoiceAmount) : 0;
                                            @endphp
                                            <div class="mt-4 pt-3 border-top d-flex gap-4">
                                                <small class="text-muted">People Percentage: <strong>{{ $orderPeoplePct }}%</strong></small>
                                                <small class="text-muted">Invoice: <strong>${{ number_format($orderInvoiceAmount, 2) }}</strong></small>
                                                <small class="text-muted">Hours: <strong>{{ number_format($totalOrderHours, 2) }}</strong></small>
                                                <small class="text-muted">Cost: <strong>${{ number_format($orderTotalCost, 2) }}</strong></small>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Confirmations Tab -->
                            <div class="tab-pane fade" id="confirmations" role="tabpanel"
                                aria-labelledby="confirmations-tab">

                                @forelse($order->orderSlots as $slot)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">

                                                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h5 class="section-title mb-0">Slot #{{ $loop->iteration }}</h5>
                                                        <span class="status-pill status-pill-{{ $slot->status ?? 'scheduled' }}" style="font-size: 11px !important; padding: 4px 10px !important;">
                                                            {{ ucfirst(str_replace('_', ' ', $slot->status ?? 'scheduled')) }}
                                                        </span>
                                                    </div>
                                                    @if($slot->status === 'confirmed' || $slot->is_confirmed)
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            <i class="fas fa-check-circle me-1"></i> Confirmed
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary fs-6 px-3 py-2">Not Confirmed</span>
                                                    @endif
                                                </div>

                                                {{-- Slot Details --}}
                                                <table class="table table-hover equipment-report-table mb-3">
                                                    <tbody>
                                                        <tr>
                                                            <th>Start Time</th>
                                                            <td>{{ $slot->scheduled_start_time }}</td>
                                                            <th>End Time</th>
                                                            <td>{{ $slot->scheduled_end_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Arrival Time</th>
                                                            <td>{{ $slot->scheduled_arrival_time }}</td>
                                                            <th>Office</th>
                                                            {{-- <td>{{ $slot->scheduled_office }}</td> --}}
                                                            <td>{{ $slot->office->name ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hours</th>
                                                            <td>{{ $slot->scheduled_hours }}</td>
                                                            <th>Meet</th>
                                                            <td>{{ ucfirst($slot->meet) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Overnight</th>
                                                            <td>{{ $slot->overnight ? 'Yes' : 'No' }}</td>
                                                            <th>Recurrence</th>
                                                            <td>{{ $slot->scheduled_recurrence_rule }}</td>
                                                        </tr>
                                                        @if($slot->is_confirmed)
                                                            <tr>
                                                                <th>Confirmed At</th>
                                                                <td>{{ $slot->confirmed_at }}</td>
                                                                <th>Confirmed By</th>
                                                                <td>{{ $slot->confirmedBy->name ?? '-' }}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>

                                                {{-- Action Buttons --}}
                                                <div class="d-flex gap-2 justify-content-end">

                                                    {{-- Confirm Button --}}
                                                    @if($slot->status !== 'confirmed' && !$slot->is_confirmed)
                                                        @if($canEdit)
                                                            <form action="{{ route('admin.lead.service.slot.confirm', $slot->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-check me-1"></i> Confirm Slot
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    @if($canEdit)
                                                        <button type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#editSlot{{ $slot->id }}">
                                                            <i class="fas fa-edit me-1"></i> Edit Slot
                                                        </button>
                                                    @endif

                                                </div>

                                                {{-- Edit Form (collapsible) --}}
                                                <div class="collapse mt-3" id="editSlot{{ $slot->id }}">
                                                    <form action="{{ route('admin.lead.service.slot.update', $slot->id) }}" method="POST">
                                                        @csrf
                                                        <table class="table table-hover equipment-report-table">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Start Time</th>
                                                                    <td><input type="datetime-local" class="form-control" name="scheduled_start_time" value="{{ $slot->scheduled_start_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>End Time</th>
                                                                    <td><input type="datetime-local" class="form-control" name="scheduled_end_time" value="{{ $slot->scheduled_end_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Arrival Time</th>
                                                                    <td><input type="time" class="form-control" name="scheduled_arrival_time" value="{{ $slot->scheduled_arrival_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Office</th>
                                                                    <td>
                                                                        <select class="form-select" name="scheduled_office">
                                                                            <option value="">Select Office</option>
                                                                            @foreach($territories as $territory)
                                                                                <option value="{{ $territory->id }}"
                                                                                    {{ $slot->scheduled_office == $territory->id ? 'selected' : '' }}>
                                                                                    {{ $territory->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Recurrence</th>
                                                                    <td>
                                                                        <select class="form-select" name="scheduled_recurrence_rule">
                                                                            @foreach(['N/A', 'Daily', 'Weekly', 'Monthly', 'Quarterly', 'Annually'] as $rule)
                                                                                <option {{ $slot->scheduled_recurrence_rule == $rule ? 'selected' : '' }}>{{ $rule }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Meet</th>
                                                                    <td>
                                                                        <select class="form-select" name="meet">
                                                                            <option value="office" {{ $slot->meet == 'office' ? 'selected' : '' }}>Meet @ Office</option>
                                                                            <option value="facility" {{ $slot->meet == 'facility' ? 'selected' : '' }}>Meet @ Facility</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Overnight</th>
                                                                    <td>
                                                                        <select class="form-select" name="overnight">
                                                                            <option value="0" {{ !$slot->overnight ? 'selected' : '' }}>Not Overnight</option>
                                                                            <option value="1" {{ $slot->overnight ? 'selected' : '' }}>Overnight</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-end">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-save me-1"></i> Update Slot
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No slots found for this order.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>

                            <!-- Pre-Checklist Tab -->
                            <div class="tab-pane fade" id="pre-checklist" role="tabpanel"
                                aria-labelledby="pre-checklist-tab">

                                <!-- Supervisor Items Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Supervisor Items to Check</h5>
                                            </div>
                                            <ul style="line-height: 1.8;">
                                                <li>ATF Meter</li>
                                                <li>10 Swabs</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Consumables Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="section-title">Consumables (Pre-Service Initial Counts)</h5>
                                            </div>
                                            <form class="pre-checklist-consumables-form" id="preChecklistConsumablesForm">
                                                @csrf
                                                <div class="table-responsive">
                                                    <table class="table table-hover equipment-report-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Pre-Service Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ([
                                                                'microfiber_bins' => 'Microfiber Bins',
                                                                'disposable_microfiber' => 'Disposable Microfiber (Count Packs, Not Cloths)',
                                                                'atp_swabs' => 'ATP Swabs',
                                                                'gallons_water' => 'Gallons of Water',
                                                                'gallons_d2' => 'Gallons of D2',
                                                                'bottles_oxivir' => 'Bottles of Oxivir Concentrate',
                                                                'bottles_shield' => 'Bottles of Shield Concentrate',
                                                                'gallons_opticide' => 'Gallons of Opticide',
                                                                'gallons_halomist' => 'Gallons of Halomist (Gallons in Halomist Units)',
                                                                'gallons_sterifab' => 'Gallons of Sterifab',
                                                                'boxes_gloves' => 'Boxes of Gloves',
                                                                'monster_mop_fibers' => 'Monster Mop Fibers'
                                                            ] as $key => $label)
                                                                <tr>
                                                                    <td class="align-middle fw-semibold" style="width: 60%;">{{ $label }}</td>
                                                                    <td>
                                                                        <input type="number" step="any" min="0" 
                                                                            name="pre_checklist_consumables[{{ $key }}]" 
                                                                            class="form-control form-control-sm text-center" 
                                                                            value="{{ $order->pre_checklist_consumables[$key] ?? 0 }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-primary btn-sm save-pre-consumables-btn">
                                                        <i class="fas fa-save me-1"></i> Save Pre-Service Consumables
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Plan Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Service Plan (Plan Required: NO)</h5>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted" style="font-size: 13px;">Outline your plan here. This plan should include:</label>
                                                <ul style="font-size: 13px; color: #555; line-height: 1.8; margin-left: 15px;">
                                                    <li>Your plan for the outline in which you will address critical areas</li>
                                                    <li>Who is responsible for each mobility during the job</li>
                                                    <li>When you anticipate taking breaks during the service</li>
                                                    <li>What time you expect to finish service</li>
                                                    <li>Any client concerns or needs</li>
                                                    <li>Any special requirements for the job (i.e. need/spare cash trailer)</li>
                                                    <li>Simple plans are best. Don't complicate it with unnecessary job phase</li>
                                                    <li>SAVE before you navigate to any other tabs</li>
                                                </ul>
                                            </div>
                                            <form class="service-plan-form" id="servicePlanForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="service_plan_narrative" class="form-label">Narrative:</label>
                                                    <textarea class="form-control" id="service_plan_narrative" name="service_plan_narrative" rows="6" placeholder="Enter service plan narrative here...">{{ $order->service_plan_narrative ?? '' }}</textarea>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary btn-sm save-service-plan-btn">
                                                        <i class="fas fa-save me-1"></i> Update Narrative
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Plan Review Status Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Plan Review Status:</h6>
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <span class="badge badge-plan-review-status {{ $order->plan_review_status == 'REVIEWED' ? 'bg-success' : 'bg-warning' }}" style="font-size: 12px; padding: 6px 12px;">
                                                        {{ $order->plan_review_status ?? 'PENDING' }}
                                                    </span>
                                                    <button type="button" class="btn btn-sm btn-plan-review-toggle {{ $order->plan_review_status == 'REVIEWED' ? 'btn-success' : 'btn-outline-success' }}" data-order-id="{{ $order->id }}" style="transition: all 0.3s ease;">
                                                        @if($order->plan_review_status == 'REVIEWED')
                                                            <i class="bi bi-arrow-counterclockwise"></i> Undo Review
                                                        @else
                                                            <i class="bi bi-check-circle"></i> Review Done
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Previous Plans Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Service Plan Narrative</h5>
                                            </div>
                                            @if($order->service_plan_narrative)
                                                <div class="border rounded p-3 bg-light" style="min-height: 120px;">
                                                    <p class="mb-0" style="white-space: pre-wrap; word-break: break-word;">{{ $order->service_plan_narrative }}</p>
                                                </div>
                                            @else
                                                <p class="text-muted" style="font-size: 13px;">No service plan narrative available.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Reference Material Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Reference Material (use this to make your plan)</h5>
                                            </div>
                                            <form class="sales-narrative-form" id="salesNarrativeForm">
                                                @csrf
                                                <label class="form-label">Sales Narrative</label>
                                                <textarea class="form-control" id="sales_narrative" name="sales_narrative" rows="4" placeholder="Sales narrative reference...">{{ $order->sales_narrative ?? '' }}</textarea>
                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-primary btn-sm save-sales-narrative-btn">
                                                        <i class="fas fa-save me-1"></i> Update Narrative
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select C.E. Notes Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Staff</h5>
                                            </div>
                                            <label class="form-label">Certified Details</label>
                                            <div class="mb-3">
                                                <table class="table table-sm table-hover equipment-report-table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Test C</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Test D</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Test A</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Facility Maps Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Facility Maps (if available)</h5>
                                            </div>
                                            <p class="text-muted" style="font-size: 13px;">No facility maps available for this order.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>




                            <!-- Facilities Tab -->
                            <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">

                                @forelse($order->orderSlots->where('is_confirmed', true) as $slot)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">

                                                <div class="section-header mb-3">
                                                    <h5 class="section-title mb-0">Slot #{{ $loop->iteration }}</h5>
                                                    <small class="text-muted">
                                                        {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}
                                                    </small>
                                                </div>

                                                {{-- Assigned Facilities --}}
                                                @if($slot->facilities->count())
                                                    <ul class="list-group list-group-flush mb-3">
                                                        @foreach($slot->facilities as $facility)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <i class="fas fa-building me-2 text-muted"></i>
                                                                    <strong class="text-dark">{{ $facility->companyLocation->location_name }}</strong>
                                                                    @if($facility->companyLocation && $facility->companyLocation->full_address)
                                                                        <span class="text-muted d-block ms-4" style="font-size: 12px;">{{ $facility->companyLocation->full_address }}</span>
                                                                    @endif
                                                                </span>
                                                                @if($canEdit)
                                                                    <form action="{{ route('admin.lead.service.slot.facility.remove', $facility->id) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted mb-3">No facilities assigned yet.</p>
                                                @endif

                                                {{-- Add Facility Form --}}
                                                <form action="{{ route('admin.lead.service.slot.facility.add', $slot->id) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex gap-2">
                                                            <select class="form-select" name="company_location_id" required {{ !$canEdit ? 'disabled' : '' }}>
                                                                <option value="">-- Select Location --</option>
                                                                @foreach($companyLocations as $location)
                                                                    {{-- Skip already-added ones --}}
                                                                    @unless($slot->facilities->pluck('company_location_id')->contains($location->id))
                                                                        <option value="{{ $location->id }}">{{ $location->location_name }}{{ $location->full_address ? ' (' . $location->full_address . ')' : '' }}</option>
                                                                    @endunless
                                                                @endforeach
                                                            </select>
                                                        @if($canEdit)
                                                            <button type="submit" class="btn btn-success">
                                                                Add
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No slots found for this order.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>


                            <!-- Staffing Tab -->
                            <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="staffing-tab">

                                @php $confirmedSlots = $order->orderSlots->where('is_confirmed', true); @endphp

                                @if($confirmedSlots->count())

                                    <div class="section-card mt-3">
                                        <div class="navbar-tabs overflow-auto">
                                            <nav class="nav nav-tabs mb-3 flex-nowrap" id="staffingSlotTabs" role="tablist">
                                                @foreach ($confirmedSlots as $slot)
                                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                        id="staffing-slot-{{ $slot->id }}-tab" data-bs-toggle="tab"
                                                        data-bs-target="#staffing-slot-{{ $slot->id }}"
                                                        type="button" role="tab">
                                                        Slot #{{ $loop->iteration }}
                                                        <small
                                                            class="text-muted ms-1">{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d') }}</small>
                                                    </button>
                                                @endforeach
                                            </nav>
                                        </div>



                                        <div class="tab-content" id="staffingSlotTabContent">
                                            @foreach($confirmedSlots as $slot)
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                    id="staffing-slot-{{ $slot->id }}"
                                                    role="tabpanel">

                                                    {{-- Time & Facility Info --}}
                                                    <div class="border rounded p-3 mb-3 bg-light d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <p class="mb-1"><strong>Office:</strong> {{ $slot->office->name ?? 'N/A' }}</p>
                                                            <p class="mb-1"><strong>Schedule:</strong> {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}</p>
                                                            <p class="mb-0"><strong>Arrival Time:</strong> {{ $slot->scheduled_arrival_time }}</p>
                                                        </div>
                                                        <div class="audit-action-container">
                                                            @if(!$slot->is_audit)
                                                                <form action="{{ route('admin.operations.slots.audit-this', $slot->id) }}" method="POST" class="d-inline form-audit-this">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-export">
                                                                        Audit this
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('admin.operations.slots.cancel-audit', $slot->id) }}" method="POST" class="d-inline form-cancel-audit">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-export">
                                                                        Cancel Audit
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Facilities --}}
                                                    @if($slot->facilities->count())
                                                        <div class="mb-3">
                                                            <p class="fw-semibold mb-2">Facilities</p>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach($slot->facilities as $facility)
                                                                    <div class="border rounded p-2 text-center bg-white" style="min-width: 160px; max-width: 220px;">
                                                                        <i class="fas fa-map-marker-alt text-danger mb-1 fs-5"></i>
                                                                        <p class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $facility->companyLocation->location_name ?? '-' }}</p>
                                                                        @if($facility->companyLocation && $facility->companyLocation->full_address)
                                                                            <span class="text-muted d-block mt-1" style="font-size: 13px;">{{ $facility->companyLocation->full_address }}</span>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Two Column Layout --}}
                                                    <div class="row g-3">

                                                        {{-- LEFT: Assigned Team --}}
                                                        <div class="col-md-5">
                                                            <div class="border rounded p-3 h-100">
                                                                <h6 class="fw-bold mb-3">Team</h6>

                                                                @forelse($slot->staff as $staffMember)
                                                                    @php
                                                                        $isLeader = $staffMember->is_leader ?? false;
                                                                        $cardClass = $isLeader ? 'border-warning bg-warning bg-opacity-10' : 'bg-success bg-opacity-25';

                                                                        $tech = $staffMember->user;
                                                                        $slotDate = \Carbon\Carbon::parse($slot->scheduled_start_time);
                                                                        $startOfWeek = $slotDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                                                        $endOfWeek = $slotDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

                                                                        $weeklySlots = \App\Models\ServiceOrderSlot::whereHas('staff', function($q) use ($tech) {
                                                                                $q->where('user_id', $tech->id);
                                                                            })
                                                                            ->whereBetween('scheduled_start_time', [$startOfWeek, $endOfWeek])
                                                                            ->get();
                                                                            
                                                                        $weeklyHours = $weeklySlots->sum('scheduled_hours');
                                                                        $hrs = floor($weeklyHours);
                                                                        $mins = round(($weeklyHours - $hrs) * 60);
                                                                        $formattedHours = sprintf('%02d:%02d', $hrs, $mins);

                                                                        $otherSlots = $weeklySlots->filter(function($s) use ($slotDate, $slot) {
                                                                            return \Carbon\Carbon::parse($s->scheduled_start_time)->format('Y-m-d') === $slotDate->format('Y-m-d')
                                                                                && $s->id !== $slot->id;
                                                                        });

                                                                    @endphp
                                                                    <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 {{ $cardClass }}">
                                                                        <div>
                                                                            <span class="fw-semibold small">
                                                                                {{ $tech->name }} | {{ $formattedHours }} |
                                                                                @if($isLeader)
                                                                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 10px; font-weight: 700;">
                                                                                        LEADER
                                                                                    </span>
                                                                                @endif
                                                                            </span><br>
                                                                            <small class="text-muted">{{ $staffMember->slot_hours }} hrs</small>
                                                                            @php $roles = implode(' | ', $tech->specialties); @endphp
                                                                            
                                                                            @if($otherSlots->count() > 0)
                                                                                <span class="d-block mt-1 text-muted" style="font-size:11px;">
                                                                                    Booked: 
                                                                                    @foreach($otherSlots as $os)
                                                                                        {{ \Carbon\Carbon::parse($os->scheduled_start_time)->format('h:iA') }} - {{ \Carbon\Carbon::parse($os->scheduled_end_time)->format('h:iA') }}@if(!$loop->last), @endif
                                                                                    @endforeach
                                                                                    @if($roles) | {{ $roles }} @endif
                                                                                </span>
                                                                            @else
                                                                                @if($roles)
                                                                                    <br><small class="text-muted">{{ $roles }}</small>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-info rounded-circle p-0 view-user-slots d-flex align-items-center justify-content-center"
                                                                                data-user="{{ $staffMember->user_id }}"
                                                                                data-date="{{ $slot->scheduled_start_time }}"
                                                                                style="width:22px;height:22px;"
                                                                                title="View Monthly Schedule">
                                                                                <i class="fas fa-question" style="font-size:9px;"></i>
                                                                            </button>
                                                                            {{-- Toggle Leader Button --}}
                                                                            @if($canEdit)
                                                                                <form action="{{ route('admin.lead.service.slot.staff.toggle_leader', $staffMember->id) }}" method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm {{ $isLeader ? 'btn-warning text-dark' : 'btn-outline-warning border-0' }}" title="{{ $isLeader ? 'Remove Leader Designation' : 'Designate as Leader' }}" style="padding: 4px 6px; line-height: 1;">
                                                                                        <svg viewBox="0 0 100 100" style="width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 6; stroke-linecap: round; stroke-linejoin: round; vertical-align: middle; display: inline-block;">
                                                                                            <!-- Head -->
                                                                                            <circle cx="33" cy="28" r="9" />
                                                                                            <!-- Body/Spine -->
                                                                                            <path d="M33 37 v24" />
                                                                                            <!-- Left arm (hand on hip) -->
                                                                                            <path d="M33 41 H23 L19 50 L25 56" />
                                                                                            <!-- Right arm (pointing up) -->
                                                                                            <path d="M33 41 L47 29" />
                                                                                            <!-- Left leg (straight down) -->
                                                                                            <path d="M33 61 H28 V81" />
                                                                                            <!-- Right leg (stepped up) -->
                                                                                            <path d="M33 61 H44 V68 H38" />
                                                                                            <!-- Podium/Box -->
                                                                                            <rect x="36" y="68" width="18" height="13" />
                                                                                            <!-- Dotted ray -->
                                                                                            <path d="M51 26 L56 22" stroke-dasharray="2,3" />
                                                                                            <path d="M60 19 L65 15" stroke-dasharray="2,3" />
                                                                                            <!-- Star -->
                                                                                            <path d="M74 8 L77 15 L84 18 L77 21 L74 28 L71 21 L64 18 L71 15 Z" fill="currentColor" stroke="none" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </form>

                                                                                {{-- Remove Staff Button --}}
                                                                                <form action="{{ route('admin.lead.service.slot.staff.remove', $staffMember->id) }}" method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Remove Staff Member">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </button>
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @empty
                                                                    <p class="text-muted small">No team members assigned yet.</p>
                                                                @endforelse

                                                            </div>
                                                        </div>

                                                        {{-- RIGHT: Available Service Technicians --}}
                                                        <div class="col-md-7">
                                                            <div class="border rounded p-3 h-100">
                                                                <h6 class="fw-bold mb-3">Service Technicians</h6>

                                                                @php
                                                                    $territoryId     = $slot->scheduled_office;
                                                                    $staffForTerritory = $allStaff[$territoryId] ?? collect();
                                                                    $assignedUserIds = $slot->staff->pluck('user_id')->toArray();
                                                                @endphp

                                                                @if($staffForTerritory->isEmpty())
                                                                    <p class="text-muted small">No technicians found for this office.</p>
                                                                @else
                                                                    <form action="{{ route('admin.lead.service.slot.staff.assign', $slot->id) }}" method="POST">
                                                                        @csrf

                                                                        {{-- Leaders --}}
                                                                        @if(isset($staffForTerritory['leader']) && $staffForTerritory['leader']->count())
                                                                            <p class="text-muted small fw-semibold mb-2">Leaders</p>
                                                                            @foreach($staffForTerritory['leader'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php
                                                                                        $roles = implode(' | ', $tech->specialties);
                                                                                        $slotDate = \Carbon\Carbon::parse($slot->scheduled_start_time);
                                                                                        $slotDateStr = $slotDate->toDateString();
                                                                                        $startOfWeek = $slotDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                                                                        $endOfWeek = $slotDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

                                                                                        $weeklySlots = \App\Models\ServiceOrderSlot::whereHas('staff', function($q) use ($tech) {
                                                                                                $q->where('user_id', $tech->id);
                                                                                            })
                                                                                            ->whereBetween('scheduled_start_time', [$startOfWeek, $endOfWeek])
                                                                                            ->get();
                                                                                            
                                                                                        $weeklyHours = $weeklySlots->sum('scheduled_hours');
                                                                                        $hrs = floor($weeklyHours);
                                                                                        $mins = round(($weeklyHours - $hrs) * 60);
                                                                                        $formattedHours = sprintf('%02d:%02d', $hrs, $mins);

                                                                                        $otherSlots = $weeklySlots->filter(function($s) use ($slotDate, $slot) {
                                                                                            return \Carbon\Carbon::parse($s->scheduled_start_time)->format('Y-m-d') === $slotDate->format('Y-m-d')
                                                                                                && $s->id !== $slot->id;
                                                                                        });

                                                                                        // Check availability record
                                                                                        $dayOfWeek = strtolower($slotDate->format('D')); // mon, tue, wed...
                                                                                        $availability = \App\Models\EmployeeAvailability::where('user_id', $tech->id)
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        $isAvailable = false;
                                                                                        $availDetail = '';
                                                                                        if ($availability) {
                                                                                            $availStartStr = $availability->{$dayOfWeek . '_start'} ?? '00:00';
                                                                                            $availEndStr = $availability->{$dayOfWeek . '_end'} ?? '23:59';
                                                                                            
                                                                                            $baseDate = '2000-01-01 ';
                                                                                            $availStart = \Carbon\Carbon::parse($baseDate . $availStartStr);
                                                                                            $availEnd = \Carbon\Carbon::parse($baseDate . $availEndStr);
                                                                                            if ($availEnd->lessThanOrEqualTo($availStart)) {
                                                                                                $availEnd->addDay();
                                                                                            }
                                                                                            
                                                                                            $slotStartParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_start_time)->format('H:i'));
                                                                                            $slotEndParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_end_time)->format('H:i'));
                                                                                            if ($slotEndParsed->lessThanOrEqualTo($slotStartParsed)) {
                                                                                                $slotEndParsed->addDay();
                                                                                            }
                                                                                            
                                                                                            if ($slotStartParsed->greaterThanOrEqualTo($availStart) && $slotEndParsed->lessThanOrEqualTo($availEnd)) {
                                                                                                $isAvailable = true;
                                                                                            }
                                                                                            $availDetail = $availStartStr . '-' . $availEndStr;
                                                                                        }

                                                                                        $isOnLeave = false;
                                                                                        $timeOff = \App\Models\TimeOffRequest::where('user_id', $tech->id)
                                                                                            ->where('status', 'approved')
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        if ($timeOff) {
                                                                                            $isAvailable = false;
                                                                                            $isOnLeave = true;
                                                                                        }

                                                                                        if ($isAvailable) {
                                                                                            $bgColor = '#4caf50';
                                                                                            $textColor = 'text-white';
                                                                                        } else {
                                                                                            $bgColor = '#ea3d2f';
                                                                                            $textColor = 'text-white';
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: {{ $bgColor }}; opacity: {{ $isAvailable ? '1' : '0.6' }};">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                {{ ($isAvailable && $canEdit) ? '' : 'disabled' }}>
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="{{ $textColor }} small mb-0" style="cursor:{{ $isAvailable ? 'pointer' : 'not-allowed' }};">
                                                                                                {{ $tech->name }} | {{ $formattedHours }} 
                                                                                                @if(!$isAvailable)
                                                                                                    @if($isOnLeave)
                                                                                                        <strong class="text-warning">(On Leave)</strong>
                                                                                                    @else
                                                                                                        <strong class="text-warning">(Unavailable{{ $availDetail ? ': ' . $availDetail : '' }})</strong>
                                                                                                    @endif
                                                                                                @endif
                                                                                                |
                                                                                                @if($otherSlots->count() > 0)
                                                                                                    <span class="d-block mt-1" style="font-size:11px;">
                                                                                                        @foreach($otherSlots as $os)
                                                                                                            {{ \Carbon\Carbon::parse($os->scheduled_start_time)->format('h:iA') }} - {{ \Carbon\Carbon::parse($os->scheduled_end_time)->format('h:iA') }}@if(!$loop->last), @endif
                                                                                                        @endforeach
                                                                                                        @if($roles) {{ $roles }} @endif
                                                                                                    </span>
                                                                                                @else
                                                                                                    @if($roles) <span class="d-block mt-1" style="font-size:11px;">{{ $roles }}</span> @endif
                                                                                                @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Technicians --}}
                                                                        @if(isset($staffForTerritory['technician']) && $staffForTerritory['technician']->count())
                                                                            <p class="text-muted small fw-semibold mt-3 mb-2">Technicians</p>
                                                                            @foreach($staffForTerritory['technician'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php
                                                                                        $roles = implode(' | ', $tech->specialties);
                                                                                        $slotDate = \Carbon\Carbon::parse($slot->scheduled_start_time);
                                                                                        $slotDateStr = $slotDate->toDateString();
                                                                                        $startOfWeek = $slotDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                                                                        $endOfWeek = $slotDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

                                                                                        $weeklySlots = \App\Models\ServiceOrderSlot::whereHas('staff', function($q) use ($tech) {
                                                                                                $q->where('user_id', $tech->id);
                                                                                            })
                                                                                            ->whereBetween('scheduled_start_time', [$startOfWeek, $endOfWeek])
                                                                                            ->get();
                                                                                            
                                                                                        $weeklyHours = $weeklySlots->sum('scheduled_hours');
                                                                                        $hrs = floor($weeklyHours);
                                                                                        $mins = round(($weeklyHours - $hrs) * 60);
                                                                                        $formattedHours = sprintf('%02d:%02d', $hrs, $mins);

                                                                                        $otherSlots = $weeklySlots->filter(function($s) use ($slotDate, $slot) {
                                                                                            return \Carbon\Carbon::parse($s->scheduled_start_time)->format('Y-m-d') === $slotDate->format('Y-m-d')
                                                                                                && $s->id !== $slot->id;
                                                                                        });

                                                                                        // Check availability record
                                                                                        $dayOfWeek = strtolower($slotDate->format('D')); // mon, tue, wed...
                                                                                        $availability = \App\Models\EmployeeAvailability::where('user_id', $tech->id)
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        $isAvailable = false;
                                                                                        $availDetail = '';
                                                                                        if ($availability) {
                                                                                            $availStartStr = $availability->{$dayOfWeek . '_start'} ?? '00:00';
                                                                                            $availEndStr = $availability->{$dayOfWeek . '_end'} ?? '23:59';
                                                                                            
                                                                                            $baseDate = '2000-01-01 ';
                                                                                            $availStart = \Carbon\Carbon::parse($baseDate . $availStartStr);
                                                                                            $availEnd = \Carbon\Carbon::parse($baseDate . $availEndStr);
                                                                                            if ($availEnd->lessThanOrEqualTo($availStart)) {
                                                                                                $availEnd->addDay();
                                                                                            }
                                                                                            
                                                                                            $slotStartParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_start_time)->format('H:i'));
                                                                                            $slotEndParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_end_time)->format('H:i'));
                                                                                            if ($slotEndParsed->lessThanOrEqualTo($slotStartParsed)) {
                                                                                                $slotEndParsed->addDay();
                                                                                            }
                                                                                            
                                                                                            if ($slotStartParsed->greaterThanOrEqualTo($availStart) && $slotEndParsed->lessThanOrEqualTo($availEnd)) {
                                                                                                $isAvailable = true;
                                                                                            }
                                                                                            $availDetail = $availStartStr . '-' . $availEndStr;
                                                                                        }

                                                                                        $isOnLeave = false;
                                                                                        $timeOff = \App\Models\TimeOffRequest::where('user_id', $tech->id)
                                                                                            ->where('status', 'approved')
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        if ($timeOff) {
                                                                                            $isAvailable = false;
                                                                                            $isOnLeave = true;
                                                                                        }

                                                                                        if ($isAvailable) {
                                                                                            $bgColor = '#4caf50';
                                                                                            $textColor = 'text-white';
                                                                                        } else {
                                                                                            $bgColor = '#ea3d2f';
                                                                                            $textColor = 'text-white';
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: {{ $bgColor }}; opacity: {{ $isAvailable ? '1' : '0.6' }};">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                {{ ($isAvailable && $canEdit) ? '' : 'disabled' }}>
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="{{ $textColor }} small mb-0" style="cursor:{{ $isAvailable ? 'pointer' : 'not-allowed' }};">
                                                                                                {{ $tech->name }} | {{ $formattedHours }} 
                                                                                                @if(!$isAvailable)
                                                                                                    @if($isOnLeave)
                                                                                                        <strong class="text-warning">(On Leave)</strong>
                                                                                                    @else
                                                                                                        <strong class="text-warning">(Unavailable{{ $availDetail ? ': ' . $availDetail : '' }})</strong>
                                                                                                    @endif
                                                                                                @endif
                                                                                                |
                                                                                                @if($otherSlots->count() > 0)
                                                                                                    <span class="d-block mt-1" style="font-size:11px;">
                                                                                                        @foreach($otherSlots as $os)
                                                                                                            {{ \Carbon\Carbon::parse($os->scheduled_start_time)->format('h:iA') }} - {{ \Carbon\Carbon::parse($os->scheduled_end_time)->format('h:iA') }}@if(!$loop->last), @endif
                                                                                                        @endforeach
                                                                                                        @if($roles) {{ $roles }} @endif
                                                                                                    </span>
                                                                                                @else
                                                                                                    @if($roles) <span class="d-block mt-1" style="font-size:11px;">{{ $roles }}</span> @endif
                                                                                                @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Corporate --}}
                                                                        @if(isset($staffForTerritory['corporate']) && $staffForTerritory['corporate']->count())
                                                                            <p class="text-muted small fw-semibold mt-3 mb-2">Corporate</p>
                                                                            @foreach($staffForTerritory['corporate'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php
                                                                                        $roles = implode(' | ', $tech->specialties);
                                                                                        $slotDate = \Carbon\Carbon::parse($slot->scheduled_start_time);
                                                                                        $slotDateStr = $slotDate->toDateString();
                                                                                        $startOfWeek = $slotDate->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                                                                        $endOfWeek = $slotDate->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

                                                                                        $weeklySlots = \App\Models\ServiceOrderSlot::whereHas('staff', function($q) use ($tech) {
                                                                                                $q->where('user_id', $tech->id);
                                                                                            })
                                                                                            ->whereBetween('scheduled_start_time', [$startOfWeek, $endOfWeek])
                                                                                            ->get();
                                                                                            
                                                                                        $weeklyHours = $weeklySlots->sum('scheduled_hours');
                                                                                        $hrs = floor($weeklyHours);
                                                                                        $mins = round(($weeklyHours - $hrs) * 60);
                                                                                        $formattedHours = sprintf('%02d:%02d', $hrs, $mins);

                                                                                        $otherSlots = $weeklySlots->filter(function($s) use ($slotDate, $slot) {
                                                                                            return \Carbon\Carbon::parse($s->scheduled_start_time)->format('Y-m-d') === $slotDate->format('Y-m-d')
                                                                                                && $s->id !== $slot->id;
                                                                                        });

                                                                                        // Check availability record
                                                                                        $dayOfWeek = strtolower($slotDate->format('D')); // mon, tue, wed...
                                                                                        $availability = \App\Models\EmployeeAvailability::where('user_id', $tech->id)
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        $isAvailable = false;
                                                                                        $availDetail = '';
                                                                                        if ($availability) {
                                                                                            $availStartStr = $availability->{$dayOfWeek . '_start'} ?? '00:00';
                                                                                            $availEndStr = $availability->{$dayOfWeek . '_end'} ?? '23:59';
                                                                                            
                                                                                            $baseDate = '2000-01-01 ';
                                                                                            $availStart = \Carbon\Carbon::parse($baseDate . $availStartStr);
                                                                                            $availEnd = \Carbon\Carbon::parse($baseDate . $availEndStr);
                                                                                            if ($availEnd->lessThanOrEqualTo($availStart)) {
                                                                                                $availEnd->addDay();
                                                                                            }
                                                                                            
                                                                                            $slotStartParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_start_time)->format('H:i'));
                                                                                            $slotEndParsed = \Carbon\Carbon::parse($baseDate . \Carbon\Carbon::parse($slot->scheduled_end_time)->format('H:i'));
                                                                                            if ($slotEndParsed->lessThanOrEqualTo($slotStartParsed)) {
                                                                                                $slotEndParsed->addDay();
                                                                                            }
                                                                                            
                                                                                            if ($slotStartParsed->greaterThanOrEqualTo($availStart) && $slotEndParsed->lessThanOrEqualTo($availEnd)) {
                                                                                                $isAvailable = true;
                                                                                            }
                                                                                            $availDetail = $availStartStr . '-' . $availEndStr;
                                                                                        }

                                                                                        $isOnLeave = false;
                                                                                        $timeOff = \App\Models\TimeOffRequest::where('user_id', $tech->id)
                                                                                            ->where('status', 'approved')
                                                                                            ->where('start_date', '<=', $slotDateStr)
                                                                                            ->where('end_date', '>=', $slotDateStr)
                                                                                            ->first();
                                                                                        
                                                                                        if ($timeOff) {
                                                                                            $isAvailable = false;
                                                                                            $isOnLeave = true;
                                                                                        }

                                                                                        if ($isAvailable) {
                                                                                            $bgColor = '#4caf50';
                                                                                            $textColor = 'text-white';
                                                                                        } else {
                                                                                            $bgColor = '#ea3d2f';
                                                                                            $textColor = 'text-white';
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: {{ $bgColor }}; opacity: {{ $isAvailable ? '1' : '0.6' }};">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                {{ ($isAvailable && $canEdit) ? '' : 'disabled' }}>
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="{{ $textColor }} small mb-0" style="cursor:{{ $isAvailable ? 'pointer' : 'not-allowed' }};">
                                                                                                {{ $tech->name }} | {{ $formattedHours }} 
                                                                                                @if(!$isAvailable)
                                                                                                    @if($isOnLeave)
                                                                                                        <strong class="text-warning">(On Leave)</strong>
                                                                                                    @else
                                                                                                        <strong class="text-warning">(Unavailable{{ $availDetail ? ': ' . $availDetail : '' }})</strong>
                                                                                                    @endif
                                                                                                @endif
                                                                                                |
                                                                                                @if($otherSlots->count() > 0)
                                                                                                    <span class="d-block mt-1" style="font-size:11px;">
                                                                                                        @foreach($otherSlots as $os)
                                                                                                            {{ \Carbon\Carbon::parse($os->scheduled_start_time)->format('h:iA') }} - {{ \Carbon\Carbon::parse($os->scheduled_end_time)->format('h:iA') }}@if(!$loop->last), @endif
                                                                                                        @endforeach
                                                                                                        @if($roles) {{ $roles }} @endif
                                                                                                    </span>
                                                                                                @else
                                                                                                    @if($roles) <span class="d-block mt-1" style="font-size:11px;">{{ $roles }}</span> @endif
                                                                                                @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Add Selected Button --}}
                                                                        @if($canEdit)
                                                                            <div class="mt-3 text-end">
                                                                                <button type="submit" class="btn btn-success px-4">
                                                                                    Add Selected
                                                                                </button>
                                                                            </div>
                                                                        @endif

                                                                    </form>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- Summary Footer --}}
                                                    @php
                                                        $staffCount    = $slot->staff->count();
                                                        $scheduledHrs  = $slot->scheduled_hours ?? 0;
                                                        $totalHours    = $scheduledHrs * $staffCount;
                                                        
                                                        $invoiceAmount = $order->service->price_per_service ?? 0;
                                                        $totalCost     = 28.78 * $totalHours;
                                                        $peoplePct     = $invoiceAmount > 0 ? round(($totalCost * 100) / $invoiceAmount) : 0;
                                                    @endphp
                                                    <div class="mt-3 pt-3 border-top d-flex gap-4">
                                                        <small class="text-muted">People Percentage: <strong>{{ $peoplePct }}%</strong></small>
                                                        <small class="text-muted">Invoice: <strong>${{ number_format($invoiceAmount, 2) }}</strong></small>
                                                        <small class="text-muted">Hours: <strong>{{ number_format($totalHours, 2) }}</strong></small>
                                                        <small class="text-muted">Cost: <strong>${{ number_format($totalCost, 2) }}</strong></small>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @else
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No confirmed slots found. Confirm slots in the Confirmations tab first.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        <!-- Vehicle Planning Tab -->
                        <div class="tab-pane fade" id="vehicle-planning" role="tabpanel"
                            aria-labelledby="vehicle-planning-tab">
                            
                            @if($confirmedSlots->count())
                                <div class="section-card mt-3">
                                    <div class="navbar-tabs overflow-auto">
                                        <nav class="nav nav-tabs mb-3 flex-nowrap" id="vehiclePlanningSlotTabs" role="tablist">
                                            @foreach ($confirmedSlots as $slot)
                                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                    id="vehicle-planning-slot-{{ $slot->id }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#vehicle-planning-slot-{{ $slot->id }}"
                                                    type="button" role="tab">
                                                    Slot #{{ $loop->iteration }}
                                                    <small class="text-muted ms-1">{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d') }}</small>
                                                </button>
                                            @endforeach
                                        </nav>
                                    </div>
                                    <div class="tab-content" id="vehiclePlanningSlotTabContent">
                                        @foreach($confirmedSlots as $slot)
                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                id="vehicle-planning-slot-{{ $slot->id }}"
                                                role="tabpanel">
                                                {{-- Time & Facility Info --}}
                                                <div class="border rounded p-3 mb-3 bg-light">
                                                    <p class="mb-1"><strong>Office:</strong> {{ $slot->office->name ?? 'N/A' }}</p>
                                                    <p class="mb-1"><strong>Schedule:</strong> {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}</p>
                                                    <p class="mb-0"><strong>Arrival Time:</strong> {{ $slot->scheduled_arrival_time }}</p>
                                                </div>

                                                {{-- Facilities --}}
                                                @if($slot->facilities->count())
                                                    <div class="mb-3">
                                                        <p class="fw-semibold mb-2">Facilities</p>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @foreach($slot->facilities as $facility)
                                                                <div class="border rounded p-2 text-center bg-white" style="min-width: 160px; max-width: 220px;">
                                                                    <i class="fas fa-map-marker-alt text-danger mb-1 fs-5"></i>
                                                                    <p class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $facility->companyLocation->location_name ?? '-' }}</p>
                                                                    @if($facility->companyLocation && $facility->companyLocation->full_address)
                                                                        <span class="text-muted d-block mt-1" style="font-size: 13px;">{{ $facility->companyLocation->full_address }}</span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- Two Column Layout --}}
                                                <div class="row g-3">

                                                    {{-- LEFT: Assigned Vehicles --}}
                                                    <div class="col-md-5">
                                                        <div class="border rounded p-3 h-100">
                                                            <h6 class="fw-bold mb-3">Assigned Vehicles</h6>

                                                            @forelse($slot->vehicles as $vehicle)
                                                                <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 bg-success bg-opacity-25">
                                                                    <div>
                                                                        <span class="fw-semibold small">
                                                                            <i class="fas fa-truck me-2"></i>{{ $vehicle->name }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <p class="text-muted small">No vehicles assigned yet.</p>
                                                            @endforelse
                                                        </div>
                                                    </div>

                                                    {{-- RIGHT: Assign Action --}}
                                                    <div class="col-md-7">
                                                        <div class="border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center bg-light text-center">
                                                            <h6 class="fw-bold mb-2">Vehicle Management</h6>
                                                            <p class="text-muted small mb-3">
                                                                Assign and manage vehicles for this slot via the Vehicle Planning dashboard.
                                                            </p>
                                                            <a href="{{ route('admin.vehicle.planning', ['date' => \Carbon\Carbon::parse($slot->scheduled_start_time)->format('Y-m-d')]) }}" class="btn btn-primary" target="_blank">
                                                                </i> Open Vehicle Planning
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <p class="text-center text-muted mb-0">No confirmed slots found. Confirm slots in the Confirmations tab first.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <!-- Notes Tab -->
                        <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">

                                {{-- Contract Details --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Contract Details</h5>
                                            </div>

                                            @forelse($order->service->outlines as $outline)
                                                <div class="border-bottom py-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <p class="mb-1 fw-semibold">{{ ucwords($outline->outline_name) }}</p>
                                                        </div>
                                                        <span class="text-muted small">{{ $outline->range }}% complete</span>
                                                    </div>

                                                    {{-- Progress Bar --}}
                                                    <div class="progress mb-2" style="height: 6px;">
                                                        <div class="progress-bar bg-success"
                                                            role="progressbar"
                                                            style="width: {{ $outline->range }}%"
                                                            aria-valuenow="{{ $outline->range }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>

                                                    {{-- Edit Form --}}
                                                    <!-- <form action="{{ route('admin.lead.service.outline.update', $outline->id) }}" method="POST" class="mt-2">
                                                        @csrf -->
                                                        <div class="row mt-2 g-2">
                                                            <!-- <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                        class="form-control"
                                                                        name="range"
                                                                        value="{{ $outline->range ?? 0 }}"
                                                                        min="0" max="100" step="1"
                                                                        placeholder="0">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div> -->
                                                            <div class="col-md-12 mt-2">
                                                                <textarea name="description"
                                                                    class="form-control"
                                                                    placeholder="Add description..." readonly>{{ $outline->description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="row mt-2">
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-success">Save</button>
                                                            </div>
                                                        </div>
                                                    </form> -->
                                                </div>
                                            @empty
                                                <p class="text-muted">No contract details found.</p>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>

                                {{-- Departmental --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Departmental</h5>
                                                <small class="text-muted">Enter new departments in the form below:</small>
                                            </div>

                                            {{-- Add Department Form --}}
                                            @if($canEdit)
                                                <form action="{{ route('admin.lead.service.outline.add', $order->service->id) }}" method="POST">
                                                    @csrf
                                                    <table class="table table-hover equipment-report-table">
                                                        <tbody>
                                                            <tr>
                                                                <th style="width: 25%;">Department Name</th>
                                                                <td>
                                                                    <input type="text" class="form-control" name="outline_name" placeholder="Enter department name" required>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-end">
                                                                    <button type="submit" class="btn btn-success">Add Department</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                {{-- Service Notes --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Service Notes</h5>
                                                <small class="text-muted">Enter new notes in the form below:</small>
                                            </div>

                                            {{-- Existing Notes List --}}
                                            @if($order->notes->count())
                                                <div class="mb-4">
                                                    @foreach($order->notes as $note)
                                                        <div class="border rounded p-3 mb-2">
                                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                                <small class="text-muted">
                                                                    {{ $note->user->name ?? '-' }} &bull; {{ $note->created_at->format('d M Y, h:i A') }}
                                                                </small>
                                                                @if($note->notify_sales_team)
                                                                    <span class="badge bg-warning text-dark">Sales Team Notified</span>
                                                                @endif
                                                            </div>
                                                            <p class="mb-1">{!! nl2br(e($note->notes)) !!}</p>
                                                            @if($note->image_path)
                                                                <img src="{{ asset('storage/' . $note->image_path) }}"
                                                                    class="img-thumbnail mt-2"
                                                                    style="max-height: 150px;">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                        {{-- Add Note Form --}}
                                        @if($canEdit)
                                            <form action="{{ route('admin.lead.service.order.notes.add', $order->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <table class="table table-hover equipment-report-table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Notes</th>
                                                            <td>
                                                                <textarea class="form-control" name="notes" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Upload Photo <small class="text-muted">(optional)</small></th>
                                                            <td>
                                                                <input type="file" class="form-control" name="photo">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <small class="text-muted">Note: Use the Contracts section to
                                                                    document service that was performed. Discrepancies, damage,
                                                                    or other issues that the sales team should be notified about
                                                                    should be documented and the checkbox checked.</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="notify_sales_team" id="notify_sales_team">
                                                                    <label class="form-check-label"
                                                                        for="notify_sales_team">Notify Sales Team</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-end">
                                                                <button type="submit" class="btn btn-success">Add
                                                                    Notes</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        @endif

                                        </div>
                                    </div>
                                </div>

                                    {{-- Inventory Consumables --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <div class="section-header mb-3">
                                                    <h5 class="section-title">Inventory Consumables</h5>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover equipment-report-table mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Quantity Used</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $consumablesList = [
                                                                    'microfiber_bins' => 'Microfiber Bins',
                                                                    'disposable_microfiber' => 'Disposable Microfiber',
                                                                    'atp_swabs' => 'ATP Swabs',
                                                                    'water' => 'Water',
                                                                    'oxivir' => 'Oxivir',
                                                                    'opticide' => 'Opticide',
                                                                    'halomist' => 'Halomist',
                                                                    'gloves' => 'Gloves',
                                                                    'sterifab' => 'Sterifab',
                                                                    'd2' => 'D2',
                                                                    'shield' => 'Shield',
                                                                    'rinse_aid' => 'Rinse Aid',
                                                                    'wash_cleaner' => 'Wash Cleaner',
                                                                    'rust_inhibitor' => 'Rust Inhibitor'
                                                                ];
                                                                $hasConsumables = false;
                                                            @endphp
                                                            
                                                            @if(isset($order->consumables) && is_array($order->consumables))
                                                                @foreach($consumablesList as $key => $label)
                                                                    @if(isset($order->consumables[$key]) && floatval($order->consumables[$key]) > 0)
                                                                        @php $hasConsumables = true; @endphp
                                                                        <tr>
                                                                            <td>{{ $label }}</td>
                                                                            <td>{{ floatval($order->consumables[$key]) }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                            @if(!$hasConsumables)
                                                                <tr>
                                                                    <td colspan="2" class="text-muted text-center">No inventory consumables have been recorded.</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                        </div>

                        <!-- Invoicing Tab -->
                        <div class="tab-pane fade" id="invoicing" role="tabpanel" aria-labelledby="invoicing-tab">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        @if($order->invoices->count() == 0)
                                            <!-- Inventory Breakdown Page -->
                                            <div class="border rounded p-4 mb-4">
                                                <h4 class="mb-1 text-dark" style="font-weight: 400;">Invoice It</h4>
                                                <h6 class="mb-4 text-secondary" style="font-weight: 400;">Inventory Breakdown</h6>

                                                <form action="{{ route('admin.lead.service.order.invoice.generate', $order->id) }}" method="POST" id="generate-invoice-form">
                                                    @csrf
                                                    <table class="table equipment-report-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th style="width: 150px;">Quantity</th>
                                                                <th style="width: 150px;">Price per Unit</th>
                                                                <th style="width: 150px;" class="text-end">Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $consumablesList = [
                                                                    'disposable_microfiber' => 'Disposable Microfiber',
                                                                    'atp_swabs' => 'ATP Swabs',
                                                                    'water' => 'Water',
                                                                    'oxivir' => 'Oxivir',
                                                                    'opticide' => 'Opticide',
                                                                    'halomist' => 'Halomist',
                                                                    'gloves' => 'Gloves',
                                                                    'sterifab' => 'Sterifab',
                                                                    'd2' => 'D2',
                                                                    'shield' => 'Shield',
                                                                    'rinse_aid' => 'Rinse Aid',
                                                                    'wash_cleaner' => 'Wash Cleaner',
                                                                    'rust_inhibitor' => 'Rust Inhibitor'
                                                                ];
                                                            @endphp
                                                            @foreach($consumablesList as $key => $label)
                                                                @php
                                                                    $qty = $order->consumables[$key] ?? 0;
                                                                @endphp
                                                                <tr>
                                                                    <td class="align-middle">{{ $label }}</td>
                                                                    <td class="align-middle text-center">{{ $qty }}</td>
                                                                    <td class="align-middle">
                                                                        <div class="input-group input-group-sm">
                                                                            <span class="input-group-text">$</span>
                                                                            <input type="number" name="consumable_prices[{{ $key }}]" class="form-control consumable-price" data-qty="{{ $qty }}" value="0.00" min="0" step="0.01">
                                                                        </div>
                                                                    </td>
                                                                    <td class="align-middle text-end fw-semibold consumable-value-text">$0.00</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3" class="fw-bold text-dark text-end">Total Service Supplies:</td>
                                                                <td class="fw-bold text-dark text-end">$<span id="inventory-total-value">0.00</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="mt-4 pt-3">
                                                        <p class="mb-0 text-dark">Pricing for this order is currently set at: ${{ number_format($order->service->price_per_service ?? 0.00, 2) }}</p>
                                                        <p class="mb-3 text-dark">If you bill with inventory charges this is what your line items will bill as:</p>
                                                        <table class="table equipment-report-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="align-middle text-dark">GermBlast</td>
                                                                    <td class="align-middle text-dark text-end">${{ number_format($order->service->price_per_service ?? 0.00, 2) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="align-middle text-dark">Service Supplies</td>
                                                                    <td class="align-middle text-dark text-end">$<span id="summary-service-supplies">0.00</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    @if($canEdit)
                                                        <div class="d-flex gap-3 mt-4 pt-3">
                                                            <button type="submit" name="with_inventory" value="1" class="btn btn-success">Invoice With Inventory Billing</button>
                                                            <button type="submit" name="with_inventory" value="0" class="btn btn-primary">Invoice Without Inventory Billing</button>
                                                        </div>
                                                    @endif
                                                </form>
                                            </div>
                                        @else
                                        <h5 class="section-title mb-4">Invoices</h5>

                                        @php
                                            $orderTotal = $order->service->price_per_service ?? 0.00;
                                            $totalInvoiced = $order->invoices->where('status', '!=', 'Cancelled')->sum('total_amount');
                                            $remainingUninvoiced = max(0, $orderTotal - $totalInvoiced);
                                            $invoiceCount = $order->invoices->count();

                                            $lastInvoice = $order->invoices()->latest()->first();
                                            if ($lastInvoice) {
                                                $invoiceNo = $lastInvoice->invoice_no;

                                                $invoiceNotes = $lastInvoice->notes;
                                                if (is_array($lastInvoice->line_items)) {
                                                    $invoiceItems = $lastInvoice->line_items;
                                                } else {
                                                    $invoiceItems = [
                                                        [
                                                            'type' => 'GermBlast Flat Fee',
                                                            'qty' => 1,
                                                            'price' => $order->service->price_per_service ?? 0.00,
                                                            'total' => $order->service->price_per_service ?? 0.00
                                                        ]
                                                    ];
                                                }
                                                $invoiceTotal = $lastInvoice->total_amount;
                                            }
                                            
                                            $isReadOnly = false;
                                            $selectedInvoice = null;
                                        @endphp

                                        <form action="{{ route('admin.lead.service.order.invoice.update', $lastInvoice->id) }}" method="POST" id="invoiceForm">
                                            @csrf

                                            <div class="border rounded p-4 mb-4">
                                                {{-- Invoice Header --}}
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        {{-- Logo --}}
                                                        <img src="{{ asset('img/logo/logo.png') }}" alt="GermBlast" style="max-height: 60px;">
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <div class="d-flex flex-column align-items-end gap-2 mt-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="small fw-semibold">Invoice Number:</span>
                                                                <input type="text" name="invoice_no" class="form-control form-control-sm" style="width: 150px;" value="{{ $invoiceNo }}" readonly required>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="small fw-semibold">Invoice Date:</span>
                                                                <input type="text" class="form-control form-control-sm" style="width: 150px;" value="{{ date('m/d/Y') }}" readonly>
                                                            </div>

                                                            <div class="mt-1">
                                                                <span class="small fw-bold">Amount Due: </span>
                                                                <strong class="text-danger" style="font-size: 1.1rem;">$<span id="invoice-header-total">{{ number_format($invoiceTotal, 2) }}</span></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Service Provider + Customer --}}
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <p class="fw-bold mb-1 text-secondary">Service Provider</p>
                                                        <p class="mb-0 small">Infection Controls, Inc.</p>
                                                        <p class="mb-0 small">1414 Avenue J</p>
                                                        <p class="mb-0 small">Lubbock, TX 79401</p>
                                                        <p class="mb-0 small">877.771.3558</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fw-bold mb-1 text-secondary">Customer</p>
                                                        <p class="mb-0 small fw-bold">{{ $order->service->lead->company->name ?? 'N/A' }}</p>
                                                        @if ($order->service->lead->company && $order->service->lead->company->locations->first())
                                                            <p class="mb-0 small">{{ $order->service->lead->company->locations->first()->full_address }}</p>
                                                        @endif
                                                        @if ($order->service->lead->company && $order->service->lead->company->companyPhone)
                                                            <p class="mb-0 small">{{ $order->service->lead->company->companyPhone->phone }}</p>
                                                        @endif
                                                        @if ($order->service->lead->company && $order->service->lead->company->companyEmail)
                                                            <p class="mb-0 small">{{ $order->service->lead->company->companyEmail->email }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Line Items --}}
                                                <h6 class="fw-bold mb-3 text-secondary">Line Items</h6>

                                                <div id="invoice-items-container">
                                                    @foreach($invoiceItems as $index => $item)
                                                        <div class="row align-items-center mb-2 g-2 invoice-item-row" data-index="{{ $index }}">
                                                            <div class="col-md-4">
                                                                <select name="items[{{ $index }}][type]" class="form-select form-select-sm item-type">
                                                                    <option value="New Line" {{ ($item['type'] ?? '') == 'New Line' ? 'selected' : '' }}>New Line</option>
                                                                    <option value="GermBlast Disinfection Services" {{ ($item['type'] ?? '') == 'GermBlast Disinfection Services' ? 'selected' : '' }}>GermBlast Disinfection Services</option>
                                                                    <option value="GermBlast Response Service" {{ ($item['type'] ?? '') == 'GermBlast Response Service' ? 'selected' : '' }}>GermBlast Response Service</option>
                                                                    <option value="GermBlast Response Service under contract" {{ ($item['type'] ?? '') == 'GermBlast Response Service under contract' ? 'selected' : '' }}>GermBlast Response Service under contract</option>
                                                                    <option value="Service Supplies" {{ ($item['type'] ?? '') == 'Service Supplies' ? 'selected' : '' }}>Service Supplies</option>
                                                                    <option value="COVID Travel Manhours" {{ ($item['type'] ?? '') == 'COVID Travel Manhours' ? 'selected' : '' }}>COVID Travel Manhours</option>
                                                                    <option value="COVID Service Manhours" {{ ($item['type'] ?? '') == 'COVID Service Manhours' ? 'selected' : '' }}>COVID Service Manhours</option>
                                                                    <option value="modified GermBlast Response Service" {{ ($item['type'] ?? '') == 'modified GermBlast Response Service' ? 'selected' : '' }}>modified GermBlast Response Service</option>
                                                                    <option value="GermBlast Biological Response Service COVID-19" {{ ($item['type'] ?? '') == 'GermBlast Biological Response Service COVID-19' ? 'selected' : '' }}>GermBlast Biological Response Service COVID-19</option>
                                                                    <option value="GermBlast Flat Fee" {{ ($item['type'] ?? 'GermBlast Flat Fee') == 'GermBlast Flat Fee' ? 'selected' : '' }}>GermBlast Flat Fee</option>
                                                                    <option value="GBS - Flooring" {{ ($item['type'] ?? '') == 'GBS - Flooring' ? 'selected' : '' }}>GBS - Flooring</option>
                                                                    <option value="GBS-BONA Flooring Service" {{ ($item['type'] ?? '') == 'GBS-BONA Flooring Service' ? 'selected' : '' }}>GBS-BONA Flooring Service</option>
                                                                    <option value="Discount" {{ ($item['type'] ?? '') == 'Discount' ? 'selected' : '' }}>Discount</option>
                                                                    <option value="Sales Tax" {{ ($item['type'] ?? '') == 'Sales Tax' ? 'selected' : '' }}>Sales Tax</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text">Qty</span>
                                                                    <input type="number" name="items[{{ $index }}][qty]" class="form-control item-qty" value="{{ $item['qty'] ?? 1 }}" min="1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="number" name="items[{{ $index }}][price]" class="form-control item-price" value="{{ $item['price'] ?? 0 }}" min="0" step="0.01">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span class="small">Total = $<strong><span class="item-total">{{ number_format($item['total'] ?? 0, 2) }}</span></strong></span>
                                                            </div>
                                                            <div class="col-md-2 d-flex gap-1">
                                                                <button type="button" class="btn btn-sm btn-danger delete-item-btn">Delete Line</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                {{-- Total --}}
                                                <p class="small mt-2 fw-semibold">Total of Line Items: <strong>$<span id="invoice-grand-total">{{ number_format($invoiceTotal, 2) }}</span></strong></p>

                                                {{-- Add Line Button --}}
                                                @if($canEdit)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-4" id="add-invoice-item-btn">
                                                        <i class="bi bi-plus-circle"></i> Add Another Line
                                                    </button>
                                                @endif

                                                {{-- Notes --}}
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Notes:</label>
                                                    <textarea name="notes" class="form-control" rows="3">{{ $invoiceNotes }}</textarea>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                                    <div>
                                                        @if($canEdit)
                                                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                                                <i class="bi bi-save"></i> Update Invoice
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.lead.service.order.invoice.download.pdf', $lastInvoice->id) }}" class="btn btn-sm btn-outline-danger py-1 px-2" title="Download PDF">
                                                            <i class="bi bi-file-pdf"></i> PDF
                                                        </a>
                                                        <a href="{{ route('admin.lead.service.order.invoice.download.csv', $lastInvoice->id) }}" class="btn btn-sm btn-outline-info py-1 px-2" title="Download CSV">
                                                            <i class="bi bi-file-earmark-spreadsheet"></i> CSV
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-primary py-1 px-2 share-invoice-btn" data-url="{{ route('admin.lead.service.order.invoice.share', $lastInvoice->id) }}" title="Share with Customer">
                                                            <i class="bi bi-envelope"></i> Share
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>


                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- Schedule View Tab -->
                        <div class="tab-pane fade" id="schedule-view" role="tabpanel"
                            aria-labelledby="schedule-view-tab">

                            @php $confirmedSlots = $order->orderSlots->where('is_confirmed', true); @endphp

                            @if($confirmedSlots->count())

                                <div class="section-card mt-3">
                                    <div class="navbar-tabs overflow-auto">
                                        <nav class="nav nav-tabs mb-3 flex-nowrap" id="scheduleViewSlotTabs" role="tablist">
                                            @foreach ($confirmedSlots as $slot)
                                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                    id="schedule-view-slot-{{ $slot->id }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#schedule-view-slot-{{ $slot->id }}"
                                                    type="button" role="tab">
                                                    Slot #{{ $loop->iteration }}
                                                    <small
                                                        class="text-muted ms-1">{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d') }}</small>
                                                </button>
                                            @endforeach
                                        </nav>
                                    </div>

                                    <div class="tab-content" id="scheduleViewSlotTabContent">
                                        @foreach($confirmedSlots as $slot)
                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                id="schedule-view-slot-{{ $slot->id }}"
                                                role="tabpanel">

                                                {{-- Basic Details --}}
                                                <div class="border rounded p-3 mb-3 bg-light">
                                                    <p class="mb-1"><strong>Office:</strong> {{ $slot->office->name ?? 'N/A' }}</p>
                                                    <p class="mb-1"><strong>Interval:</strong> {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}</p>
                                                    <p class="mb-1"><strong>Hours:</strong> {{ $slot->scheduled_hours }}</p>
                                                    <p class="mb-1"><strong>Arrival Time:</strong> {{ $slot->scheduled_arrival_time }}</p>
                                                </div>

                                                {{-- Vehicles and Service Locations Side-by-Side --}}
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="section-card h-100 mb-0">
                                                            <div class="section-header mb-3">
                                                                <h5 class="section-title">Vehicles</h5>
                                                            </div>
                                                            @if($slot->vehicles->count())
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    @foreach($slot->vehicles as $vehicle)
                                                                        <div class="border rounded p-2 text-center bg-white" style="min-width: 160px;">
                                                                            <i class="fas fa-car text-danger mb-1"></i>
                                                                            <p class="mb-0 small fw-semibold">{{ $vehicle->name ?? $vehicle->plate_number ?? 'Vehicle #'.$vehicle->id }}</p>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p class="text-muted mb-0 small">No vehicles assigned.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="section-card h-100 mb-0">
                                                            <div class="section-header mb-3">
                                                                <h5 class="section-title">Service Locations</h5>
                                                            </div>
                                                            @if($slot->facilities->count())
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    @foreach($slot->facilities as $facility)
                                                                        <div class="border rounded p-2 text-center bg-white" style="min-width: 160px; max-width: 220px;">
                                                                            <i class="fas fa-map-marker-alt text-danger mb-1 fs-5"></i>
                                                                            <p class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $facility->companyLocation->location_name ?? '-' }}</p>
                                                                            @if($facility->companyLocation && $facility->companyLocation->full_address)
                                                                                <span class="text-muted d-block mt-1" style="font-size: 13px;">{{ $facility->companyLocation->full_address }}</span>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <p class="text-muted mb-0 small">No service locations assigned.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Job Clocks --}}
                                                <div class="section-card">
                                                    <div class="section-header mb-3">
                                                        <h5 class="section-title">Job Clocks</h5>
                                                    </div>

                                                    @if($slot->clocks->count())
                                                        <table class="table table-hover equipment-report-table mb-3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <th>Interval</th>
                                                                    <th>By</th>
                                                                    <th>Hours</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($slot->clocks as $clock)
                                                                    <tr>
                                                                        <td>
                                                                            @php
                                                                                $badgeMap = [
                                                                                    'service'      => 'bg-primary',
                                                                                    'travel'       => 'bg-info text-dark',
                                                                                    'break'        => 'bg-warning text-dark',
                                                                                    'office work'  => 'bg-secondary',
                                                                                    'warehouse'    => 'bg-dark',
                                                                                    'training'     => 'bg-success',
                                                                                    'service prep' => 'bg-danger',
                                                                                    'umc'          => 'bg-purple text-white',
                                                                                ];
                                                                                $badge = $badgeMap[$clock->type] ?? 'bg-secondary';
                                                                            @endphp
                                                                            <span class="badge {{ $badge }}">{{ ucwords($clock->type) }}</span>
                                                                        </td>
                                                                        <td>{{ $clock->clocked_in_at ?? '-' }} — {{ $clock->clocked_out_at ?? 'Running' }}</td>
                                                                        <td>
                                                                            {{ $clock->clockedBy->name ?? '-' }}
                                                                            @if($clock->type === 'travel')
                                                                                @if($clock->vehicle)
                                                                                    <br><small class="text-muted"><i class="fas fa-car me-1"></i>{{ $clock->vehicle->name ?? $clock->vehicle->plate_number }}</small>
                                                                                @endif
                                                                                @if($clock->driver)
                                                                                    <br><small class="text-muted"><i class="fas fa-user me-1"></i>{{ $clock->driver->name }}</small>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <!-- <td>{{ $clock->clockedBy->name ?? '-' }}</td> -->
                                                                        <td>{{ $clock->clocked_hours ? $clock->clocked_hours . ' hrs' : '-' }}</td>
                                                                        <td>
                                                                            @if($clock->clocked_out_at)
                                                                                <span class="badge bg-success">Done</span>
                                                                            @else
                                                                                <span class="badge bg-warning text-dark">Running</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($canEdit)
                                                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editClockModal-{{ $clock->id }}">
                                                                                    <i class="fas fa-edit"></i> Edit
                                                                                </button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                    <!-- Edit Clock Modal -->
                                                                    <div class="modal fade" id="editClockModal-{{ $clock->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title" id="exampleModalLabel">Edit Job Clock</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{ route('admin.lead.service.clock.update', $clock->id) }}" method="POST" class="company-form">
                                                                                        @csrf
                                                                                        <div class="row mx-0">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label">Type</label>
                                                                                                    <span class="text-danger">*</span>
                                                                                                    <select class="form-select" name="type" required>
                                                                                                        @foreach(['service', 'travel', 'break', 'office work', 'warehouse', 'training', 'service prep', 'umc'] as $t)
                                                                                                            <option value="{{ $t }}" {{ $clock->type === $t ? 'selected' : '' }}>{{ ucwords($t) }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label">Clock In</label>
                                                                                                    <input type="datetime-local" class="form-control" name="clocked_in_at" value="{{ $clock->clocked_in_at ? \Carbon\Carbon::parse($clock->clocked_in_at)->format('Y-m-d\TH:i') : '' }}">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="form-label">Clock Out</label>
                                                                                                    <input type="datetime-local" class="form-control" name="clocked_out_at" value="{{ $clock->clocked_out_at ? \Carbon\Carbon::parse($clock->clocked_out_at)->format('Y-m-d\TH:i') : '' }}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer d-flex justify-content-between">
                                                                                            @if($canEdit)
                                                                                                <button type="button" class="btn btn-danger" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this job clock?')) document.getElementById('delete-clock-{{ $clock->id }}').submit();">Delete</button>
                                                                                            @else
                                                                                                <div></div>
                                                                                            @endif
                                                                                            <div>
                                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                                @if($canEdit)
                                                                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                    <form id="delete-clock-{{ $clock->id }}" action="{{ route('admin.lead.service.clock.delete', $clock->id) }}" method="POST" style="display: none;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-muted mb-3">No clock entries yet.</p>
                                                    @endif

                                                </div>

                                                {{-- Technicians 
                                                <div class="section-card">
                                                    <div class="section-header mb-3">
                                                        <h5 class="section-title">Technicians</h5>
                                                    </div>
                                                    @if($slot->staff->count())
                                                        <table class="table table-hover equipment-report-table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Technician</th>
                                                                    <th>Level / Role</th>
                                                                    <th>Hours</th>
                                                                    <th>Clocked In</th>
                                                                    <th>Clocked Out</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($slot->staff as $staffMember)
                                                                    <tr>
                                                                        <td>{{ $staffMember->user->name ?? '-' }}</td>
                                                                        <td>{{ $staffMember->user->training_level ?? '-' }}</td>
                                                                        <td>{{ $staffMember->slot_hours }}</td>
                                                                        <td>
                                                                            <span class="{{ $slot->clocked_in_at ? 'text-success fw-bold' : 'text-danger fw-bold' }}" style="font-size: 15px;">{{ $slot->clocked_in_at ? '✓' : '✗' }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="{{ $slot->clocked_out_at ? 'text-success fw-bold' : 'text-danger fw-bold' }}" style="font-size: 15px;">{{ $slot->clocked_out_at ? '✓' : '✗' }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p class="text-muted mb-0">No technicians assigned.</p>
                                                    @endif
                                                </div>
                                                --}}

                                                {{-- Stats --}}
                                                @php
                                                    $totalClocked  = $slot->clocks->sum('clocked_hours');
                                                    $serviceHours  = $slot->clocks->where('type', 'service')->sum('clocked_hours');
                                                    $travelHours   = $slot->clocks->where('type', 'travel')->sum('clocked_hours');
                                                    $breakHours    = $slot->clocks->where('type', 'break')->sum('clocked_hours');
                                                    $invoiceAmt    = $order->service->price_per_service ?? 0;
                                                    $totalCost     = $slot->staff->sum('cost');
                                                    $peoplePct     = $invoiceAmt > 0 ? round(($totalCost / $invoiceAmt) * 100) : 0;
                                                @endphp
                                                <div class="section-card">
                                                    <div class="section-header mb-3">
                                                        <h5 class="section-title">Stats</h5>
                                                    </div>
                                                    <!-- <div class="mt-3 pt-3 d-flex gap-4 flex-wrap">
                                                        <small class="text-muted">People Percentage: <strong>{{ $peoplePct }}%</strong></small>
                                                        <small class="text-muted">Invoice: <strong>${{ number_format($invoiceAmt, 2) }}</strong></small>
                                                        <small class="text-muted">Scheduled Hours: <strong>{{ $slot->scheduled_hours }}</strong></small>
                                                        <small class="text-muted">Total Clocked Hours: <strong>{{ $totalClocked }}</strong></small>
                                                        <small class="text-muted">Service Hours: <strong>{{ $serviceHours }}</strong></small>
                                                        <small class="text-muted">Travel Hours: <strong>{{ $travelHours }}</strong></small>
                                                        <small class="text-muted">Break Hours: <strong>{{ $breakHours }}</strong></small>
                                                        <small class="text-muted">Cost: <strong>${{ number_format($totalCost, 2) }}</strong></small>
                                                    </div> -->
                                                    @php
                                                        // Calculate Dynamic Summary
                                                        $travelDurationMinutes = 0;
                                                        $serviceDurationMinutes = 0;

                                                        foreach ($slot->clocks as $clock) {
                                                            if ($clock->clocked_in_at && $clock->clocked_out_at) {
                                                                $in = \Carbon\Carbon::parse($clock->clocked_in_at);
                                                                $out = \Carbon\Carbon::parse($clock->clocked_out_at);
                                                                $diff = $in->diffInMinutes($out);
                                                                
                                                                if (strtolower($clock->type) === 'travel') {
                                                                    $travelDurationMinutes += $diff;
                                                                } elseif (strtolower($clock->type) === 'service') {
                                                                    $serviceDurationMinutes += $diff;
                                                                }
                                                            }
                                                        }

                                                        $calcTravelHours = round($travelDurationMinutes / 60, 2);
                                                        $calcServiceHours = round($serviceDurationMinutes / 60, 2);

                                                        $techCount = $slot->staff->count();
                                                        
                                                        $totalTravelHours = $calcTravelHours * $techCount;
                                                        $totalServiceHours = $calcServiceHours * $techCount;

                                                        $travelPrice = $totalTravelHours * 25;
                                                        
                                                        // Service Price = Invoice Amount ÷ Estimated Cost
                                                        $servicePrice = $totalCost > 0 ? ($invoiceAmt / $totalCost) : 0;
                                                    @endphp

                                                    <div class="mt-4 row">
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover equipment-report-table bg-white">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Calendar Slot</th>
                                                                            <th class="text-end">Travel Bill</th>
                                                                            <th class="text-end">Service Bill</th>
                                                                            <th class="text-end">Tech Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('m/d/y H:i') }}</td>
                                                                            <td class="text-end">{{ number_format($calcTravelHours, 2) }}</td>
                                                                            <td class="text-end">{{ number_format($calcServiceHours, 2) }}</td>
                                                                            <td class="text-end">{{ number_format($techCount, 2) }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover equipment-report-table bg-white">
                                                                    <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                            <th class="text-end">Hours</th>
                                                                            <th class="text-end">Price</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Total Travel</td>
                                                                            <td class="text-end">{{ number_format($totalTravelHours, 2) }}</td>
                                                                            <td class="text-end">{{ number_format($travelPrice, 2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Total Service</td>
                                                                            <td class="text-end">{{ number_format($totalServiceHours, 2) }}</td>
                                                                            <td class="text-end">{{ number_format($servicePrice, 2) }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- JobClock Audit Log --}}
                                                <div class="section-card mt-4">
                                                    <div class="section-header mb-3">
                                                        <h5 class="section-title">JobClock Audit Log</h5>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover equipment-report-table bg-white mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Action</th>
                                                                    <th>State</th>
                                                                    <th>Clock Type</th>
                                                                    <th>Leader</th>
                                                                    <th>Start</th>
                                                                    <th>End</th>
                                                                    <th>Changed By</th>
                                                                    <th>Changed On</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $auditLogs = \App\Models\JobClockAuditLog::with(['clock.clockedBy', 'user'])
                                                                        ->whereIn('slot_clock_id', $slot->clocks()->withTrashed()->pluck('id'))
                                                                        ->orderBy('created_at', 'desc')
                                                                        ->get();
                                                                @endphp
                                                                @forelse($auditLogs as $log)
                                                                    @if(strtolower($log->action) === 'edit' || strtolower($log->action) === 'update')
                                                                        <!-- New State -->
                                                                        <tr>
                                                                            <td>update</td>
                                                                            <td>new</td>
                                                                            <td>{{ ucwords($log->new_type) }}</td>
                                                                            <td>{{ $log->clock->clockedBy->name ?? 'N/A' }}</td>
                                                                            <td>{{ $log->new_clocked_in_at ? \Carbon\Carbon::parse($log->new_clocked_in_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->new_clocked_out_at ? \Carbon\Carbon::parse($log->new_clocked_out_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                                                        </tr>
                                                                        <!-- Old State -->
                                                                        <tr>
                                                                            <td>update</td>
                                                                            <td>old</td>
                                                                            <td>{{ ucwords($log->old_type) }}</td>
                                                                            <td>{{ $log->clock->clockedBy->name ?? 'N/A' }}</td>
                                                                            <td>{{ $log->old_clocked_in_at ? \Carbon\Carbon::parse($log->old_clocked_in_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->old_clocked_out_at ? \Carbon\Carbon::parse($log->old_clocked_out_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                                                        </tr>
                                                                    @elseif(strtolower($log->action) === 'delete')
                                                                        <!-- Deleted State -->
                                                                        <tr>
                                                                            <td>delete</td>
                                                                            <td>old</td>
                                                                            <td>{{ ucwords($log->old_type) }}</td>
                                                                            <td>{{ $log->clock->clockedBy->name ?? 'N/A' }}</td>
                                                                            <td>{{ $log->old_clocked_in_at ? \Carbon\Carbon::parse($log->old_clocked_in_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->old_clocked_out_at ? \Carbon\Carbon::parse($log->old_clocked_out_at)->format('Y-m-d H:i') : '' }}</td>
                                                                            <td>{{ $log->user->name ?? 'System' }}</td>
                                                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="8" class="text-center text-muted py-3">No audit logs found.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @else
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <p class="text-center text-muted mb-0">No confirmed slots found. Confirm slots in the Confirmations tab first.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                            <!-- Employee Performance Tab -->
                            <div class="tab-pane fade" id="employee-performance" role="tabpanel"
                                aria-labelledby="employee-performance-tab">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Employee Performance Records</h5>
                                            </div>

                                            <!-- Existing Performance Records -->
                                            @if($order->employeePerformances->count())
                                                <div class="mb-4">
                                                    <h6 class="mb-3">Recorded Performance Issues</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover equipment-report-table">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Employee</th>
                                                                    <th>Issue Type</th>
                                                                    <th>Recorded By</th>
                                                                    <th>Date Recorded</th>
                                                                    <th>Notes</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->employeePerformances as $performance)
                                                                    <tr>
                                                                        <td>
                                                                            <strong>{{ $performance->employee->name ?? 'N/A' }}</strong>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-warning text-dark">
                                                                                {{ $performance->issue->name ?? 'N/A' }}
                                                                            </span>
                                                                        </td>
                                                                        <td>{{ $performance->user->name ?? 'N/A' }}</td>
                                                                        <td>{{ $performance->created_at->format('M d, Y H:i') }}</td>
                                                                        <td>
                                                                            <small>{{ Str::limit($performance->notes, 50) }}</small>
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewPerformanceModal{{ $performance->id }}">
                                                                                View
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- View Detail Modal -->
                                                                    <div class="modal fade" id="viewPerformanceModal{{ $performance->id }}" tabindex="-1">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Performance Details</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p><strong>Employee:</strong> {{ $performance->employee->name }}</p>
                                                                                    <p><strong>Issue:</strong> {{ $performance->issue->name }}</p>
                                                                                    <p><strong>Recorded By:</strong> {{ $performance->user->name }}</p>
                                                                                    <p><strong>Date:</strong> {{ $performance->created_at->format('M d, Y H:i') }}</p>
                                                                                    <p><strong>Notes:</strong></p>
                                                                                    <p>{{ $performance->notes }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endif

                                            <!-- Add New Performance Record Form -->
                                            <div>
                                                <h6 class="mb-3">Record New Performance Issue</h6>
                                                <form id="employeePerformanceForm" class="employee-performance-form">
                                                    @csrf
                                                    <table class="table table-hover equipment-report-table">
                                                        <tbody>
                                                            <tr>
                                                                <th>Employee <span class="text-danger">*</span></th>
                                                                <td>
                                                                    <select class="form-select" name="employee_id" required>
                                                                        <option value="">Select Employee</option>
                                                                        @foreach($assignedEmployees as $employee)
                                                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Disciplinary Issue <span class="text-danger">*</span></th>
                                                                <td>
                                                                    <select class="form-select" name="disciplinary_issue_id" required>
                                                                        <option value="">Select Issue</option>
                                                                        @foreach($disciplinaryIssues as $issue)
                                                                            <option value="{{ $issue->id }}">{{ $issue->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="vertical-align: top;">Notes</th>
                                                                <td>
                                                                    <textarea class="form-control" name="notes" rows="5" placeholder="Enter performance notes here..."></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-start">
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Post Checklist Tab -->
                            <div class="tab-pane fade" id="post-checklist" role="tabpanel"
                                aria-labelledby="post-checklist-tab">

                                <!-- Consumables Section -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="section-title">Consumables (Post-Service Remaining Counts)</h5>
                                            </div>
                                            <form class="post-checklist-consumables-form" id="postChecklistConsumablesForm">
                                                @csrf
                                                <div class="table-responsive">
                                                    <table class="table table-hover equipment-report-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th class="text-center" style="width: 20%;">Pre-Service Qty</th>
                                                                <th class="text-center" style="width: 20%;">Post-Service Qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ([
                                                                'microfiber_bins' => 'Microfiber Bins',
                                                                'disposable_microfiber' => 'Disposable Microfiber (Count Packs, Not Cloths)',
                                                                'atp_swabs' => 'ATP Swabs',
                                                                'gallons_water' => 'Gallons of Water',
                                                                'gallons_d2' => 'Gallons of D2',
                                                                'bottles_oxivir' => 'Bottles of Oxivir Concentrate',
                                                                'bottles_shield' => 'Bottles of Shield Concentrate',
                                                                'gallons_opticide' => 'Gallons of Opticide',
                                                                'gallons_halomist' => 'Gallons of Halomist (Gallons in Halomist Units)',
                                                                'gallons_sterifab' => 'Gallons of Sterifab',
                                                                'boxes_gloves' => 'Boxes of Gloves',
                                                                'monster_mop_fibers' => 'Monster Mop Fibers'
                                                            ] as $key => $label)
                                                                <tr>
                                                                    <td class="align-middle fw-semibold" style="width: 60%;">{{ $label }}</td>
                                                                    <td class="align-middle text-center font-monospace" style="font-size: 14px; background-color: #fdfaf2; color: #b58900; font-weight: bold;">
                                                                        {{ floatval($order->pre_checklist_consumables[$key] ?? 0) }}
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" step="any" min="0" 
                                                                            name="post_checklist_consumables[{{ $key }}]" 
                                                                            class="form-control form-control-sm text-center" 
                                                                            value="{{ $order->post_checklist_consumables[$key] ?? 0 }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-primary btn-sm save-post-consumables-btn">
                                                        <i class="fas fa-save me-1"></i> Save Post-Service Consumables
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Plan Debrief Section -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Plan Debrief <span style="font-size: 14px; font-weight: 400;">(Debrief Required: NO(48 hours in advance))</span></h5>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted" style="font-size: 13px;">Debrief your plan here.</label>
                                                <ul style="font-size: 13px; color: #555; line-height: 1.8; margin-left: 15px;">
                                                    <li>Outline how your plan went. What worked, what didn't.</li>
                                                    <li>Identify any extra areas you were asked to do.</li>
                                                    <li>List any issues with equipment, vehicles, or other resources.</li>
                                                    <li>Any thoughts that should be considered on future plans.</li>
                                                    </ul>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-muted" style="font-weight: 500;">Here was your plan:</label>
                                                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px solid #dee2e6; margin-bottom: 15px;">
                                                    <p class="mb-0" style="font-size: 13px;">{{ $order->service_plan_narrative ?? 'No plan available yet.' }}</p>
                                                </div>
                                            </div>

                                            <form class="plan-debrief-form" id="planDebriefForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="plan_debrief" class="form-label">Debrief</label>
                                                    <textarea class="form-control" id="plan_debrief" name="plan_debrief" rows="10" placeholder="Enter your debrief here...">{{ $order->plan_debrief ?? '' }}</textarea>
                                                </div>

                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-primary btn-sm save-debrief-btn">
                                                        <i class="fas fa-save me-1"></i> Update Debrief
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /tab-content -->

                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="userSlotsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">User Weekly Schedule</h5>
                        <small class="text-muted" id="userSlotsWeek"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover equipment-report-table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Office</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Hours</th>
                            </tr>
                        </thead>
                        <tbody id="userSlotsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Travel Clock-In Modal --}}
<div class="modal fade" id="travelClockInModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clock In — Travel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.lead.service.clock_in') }}" method="POST">
                @csrf
                <input type="hidden" name="slot_id" id="travel_slot_id">
                <input type="hidden" name="type" value="travel">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select" name="vehicle_id" id="travel_vehicle_id" required>
                            <option value="">-- Select Vehicle --</option>
                            @foreach($allVehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">
                                    {{ $vehicle->name ?? $vehicle->plate_number ?? 'Vehicle #'.$vehicle->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Driver <span class="text-danger">*</span></label>
                        <select class="form-select" name="driver_user_id" id="travel_driver_id" required>
                            <option value="">-- Select Driver --</option>
                            @foreach($assignedDrivers as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-play-circle me-1"></i> Clock In — Travel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    // Toastr Notifications from Session
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if(session('error'))
        @if(str_contains(session('error'), 'booked') || str_contains(session('error'), 'conflict') || str_contains(session('error'), 'schedule'))
            Swal.fire({
                title: 'Schedule Conflict!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#0d6efd'
            });
        @else
            toastr.error("{{ session('error') }}");
        @endif
    @endif
    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    // Persist active tab in URL query parameters
    $(function() {
        function getQueryParam(name) {
            var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
            return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
        }

        function setQueryParam(params) {
            var url = new URL(window.location.href);
            for (var key in params) {
                if (params[key] === null) {
                    url.searchParams.delete(key);
                } else {
                    url.searchParams.set(key, params[key]);
                }
            }
            history.replaceState(null, null, url.pathname + url.search + url.hash);
        }

        var activeTab = getQueryParam('tab');
        var activeSubtab = getQueryParam('subtab');

        if (activeTab) {
            var tabBtn = $('[data-bs-target="#' + activeTab + '"], [href="#' + activeTab + '"]');
            if (tabBtn.length) {
                tabBtn.click();
            }
        }
        if (activeSubtab) {
            var subtabBtn = $('[data-bs-target="#' + activeSubtab + '"], [href="#' + activeSubtab + '"]');
            if (subtabBtn.length) {
                subtabBtn.click();
            }
        }

        $(document).on('shown.bs.tab', 'button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]', function(e) {
            var target = $(e.target).attr('data-bs-target') || $(e.target).attr('href');
            if (target) {
                var tabId = target.replace('#', '');
                var parentPane = $(e.target).closest('.tab-pane');
                if (parentPane.length) {
                    var parentTabId = parentPane.attr('id');
                    setQueryParam({
                        'tab': parentTabId,
                        'subtab': tabId
                    });
                } else {
                    setQueryParam({
                        'tab': tabId,
                        'subtab': null
                    });
                }
            }
        });
    });

    // Live Clock — update all .live-clock and .live-date elements
    function updateClock() {
        const now = new Date();

        let hours = now.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeStr = `${hours}:${minutes}:${seconds} ${ampm}`;

        const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
        const dateStr = now.toLocaleDateString('en-US', options);

        document.querySelectorAll('.live-clock').forEach(el => el.textContent = timeStr);
        document.querySelectorAll('.live-date').forEach(el => el.textContent = dateStr);
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Since Clock In — per slot
    function updateTimeSinceClockIn() {
        document.querySelectorAll('[data-clockin-time]').forEach(function(el) {
            const clockInTime = new Date(el.dataset.clockinTime);
            const now = new Date();
            const diff = now - clockInTime;

            const totalSeconds = Math.floor(diff / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            el.textContent = `${hours}h ${minutes}m ${seconds}s`;
        });
    }

    setInterval(updateTimeSinceClockIn, 1000);
    updateTimeSinceClockIn();

    $(document).on('click', '.view-user-slots', function () {
        let userId = $(this).data('user');
        let date   = $(this).data('date');

        $.get("{{ route('admin.lead.service.user.monthly_slots') }}", {
            user_id: userId,
            date: date
        }, function (res) {
            let html = '';

            if (res.slots.length === 0) {
                html = `<tr><td colspan="5" class="text-center">No bookings</td></tr>`;
            } else {
                res.slots.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.company}</td>
                            <td>${row.office}</td>
                            <td>${row.start_time}</td>
                            <td>${row.end_time}</td>
                            <td>${row.hours}</td>
                        </tr>
                    `;
                });
            }

            $('#userSlotsBody').html(html);
            $('#userSlotsWeek').text('Week: ' + res.week_range);
            $('#userSlotsTotalHours').text(res.total_hours);
            $('#userSlotsModal').modal('show');
        });
    });

    // ==============================
    // Save Service Plan Narrative
    // ==============================
    $(document).on('submit', '.service-plan-form', function(e) {
        e.preventDefault();
        const form = $(this);
        const orderId = {{ $order->id }};
        const narrative = $('textarea[name="service_plan_narrative"]').val();

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                service_plan_narrative: narrative
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Service plan narrative saved successfully!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save service plan narrative');
            }
        });
    });

    // ==============================
    // Save Sales Narrative
    // ==============================
    $(document).on('submit', '.sales-narrative-form', function(e) {
        e.preventDefault();
        const orderId = {{ $order->id }};
        const narrative = $('textarea[name="sales_narrative"]').val();

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sales_narrative: narrative
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Sales narrative saved successfully!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save sales narrative');
            }
        });
    });

    // ==============================
    // Save Plan Debrief
    // ==============================
    $(document).on('submit', '.plan-debrief-form', function(e) {
        e.preventDefault();
        const orderId = {{ $order->id }};
        const debrief = $('textarea[name="plan_debrief"]').val();

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                plan_debrief: debrief
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Plan debrief saved successfully!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save plan debrief');
            }
        });
    });

    // ==============================
    // Save Employee Performance
    // ==============================
    $(document).on('submit', '.employee-performance-form', function(e) {
        e.preventDefault();
        const form = $(this);
        const orderId = {{ $order->id }};
        const employeeId = form.find('select[name="employee_id"]').val();
        const disciplinaryIssueId = form.find('select[name="disciplinary_issue_id"]').val();
        const notes = form.find('textarea[name="notes"]').val();

        console.log('Form submitted:', {
            employeeId: employeeId,
            disciplinaryIssueId: disciplinaryIssueId,
            notes: notes,
            orderId: orderId
        });

        if (!employeeId) {
            toastr.error('Please select an employee');
            return;
        }

        if (!disciplinaryIssueId) {
            toastr.error('Please select a disciplinary issue');
            return;
        }

        $.ajax({
            url: "{{ route('admin.lead.service.order.employee_performance.store', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                employee_id: employeeId,
                disciplinary_issue_id: disciplinaryIssueId,
                notes: notes
            },
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    toastr.success('Employee performance recorded successfully!');
                    form[0].reset();
                    // Reload the page to show the new record
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                console.log('Error response:', xhr.responseJSON);
                const errors = xhr.responseJSON?.errors || {};
                if (Object.keys(errors).length > 0) {
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Failed to record employee performance');
                }
            }
        });
    });

    // ==============================
    // Toggle Plan Review Status
    // ==============================
    $(document).on('click', '.btn-plan-review-toggle', function(e) {
        e.preventDefault();
        const btn = $(this);
        const orderId = btn.data('order-id');
        const currentStatus = $('.badge-plan-review-status').text().trim();
        const newStatus = currentStatus === 'REVIEWED' ? 'PENDING' : 'REVIEWED';

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                plan_review_status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    // Update badge
                    const badgeClass = newStatus === 'REVIEWED' ? 'bg-success' : 'bg-warning';
                    $('.badge-plan-review-status')
                        .removeClass('bg-success bg-warning')
                        .addClass(badgeClass)
                        .text(newStatus);

                    // Update button styling and text
                    const btnHtml = newStatus === 'REVIEWED'
                        ? '<i class="bi bi-arrow-counterclockwise"></i> Undo Review'
                        : '<i class="bi bi-check-circle"></i> Review Done';

                    btn.removeClass('btn-success btn-outline-success')
                        .addClass(newStatus === 'REVIEWED' ? 'btn-success' : 'btn-outline-success')
                        .html(btnHtml);

                    toastr.success(newStatus === 'REVIEWED' ? 'Plan marked as reviewed!' : 'Review status reset!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to update plan review status');
            }
        });
    });

    // ==============================
    // Save Pre-Service Consumables
    // ==============================
    $(document).on('submit', '#preChecklistConsumablesForm', function(e) {
        e.preventDefault();
        const form = $(this);
        const orderId = {{ $order->id }};

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('Pre-service consumables saved successfully!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save pre-service consumables');
            }
        });
    });

    // ==============================
    // Save Post-Service Consumables
    // ==============================
    $(document).on('submit', '#postChecklistConsumablesForm', function(e) {
        e.preventDefault();
        const form = $(this);
        const orderId = {{ $order->id }};

        $.ajax({
            url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('Post-service consumables saved successfully!');
                } else {
                    toastr.error(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save post-service consumables');
            }
        });
    });

    // ==============================
    // Travel Clock-In — show modal
    // ==============================
    $(document).on('submit', '.clock-in-form', function(e) {
        const selectedType = $(this).find('.clock-type-select').val();

        if (selectedType === 'travel') {
            e.preventDefault();
            const slotId = $(this).find('.clock-in-slot-id').val();
            $('#travel_slot_id').val(slotId);
            
            // Rebuild the vehicle select dynamically with only this slot's assigned vehicles
            const vehicles = $(this).data('vehicles') || [];
            const vehicleSelect = $('#travel_vehicle_id');
            vehicleSelect.empty();
            vehicleSelect.append('<option value="">-- Select Vehicle --</option>');
            
            vehicles.forEach(function (v) {
                vehicleSelect.append(`<option value="${v.id}">${v.name}</option>`);
            });

            $('#travel_driver_id').val('');
            $('#travelClockInModal').modal('show');
        }
        // All other types submit normally
    });

    // ==========================================
    // Dynamic Invoice Item Management (Page-based)
    // ==========================================
    let itemIndex = $('#invoice-items-container .invoice-item-row').length;

    function calculateInvoiceTotals() {
        let grandTotal = 0;
        $('#invoice-items-container .invoice-item-row').each(function() {
            const row = $(this);
            const qty = parseFloat(row.find('.item-qty').val()) || 0;
            const price = parseFloat(row.find('.item-price').val()) || 0;
            const total = qty * price;
            row.find('.item-total').text(total.toFixed(2));
            grandTotal += total;
        });

        const formattedTotal = grandTotal.toFixed(2);
        $('#invoice-grand-total').text(formattedTotal);
        $('#invoice-header-total').text(formattedTotal);
    }

    // Add row
    $(document).on('click', '#add-invoice-item-btn', function() {
        const rowHtml = `
            <div class="row align-items-center mb-2 g-2 invoice-item-row" data-index="${itemIndex}">
                <div class="col-md-4">
                    <select name="items[${itemIndex}][type]" class="form-select form-select-sm item-type">
                        <option value="New Line">New Line</option>
                        <option value="GermBlast Disinfection Services">GermBlast Disinfection Services</option>
                        <option value="GermBlast Response Service">GermBlast Response Service</option>
                        <option value="GermBlast Response Service under contract">GermBlast Response Service under contract</option>
                        <option value="Service Supplies">Service Supplies</option>
                        <option value="COVID Travel Manhours">COVID Travel Manhours</option>
                        <option value="COVID Service Manhours">COVID Service Manhours</option>
                        <option value="modified GermBlast Response Service">modified GermBlast Response Service</option>
                        <option value="GermBlast Biological Response Service COVID-19">GermBlast Biological Response Service COVID-19</option>
                        <option value="GermBlast Flat Fee">GermBlast Flat Fee</option>
                        <option value="GBS - Flooring">GBS - Flooring</option>
                        <option value="GBS-BONA Flooring Service">GBS-BONA Flooring Service</option>
                        <option value="Discount">Discount</option>
                        <option value="Sales Tax">Sales Tax</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Qty</span>
                        <input type="number" name="items[${itemIndex}][qty]" class="form-control item-qty" value="1" min="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>
                        <input type="number" name="items[${itemIndex}][price]" class="form-control item-price" value="0.00" min="0" step="0.01">
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="small">Total = $<strong><span class="item-total">0.00</span></strong></span>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="button" class="btn btn-sm btn-danger delete-item-btn">Delete Line</button>
                </div>
            </div>
        `;
        $('#invoice-items-container').append(rowHtml);
        itemIndex++;
        calculateInvoiceTotals();
    });

    // Delete row
    $(document).on('click', '.delete-item-btn', function() {
        const rowsCount = $('#invoice-items-container .invoice-item-row').length;
        if (rowsCount <= 1) {
            toastr.warning('Invoice must have at least one line item.');
            return;
        }
        $(this).closest('.invoice-item-row').remove();
        calculateInvoiceTotals();
    });

    // Listeners for keyup/change on qty and price
    $(document).on('input change', '.invoice-item-row .item-qty, .invoice-item-row .item-price', function() {
        calculateInvoiceTotals();
    });

    // Share Invoice via sweetalert & AJAX
    $(document).on('click', '.share-invoice-btn', function() {
        const shareUrl = $(this).data('url');
        
        Swal.fire({
            title: 'Share Invoice?',
            text: 'Are you sure you want to send the invoice email with the PDF attached to the customer?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Send Email',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: shareUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json'
                }).done(function(response) {
                    if (response && response.success === false) {
                        Swal.showValidationMessage(
                            `Request failed: ${response.message}`
                        );
                    }
                    return response;
                }).fail(function(xhr) {
                    let errMsg = 'Failed to share invoice.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.showValidationMessage(
                        `Request failed: ${errMsg}`
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value && result.value.success) {
                Swal.fire({
                    title: 'Shared!',
                    text: 'Invoice email with PDF attachment has been sent to the customer.',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            }
        });
    });
    // ==========================================
    // Dynamic Inventory Breakdown Calculation
    // ==========================================
    function calculateInventoryBreakdown() {
        let total = 0;
        $('.consumable-price').each(function() {
            const qty = parseFloat($(this).data('qty')) || 0;
            const price = parseFloat($(this).val()) || 0;
            const subtotal = qty * price;
            
            // Update individual row text
            $(this).closest('tr').find('.consumable-value-text').text('$' + subtotal.toFixed(2));
            
            total += subtotal;
        });

        const formattedTotal = total.toFixed(2);
        $('#inventory-total-value').text(formattedTotal);
        $('#summary-service-supplies').text(formattedTotal);
    }

    $(document).on('input', '.consumable-price', function() {
        calculateInventoryBreakdown();
    });

    $(document).on('submit', '.form-audit-this', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),

            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
            },

            success: function(response) {
                toastr.success(response.message || 'Slot marked for audit successfully!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },

            error: function() {
                toastr.error('Something went wrong while marking for audit.');
                $submitBtn.prop('disabled', false).text('Audit this');
            }
        });
    });

    $(document).on('submit', '.form-cancel-audit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),

            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
            },

            success: function(response) {
                toastr.success(response.message || 'Audit cancelled successfully!');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },

            error: function() {
                toastr.error('Something went wrong while cancelling audit.');
                $submitBtn.prop('disabled', false).text('Cancel Audit');
            }
        });
    });

</script>
@endpush



