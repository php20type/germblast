@extends('admin.includes.layout')

@section('title', 'Company Dashboard')

@push('styles')
    <style>
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

        /* Row Status Styling to match legend */
        .equipment-report-table tbody tr.row-status-pending td {
            background-color: #f3f4f6 !important;
        }
        .equipment-report-table tbody tr.row-status-scheduled td {
            background-color: #fff8eb !important;
        }
        .equipment-report-table tbody tr.row-status-in-progress td {
            background-color: #fffbeb !important;
        }
        .equipment-report-table tbody tr.row-status-completed td {
            background-color: #f0fdfa !important;
        }
        .equipment-report-table tbody tr.row-status-cancelled td {
            background-color: #fef2f2 !important;
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

        .equipment-report-table tbody tr.row-status-confirmed td,
        .equipment-report-table tbody tr.row-status-open td {
            background-color: #f0f7ff !important;
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
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <div class="main-content">

                        {{-- HEADER --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">
                                    {{ strtoupper($company->name) }} - DASHBOARD <span style="font-size: 24px;">📌</span>
                                </h3>
                                <p class="text-muted mb-0">
                                    Overview of IAQ, Biological Response, Services and Surveys
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <a href="{{ route('admin.company.show', $company->id) }}" class="btn btn-outline-dark">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Company
                                </a>
                            </div>
                        </div>

                        <div class="my-4"></div>

                        <div class="dashboard-body px-4 pb-4">

                            {{-- IAQ DEVICES & ZONES --}}
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">IAQ Zones</h3>
                                            @can('company.dashboard.edit')
                                                <a href="#" class="btn btn-sm btn-export" onclick="addZone()">Add Zone</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Zone Name</th>
                                                        <th>Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($iaqZones as $zone)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                    <a href="javascript:void(0)" class="text-decoration-none text-primary"
                                                                        onclick="editZone({{ $zone->id }})">
                                                                        {{ $zone->name }}
                                                                    </a>
                                                                @else
                                                                    {{ $zone->name }}
                                                                @endcan
                                                            </td>
                                                            <td>{{ $zone->companyLocation->location_name ?? '-' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-muted text-center py-4">
                                                                No zones created yet.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">IAQ Devices</h3>
                                            @can('company.dashboard.edit')
                                                <a href="#" class="btn btn-sm btn-export" onclick="addDevice()">Add Meter</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Zone</th>
                                                        <th>Location</th>
                                                        <th>Node ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($iaqDevices as $device)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                    <a href="javascript:void(0)" class="text-decoration-none text-primary"
                                                                        onclick="editDevice({{ $device->id }})">
                                                                        {{ $device->name }}
                                                                    </a>
                                                                @else
                                                                    {{ $device->name }}
                                                                @endcan
                                                            </td>
                                                            <td>{{ $device->iaqZone->name ?? '-' }}</td>
                                                            <td>{{ $device->iaqZone->companyLocation->location_name ?? '-' }}</td>
                                                            <td>{{ $device->node_id ?? '-' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-muted text-center py-4">
                                                                No IAQ devices added yet.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BIOLOGICAL RESPONSE INTAKE --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">Biological Response Intake</h3>
                                            @can('company.dashboard.edit')
                                                <a href="{{ route('admin.company.biological.response', $company->id) }}"
                                                    class="btn btn-sm btn-export">Add Intake</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <th>Project Leader</th>
                                                        <th>Project Zip</th>
                                                        <th>Type of Loss</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($biologicalResponseIntakes as $intake)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                    <a href="{{ route('admin.company.biological.response.edit', [$company->id, $intake->id]) }}" class="text-decoration-none text-primary">
                                                                        {{ $intake->project_name }}
                                                                    </a>
                                                                @else
                                                                    {{ $intake->project_name }}
                                                                @endcan
                                                            </td>
                                                            <td>{{ $intake->project_leader }}</td>
                                                            <td>{{ $intake->project_zip }}</td>
                                                            <td>{{ $intake->type_of_loss }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-muted text-center py-4">
                                                                No biological response records found.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BIOLOGICAL READINESS INTAKE --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">Biological Readiness Intake</h3>
                                            @can('company.dashboard.edit')
                                                <a href="{{ route('admin.company.biological.readiness', $company->id) }}"
                                                    class="btn btn-sm btn-export">Add Intake</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <th>Status</th>
                                                        <th>Length</th>
                                                        <th>Total</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($biologicalReadiness as $readiness)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                    <a href="{{ route('admin.company.biological.readiness.edit', [$company->id, $readiness->id]) }}" class="text-decoration-none text-primary">
                                                                        {{ $readiness->project_name }}
                                                                    </a>
                                                                @else
                                                                    {{ $readiness->project_name }}
                                                                @endcan
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-light text-dark border px-2 py-1">{{ $readiness->status }}</span>
                                                            </td>
                                                            <td>{{ $readiness->length }}</td>
                                                            <td>{{ $readiness->line_total }}</td>
                                                            <td>{{ $readiness->created_at->format('d M Y') }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-muted text-center py-4">
                                                                No readiness records available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- IAQ SURVEY --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">Indoor Air Quality</h3>
                                            @can('company.dashboard.edit')
                                                <a href="{{ route('admin.company.iaq.survey', $company->id) }}"
                                                class="btn btn-sm btn-export">Create IAQ Survey</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Survey Name</th>
                                                        <th>Date</th>
                                                        <th>Building Description</th>
                                                        <th>Reported Issues</th>
                                                        <th>Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($iaqSurveys as $survey)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                <a href="{{ route('admin.company.iaq.survey.edit', [$company->id, $survey->id]) }}" class="text-decoration-none text-primary">
                                                                    {{ $survey->survey_name ?? '-' }}
                                                                </a>
                                                                @else
                                                                    {{ $survey->survey_name ?? '-' }}
                                                                @endcan
                                                            </td>
                                                            <td>
                                                                {{ $survey->created_at->format('d M Y') }}
                                                            </td>
                                                            <td>
                                                                {{ \Illuminate\Support\Str::words($survey->building_description, 10, '...') }}
                                                            </td>
                                                            <td>
                                                                {{ \Illuminate\Support\Str::words($survey->reported_issues, 10, '...') }}
                                                            </td>
                                                            <td>
                                                                {{ $survey->location ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-muted text-center py-4">
                                                                No IAQ surveys created.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- WATER MANAGEMENT --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">Water Management</h3>
                                            @can('company.dashboard.edit')
                                            <a href="{{ route('admin.company.water.management', $company->id) }}"
                                                class="btn btn-sm btn-export">Create H2O Survey</a>
                                            @endcan
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Survey Name</th>
                                                        <th>Date</th>
                                                        <th>Municipal Water Supplier</th>
                                                        <th>No. of Teams</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($waterManagement as $water)
                                                        <tr>
                                                            <td>
                                                                @can('company.dashboard.edit')
                                                                <a href="{{ route('admin.company.water.management.edit', [$company->id, $water->id]) }}" class="text-decoration-none text-primary">
                                                                    {{ $water->survey_name ?? '-' }}
                                                                </a>
                                                                @else
                                                                    {{ $water->survey_name ?? '-' }}
                                                                @endcan
                                                            </td>
                                                            <td>{{ $water->created_at->format('d M Y') }}</td>
                                                            <td>{{ $water->municipal_water_supplier ?? '-' }}</td>
                                                            <td>
                                                                {{ $water->waterManagementTeams->count() }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-muted text-center py-4">
                                                                No water surveys created.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SERVICES --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header d-flex justify-content-between align-items-center">
                                            <h3 class="section-title">Services</h3>
                                            {{-- <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-export">Schedule Response</button>
                                                <button class="btn btn-sm btn-add-audience">Schedule RGB</button>
                                            </div> --}}
                                        </div>

                                        <p class="small text-muted">
                                            Legend:
                                            <span class="status-pill status-pill-open">Open</span>,
                                            <span class="status-pill status-pill-completed">Completed</span>,
                                            <span class="status-pill status-pill-cancelled">Cancelled</span>
                                        </p>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Service Info</th>
                                                        <th>Dates</th>
                                                        {{-- <th>Status</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     @forelse ( $serviceOrders as $order)
                                                         @php
                                                             $displayStatus = strtolower($order->status ?? 'open');
                                                             $rowClass = match($displayStatus) {
                                                                 'open'        => 'row-status-open',
                                                                 'completed'   => 'row-status-completed',
                                                                 'cancelled'   => 'row-status-cancelled',
                                                                 default       => ''
                                                             };
                                                         @endphp
                                                         <tr class="{{ $rowClass }} small">
                                                            <td>
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <a href="{{ route('admin.lead.service.service_dashboard', $order->id) }}" class="text-decoration-none text-primary">
                                                                            Order ID: {{ $order->order_no }}
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            Actions
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            @if($displayStatus !== 'cancelled')
                                                                                <li>
                                                                                    <form action="{{ route('admin.lead.service.order.cancel', $order->id) }}" method="POST" class="d-inline form-cancel-order w-100">
                                                                                        @csrf
                                                                                        <button type="submit" class="dropdown-item text-danger w-100 text-start border-0 bg-transparent">Cancel Order</button>
                                                                                    </form>
                                                                                </li>
                                                                            @else
                                                                                <li>
                                                                                    <form action="{{ route('admin.lead.service.order.reopen', $order->id) }}" method="POST" class="d-inline form-reopen-order w-100">
                                                                                        @csrf
                                                                                        <button type="submit" class="dropdown-item text-success w-100 text-start border-0 bg-transparent">Re-Open Order</button>
                                                                                    </form>
                                                                                </li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <strong>{{ $order->service->service_name }}</strong>
                                                                </div>
                                                                <div class="text-muted small mt-1">
                                                                    Number Of Service: {{ $order->service->number_of_services }} <br>
                                                                    Price Per Service: ${{ number_format($order->service->price_per_service,2) }} <br>
                                                                    Total Price: ${{ number_format($order->service->total_price,2) }} <br>
                                                                    Estimated Man Hours: 12
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="fw-semibold">Intended Date:</div>
                                                                <span class="text-muted small">{{ $order->intended_date }}</span>
                                                                
                                                                @if($order->orderSlots->count())
                                                                    <div class="fw-semibold mt-2">Scheduled Slots:</div>
                                                                    @foreach($order->orderSlots as $slot)
                                                                        <span class="text-muted small d-block">
                                                                            {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}
                                                                        </span>
                                                                    @endforeach
                                                                @else
                                                                    <div class="text-muted small mt-1">No slots scheduled yet.</div>
                                                                @endif
                                                            </td>
                                                            {{-- 
                                                            <td>
                                                                <span class="status-pill status-pill-{{ $displayStatus }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $displayStatus)) }}
                                                                </span>
                                                            </td>
                                                            --}}
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-muted text-center py-4">
                                                                No services scheduled.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> {{-- dashboard-body closed --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- IAQ Zone Modal --}}
    <div class="modal fade" id="AddIAQZone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add IAQ Zone</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.company.iaq-zones.store', $company->id) }}" method="POST"
                        class="company-form" id="add-iaq-zone">
                        @csrf

                        <div class="row mx-0">

                            {{-- Location Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            {{-- Country --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <span class="text-danger">*</span>
                                    <select name="company_location_id" class="form-select select2"
                                        id="company_location_select">
                                        <option value="">Select One</option>
                                        @foreach ($companyLocations as $companyLocation)
                                            <option value="{{ $companyLocation->id }}">
                                                {{ $companyLocation->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Zone
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- IAQ Devices Modal --}}
    <div class="modal fade" id="AddIAQDevice" tabindex="-1" aria-labelledby="AddIAQDeviceLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="AddIAQDeviceLabel">Add IAQ Device</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form action="{{ route('admin.company.iaq-devices.store', $company->id) }}" method="POST"
                        class="company-form" id="add-iaq-device">
                        @csrf

                        <div class="row mx-0">

                            {{-- Device Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Eg. IAQ Meter 01">
                                </div>
                            </div>

                            {{-- IAQ Zone --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">IAQ Zone</label>
                                    <span class="text-danger">*</span>
                                    <select name="iaq_zone_id" class="form-select select2" id="iaq_zone_select">
                                        <option value="">Select One</option>
                                        @foreach ($iaqZones as $zone)
                                            <option value="{{ $zone->id }}">
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Node ID --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Node ID</label>
                                    <input type="text" name="node_id" class="form-control" placeholder="Node ID">
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Device
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Edit IAQ Zone Modal --}}
    <div class="modal fade" id="EditIAQZone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Edit IAQ Zone</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form method="POST" id="edit-iaq-zone-form">
                        @csrf

                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="edit_zone_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <span class="text-danger">*</span>
                                    <select name="company_location_id" id="edit_company_location"
                                        class="form-select select2">
                                        @foreach ($companyLocations as $location)
                                            <option value="{{ $location->id }}">
                                                {{ $location->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Location
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Edit Edit IAQ Device Modal --}}
    <div class="modal fade" id="EditIAQDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Edit IAQ Device</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form method="POST" id="edit-iaq-device-form">
                        @csrf
                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="edit_device_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">IAQ Zone</label>
                                    <span class="text-danger">*</span>
                                    <select name="iaq_zone_id" id="edit_iaq_zone" class="form-select select2">
                                        @foreach ($iaqZones as $zone)
                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Node ID</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="node_id" id="edit_node_id" class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Location
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        function addZone() {
            $('#AddIAQZone').modal('show');
        }

        function addDevice() {
            $('#AddIAQDevice').modal('show');
        }

        function editZone(zoneId) {
            $.get(
                "{{ route('admin.company.iaq-zones.edit', [$company->id, 'ZONE_ID']) }}"
                .replace('ZONE_ID', zoneId),
                function(res) {

                    $('#edit_zone_name').val(res.data.name);
                    $('#edit_company_location')
                        .val(res.data.company_location_id)
                        .trigger('change');

                    $('#edit-iaq-zone-form')
                        .attr('action',
                            "{{ route('admin.company.iaq-zones.update', [$company->id, 'ZONE_ID']) }}"
                            .replace('ZONE_ID', zoneId)
                        );

                    $('#EditIAQZone').modal('show');
                }
            );
        }

        function editDevice(deviceId) {
            $.get(
                "{{ route('admin.company.iaq-devices.edit', [$company->id, 'DEVICE_ID']) }}"
                .replace('DEVICE_ID', deviceId),
                function(res) {

                    $('#edit_device_name').val(res.data.name);
                    $('#edit_node_id').val(res.data.node_id);
                    $('#edit_iaq_zone')
                        .val(res.data.iaq_zone_id)
                        .trigger('change');

                    $('#edit-iaq-device-form')
                        .attr('action',
                            "{{ route('admin.company.iaq-devices.update', [$company->id, 'DEVICE_ID']) }}"
                            .replace('DEVICE_ID', deviceId)
                        );

                    $('#EditIAQDevice').modal('show');
                }
            );
        }

        $(document).ready(function() {

            $('#company_location_select').select2({
                dropdownParent: $('#AddIAQZone'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#iaq_zone_select').select2({
                dropdownParent: $('#AddIAQDevice'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#edit_company_location').select2({
                dropdownParent: $('#EditIAQZone'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#edit_iaq_zone').select2({
                dropdownParent: $('#EditIAQDevice'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });


            $("#add-iaq-zone").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    company_location_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter zone name."
                    },
                    company_location_id: {
                        required: "Please select a location."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#add-iaq-zone').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong'
                        });
                    }
                });
            });


            $("#add-iaq-device").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    iaq_zone_id: {
                        required: true
                    },
                    node_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter device name."
                    },
                    iaq_zone_id: {
                        required: "Please select IAQ zone."
                    },
                    node_id: {
                        required: "Please enter node ID."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#add-iaq-device').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to add device'
                        });
                    }
                });
            });


            $("#edit-iaq-zone-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    company_location_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter zone name."
                    },
                    company_location_id: {
                        required: "Please select a location."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#edit-iaq-zone-form').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update zone'
                        });
                    }
                });
            });


            $("#edit-iaq-device-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    iaq_zone_id: {
                        required: true
                    },
                    node_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter device name."
                    },
                    iaq_zone_id: {
                        required: "Please select IAQ zone."
                    },
                    node_id: {
                        required: "Please enter node ID."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#edit-iaq-device-form').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update device'
                        });
                    }
                });
            });

            $('.form-cancel-order').submit(function(e) {
                e.preventDefault();
                let form = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to cancel this order?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $('.form-reopen-order').submit(function(e) {
                e.preventDefault();
                let form = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to re-open this order?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, re-open it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endpush



