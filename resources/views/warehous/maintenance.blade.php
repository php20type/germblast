@extends('admin.includes.layout')

@section('title', 'Warehouse Maintenance Dashboard')

@push('styles')
    <style>
        /* Section Cards */
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

        /* Status Pills styling */
        .status-pill {
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 4px 10px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-due {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
        }

        .status-pill-completed {
            background-color: rgba(111, 66, 193, 0.12) !important;
            color: #6f42c1 !important;
            border-color: rgba(111, 66, 193, 0.2) !important;
        }

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

                        <div class="alert alert-info d-flex align-items-center mb-4 mx-4" role="alert" style="border-radius: 12px; font-size: 14px; background-color: #e0f2fe; border-color: #bae6fd; color: #0369a1;">
                            <i class="fas fa-info-circle me-3" style="font-size: 20px;"></i>
                            <div>
                                <strong>How it works:</strong> The "Complete" button will automatically reappear when the task is due again, based on its <strong>Service Frequency</strong> (e.g., Daily tasks will become due again at midnight).
                            </div>
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
                                <div class="pb-4 text-start">
                                    @forelse($generalTasks as $duty)
                                        <div class="section-card mt-3 duty-card"
                                            data-id="{{ $duty->id }}"
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
                                            
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @if($duty->due)
                                                            <span class="status-pill status-pill-due">Due</span>
                                                        @else
                                                            <span class="status-pill status-pill-completed">Completed</span>
                                                        @endif
                                                        <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                            {{ $duty->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency_text }}</span> | 
                                                        Last Performed: <span class="fw-semibold text-dark">{{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary view-more-btn py-1 px-3" style="border-radius: 6px;" data-target="details-duty-{{ $duty->id }}">
                                                            View More
                                                        </button>
                                                        @if($duty->due)
                                                        <button class="btn btn-outline-success btn-duty-complete-btn py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Complete
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-outline-warning btn-duty-settings py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                                <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                    {{ $duty->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                @if($duty->supplier)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Supplier</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->supplier }}</div>
                                                </div>
                                                @endif
                                                @if($duty->unit_of_measure)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Unit of Measure</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->unit_of_measure }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_point)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Point</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_point }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_quantity)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Quantity</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_quantity }}</div>
                                                </div>
                                                @endif
                                                @if($duty->vehicle_id && $duty->vehicle)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Vehicle</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->vehicle->name ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Expandable History Details -->
                                            <div id="details-duty-{{ $duty->id }}" class="mt-4 pt-3 border-top" style="display: none;">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Completion History:</h6>
                                                @if($duty->completions->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No completion records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($duty->completions as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->user->name ?? 'Unknown User' }}</span>
                                                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1" style="font-size: 12px; border: 1px solid #e5e7eb;">{{ $record->completed_at->format('M d, Y h:i A') }}</span>
                                                                </div>
                                                                @if($record->notes)
                                                                    <div class="text-muted mt-2" style="font-size: 13px;">{{ $record->notes }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                            No duties registered in this category.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- DATA TAB -->
                            <div class="tab-pane fade" id="data">
                                <div class="pb-4 text-start">
                                    @forelse($dataTasks as $duty)
                                        <div class="section-card mt-3 duty-card"
                                            data-id="{{ $duty->id }}"
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
                                            
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @if($duty->due)
                                                            <span class="status-pill status-pill-due">Due</span>
                                                        @else
                                                            <span class="status-pill status-pill-completed">Completed</span>
                                                        @endif
                                                        <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                            {{ $duty->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency_text }}</span> | 
                                                        Last Performed: <span class="fw-semibold text-dark">{{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary view-more-btn py-1 px-3" style="border-radius: 6px;" data-target="details-duty-{{ $duty->id }}">
                                                            View More
                                                        </button>
                                                        @if($duty->due)
                                                        <button class="btn btn-outline-success btn-duty-complete-btn py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Complete
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-outline-warning btn-duty-settings py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                                <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                    {{ $duty->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                @if($duty->supplier)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Supplier</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->supplier }}</div>
                                                </div>
                                                @endif
                                                @if($duty->unit_of_measure)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Unit of Measure</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->unit_of_measure }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_point)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Point</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_point }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_quantity)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Quantity</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_quantity }}</div>
                                                </div>
                                                @endif
                                                @if($duty->vehicle_id && $duty->vehicle)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Vehicle</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->vehicle->name ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Expandable History Details -->
                                            <div id="details-duty-{{ $duty->id }}" class="mt-4 pt-3 border-top" style="display: none;">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Completion History:</h6>
                                                @if($duty->completions->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No completion records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($duty->completions as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->user->name ?? 'Unknown User' }}</span>
                                                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1" style="font-size: 12px; border: 1px solid #e5e7eb;">{{ $record->completed_at->format('M d, Y h:i A') }}</span>
                                                                </div>
                                                                @if($record->notes)
                                                                    <div class="text-muted mt-2" style="font-size: 13px;">{{ $record->notes }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                            No duties registered in this category.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- VEHICLE TAB -->
                            <div class="tab-pane fade" id="vehicle">
                                <div class="pb-4 text-start">
                                    @forelse($vehicleTasks as $duty)
                                        <div class="section-card mt-3 duty-card"
                                            data-id="{{ $duty->id }}"
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
                                            
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @if($duty->due)
                                                            <span class="status-pill status-pill-due">Due</span>
                                                        @else
                                                            <span class="status-pill status-pill-completed">Completed</span>
                                                        @endif
                                                        <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                            {{ $duty->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency_text }}</span> | 
                                                        Last Performed: <span class="fw-semibold text-dark">{{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary view-more-btn py-1 px-3" style="border-radius: 6px;" data-target="details-duty-{{ $duty->id }}">
                                                            View More
                                                        </button>
                                                        @if($duty->due)
                                                        <button class="btn btn-outline-success btn-duty-complete-btn py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Complete
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-outline-warning btn-duty-settings py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                                <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                    {{ $duty->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                @if($duty->supplier)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Supplier</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->supplier }}</div>
                                                </div>
                                                @endif
                                                @if($duty->unit_of_measure)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Unit of Measure</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->unit_of_measure }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_point)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Point</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_point }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_quantity)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Quantity</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_quantity }}</div>
                                                </div>
                                                @endif
                                                @if($duty->vehicle_id && $duty->vehicle)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Vehicle</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->vehicle->name ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Expandable History Details -->
                                            <div id="details-duty-{{ $duty->id }}" class="mt-4 pt-3 border-top" style="display: none;">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Completion History:</h6>
                                                @if($duty->completions->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No completion records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($duty->completions as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->user->name ?? 'Unknown User' }}</span>
                                                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1" style="font-size: 12px; border: 1px solid #e5e7eb;">{{ $record->completed_at->format('M d, Y h:i A') }}</span>
                                                                </div>
                                                                @if($record->notes)
                                                                    <div class="text-muted mt-2" style="font-size: 13px;">{{ $record->notes }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                            No duties registered in this category.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- TRAILER TAB -->
                            <div class="tab-pane fade" id="trailer">
                                <div class="pb-4 text-start">
                                    @forelse($trailerTasks as $duty)
                                        <div class="section-card mt-3 duty-card"
                                            data-id="{{ $duty->id }}"
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
                                            
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @if($duty->due)
                                                            <span class="status-pill status-pill-due">Due</span>
                                                        @else
                                                            <span class="status-pill status-pill-completed">Completed</span>
                                                        @endif
                                                        <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                            {{ $duty->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency_text }}</span> | 
                                                        Last Performed: <span class="fw-semibold text-dark">{{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary view-more-btn py-1 px-3" style="border-radius: 6px;" data-target="details-duty-{{ $duty->id }}">
                                                            View More
                                                        </button>
                                                        @if($duty->due)
                                                        <button class="btn btn-outline-success btn-duty-complete-btn py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Complete
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-outline-warning btn-duty-settings py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                                <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                    {{ $duty->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                @if($duty->supplier)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Supplier</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->supplier }}</div>
                                                </div>
                                                @endif
                                                @if($duty->unit_of_measure)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Unit of Measure</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->unit_of_measure }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_point)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Point</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_point }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_quantity)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Quantity</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_quantity }}</div>
                                                </div>
                                                @endif
                                                @if($duty->vehicle_id && $duty->vehicle)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Vehicle</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->vehicle->name ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Expandable History Details -->
                                            <div id="details-duty-{{ $duty->id }}" class="mt-4 pt-3 border-top" style="display: none;">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Completion History:</h6>
                                                @if($duty->completions->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No completion records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($duty->completions as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">   
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->user->name ?? 'Unknown User' }}</span>
                                                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1" style="font-size: 12px; border: 1px solid #e5e7eb;">{{ $record->completed_at->format('M d, Y h:i A') }}</span>
                                                                </div>
                                                                @if($record->notes)
                                                                    <div class="text-muted mt-2" style="font-size: 13px;">{{ $record->notes }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                            No duties registered in this category.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- INVENTORY TAB -->
                            <div class="tab-pane fade" id="inventory">
                                <div class="pb-4 text-start">
                                    @forelse($inventoryTasks as $duty)
                                        <div class="section-card mt-3 duty-card"
                                            data-id="{{ $duty->id }}"
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
                                            
                                            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @if($duty->due)
                                                            <span class="status-pill status-pill-due">Due</span>
                                                        @else
                                                            <span class="status-pill status-pill-completed">Completed</span>
                                                        @endif
                                                        <h4 class="mb-0" style="font-size: 18px; color: #111827;">
                                                            {{ $duty->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        Frequency: <span class="fw-semibold text-dark">{{ $duty->frequency_text }}</span> | 
                                                        Last Performed: <span class="fw-semibold text-dark">{{ $duty->last_performed_by ? $duty->last_performed_by . ' (' . $duty->last_performed_on . ')' : '-' }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-outline-primary view-more-btn py-1 px-3" style="border-radius: 6px;" data-target="details-duty-{{ $duty->id }}">
                                                            View More
                                                        </button>
                                                        @if($duty->due)
                                                        <button class="btn btn-outline-success btn-duty-complete-btn py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Complete
                                                        </button>
                                                        @endif
                                                        <button class="btn btn-outline-warning btn-duty-settings py-1 px-3" style="border-radius: 6px;" data-id="{{ $duty->id }}" {{ auth()->user()->can('warehouse.add') ? '' : 'disabled' }}>
                                                            Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Description</h6>
                                                <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                    {{ $duty->description ?? 'No description provided.' }}
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                @if($duty->supplier)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Supplier</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->supplier }}</div>
                                                </div>
                                                @endif
                                                @if($duty->unit_of_measure)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Unit of Measure</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->unit_of_measure }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_point)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Point</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_point }}</div>
                                                </div>
                                                @endif
                                                @if($duty->reorder_quantity)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Reorder Quantity</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->reorder_quantity }}</div>
                                                </div>
                                                @endif
                                                @if($duty->vehicle_id && $duty->vehicle)
                                                <div class="col-md-3">
                                                    <div class="text-uppercase text-secondary fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Vehicle</div>
                                                    <div class="text-dark" style="font-size: 16px;">{{ $duty->vehicle->name ?? 'N/A' }}</div>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Expandable History Details -->
                                            <div id="details-duty-{{ $duty->id }}" class="mt-4 pt-3 border-top" style="display: none;">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Completion History:</h6>
                                                @if($duty->completions->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No completion records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($duty->completions as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->user->name ?? 'Unknown User' }}</span>
                                                                    <span class="badge bg-light text-secondary rounded-pill px-2 py-1" style="font-size: 12px; border: 1px solid #e5e7eb;">{{ $record->completed_at->format('M d, Y h:i A') }}</span>
                                                                </div>
                                                                @if($record->notes)
                                                                    <div class="text-muted mt-2" style="font-size: 13px;">{{ $record->notes }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 text-secondary d-block"></i>
                                            No duties registered in this category.
                                        </div>
                                    @endforelse
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
                            <button type="button" class="btn btn-danger" id="btn-delete-duty">Delete</button>
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
            // Handle active tab based on URL query parameter ?tab=...
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            
            if (tabParam) {
                const targetTab = $('.nav-tabs button[data-bs-target="#' + tabParam + '"]');
                if (targetTab.length) {
                    $('.nav-tabs button').removeClass('active');
                    $('.tab-pane').removeClass('show active');
                    targetTab.addClass('active');
                    $('#' + tabParam).addClass('show active');
                }
            } 
            
            $('button[data-bs-toggle="tab"]').on("click", function() {
                const targetId = $(this).data("bs-target").substring(1); // remove '#'
                let newUrl = new URL(window.location.href);
                if(targetId === "general") {
                    newUrl.searchParams.delete('tab');
                } else {
                    newUrl.searchParams.set('tab', targetId);
                }
                history.replaceState(null, null, newUrl.toString());
            });

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
                const row = $(`.duty-card[data-id="${id}"]`).first();

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
            // ACTION: TOGGLE VIEW MORE DETAILS
            // ==========================================
            $(document).on('click', '.view-more-btn', function(e) {
                e.preventDefault();
                const targetId = $(this).data('target');
                $('#' + targetId).slideToggle(200);
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
                const row = $(`.duty-card[data-id="${id}"]`).first();

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
