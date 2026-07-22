@extends('admin.includes.layout')

@section('title', 'Warehouse Maintenance Dashboard')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Modern Soft Tabs Styling with Premium Thin Scrollbar */
        .navbar-tabs {
            overflow-x: auto !important;
            overflow-y: hidden !important;
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: rgba(255, 180, 0, 0.4) rgba(0, 0, 0, 0.05); /* Firefox */
            padding-bottom: 6px !important; /* Thin scrollbar clearance */
        }

        .navbar-tabs::-webkit-scrollbar {
            height: 5px !important; /* Thin scrollbar height */
            background-color: rgba(0, 0, 0, 0.02);
            border-radius: 10px;
        }

        .navbar-tabs::-webkit-scrollbar-thumb {
            background-color: rgba(255, 180, 0, 0.35); /* Soft gold scrollbar thumb */
            border-radius: 10px;
            transition: background-color 0.2s ease;
        }

        .navbar-tabs::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 180, 0, 0.7); /* Brighter gold on hover */
        }

        .navbar-tabs::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0.02);
            border-radius: 10px;
        }

        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
            flex: 1 0 auto !important;
            white-space: nowrap !important;
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

        /* Equipment Report Table Boxed Styling (from Equipment Report page) */
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

        /* Status Badge (from Equipment Report page) */
        .status-pill {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .status-pill-due {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pill-completed {
            background: #eef2ff;
            color: #4f46e5;
        }

        /* ============================================================ */
        /* Timeline History Styles (from index.blade.php) */
        /* ============================================================ */
        .history-timeline-container {
            position: relative;
            padding: 30px 40px;
            background: #fff;
        }

        .history-timeline-line {
            position: absolute;
            left: 55px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ffb400;
            opacity: 0.3;
        }

        .timeline-item {
            position: relative;
            display: flex;
            margin-bottom: 30px;
            align-items: flex-start;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            background: #ffb400;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            z-index: 1;
            flex-shrink: 0;
            margin-right: 25px;
            box-shadow: 0 0 0 5px #fff;
            margin-top: 15px;
        }

        .history-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 16px;
            padding: 20px 25px;
            flex-grow: 1;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .history-card:hover {
            border-color: #ffb400;
            box-shadow: 0 5px 15px rgba(255, 180, 0, 0.05);
        }

        .history-date {
            width: 90px;
            flex-shrink: 0;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
            font-weight: 500;
        }

        .history-content {
            flex-grow: 1;
            padding: 0 25px;
        }

        .history-note {
            font-size: 15px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .history-status-change {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: #9ca3af;
        }

        .history-category {
            width: 140px;
            text-align: center;
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
        }

        .history-user {
            width: 150px;
            text-align: right;
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        /* Modal Refinement */
        #viewNotesModal .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        #viewNotesModal .modal-header {
            padding: 35px 40px 25px 40px;
            border-bottom: none !important;
        }

        #viewNotesModalSubtitle {
            font-size: 14px;
            color: #9ca3af !important;
            margin-top: 8px;
            display: block;
        }

        .btn-close-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff8e8;
            border: none;
            color: #ffb400;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.2s;
        }

        .btn-close-circle:hover {
            background: #ffb400;
            color: #fff;
        }

        .history-labels {
            display: flex;
            padding: 10px 40px;
            color: #9ca3af;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-yellow-rounded {
            background: #ffb400;
            color: #fff;
            border-radius: 12px;
            padding: 10px 35px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }

        .btn-yellow-rounded:hover {
            background: #e6a200;
            color: #fff;
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
                                <h3 class="mb-1">Warehouse</h3>
                                <p class="text-muted mb-0">
                                    Track and complete warehouse duties and standard operations.
                                </p>
                            </div>
                            @can('warehouse.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#addDutyModal">
                                    + CREATE DUTY
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- TABS (matching Equipment Report layouts) -->
                        <div class="navbar-tabs px-4">
                            <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">
                                    General <span class="badge bg-secondary text-white rounded-pill ms-1" id="general-count">{{ $generalTasks->count() }}</span>
                                </button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#data">
                                    Data <span class="badge bg-secondary text-white rounded-pill ms-1" id="data-count">{{ $dataTasks->count() }}</span>
                                </button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vehicle">
                                    Vehicle <span class="badge bg-secondary text-white rounded-pill ms-1" id="vehicle-count">{{ $vehicleTasks->count() }}</span>
                                </button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#trailer">
                                    Trailer <span class="badge bg-secondary text-white rounded-pill ms-1" id="trailer-count">{{ $trailerTasks->count() }}</span>
                                </button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inventory">
                                    Inventory <span class="badge bg-secondary text-white rounded-pill ms-1" id="inventory-count">{{ $inventoryTasks->count() }}</span>
                                </button>
                            </nav>
                        </div>

                        <hr class="mx-4 mb-4 mt-0" style="opacity: 0.1;">

                        <!-- TAB CONTENT -->
                        <div class="tab-content px-4">

                            <!-- GENERAL TAB -->
                            <div class="tab-pane fade show active" id="general">
                                <div class="table-responsive">
                                    <table id="generalTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Duty / Activity</th>
                                                <th>Frequency</th>
                                                <th>Last Performed</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 250px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($generalTasks as $duty)
                                                <tr data-id="{{ $duty->id }}"
                                                    data-title="{{ $duty->title }}"
                                                    data-description="{{ $duty->description }}"
                                                    data-supplier="{{ $duty->supplier }}"
                                                    data-unit-of-measure="{{ $duty->unit_of_measure }}"
                                                    data-reorder-point="{{ $duty->reorder_point }}"
                                                    data-reorder-quantity="{{ $duty->reorder_quantity }}"
                                                    data-frequency="{{ $duty->frequency }}"
                                                    data-frequency-text="{{ $duty->frequency_text }}"
                                                    data-form-type="{{ $duty->form_type }}"
                                                    data-form-type-text="{{ $duty->form_type_text }}"
                                                    data-vehicle-id="{{ $duty->vehicle_id }}"
                                                    data-last-performed-by="{{ $duty->last_performed_by }}"
                                                    data-last-performed-on="{{ $duty->last_performed_on }}"
                                                    data-notes="{{ $duty->notes }}"
                                                    data-due="{{ $duty->due ? 'true' : 'false' }}">
                                                    <td class="align-middle">
                                                        <span class="fw-semibold text-dark" style="font-size: 15px;">{{ $duty->title }}</span>
                                                    </td>
                                                    <td class="align-middle">{{ $duty->frequency_text }}</td>
                                                    <td class="align-middle">
                                                        {{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <button class="btn btn-sm btn-outline-dark btn-view-notes" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}">
                                                            View Notes
                                                        </button>
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('warehouse.add')
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due cursor-pointer btn-duty-complete" data-id="{{ $duty->id }}">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed cursor-pointer btn-duty-reset" data-id="{{ $duty->id }}">Completed</span>
                                                            @endif
                                                        @else
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed">Completed</span>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-duty-complete-btn" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ $duty->due && auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            {{ $duty->due ? 'Complete' : 'Done' }}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-dark btn-duty-settings" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Settings
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                                        No duties registered in this category.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- DATA TAB -->
                            <div class="tab-pane fade" id="data">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Duty / Activity</th>
                                                <th>Frequency</th>
                                                <th>Last Performed</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 250px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($dataTasks as $duty)
                                                <tr data-id="{{ $duty->id }}"
                                                    data-title="{{ $duty->title }}"
                                                    data-description="{{ $duty->description }}"
                                                    data-supplier="{{ $duty->supplier }}"
                                                    data-unit-of-measure="{{ $duty->unit_of_measure }}"
                                                    data-reorder-point="{{ $duty->reorder_point }}"
                                                    data-reorder-quantity="{{ $duty->reorder_quantity }}"
                                                    data-frequency="{{ $duty->frequency }}"
                                                    data-frequency-text="{{ $duty->frequency_text }}"
                                                    data-form-type="{{ $duty->form_type }}"
                                                    data-form-type-text="{{ $duty->form_type_text }}"
                                                    data-vehicle-id="{{ $duty->vehicle_id }}"
                                                    data-last-performed-by="{{ $duty->last_performed_by }}"
                                                    data-last-performed-on="{{ $duty->last_performed_on }}"
                                                    data-notes="{{ $duty->notes }}"
                                                    data-due="{{ $duty->due ? 'true' : 'false' }}">
                                                    <td class="align-middle">
                                                        <span class="fw-semibold text-dark" style="font-size: 15px;">{{ $duty->title }}</span>
                                                    </td>
                                                    <td class="align-middle">{{ $duty->frequency_text }}</td>
                                                    <td class="align-middle">
                                                        {{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <button class="btn btn-sm btn-outline-dark btn-view-notes" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}">
                                                            View Notes
                                                        </button>
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('warehouse.add')
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due cursor-pointer btn-duty-complete" data-id="{{ $duty->id }}">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed cursor-pointer btn-duty-reset" data-id="{{ $duty->id }}">Completed</span>
                                                            @endif
                                                        @else
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed">Completed</span>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-duty-complete-btn" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ $duty->due && auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            {{ $duty->due ? 'Complete' : 'Done' }}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-dark btn-duty-settings" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Settings
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                                        No duties registered in this category.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- VEHICLE TAB -->
                            <div class="tab-pane fade" id="vehicle">
                                <div class="table-responsive">
                                    <table id="vehicleTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Duty / Activity</th>
                                                <th>Frequency</th>
                                                <th>Last Performed</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 250px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($vehicleTasks as $duty)
                                                <tr data-id="{{ $duty->id }}"
                                                    data-title="{{ $duty->title }}"
                                                    data-description="{{ $duty->description }}"
                                                    data-supplier="{{ $duty->supplier }}"
                                                    data-unit-of-measure="{{ $duty->unit_of_measure }}"
                                                    data-reorder-point="{{ $duty->reorder_point }}"
                                                    data-reorder-quantity="{{ $duty->reorder_quantity }}"
                                                    data-frequency="{{ $duty->frequency }}"
                                                    data-frequency-text="{{ $duty->frequency_text }}"
                                                    data-form-type="{{ $duty->form_type }}"
                                                    data-form-type-text="{{ $duty->form_type_text }}"
                                                    data-vehicle-id="{{ $duty->vehicle_id }}"
                                                    data-last-performed-by="{{ $duty->last_performed_by }}"
                                                    data-last-performed-on="{{ $duty->last_performed_on }}"
                                                    data-notes="{{ $duty->notes }}"
                                                    data-due="{{ $duty->due ? 'true' : 'false' }}">
                                                    <td class="align-middle">
                                                        <span class="fw-semibold text-dark" style="font-size: 15px;">{{ $duty->title }}</span>
                                                    </td>
                                                    <td class="align-middle">{{ $duty->frequency_text }}</td>
                                                    <td class="align-middle">
                                                        {{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <button class="btn btn-sm btn-outline-dark btn-view-notes" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}">
                                                            View Notes
                                                        </button>
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('warehouse.add')
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due cursor-pointer btn-duty-complete" data-id="{{ $duty->id }}">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed cursor-pointer btn-duty-reset" data-id="{{ $duty->id }}">Completed</span>
                                                            @endif
                                                        @else
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed">Completed</span>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-duty-complete-btn" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ $duty->due && auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            {{ $duty->due ? 'Complete' : 'Done' }}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-dark btn-duty-settings" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Settings
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                                        No duties registered in this category.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TRAILER TAB -->
                            <div class="tab-pane fade" id="trailer">
                                <div class="table-responsive">
                                    <table id="trailerTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Duty / Activity</th>
                                                <th>Frequency</th>
                                                <th>Last Performed</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 250px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($trailerTasks as $duty)
                                                <tr data-id="{{ $duty->id }}"
                                                    data-title="{{ $duty->title }}"
                                                    data-description="{{ $duty->description }}"
                                                    data-supplier="{{ $duty->supplier }}"
                                                    data-unit-of-measure="{{ $duty->unit_of_measure }}"
                                                    data-reorder-point="{{ $duty->reorder_point }}"
                                                    data-reorder-quantity="{{ $duty->reorder_quantity }}"
                                                    data-frequency="{{ $duty->frequency }}"
                                                    data-frequency-text="{{ $duty->frequency_text }}"
                                                    data-form-type="{{ $duty->form_type }}"
                                                    data-form-type-text="{{ $duty->form_type_text }}"
                                                    data-vehicle-id="{{ $duty->vehicle_id }}"
                                                    data-last-performed-by="{{ $duty->last_performed_by }}"
                                                    data-last-performed-on="{{ $duty->last_performed_on }}"
                                                    data-notes="{{ $duty->notes }}"
                                                    data-due="{{ $duty->due ? 'true' : 'false' }}">
                                                    <td class="align-middle">
                                                        <span class="fw-semibold text-dark" style="font-size: 15px;">{{ $duty->title }}</span>
                                                    </td>
                                                    <td class="align-middle">{{ $duty->frequency_text }}</td>
                                                    <td class="align-middle">
                                                        {{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <button class="btn btn-sm btn-outline-dark btn-view-notes" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}">
                                                            View Notes
                                                        </button>
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('warehouse.add')
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due cursor-pointer btn-duty-complete" data-id="{{ $duty->id }}">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed cursor-pointer btn-duty-reset" data-id="{{ $duty->id }}">Completed</span>
                                                            @endif
                                                        @else
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed">Completed</span>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-duty-complete-btn" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ $duty->due && auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            {{ $duty->due ? 'Complete' : 'Done' }}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-dark btn-duty-settings" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Settings
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                                        No duties registered in this category.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- INVENTORY TAB -->
                            <div class="tab-pane fade" id="inventory">
                                <div class="table-responsive">
                                    <table id="inventoryTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Duty / Activity</th>
                                                <th>Frequency</th>
                                                <th>Last Performed</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th class="text-center" style="width: 250px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($inventoryTasks as $duty)
                                                <tr data-id="{{ $duty->id }}"
                                                    data-title="{{ $duty->title }}"
                                                    data-description="{{ $duty->description }}"
                                                    data-supplier="{{ $duty->supplier }}"
                                                    data-unit-of-measure="{{ $duty->unit_of_measure }}"
                                                    data-reorder-point="{{ $duty->reorder_point }}"
                                                    data-reorder-quantity="{{ $duty->reorder_quantity }}"
                                                    data-frequency="{{ $duty->frequency }}"
                                                    data-frequency-text="{{ $duty->frequency_text }}"
                                                    data-form-type="{{ $duty->form_type }}"
                                                    data-form-type-text="{{ $duty->form_type_text }}"
                                                    data-vehicle-id="{{ $duty->vehicle_id }}"
                                                    data-last-performed-by="{{ $duty->last_performed_by }}"
                                                    data-last-performed-on="{{ $duty->last_performed_on }}"
                                                    data-notes="{{ $duty->notes }}"
                                                    data-due="{{ $duty->due ? 'true' : 'false' }}">
                                                    <td class="align-middle">
                                                        <span class="fw-semibold text-dark" style="font-size: 15px;">{{ $duty->title }}</span>
                                                    </td>
                                                    <td class="align-middle">{{ $duty->frequency_text }}</td>
                                                    <td class="align-middle">
                                                        {{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}
                                                    </td>
                                                    <td class="align-middle text-start">
                                                        <button class="btn btn-sm btn-outline-dark btn-view-notes" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}">
                                                            View Notes
                                                        </button>
                                                    </td>
                                                    <td class="align-middle">
                                                        @can('warehouse.add')
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due cursor-pointer btn-duty-complete" data-id="{{ $duty->id }}">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed cursor-pointer btn-duty-reset" data-id="{{ $duty->id }}">Completed</span>
                                                            @endif
                                                        @else
                                                            @if($duty->due)
                                                                <span class="status-pill status-pill-due">Due</span>
                                                            @else
                                                                <span class="status-pill status-pill-completed">Completed</span>
                                                            @endif
                                                        @endcan
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-duty-complete-btn" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ $duty->due && auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            {{ $duty->due ? 'Complete' : 'Done' }}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-dark btn-duty-settings" style="border-radius: 6px; padding: 6px 14px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Settings
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                                        No duties registered in this category.
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
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL: COMPLETE DUTY (Dashboard Fullscreen Form Pattern) -->
    <!-- ============================================================ -->
    <div class="modal fade" id="completeDutyModal" tabindex="-1" aria-labelledby="completeDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="completeDutyModalLabel">Complete Duty</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="completeDutyForm" class="company-form">
                        <input type="hidden" id="complete-duty-id">
                        <div class="row mx-0">
                            
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Duty Title</label>
                                    <div id="complete-duty-title-text" class="fw-bold text-dark p-2 bg-light rounded" style="font-size: 15px;"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="performed_by" class="form-label">Performed By</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="performed_by" name="performed_by" value="{{ auth()->user()->name ?? 'Jacob Campbell' }}" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="performed_on" class="form-label">Date & Time</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="performed_on" name="performed_on" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="notes" class="form-label">Notes</label>
                                    <span class="text-danger">*</span>
                                    <textarea class="form-control" id="notes" name="notes" rows="6" placeholder="Enter notes or observations..." required></textarea>
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

    <!-- ============================================================ -->
    <!-- MODAL: VIEW NOTES (Equipment Status History Modal Structure) -->
    <!-- ============================================================ -->
    <div class="modal fade" id="viewNotesModal" tabindex="-1" aria-labelledby="viewNotesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="modal-title fw-bold text-dark" id="viewNotesModalLabel" style="font-size: 22px;">Duty Description & Notes</h5>
                        <div id="viewNotesModalSubtitle"></div>
                    </div>
                    <button type="button" class="btn-close-circle" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="history-labels d-flex">
                    <div style="width: 55px; margin-right: 25px;"></div> <!-- Icon Spacer -->
                    <div style="width: 90px;">Date</div>
                    <div class="flex-grow-1" style="padding: 0 25px;">Note / Status Change</div>
                    <div style="width: 140px;" class="text-center">Category</div>
                    <div style="width: 150px;" class="text-end">Performed By</div>
                </div>

                <div class="modal-body p-0">
                    <div class="history-timeline-container">
                        <div class="history-timeline-line"></div>
                        <div id="viewNotesTimelineBody">
                            <!-- Dynamically populated -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn-yellow-rounded" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL: ADD DUTY (Dashboard Single Field Row Pattern) -->
    <!-- ============================================================ -->
    <div class="modal fade" id="addDutyModal" tabindex="-1" aria-labelledby="addDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="addDutyModalLabel">Create New Warehouse Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDutyForm" class="company-form">
                        <div class="row mx-0">
                            
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_title" class="form-label">Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="new_duty_title" name="title" placeholder="Enter title" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="new_duty_description" name="description" rows="5" placeholder="Enter description"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_supplier" class="form-label">Supplier</label>
                                    <input type="text" class="form-control" id="new_duty_supplier" name="supplier" placeholder="Enter supplier">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_unit_of_measure" class="form-label">Unit of Measure (if an Inventory assignment)</label>
                                    <input type="text" class="form-control" id="new_duty_unit_of_measure" name="unit_of_measure" placeholder="Enter unit of measure">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_reorder_point" class="form-label">Reorder Point</label>
                                    <input type="text" class="form-control" id="new_duty_reorder_point" name="reorder_point" placeholder="Enter reorder point">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_reorder_quantity" class="form-label">Reorder Quantity</label>
                                    <input type="text" class="form-control" id="new_duty_reorder_quantity" name="reorder_quantity" placeholder="Enter reorder quantity">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_frequency" class="form-label">Frequency</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select mt-2" id="new_duty_frequency" name="frequency" required>
                                        <option value="1">Daily</option>
                                        <option value="2">Twice/Week</option>
                                        <option value="3">Weekly</option>
                                        <option value="4">Monthly</option>
                                        <option value="5">Quarterly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_form_type" class="form-label">Form Type</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select mt-2" id="new_duty_form_type" name="form_type" required>
                                        <option value="1">Notes Only</option>
                                        <option value="2">Notes & Data</option>
                                        <option value="3">Vehicle Form</option>
                                        <option value="4">Trailer Form</option>
                                        <option value="5">Inventory Form</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="new_duty_vehicle" class="form-label">Vehicle (if applicable)</label>
                                    <select class="form-select mt-2" id="new_duty_vehicle" name="vehicle_id">
                                        <option value="0">N/A</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
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

    <!-- ============================================================ -->
    <!-- MODAL: EDIT / SETTINGS DUTY (Dashboard Single Field Row Pattern) -->
    <!-- ============================================================ -->
    <div class="modal fade" id="editDutyModal" tabindex="-1" aria-labelledby="editDutyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editDutyModalLabel">Edit Duty Settings</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDutyForm" class="company-form">
                        <input type="hidden" id="edit-duty-id">
                        <div class="row mx-0">
                            
                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_title" class="form-label">Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="edit_duty_title" name="title" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_description" class="form-label">Description</label>
                                    <textarea class="form-control" id="edit_duty_description" name="description" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_supplier" class="form-label">Supplier</label>
                                    <input type="text" class="form-control" id="edit_duty_supplier" name="supplier">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_unit_of_measure" class="form-label">Unit of Measure (if an Inventory assignment)</label>
                                    <input type="text" class="form-control" id="edit_duty_unit_of_measure" name="unit_of_measure">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_reorder_point" class="form-label">Reorder Point</label>
                                    <input type="text" class="form-control" id="edit_duty_reorder_point" name="reorder_point">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_reorder_quantity" class="form-label">Reorder Quantity</label>
                                    <input type="text" class="form-control" id="edit_duty_reorder_quantity" name="reorder_quantity">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_frequency" class="form-label">Frequency</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select mt-2" id="edit_duty_frequency" name="frequency" required>
                                        <option value="1">Daily</option>
                                        <option value="2">Twice/Week</option>
                                        <option value="3">Weekly</option>
                                        <option value="4">Monthly</option>
                                        <option value="5">Quarterly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_form_type" class="form-label">Form Type</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select mt-2" id="edit_duty_form_type" name="form_type" required>
                                        <option value="1">Notes Only</option>
                                        <option value="2">Notes & Data</option>
                                        <option value="3">Vehicle Form</option>
                                        <option value="4">Trailer Form</option>
                                        <option value="5">Inventory Form</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label for="edit_duty_vehicle" class="form-label">Vehicle (if applicable)</label>
                                    <select class="form-select mt-2" id="edit_duty_vehicle" name="vehicle_id">
                                        <option value="0">N/A</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" id="btn-delete-duty">Delete Task</button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Duties are now read directly from HTML5 data-* attributes on the table rows!

            // Simple HTML sanitizer to prevent XSS
            function escapeHtml(text) {
                if (!text) return '';
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // Set current time helper for Complete Duty Modal
            function getFormattedDateTime() {
                const now = new Date();
                const mm = String(now.getMonth() + 1).padStart(2, '0');
                const dd = String(now.getDate()).padStart(2, '0');
                const yyyy = now.getFullYear();
                
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12;
                const formattedHour = String(hours).padStart(2, '0');
                
                return `${mm}/${dd} ${formattedHour}:${minutes} ${ampm}`;
            }

            // Form Type determines category natively on server side.
            // ==========================================
            // FRONTEND VALIDATION SYSTEMS (jQuery Validation)
            // ==========================================
            $("#completeDutyForm").validate({
                ignore: [],
                rules: {
                    performed_by: {
                        required: true,
                        maxlength: 255
                    },
                    performed_on: {
                        required: true,
                        maxlength: 255
                    },
                    notes: {
                        required: true
                    }
                },
                messages: {
                    performed_by: {
                        required: "Please specify who performed the duty.",
                        maxlength: "Name cannot exceed 255 characters."
                    },
                    performed_on: {
                        required: "Please specify the date and time.",
                        maxlength: "Date and time is required."
                    },
                    notes: {
                        required: "Please enter observations or notes."
                    }
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
                    if (element.closest('.input-group').length) {
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $("#addDutyForm").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    frequency: {
                        required: true
                    },
                    form_type: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a task title.",
                        maxlength: "Title cannot exceed 255 characters."
                    },
                    frequency: {
                        required: "Please select a frequency."
                    },
                    form_type: {
                        required: "Please select a form type."
                    }
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
                    if (element.closest('.input-group').length) {
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $("#editDutyForm").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    frequency: {
                        required: true
                    },
                    form_type: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a task title.",
                        maxlength: "Title cannot exceed 255 characters."
                    },
                    frequency: {
                        required: "Please select a frequency."
                    },
                    form_type: {
                        required: "Please select a form type."
                    }
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
                    if (element.closest('.input-group').length) {
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // ==========================================
            // ACTION: TRIGGER COMPLETE DUTY MODAL
            // ==========================================
            $(document).on('click', '.btn-duty-complete, .btn-duty-complete-btn', function() {
                const id = $(this).data('id');
                const row = $(`tr[data-id="${id}"]`).first();

                if (row.length && (row.data('due') === true || row.data('due') === 'true')) {
                    $('#complete-duty-id').val(id);
                    $('#complete-duty-title-text').text(row.data('title'));
                    $('#performed_on').val(getFormattedDateTime());
                    $('#notes').val('');
                    
                    // Reset validation state
                    const validator = $('#completeDutyForm').validate();
                    validator.resetForm();
                    $('#completeDutyForm').find('.is-invalid').removeClass('is-invalid');

                    $('#completeDutyModal').modal('show');
                }
            });

            // Submit Complete Duty Form
            $('#completeDutyForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);

                if (!form.valid()) {
                    return;
                }

                const id = $('#complete-duty-id').val();
                const performer = $('#performed_by').val();
                const performedOn = $('#performed_on').val();
                const noteVal = $('#notes').val();

                $.ajax({
                    url: `/admin/warehouse/tasks/complete/${id}`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        last_performed_by: performer,
                        last_performed_on: performedOn,
                        notes: noteVal
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#completeDutyModal').modal('hide');
                            toastr.success('Duty completed successfully!');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
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
                            'Error completing task.'
                        );
                    }
                });
            });

            // ==========================================
            // ACTION: TRIGGER VIEW NOTES MODAL
            // ==========================================
            $(document).on('click', '.btn-view-notes', function() {
                const id = $(this).data('id');
                const row = $(`tr[data-id="${id}"]`).first();

                if (row.length) {
                    const title = row.data('title');
                    const description = row.data('description') || '';
                    const supplier = row.data('supplier') || '';
                    const frequencyText = row.data('frequency-text') || '';
                    const formTypeText = row.data('form-type-text') || '';
                    const lastPerformedBy = row.data('last-performed-by') || '';
                    const lastPerformedOn = row.data('last-performed-on') || '';
                    const notes = row.data('notes') || '';
                    const formTypeVal = row.data('form-type');

                    // Map category dynamically based on formTypeVal (1=general, 2=data, 3=vehicle, 4=trailer, 5=inventory)
                    let category = 'General';
                    if (formTypeVal == 2) category = 'Data';
                    else if (formTypeVal == 3) category = 'Vehicle';
                    else if (formTypeVal == 4) category = 'Trailer';
                    else if (formTypeVal == 5) category = 'Inventory';

                    const descText = description ? `  ·  Description: ${description}` : '';
                    $('#viewNotesModalSubtitle').html(
                        `Frequency: ${escapeHtml(frequencyText)}  ·  Form Type: ${escapeHtml(formTypeText)}${escapeHtml(descText)}`
                    );

                    // Rebuild Timeline Body based on Equipment history timeline architecture
                    let timelineHtml = '';

                    if (!lastPerformedBy) {
                        // Empty/unperformed state timeline
                        timelineHtml = `
                            <div class="timeline-item">
                                <div class="timeline-icon" style="background-color: #dc2626;">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <div class="history-card">
                                    <div class="history-date">
                                        <div class="text-dark">-</div>
                                    </div>
                                    <div class="history-content">
                                        <div class="history-note text-muted fst-italic">No history records or completion notes logged for this duty yet.</div>
                                        <div class="history-status-change">
                                            <span class="status-pill status-pill-due">Due</span>
                                        </div>
                                    </div>
                                    <div class="history-category">
                                        ${escapeHtml(category)}
                                    </div>
                                    <div class="history-user">
                                        -
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        // Performed state timeline
                        timelineHtml = `
                            <div class="timeline-item">
                                <div class="timeline-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="history-card">
                                    <div class="history-date">
                                        <div class="text-dark">${escapeHtml(lastPerformedOn)}</div>
                                    </div>
                                    <div class="history-content">
                                        <div class="history-note" style="white-space: pre-wrap;">${escapeHtml(notes)}</div>
                                        <div class="history-status-change">
                                            <span class="status-pill status-pill-due">Due</span>
                                            <i class="fas fa-long-arrow-alt-right mx-1"></i>
                                            <span class="status-pill status-pill-completed">Completed</span>
                                        </div>
                                    </div>
                                    <div class="history-category">
                                        ${escapeHtml(category)}
                                    </div>
                                    <div class="history-user">
                                        ${escapeHtml(lastPerformedBy)}
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    $('#viewNotesTimelineBody').html(timelineHtml);
                    $('#viewNotesModal').modal('show');
                }
            });

            // ==========================================
            // ACTION: RESET DUTY (Mark as Due Again)
            // ==========================================
            $(document).on('click', '.btn-duty-reset', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: `/admin/warehouse/tasks/reset/${id}`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            toastr.info('Duty is now flagged as DUE again.');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Error resetting task status.'
                        );
                    }
                });
            });

            // Reset validation states when Triggering Add Duty Modal
            $('#addDutyModal').on('show.bs.modal', function () {
                const validator = $('#addDutyForm').validate();
                validator.resetForm();
                $('#addDutyForm').find('.is-invalid').removeClass('is-invalid');
                $('#addDutyForm')[0].reset();
            });

            // ==========================================
            // ACTION: TRIGGER ADD DUTY FORM
            // ==========================================
            $('#addDutyForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);

                if (!form.valid()) {
                    return;
                }
                
                const title = $('#new_duty_title').val();
                const description = $('#new_duty_description').val();
                const supplier = $('#new_duty_supplier').val();
                const unit_of_measure = $('#new_duty_unit_of_measure').val();
                const reorder_point = $('#new_duty_reorder_point').val();
                const reorder_quantity = $('#new_duty_reorder_quantity').val();
                const frequency = $('#new_duty_frequency').val();
                const form_type = $('#new_duty_form_type').val();
                const vehicle_id = $('#new_duty_vehicle').val();

                $.ajax({
                    url: "{{ route('admin.warehouse.tasks.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        title: title,
                        description: description,
                        supplier: supplier,
                        unit_of_measure: unit_of_measure,
                        reorder_point: reorder_point,
                        reorder_quantity: reorder_quantity,
                        frequency: frequency,
                        form_type: form_type,
                        vehicle_id: vehicle_id === '0' ? null : vehicle_id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Reset form validation state and inputs
                            form.validate().resetForm();
                            form.find('.is-invalid').removeClass('is-invalid');
                            form[0].reset();
                            $('#addDutyModal').modal('hide');
                            
                            toastr.success('New warehouse duty added!');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
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
                            'Error creating warehouse task. Please review requirements.'
                        );
                    }
                });
            });

            // ==========================================
            // ACTION: TRIGGER EDIT DUTY MODAL
            // ==========================================
            $(document).on('click', '.btn-duty-settings', function() {
                const id = $(this).data('id');
                const row = $(`tr[data-id="${id}"]`).first();

                if (row.length) {
                    $('#edit-duty-id').val(id);
                    $('#edit_duty_title').val(row.data('title'));
                    $('#edit_duty_description').val(row.data('description') || '');
                    $('#edit_duty_supplier').val(row.data('supplier') || '');
                    $('#edit_duty_unit_of_measure').val(row.data('unit-of-measure') || '');
                    $('#edit_duty_reorder_point').val(row.data('reorder-point') || '');
                    $('#edit_duty_reorder_quantity').val(row.data('reorder-quantity') || '');
                    $('#edit_duty_frequency').val(row.data('frequency'));
                    $('#edit_duty_form_type').val(row.data('form-type'));
                    $('#edit_duty_vehicle').val(row.data('vehicle-id') || '0');

                    // Reset validation errors
                    const validator = $('#editDutyForm').validate();
                    validator.resetForm();
                    $('#editDutyForm').find('.is-invalid').removeClass('is-invalid');

                    $('#editDutyModal').modal('show');
                }
            });

            // Save Edit Duty Changes
            $('#editDutyForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);

                if (!form.valid()) {
                    return;
                }

                const id = $('#edit-duty-id').val();
                const title = $('#edit_duty_title').val();
                const description = $('#edit_duty_description').val();
                const supplier = $('#edit_duty_supplier').val();
                const unit_of_measure = $('#edit_duty_unit_of_measure').val();
                const reorder_point = $('#edit_duty_reorder_point').val();
                const reorder_quantity = $('#edit_duty_reorder_quantity').val();
                const frequency = $('#edit_duty_frequency').val();
                const form_type = $('#edit_duty_form_type').val();
                const vehicle_id = $('#edit_duty_vehicle').val();

                $.ajax({
                    url: `/admin/warehouse/tasks/update/${id}`,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        title: title,
                        description: description,
                        supplier: supplier,
                        unit_of_measure: unit_of_measure,
                        reorder_point: reorder_point,
                        reorder_quantity: reorder_quantity,
                        frequency: frequency,
                        form_type: form_type,
                        vehicle_id: vehicle_id === '0' ? null : vehicle_id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Reset validation state
                            form.validate().resetForm();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('#editDutyModal').modal('hide');
                            toastr.success('Duty settings updated!');
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
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
                            'Error updating task.'
                        );
                    }
                });
            });

            // Delete Duty
            $('#btn-delete-duty').on('click', function() {
                const id = $('#edit-duty-id').val();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this warehouse duty!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffb81c',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/warehouse/tasks/delete/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    $('#editDutyModal').modal('hide');
                                    toastr.error('Warehouse duty deleted.');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            },
                            error: function(xhr) {
                                toastr.error(
                                    xhr.responseJSON?.message ||
                                    'Error deleting task.'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
