@extends('admin.includes.layout')

@section('title', 'Service Dashboard')

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

        /* Custom Premium Status Badges */
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

        .status-pill-confirmed {
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
                                <h3 class="mb-1">SERVICE DASHBOARD<span
                                        style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">Order ID:
                                    {{ $order->order_no ?? 'N/A' }}
                                </p>
                                
                                <div class="d-flex align-items-center gap-2 mt-2 mb-3">
                                    <span class="text-muted fw-semibold" style="font-size: 14px;">Order Status:</span>
                                    <span class="status-pill status-pill-{{ $order->status ?? 'pending' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}
                                    </span>
                                </div>
                            </div>
                            <div class="right-part-sec">
                                <div>
                                    <a class="btn btn-export"
                                        href="{{ route('admin.lead.service.fulfill_order', $order->id) }}">
                                        ADMIN VIEW
                                    </a>

                                    <!-- <a class="btn btn-export"
                                                href="{{ route('admin.company.show', $order->service->lead->company->id) }}">
                                                TO CUSTOMER
                                            </a> -->
                                </div>
                            </div>
                        </div>

                        <!-- TABS -->
                        <div class="navbar-tabs px-4">
                            <nav class="nav nav-tabs mb-0 flex-nowrap" id="fulfillOrderTabs" role="tablist">
                                <button class="nav-link active" id="equipment-loadout-tab" data-bs-toggle="tab"
                                    data-bs-target="#equipment-loadout" type="button" role="tab"
                                    aria-controls="equipment-loadout" aria-selected="true">
                                    Equipment Loadout
                                </button>
                                <button class="nav-link" id="pre-checklist-tab" data-bs-toggle="tab"
                                    data-bs-target="#pre-checklist" type="button" role="tab" aria-controls="pre-checklist"
                                    aria-selected="false">
                                    Pre Checklist
                                </button>
                                <button class="nav-link" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary"
                                    type="button" role="tab" aria-controls="summary" aria-selected="false">
                                    Summary
                                </button>
                                <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule"
                                    type="button" role="tab" aria-controls="schedule" aria-selected="false">
                                    Schedule
                                </button>
                                <button class="nav-link" id="atp-tab" data-bs-toggle="tab" data-bs-target="#atp"
                                    type="button" role="tab" aria-controls="atp" aria-selected="false">
                                    ATP
                                </button>
                                <button class="nav-link" id="room-record-tab" data-bs-toggle="tab"
                                    data-bs-target="#room-record" type="button" role="tab" aria-controls="room-record"
                                    aria-selected="false">
                                    Room Record
                                </button>
                                <button class="nav-link" id="equipment-tab" data-bs-toggle="tab" data-bs-target="#equipment"
                                    type="button" role="tab" aria-controls="equipment" aria-selected="false">
                                    Equipment
                                </button>
                                <button class="nav-link" id="clean-patch-tab" data-bs-toggle="tab"
                                    data-bs-target="#clean-patch" type="button" role="tab" aria-controls="clean-patch"
                                    aria-selected="false">
                                    Clean Patch
                                </button>
                                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes"
                                    type="button" role="tab" aria-controls="notes" aria-selected="false">
                                    Notes
                                </button>
                                <button class="nav-link" id="employee-performance-tab" data-bs-toggle="tab"
                                    data-bs-target="#employee-performance" type="button" role="tab"
                                    aria-controls="employee-performance" aria-selected="false">
                                    Employee Performance
                                </button>
                                <button class="nav-link" id="post-checklist-tab" data-bs-toggle="tab"
                                    data-bs-target="#post-checklist" type="button" role="tab" aria-controls="post-checklist"
                                    aria-selected="false">
                                    Post Checklist
                                </button>
                            </nav>
                        </div>

                        <hr class="mb-4 mt-0" style="opacity: 0.1;">

                        <!-- Tab Content Section -->
                        <div class="tab-content px-4" id="fulfillOrderTabContent">


                            <!-- Equipment Loadout Tab -->
                            <div class="tab-pane fade show active" id="equipment-loadout" role="tabpanel"
                                aria-labelledby="equipment-loadout-tab">

                                @forelse($order->orderSlots as $slot)
                                    <div class="section-card mb-4">
                                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="section-title mb-0">Slot #{{ $loop->iteration }} Details</h5>
                                        </div>

                                        {{-- Slot Details Table matching confirmations slots display --}}
                                        <table class="table table-hover equipment-report-table mb-3">
                                            <tbody>
                                                <tr>
                                                    <th>Start Time</th>
                                                    <td>{{ $slot->scheduled_start_time ? \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                                                    <th>End Time</th>
                                                    <td>{{ $slot->scheduled_end_time ? \Carbon\Carbon::parse($slot->scheduled_end_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Arrival Time</th>
                                                    <td>{{ $slot->scheduled_arrival_time ?? 'N/A' }}</td>
                                                    <th>Office</th>
                                                    <td>{{ $slot->office->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Hours</th>
                                                    <td>{{ $slot->scheduled_hours ?? 0 }} hrs</td>
                                                    <th>Meet</th>
                                                    <td>{{ ucfirst($slot->meet) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Overnight</th>
                                                    <td>{{ $slot->overnight ? 'Yes' : 'No' }}</td>
                                                    <th>Recurrence</th>
                                                    <td>{{ $slot->scheduled_recurrence_rule }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Barcode Assignment Form for this specific slot -->
                                        <form action="{{ route('admin.lead.service.slot.assign_equipment', $slot->id) }}" method="POST" class="mb-0">
                                            @csrf
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="fas fa-barcode"></i>
                                                        </span>
                                                        <input type="text" name="barcode" class="form-control border-start-0 bg-light" placeholder="Scan or enter barcode for Slot #{{ $loop->iteration }}..." required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-export">
                                                        Assign to Slot #{{ $loop->iteration }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <div class="section-card">
                                        <div class="text-center text-muted py-5">
                                            <i class="fas fa-calendar-times mb-3" style="font-size: 40px; color: #cbd5e1;"></i>
                                            <p class="mb-0 fw-semibold">No confirmed slots found. Confirm slots first.</p>
                                        </div>
                                    </div>
                                @endforelse

                                {{-- A SINGLE equipment-report-table for the whole equipment loadout section --}}
                                @if($order->orderSlots->isNotEmpty())
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Slot</th>
                                                        <th>Barcode</th>
                                                        <th>Serial Number</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $hasAnyEquipment = false; @endphp
                                                    @foreach($order->orderSlots as $slot)
                                                        @foreach($slot->equipments as $equipment)
                                                            @php $hasAnyEquipment = true; @endphp
                                                            <tr>
                                                                <td class="fw-semibold text-primary">Slot #{{ $loop->parent->iteration }}</td>
                                                                <td class="fw-semibold text-dark">{{ $equipment->barcode }}</td>
                                                                <td>{{ $equipment->serial_number ?? 'N/A' }}</td>
                                                                <td>{{ $equipment->type->name ?? 'N/A' }}</td>
                                                                <td>
                                                                    <span class="badge bg-warning text-dark fw-semibold" style="text-transform: uppercase; font-size: 11px;">
                                                                        {{ config('mapping.equipment_status.' . $equipment->status, $equipment->status) }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <form action="{{ route('admin.lead.service.slot.remove_equipment', [$slot->id, $equipment->id]) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" style="border-radius: 8px; font-weight: 600;">
                                                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                    @if(!$hasAnyEquipment)
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted py-4">
                                                                No equipment assigned to any slot yet. Scan a barcode in a slot above to assign.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Pre Checklist Tab -->
                            <div class="tab-pane fade" id="pre-checklist" role="tabpanel"
                                aria-labelledby="pre-checklist-tab">
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
                                
                                {{-- Summary Tab --}}
                                 <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                                     <div class="row">
                                         <!-- Left Card: Lead Summary Details & Form -->
                                         <div class="col-md-6">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Client Details</h5>
                                                 </div>
                                                 <div class="table-responsive">
                                                     <table class="table table-hover equipment-report-table mb-4">
                                                         <tbody>
                                                             <tr>
                                                                 <th>Company</th>
                                                                 <td>{{ $order->service->lead->company->name ?? $order->service->lead->name ?? 'N/A' }}</td>
                                                                 <th>Client ID</th>
                                                                 <td>{{ $order->service->lead->company->id ?? 'N/A' }}</td>
                                                             </tr>
                                                             <tr>
                                                                 <th>Status</th>
                                                                 <td>{{ ucfirst($order->status ?? 'N/A') }} {{ $order->order_no ?? '' }}</td>
                                                                 <th>Notes</th>
                                                                 <td>{{ $order->service_plan_narrative ?? ($order->sales_narrative ?? 'No service notes documented.') }}</td>
                                                             </tr>
                                                         </tbody>
                                                     </table>
                                                 </div>

                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Add Hotel Details</h5>
                                                 </div>
                                                 <form id="hotel-details-form" action="{{ route('admin.lead.service.order.hotel.save', $order->id) }}" method="POST" class="mb-0">
                                                     @csrf
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Hotel Name</label>
                                                         <input type="text" name="hotel_name" class="form-control bg-light" placeholder="Hotel Name" required>
                                                     </div>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Full Address</label>
                                                         <input type="text" name="full_address" class="form-control bg-light" placeholder="Full Address">
                                                     </div>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Confirmation Number</label>
                                                         <input type="text" name="confirmation_no" class="form-control bg-light" placeholder="Confirmation Number">
                                                     </div>
                                                     <div class="row">
                                                         <div class="col-md-6 mb-3">
                                                             <label class="form-label fw-semibold">Check In</label>
                                                             <input type="date" name="check_in" class="form-control bg-light">
                                                         </div>
                                                         <div class="col-md-6 mb-3">
                                                             <label class="form-label fw-semibold">Check Out</label>
                                                             <input type="date" name="check_out" class="form-control bg-light">
                                                         </div>
                                                     </div>
                                                     <button type="submit" class="btn btn-export mt-2">
                                                         <i class="fa-solid fa-circle-check me-1"></i> Save
                                                     </button>
                                                 </form>
                                             </div>
                                         </div>

                                         <!-- Right Card: Hotel Information List -->
                                         <div class="col-md-6">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Hotel Information</h5>
                                                 </div>

                                                 <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                                                     <table class="table equipment-report-table mb-0">
                                                         <thead>
                                                             <tr>
                                                                 <th>Dates</th>
                                                                 <th>Hotel Name</th>
                                                                 <th>Address</th>
                                                                 <th>Confirmation #</th>
                                                                 <th class="text-end">Actions</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody id="hotel-list-container">
                                                             @php $hotels = $order->hotel_details ?? []; @endphp
                                                             @forelse($hotels as $hotel)
                                                                 @php
                                                                     $checkIn = !empty($hotel['check_in']) ? \Carbon\Carbon::parse($hotel['check_in'])->format('m-d') : '';
                                                                     $checkOut = !empty($hotel['check_out']) ? \Carbon\Carbon::parse($hotel['check_out'])->format('m-d') : '';
                                                                 @endphp
                                                                 <tr class="align-middle">
                                                                     <td class="fw-semibold text-secondary" style="font-size: 13px;">
                                                                         {{ $checkIn && $checkOut ? "$checkIn - $checkOut" : 'No Dates' }}
                                                                     </td>
                                                                     <td class="fw-bold text-dark" style="font-size: 14px;">
                                                                         {{ $hotel['hotel_name'] ?? 'N/A' }}
                                                                     </td>
                                                                     <td style="font-size: 13px;">
                                                                         {{ $hotel['full_address'] ?? 'N/A' }}
                                                                     </td>
                                                                     <td style="font-size: 13px;">
                                                                         {{ $hotel['confirmation_no'] ?? 'N/A' }}
                                                                     </td>
                                                                     <td class="text-end">
                                                                         <button type="button" class="btn-delete-hotel btn btn-sm btn-link text-danger p-0" data-id="{{ $hotel['id'] ?? '' }}">
                                                                             <i class="fa-solid fa-trash fs-5"></i>
                                                                         </button>
                                                                     </td>
                                                                 </tr>
                                                             @empty
                                                                 <tr>
                                                                     <td colspan="5" class="text-center py-5 text-secondary">
                                                                         <i class="fa-solid fa-hotel fs-1 mb-2 d-block text-muted" style="font-size: 40px;"></i>
                                                                         No hotel details have been documented yet.
                                                                     </td>
                                                                 </tr>
                                                             @endforelse
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                <!-- Schedule Tab -->
                                <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">

                                    @php $confirmedSlots = $order->orderSlots->where('is_confirmed', true); @endphp

                                    @if($confirmedSlots->count())

                                        <div class="section-card mt-3">
                                            <div class="navbar-tabs overflow-auto">
                                                <nav class="nav nav-tabs mb-3 flex-nowrap" id="scheduleSlotTabs" role="tablist">
                                                    @foreach ($confirmedSlots as $slot)
                                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                            id="schedule-slot-{{ $slot->id }}-tab" data-bs-toggle="tab"
                                                            data-bs-target="#schedule-slot-{{ $slot->id }}"
                                                            type="button" role="tab">
                                                            Slot #{{ $loop->iteration }}
                                                            <small
                                                                class="text-muted ms-1">{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d') }}</small>
                                                        </button>
                                                    @endforeach
                                                </nav>
                                            </div>

                                            <div class="tab-content" id="scheduleSlotTabContent">
                                                @foreach($confirmedSlots as $slot)
                                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                        id="schedule-slot-{{ $slot->id }}"
                                                        role="tabpanel">

                                                        {{-- Basic Details --}}
                                                        <div class="border rounded p-3 mb-3 bg-light">
                                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                                <div>
                                                                    <p class="mb-1"><strong>Office:</strong> {{ $slot->office->name ?? 'N/A' }}</p>
                                                                    <p class="mb-1"><strong>Interval:</strong> {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}</p>
                                                                    <p class="mb-1"><strong>Hours:</strong> {{ $slot->scheduled_hours }}</p>
                                                                    <p class="mb-1"><strong>Arrival Time:</strong> {{ $slot->scheduled_arrival_time }}</p>
                                                                </div>
                                                                <div class="border rounded p-2 bg-white d-flex align-items-center gap-2">
                                                                    <span class="text-muted fw-semibold" style="font-size: 13px;">Slot Status:</span>
                                                                    <span class="status-pill status-pill-{{ $slot->status ?? 'pending' }}" style="font-size: 11px !important; padding: 4px 10px !important;">
                                                                        {{ ucfirst(str_replace('_', ' ', $slot->status ?? 'pending')) }}
                                                                    </span>
                                                                </div>
                                                            </div>
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
                                                                                    <p class="mb-0 small fw-semibold">{{ $vehicle->name ?? $vehicle->plate_number ?? 'Vehicle #' . $vehicle->id }}</p>
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
                                                                                <div class="border rounded p-2 text-center bg-white" style="min-width: 160px;">
                                                                                    <i class="fas fa-map-marker-alt text-danger mb-1"></i>
                                                                                    <p class="mb-0 small fw-semibold">{{ $facility->companyLocation->location_name ?? '-' }}</p>
                                                                                    @if(!empty($facility->companyLocation->address))
                                                                                        <small class="text-muted d-block mt-1" style="font-size: 11px;">{{ $facility->companyLocation->address }}</small>
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
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($slot->clocks as $clock)
                                                                            <tr>
                                                                                <td>
                                                                                    @php
                                                                                        $badgeMap = [
                                                                                            'service' => 'bg-primary',
                                                                                            'travel' => 'bg-info text-dark',
                                                                                            'break' => 'bg-warning text-dark',
                                                                                            'office work' => 'bg-secondary',
                                                                                            'warehouse' => 'bg-dark',
                                                                                            'training' => 'bg-success',
                                                                                            'service prep' => 'bg-danger',
                                                                                            'umc' => 'bg-purple text-white',
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
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                <p class="text-muted mb-3">No clock entries yet.</p>
                                                            @endif

                                                            {{-- Active / Clock-In Form --}}
                                                            @php $runningClock = $slot->clocks->whereNull('clocked_out_at')->first(); @endphp

                                                            @if($runningClock)
                                                                <div class="border rounded p-3 bg-light mb-3">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div>
                                                                            @php $badge = $badgeMap[$runningClock->type] ?? 'bg-secondary'; @endphp
                                                                            <span class="badge {{ $badge }} fs-6 px-3 py-2">{{ ucwords($runningClock->type) }}</span>
                                                                            <span class="ms-2 text-muted small">Started: {{ $runningClock->clocked_in_at }}</span>
                                                                        </div>
                                                                        <small class="text-muted">
                                                                            ⏱ Since Clock In:
                                                                            <strong><span data-clockin-time="{{ $runningClock->clocked_in_at }}"></span></strong>
                                                                        </small>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end">
                                                                        <form action="{{ route('admin.lead.service.clock_out') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                                                            <input type="hidden" name="type" value="{{ $runningClock->type }}">
                                                                            <button type="submit" class="btn btn-danger">
                                                                                <i class="fas fa-stop-circle me-1"></i>
                                                                                Clock Out — {{ ucwords($runningClock->type) }}
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <form action="{{ route('admin.lead.service.clock_in') }}" method="POST" class="clock-in-form" data-vehicles="{{ json_encode($slot->vehicles->map(fn($v) => ['id' => $v->id, 'name' => $v->name ?? $v->plate_number ?? 'Vehicle #'.$v->id])) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="slot_id" value="{{ $slot->id }}" class="clock-in-slot-id">
                                                                    <div class="d-flex gap-2 align-items-center">
                                                                        <select class="form-select clock-type-select" name="type" required>
                                                                            <option value="">-- Select Type --</option>
                                                                            <option value="service">Service</option>
                                                                            <option value="travel">Travel</option>
                                                                            <option value="break">Break</option>
                                                                            <option value="office work">Office Work</option>
                                                                            <option value="warehouse">Warehouse</option>
                                                                            <option value="training">Training</option>
                                                                            <option value="service prep">Service Prep</option>
                                                                            <option value="umc">UMC</option>
                                                                        </select>
                                                                        <button type="submit" class="btn btn-success px-4 text-nowrap">
                                                                            <i class="fas fa-play-circle me-1"></i> Clock In
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        </div>

                                                        {{-- Technicians --}}
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

                                <div class="tab-pane fade" id="atp" role="tabpanel" aria-labelledby="atp-tab">
                                     <div class="row">
                                         <!-- Left Column: ATP Instructions & Form -->
                                         <div class="col-md-6">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">ATP Information</h5>
                                                 </div>
                                                 <p class="text-muted mb-4" style="font-size: 13px; line-height: 1.5;">
                                                     ATP Notes: Take 8 pre-service samples and 2 post-service samples total. Divide this number appropriately across facilities, departments, services (if applicable), etc
                                                 </p>

                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Add ATP Details</h5>
                                                 </div>
                                                 <form id="atp-details-form" action="{{ route('admin.lead.service.order.atp.save', $order->id) }}" method="POST" class="mb-0">
                                                     @csrf
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Description</label>
                                                         <input type="text" name="description" class="form-control bg-light" placeholder="Description" required>
                                                     </div>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Result</label>
                                                         <input type="text" name="result" class="form-control bg-light" placeholder="Result" required>
                                                     </div>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">ATP Type</label>
                                                         <select name="atp_type" class="form-select bg-light" required>
                                                             <option value="pre">Pre</option>
                                                             <option value="post">Post</option>
                                                         </select>
                                                     </div>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold">Service Location (Facility)</label>
                                                         @php
                                                             $uniqueLocations = collect();
                                                             foreach($order->orderSlots as $slot) {
                                                                 foreach($slot->facilities as $fac) {
                                                                     if ($fac->companyLocation) {
                                                                         $uniqueLocations->put($fac->companyLocation->id, $fac->companyLocation->location_name);
                                                                     }
                                                                 }
                                                             }
                                                         @endphp
                                                         <select name="facility_id" class="form-select bg-light" required>
                                                             <option value="N/A">N/A</option>
                                                             @foreach($uniqueLocations as $locId => $locName)
                                                                 <option value="{{ $locId }}">{{ $locName }}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                     <button type="submit" class="btn btn-export mt-2">
                                                         Add ATP
                                                     </button>
                                                 </form>
                                             </div>
                                         </div>

                                         <!-- Right Column: ATP Results List -->
                                         <div class="col-md-6">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">ATP Results</h5>
                                                 </div>
                                                 @php 
                                                     $atpDetails = $order->atp_details ?? []; 
                                                     $totalSamples = count($atpDetails);
                                                     $preSamples = collect($atpDetails)->where('atp_type', 'pre')->count();
                                                     $postSamples = collect($atpDetails)->where('atp_type', 'post')->count();
                                                 @endphp
                                                 <p class="text-muted mb-3" style="font-size: 13px;">
                                                     You have taken {{ $totalSamples }} samples so far ({{ $preSamples }} pre-samples & {{ $postSamples }} post-samples)
                                                 </p>

                                                 <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                                                     <table class="table table-hover equipment-report-table mb-0">
                                                         <thead>
                                                             <tr>
                                                                 <th>Date/Time</th>
                                                                 <th>Type: Result</th>
                                                                 <th>Description & Facility</th>
                                                                 <th class="text-end">Actions</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             @forelse($atpDetails as $atp)
                                                                 @php
                                                                     $facilityName = '';
                                                                     if (!empty($atp['facility_id']) && $atp['facility_id'] !== 'N/A') {
                                                                         $location = \App\Models\CompanyLocation::find($atp['facility_id']);
                                                                         if ($location) {
                                                                             $facilityName = $location->location_name;
                                                                         }
                                                                     }
                                                                     
                                                                     $displayTime = '';
                                                                     if (!empty($atp['created_at'])) {
                                                                         $displayTime = \Carbon\Carbon::parse($atp['created_at'])->format('m/d/y h:i A');
                                                                     } else {
                                                                         $displayTime = now()->format('m/d/y h:i A');
                                                                     }
                                                                 @endphp
                                                                 <tr class="align-middle">
                                                                     <td class="text-muted" style="font-size: 11px;">
                                                                         {{ $displayTime }}
                                                                     </td>
                                                                     <td>
                                                                         <span class="badge {{ ($atp['atp_type'] ?? '') === 'pre' ? 'bg-warning text-dark' : 'bg-success text-white' }} fw-semibold px-2 py-1" style="border-radius: 4px; font-size: 11px;">
                                                                             {{ strtoupper($atp['atp_type'] ?? '') }}
                                                                         </span>
                                                                         <span class="fw-bold text-dark ms-1" style="font-size: 14px;">
                                                                             {{ $atp['result'] ?? '' }}
                                                                         </span>
                                                                     </td>
                                                                     <td style="font-size: 13px;">
                                                                         <span class="fw-bold text-dark">{{ $atp['description'] ?? '' }}</span>
                                                                         @if($facilityName)
                                                                             <br>
                                                                             <small class="text-muted">{{ $facilityName }}</small>
                                                                         @else
                                                                             <br>
                                                                             <small class="text-muted">N/A</small>
                                                                         @endif
                                                                     </td>
                                                                     <td class="text-end">
                                                                         <button type="button" class="btn-delete-atp btn btn-sm btn-link text-danger p-0" data-id="{{ $atp['id'] ?? '' }}">
                                                                             <i class="fa-solid fa-trash fs-5"></i>
                                                                         </button>
                                                                     </td>
                                                                 </tr>
                                                             @empty
                                                                 <tr>
                                                                     <td colspan="4" class="text-center py-5 text-secondary">
                                                                         <i class="fa-solid fa-vial fs-1 mb-2 d-block text-muted" style="font-size: 40px;"></i>
                                                                         No ATP details have been documented yet.
                                                                     </td>
                                                                 </tr>
                                                             @endforelse
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>


                                 <!-- Room Record Tab -->
                                 <div class="tab-pane fade" id="room-record" role="tabpanel" aria-labelledby="room-record-tab">
                                     <div class="row">
                                         <!-- Left Column: Add Barcode Form -->
                                         <div class="col-md-5">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Add Barcoded Room</h5>
                                                 </div>
                                                 <form id="room-record-form" action="{{ route('admin.lead.service.order.room_record.save', $order->id) }}" method="POST" class="mb-0">
                                                     @csrf
                                                     <p class="text-muted mb-2" style="font-size: 14px;">For an existing barcode:</p>
                                                     <div class="mb-3">
                                                         <label class="form-label fw-semibold text-dark">Barcode</label>
                                                         <input type="text" name="barcode" class="form-control bg-light" placeholder="Barcode" required>
                                                     </div>
                                                     <button type="submit" class="btn btn-primary px-4" style="background-color: #3b82f6; border-color: #3b82f6;">
                                                         Submit
                                                     </button>
                                                 </form>
                                             </div>
                                         </div>

                                         <!-- Right Column: Barcoded Rooms List -->
                                         <div class="col-md-7">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Barcoded Rooms</h5>
                                                 </div>
                                                 <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                                     <table class="table table-hover equipment-report-table mb-0">
                                                         <thead>
                                                             <tr>
                                                                 <th>Barcode</th>
                                                                 <th>Recorded By</th>
                                                                 <th>Date/Time</th>
                                                                 <th class="text-end">Actions</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             @forelse($order->roomRecords as $record)
                                                                 <tr class="align-middle">
                                                                     <td class="fw-semibold text-dark">{{ $record->barcode }}</td>
                                                                     <td>{{ $record->creator->name ?? 'System' }}</td>
                                                                     <td class="text-muted" style="font-size: 12px;">
                                                                         {{ $record->created_at->format('m/d/y h:i A') }}
                                                                     </td>
                                                                     <td class="text-end">
                                                                         <form action="{{ route('admin.lead.service.order.room_record.delete', $record->id) }}" method="POST" class="d-inline room-delete-form">
                                                                             @csrf
                                                                             <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                                                 <i class="fa-solid fa-trash fs-5"></i>
                                                                             </button>
                                                                         </form>
                                                                     </td>
                                                                 </tr>
                                                             @empty
                                                                 <tr>
                                                                     <td colspan="4" class="text-center py-5 text-secondary">
                                                                         <i class="fa-solid fa-door-open fs-1 mb-2 d-block text-muted" style="font-size: 40px;"></i>
                                                                         No room barcodes have been recorded yet.
                                                                     </td>
                                                                 </tr>
                                                             @endforelse
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                                                        <!-- Equipment Tab -->
                                  <div class="tab-pane fade" id="equipment" role="tabpanel" aria-labelledby="equipment-tab">
                                      <div class="row">
                                          <div class="col-md-12">
                                              {{-- Card 1: Equipment Barcode Record --}}
                                              <div class="section-card mb-4">
                                                  <div class="section-header mb-3">
                                                      <h5 class="section-title">Equipment Barcode Record</h5>
                                                  </div>
                                                  <form action="{{ route('admin.lead.service.order.equipment_record.save', $order->id) }}" method="POST" class="mb-0">
                                                      @csrf
                                                      <div class="d-flex flex-wrap gap-2 align-items-center">
                                                          <div style="flex: 2; min-width: 200px;">
                                                              <input type="text" name="barcode" list="existing-barcodes" class="form-control bg-light" placeholder="Select or Scan Existing Barcode..." required value="{{ old('barcode') }}">
                                                              <datalist id="existing-barcodes">
                                                                  @foreach($equipments as $eq)
                                                                      <option value="{{ $eq->barcode }}">{{ $eq->barcode }} {{ $eq->serial_number ? '('.$eq->serial_number.')' : '' }}</option>
                                                                  @endforeach
                                                              </datalist>
                                                          </div>
                                                          <div style="width: 140px;">
                                                              <select name="status" class="form-select bg-light" required>
                                                                  <option value="service" {{ old('status') == 'service' ? 'selected' : '' }}>Service</option>
                                                                  <option value="washed" {{ old('status') == 'washed' ? 'selected' : '' }}>Wash</option>
                                                              </select>
                                                          </div>
                                                          <div>
                                                              <button type="submit" class="btn btn-success px-3" style="background-color: #2ec15d; border-color: #2ec15d; height: 38px;">
                                                                  <i class="fas fa-check-circle"></i>
                                                              </button>
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
 
                                              {{-- Card 2: Newly Barcoded Equipment --}}
                                              <div class="section-card mb-4">
                                                  <div class="section-header mb-3">
                                                      <h5 class="section-title">Newly Barcoded Equipment</h5>
                                                  </div>
                                                  <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded border border-dashed flex-wrap gap-2">
                                                      <div class="text-secondary" style="font-size: 13px;">
                                                          <i class="fa-solid fa-circle-info me-1 text-primary"></i> Need to register new equipment? Go to Equipment Management to create new barcodes.
                                                      </div>
                                                      <div>
                                                          <a href="{{ route('admin.equipment-management.index') }}" class="btn btn-sm btn-primary px-3 fw-semibold">
                                                              <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Equipment Management
                                                          </a>
                                                      </div>
                                                  </div>
                                              </div>
 
                                              {{-- Card 3: Equipment Summary --}}
                                              <div class="section-card mb-4">
                                                  <div class="section-header mb-3">
                                                      <h5 class="section-title">Equipment Summary</h5>
                                                  </div>
                                                  <div class="bg-light p-3 rounded">
                                                      <p class="mb-2 fw-semibold text-dark">Total Number of Pieces Serviced: <span class="badge bg-warning text-dark fs-6 px-2 py-1 ms-1">{{ $order->equipmentRecords->where('status', 'service')->count() }}</span></p>
                                                      <p class="mb-0 fw-semibold text-dark">Total Number of Pieces Washed: <span class="badge bg-primary fs-6 px-2 py-1 ms-1">{{ $order->equipmentRecords->where('status', 'washed')->count() }}</span></p>
                                                  </div>
                                              </div>
 
                                              {{-- Card 4: Equipment Records List --}}
                                              <div class="section-card">
                                                  <div class="section-header mb-3">
                                                      <h5 class="section-title">Equipment Records List</h5>
                                                  </div>
                                                  <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                                      <table class="table table-hover equipment-report-table mb-0">
                                                          <thead>
                                                              <tr>
                                                                  <th>Barcode</th>
                                                                  <th>Type</th>
                                                                  <th>Serial Number</th>
                                                                  <th>Status</th>
                                                                  <th>Recorded By</th>
                                                                  <th>Date/Time</th>
                                                                  <th class="text-end">Actions</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              @forelse($order->equipmentRecords as $record)
                                                                  <tr class="align-middle">
                                                                      <td class="fw-semibold text-dark">{{ $record->barcode }}</td>
                                                                      <td>{{ $record->equipment->type->name ?? '—' }}</td>
                                                                      <td>{{ $record->equipment->serial_number ?? '—' }}</td>
                                                                      <td>
                                                                          @php
                                                                              $statusBadges = [
                                                                                  'service' => 'bg-warning text-dark',
                                                                                  'washed' => 'bg-primary',
                                                                              ];
                                                                              $badgeClass = $statusBadges[$record->status] ?? 'bg-secondary';
                                                                              $statusLabel = $record->status == 'washed' ? 'Wash' : 'Service';
                                                                          @endphp
                                                                          <span class="badge {{ $badgeClass }}" style="font-size: 11px;">{{ $statusLabel }}</span>
                                                                      </td>
                                                                      <td>{{ $record->creator->name ?? 'System' }}</td>
                                                                      <td class="text-muted" style="font-size: 12px;">
                                                                          {{ $record->created_at->format('m/d/y h:i A') }}
                                                                      </td>
                                                                      <td class="text-end">
                                                                          <form action="{{ route('admin.lead.service.order.equipment_record.delete', $record->id) }}" method="POST" class="d-inline equipment-delete-form">
                                                                              @csrf
                                                                              <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                                                  <i class="fa-solid fa-trash fs-5"></i>
                                                                              </button>
                                                                          </form>
                                                                      </td>
                                                                  </tr>
                                                              @empty
                                                                  <tr>
                                                                      <td colspan="7" class="text-center py-5 text-secondary">
                                                                          <i class="fa-solid fa-laptop-medical fs-1 mb-2 d-block text-muted" style="font-size: 40px;"></i>
                                                                          No equipment records have been submitted yet.
                                                                      </td>
                                                                  </tr>
                                                              @endforelse
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                 <!-- Clean Patch Tab -->
                                 <div class="tab-pane fade" id="clean-patch" role="tabpanel" aria-labelledby="clean-patch-tab">
                                     <div class="row">
                                         <!-- Left Column: Add Clean Patch Form -->
                                         <div class="col-md-5">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Clean Patch Record</h5>
                                                 </div>
                                                 <form id="clean-patch-form" action="{{ route('admin.lead.service.order.clean_patch.save', $order->id) }}" method="POST" class="mb-0">
                                                     @csrf
                                                     <div class="d-flex flex-wrap gap-2 align-items-center">
                                                         <div style="flex: 1; min-width: 140px;">
                                                             <input type="text" name="barcode" class="form-control bg-light" placeholder="Barcode" required>
                                                         </div>
                                                         <div style="flex: 1; min-width: 160px;">
                                                             <select name="patch_size" class="form-select bg-light" required>
                                                                 <option value="large_rectangle">Large (Rectangle)</option>
                                                                 <option value="medium_rectangle">Medium (Rectangle)</option>
                                                                 <option value="small_rectangle">Small (Rectangle)</option>
                                                                 <option value="large_square">Large (Square)</option>
                                                                 <option value="medium_square">Medium (Square)</option>
                                                                 <option value="small_square">Small (Square)</option>
                                                             </select>
                                                         </div>
                                                         <div>
                                                             <button type="submit" class="btn btn-success px-3" style="background-color: #2ec15d; border-color: #2ec15d; height: 38px;">
                                                                 <i class="fas fa-check-circle"></i>
                                                             </button>
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>

                                         <!-- Right Column: Clean Patch List -->
                                         <div class="col-md-7">
                                             <div class="section-card mb-4">
                                                 <div class="section-header mb-3">
                                                     <h5 class="section-title">Clean Patch Records List</h5>
                                                 </div>
                                                 <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                                     <table class="table table-hover equipment-report-table mb-0">
                                                         <thead>
                                                             <tr>
                                                                 <th>Barcode</th>
                                                                 <th>Size / Type</th>
                                                                 <th>Recorded By</th>
                                                                 <th>Date/Time</th>
                                                                 <th class="text-end">Actions</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>
                                                             @forelse($order->cleanPatches as $patch)
                                                                 <tr class="align-middle">
                                                                     <td class="fw-semibold text-dark">{{ $patch->barcode }}</td>
                                                                     <td>
                                                                         @php
                                                                             $patchSizes = [
                                                                                 'large_rectangle' => 'Large (Rectangle)',
                                                                                 'medium_rectangle' => 'Medium (Rectangle)',
                                                                                 'small_rectangle' => 'Small (Rectangle)',
                                                                                 'large_square' => 'Large (Square)',
                                                                                 'medium_square' => 'Medium (Square)',
                                                                                 'small_square' => 'Small (Square)',
                                                                             ];
                                                                             echo $patchSizes[$patch->patch_size] ?? $patch->patch_size;
                                                                         @endphp
                                                                     </td>
                                                                     <td>{{ $patch->creator->name ?? 'System' }}</td>
                                                                     <td class="text-muted" style="font-size: 12px;">
                                                                         {{ $patch->created_at->format('m/d/y h:i A') }}
                                                                     </td>
                                                                     <td class="text-end">
                                                                         <form action="{{ route('admin.lead.service.order.clean_patch.delete', $patch->id) }}" method="POST" class="d-inline patch-delete-form">
                                                                             @csrf
                                                                             <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                                                                 <i class="fa-solid fa-trash fs-5"></i>
                                                                             </button>
                                                                         </form>
                                                                     </td>
                                                                 </tr>
                                                             @empty
                                                                 <tr>
                                                                     <td colspan="5" class="text-center py-5 text-secondary">
                                                                         <i class="fa-solid fa-shield-halved fs-1 mb-2 d-block text-muted" style="font-size: 40px;"></i>
                                                                         No clean patch records have been saved yet.
                                                                     </td>
                                                                 </tr>
                                                             @endforelse
                                                         </tbody>
                                                     </table>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
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
                                                    <form action="{{ route('admin.lead.service.outline.update', $outline->id) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        <div class="row mt-2 g-2">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                        class="form-control"
                                                                        name="range"
                                                                        value="{{ $outline->range ?? 0 }}"
                                                                        min="0" max="100" step="1"
                                                                        placeholder="0">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <textarea name="description"
                                                                    class="form-control"
                                                                    placeholder="Add description...">{{ $outline->description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-success">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @empty
                                                <p class="text-muted">No contract details found.</p>
                                            @endforelse

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

                                            </div>
                                        </div>
                                    </div>

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
                        <div class="modal-header">
                            <h5>User Monthly Schedule</h5>
                        </div>
                        <div class="modal-body">
                            <table class="table table-hover equipment-report-table">
                                <thead>
                                    <tr>
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
                                                {{ $vehicle->name ?? $vehicle->plate_number ?? 'Vehicle #' . $vehicle->id }}
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
                toastr.error("{{ session('error') }}");
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
                document.querySelectorAll('[data-clockin-time]').forEach(function (el) {
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
                let date = $(this).data('date');

                $.get("{{ route('admin.lead.service.user.monthly_slots') }}", {
                    user_id: userId,
                    date: date
                }, function (res) {
                    let html = '';

                    if (res.length === 0) {
                        html = `<tr><td colspan="4" class="text-center">No bookings</td></tr>`;
                    } else {
                        res.forEach(row => {
                            html += `
                            <tr>
                                <td>${row.office}</td>
                                <td>${row.start_time}</td>
                                <td>${row.end_time}</td>
                                <td>${row.hours}</td>
                            </tr>
                        `;
                        });
                    }

                    $('#userSlotsBody').html(html);
                    $('#userSlotsModal').modal('show');
                });
            });

            // ==============================
            // Save Service Plan Narrative
            // ==============================
            $(document).on('submit', '.service-plan-form', function (e) {
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
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Service plan narrative saved successfully!');
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save service plan narrative');
                    }
                });
            });

            // ==============================
            // Save Sales Narrative
            // ==============================
            $(document).on('submit', '.sales-narrative-form', function (e) {
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
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Sales narrative saved successfully!');
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save sales narrative');
                    }
                });
            });

            // ==============================
            // Save Plan Debrief
            // ==============================
            $(document).on('submit', '.plan-debrief-form', function (e) {
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
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Plan debrief saved successfully!');
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save plan debrief');
                    }
                });
            });

            // ==============================
            // Save Employee Performance
            // ==============================
            $(document).on('submit', '.employee-performance-form', function (e) {
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
                    success: function (response) {
                        console.log('Success response:', response);
                        if (response.success) {
                            toastr.success('Employee performance recorded successfully!');
                            form[0].reset();
                            // Reload the page to show the new record
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        console.log('Error response:', xhr.responseJSON);
                        const errors = xhr.responseJSON?.errors || {};
                        if (Object.keys(errors).length > 0) {
                            $.each(errors, function (key, value) {
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
            $(document).on('click', '.btn-plan-review-toggle', function (e) {
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
                    success: function (response) {
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
                    error: function (xhr) {
                        toastr.error('Failed to update plan review status');
                    }
                });
            });

            // ==============================
            // Save Pre-Service Consumables
            // ==============================
            $(document).on('submit', '#preChecklistConsumablesForm', function (e) {
                e.preventDefault();
                const form = $(this);
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Pre-service consumables saved successfully!');
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save pre-service consumables');
                    }
                });
            });

            // ==============================
            // Save Post-Service Consumables
            // ==============================
            $(document).on('submit', '#postChecklistConsumablesForm', function (e) {
                e.preventDefault();
                const form = $(this);
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.update_checklist', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Post-service consumables saved successfully!');
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save post-service consumables');
                    }
                });
            });

            // ==============================
            // Travel Clock-In — show modal
            // ==============================
            $(document).on('submit', '.clock-in-form', function (e) {
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

            // ==============================
            // Hotel Details Form Submission
            // ==============================
            $(document).on('submit', '#hotel-details-form', function (e) {
                e.preventDefault();
                const form = $(this);
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.hotel.save', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Hotel details saved successfully!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save hotel details');
                    }
                });
            });

            // ==============================
            // Hotel Details Deletion
            // ==============================
            $(document).on('click', '.btn-delete-hotel', function (e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to remove this hotel entry?')) return;
                
                const btn = $(this);
                const hotelEntryId = btn.data('id');
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.hotel.delete', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        hotel_entry_id: hotelEntryId
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Hotel detail removed successfully!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to delete hotel entry');
                    }
                });
            });

            // ==============================
            // ATP Details Form Submission
            // ==============================
            $(document).on('submit', '#atp-details-form', function (e) {
                e.preventDefault();
                const form = $(this);
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.atp.save', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            toastr.success('ATP details saved successfully!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to save ATP details');
                    }
                });
            });

            // ==============================
            // ATP Details Deletion
            // ==============================
            $(document).on('click', '.btn-delete-atp', function (e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to remove this ATP entry?')) return;
                
                const btn = $(this);
                const atpEntryId = btn.data('id');
                const orderId = {{ $order->id }};

                $.ajax({
                    url: "{{ route('admin.lead.service.order.atp.delete', ['orderId' => ':orderId']) }}".replace(':orderId', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        atp_entry_id: atpEntryId
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('ATP detail removed successfully!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to delete ATP entry');
                    }
                });
            });
        </script>
    @endpush