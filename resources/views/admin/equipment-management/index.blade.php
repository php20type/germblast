@extends('admin.includes.layout')

@section('title', 'Equipment Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Modern Soft Tabs Styling */
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

        /* Status Badge from Reference */
        .status-pill {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .status-pill-dirty {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pill-ready {
            background: #eef2ff;
            color: #4f46e5;
        }

        .status-pill-inuse {
            background: #fef3c7;
            color: #92400e;
        }

        .status-pill-assigned {
            background: #fef3c7;
            color: #92400e;
        }

        .status-pill-broken {
            background: #eff6ff;
            color: #3b82f6;
        }

        .status-pill-lost {
            background: #f3f4f6;
            color: #4b5563;
        }

        .status-pill-decommissioned {
            background: #f1f5f9;
            color: #334155;
        }

        /* Timeline History Styles */
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

        .history-office {
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
        #equipmentHistoryModal .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        #equipmentHistoryModal .modal-header {
            padding: 35px 40px 25px 40px;
            border-bottom: none !important;
        }

        #historyModalSubtitle {
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
                                <h3 class="mb-1">Equipment Manager</h3>
                                <p class="text-muted mb-0">Track and analyze equipment status across your organization.</p>
                            </div>
                            @can('equipment_manager.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
                                    + CREATE EQUIPMENT
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- TABS -->
                        <div class="navbar-tabs px-4">
                            <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dirty">Dirty <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="dirty-count">{{ $dirtyCount }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ready">Ready <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="ready-count">{{ $readyCount }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inuse">In Use <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="inuse-count">{{ $inUseCount }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#broken">Broken <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="broken-count">{{ $brokenCount }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lost">Lost <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="lost-count">{{ $lostCount }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#decommissioned">Decommissioned
                                    <span class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="decommissioned-count">{{ $decommissionedCount }}</span></button>

                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">All <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="all-count">{{ $allCount }}</span></button>
                            </nav>
                        </div>

                        <hr class="mb-4 mt-0" style="opacity: 0.1;">

                        <!-- TAB CONTENT -->
                        <div class="tab-content px-4">

                            <div class="tab-pane fade show" id="dirty">
                                <div class="table-responsive">
                                    <table id="dirtyTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $dirtyTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="ready">
                                <div class="table-responsive">
                                    <table id="readyTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $readyTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="inuse">
                                <div class="table-responsive">
                                    <table id="inuseTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $inUseTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="broken">
                                <div class="table-responsive">
                                    <table id="brokenTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $brokenTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="lost">
                                <div class="table-responsive">
                                    <table id="lostTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $lostTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="decommissioned">
                                <div class="table-responsive">
                                    <table id="decommissionedTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $decommissionedTypes])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade show active" id="all">
                                <div class="table-responsive">
                                    <table id="allTable" class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Barcode</th>
                                                <th>Serial #</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $allTypes])
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

    <div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="addEquipmentModalLabel">Create New Equipment</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <form action="{{ route('admin.equipment-management.store') }}" method="POST">
                        @csrf

                        <div class="row mx-0">

                            {{-- Barcode --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Barcode</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="barcode" class="form-control" placeholder="Enter Barcode"
                                        required>
                                </div>
                            </div>

                            {{-- Serial Number --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Serial Number</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="serial_number" class="form-control"
                                        placeholder="Enter Serial Number" required>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Equipment Type</label>
                                    <span class="text-danger">*</span>
                                    <select name="type_id" class="form-control" required>
                                        <option value="">Select Type</option>
                                        @foreach($equipmentTypes as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- ============================================================ --}}
    {{-- UNIVERSAL STATUS CHANGE MODAL --}}
    {{-- ============================================================ --}}
    @can('equipment_manager.add')
    <div class="modal fade" id="universalStatusModal" tabindex="-1" aria-labelledby="universalStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="universalStatusModalLabel">Change Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="universalStatusForm" method="POST">
                    @csrf
                    <div class="modal-body" id="universalModalBody">
                        <!-- Dynamically populated based on status -->
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- ============================================================ --}}
    {{-- EQUIPMENT STATUS HISTORY MODAL --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="equipmentHistoryModal" tabindex="-1" aria-labelledby="equipmentHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="modal-title" id="historyModalTitle">Equipment Status History</h5>
                        <div id="historyModalSubtitle"></div>
                    </div>
                    <button type="button" class="btn-close-circle" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="history-labels d-flex">
                    <div style="width: 55px; margin-right: 25px;"></div> <!-- Icon Spacer -->
                    <div style="width: 90px;">Date</div>
                    <div class="flex-grow-1" style="padding: 0 25px;">Note / Status Change</div>
                    <div style="width: 140px;" class="text-center">Office</div>
                    <div style="width: 150px;" class="text-end">Changed By</div>
                </div>

                <div class="modal-body p-0">
                    <div class="history-timeline-container">
                        <div class="history-timeline-line"></div>
                        <div id="historyTimelineBody">
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

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        /**
         * Build the update-status URL for a given equipment ID.
         */
        function buildStatusUrl(equipmentId) {
            return '/admin/equipment-management/update-status/' + equipmentId;
        }

        /**
         * Reset all textarea and select fields inside a form.
         */
        function resetForm(formId) {
            var form = document.getElementById(formId);
            if (form) {
                form.querySelectorAll('textarea').forEach(function (el) { el.value = ''; });
                form.querySelectorAll('select').forEach(function (el) { el.selectedIndex = 0; });
            }
        }

        /* ------------------------------------------------------------------
         * STATUS TRANSITIONS & CONFIGURATION
         * ------------------------------------------------------------------ */
        var statusTransitions = {
            'new': ['ready'],
            'ready': ['lost', 'broken', 'dirty'],
            'dirty': ['ready'],
            'broken': ['dirty', 'broken', 'lost', 'decommissioned'],
            'lost': ['dirty', 'broken', 'lost', 'decommissioned'],
            'decommissioned': ['dirty', 'broken', 'lost'],
            'assigned': ['dirty', 'broken', 'lost'],
        };

        var modalConfig = {
            'dirty': {
                title: 'Clean and Inspect Equipment',
                isDirtyStatus: true
            },
            'ready': {
                title: 'Change Status'
            },
            'broken': {
                title: 'Change Status'
            },
            'lost': {
                title: 'Change Status'
            },
            'decommissioned': {
                title: 'Change Status'
            },
            'assigned': {
                title: 'Change Status'
            }
        };

        function capitalize(str) {
            if (!str) return '';
            return str.charAt(0).toUpperCase() + str.slice(1).replace(/_/g, ' ');
        }

        function getStatusLabel(status, fromStatus) {
            if (status === 'dirty' && fromStatus === 'broken') {
                return 'Fixed';
            } else if (status === 'dirty' && fromStatus === 'lost') {
                return 'Found';
            } else if (status === 'dirty' && fromStatus === 'decommissioned') {
                return 'Fixed';
            }
            return capitalize(status);
        }

        function buildModalBody(currentStatus) {
            var config = modalConfig[currentStatus] || { title: 'Change Status' };
            var transitions = statusTransitions[currentStatus] || [];
            var territories = @json($territories);

            // Special case for dirty status
            if (currentStatus === 'dirty') {
                return `
                    <p>I am certifying that I have cleaned and inspected this unit for damage.</p>
                    <input type="hidden" name="status" value="ready">
                    <input type="hidden" name="note" value="Cleaned and inspected this unit for damage.">
                `;
            }

            // General case for other statuses
            var html = `
                <div class="mb-3">
                    <label class="form-label">Document the Status Change</label>
                    <textarea name="note" class="form-control" rows="4" placeholder="Enter reason for status change"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">Select Status</option>
            `;

            transitions.forEach(function (status) {
                var label = getStatusLabel(status, currentStatus);
                html += `<option value="${status}">${label}</option>`;
            });

            html += `
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Office</label>
                    <select name="office" class="form-control">
                        <option value="">Select Office</option>
            `;

            territories.forEach(function (territory) {
                html += `<option value="${territory.id}">${territory.name}</option>`;
            });

            html += `
                    </select>
                </div>
            `;

            return html;
        }

        /* ------------------------------------------------------------------
         * OPEN STATUS MODAL  →  openStatusModal(el)
         * Opens universal modal based on equipment's current status
         * ------------------------------------------------------------------ */
        function openStatusModal(el) {
            var id = el.getAttribute('data-id');
            var currentStatus = el.getAttribute('data-status');

            var form = document.getElementById('universalStatusForm');
            form.action = buildStatusUrl(id);

            // Clear form
            form.querySelectorAll('textarea').forEach(function (el) { el.value = ''; });
            form.querySelectorAll('select').forEach(function (el) { el.selectedIndex = 0; });

            // Update modal title
            var config = modalConfig[currentStatus] || { title: 'Change Status' };
            document.getElementById('universalStatusModalLabel').textContent = config.title;

            // Build and set modal body
            var modalBody = document.getElementById('universalModalBody');
            modalBody.innerHTML = buildModalBody(currentStatus);

            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('universalStatusModal'));
            modal.show();
        }

        /* ------------------------------------------------------------------
         * LEGACY FUNCTIONS - MAINTAINED FOR COMPATIBILITY
         * These now delegate to openStatusModal
         * ------------------------------------------------------------------ */
        function openDirtyModal(el) { openStatusModal(el); }
        function openReadyModal(el) { openStatusModal(el); }
        function openBrokenModal(el) { openStatusModal(el); }
        function openLostModal(el) { openStatusModal(el); }
        function openDecommissionedModal(el) { openStatusModal(el); }
        function openInUseModal(el) { openStatusModal(el); }

        function openEditModal(el) {
            openStatusModal(el);
        }

        /* ------------------------------------------------------------------
         * VIEW HISTORY  →  openHistoryModal(btn)
         * Fetches status logs via AJAX and renders them in the history modal.
         * ------------------------------------------------------------------ */
        function openHistoryModal(btn) {
            var id = btn.getAttribute('data-id');

            // Show modal immediately with loading state
            var historyModalEl = document.getElementById('equipmentHistoryModal');
            var historyModal = new bootstrap.Modal(historyModalEl);

            document.getElementById('historyModalSubtitle').innerHTML = 'Loading...';
            document.getElementById('historyTimelineBody').innerHTML =
                '<div class="text-center py-5 text-muted">Loading history details&hellip;</div>';

            historyModal.show();

            // Fetch logs
            fetch('/admin/equipment-management/' + id + '/history', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    var eq = data.equipment;

                    // Subtitle
                    document.getElementById('historyModalSubtitle').innerHTML =
                        eq.type + '  ·  Barcode: ' + eq.barcode + '  ·  Serial #: ' + (eq.serial_number || 'N/A') + '  ·  Current Status: ' + eq.status;

                    var container = document.getElementById('historyTimelineBody');

                    if (!data.logs || data.logs.length === 0) {
                        container.innerHTML = '<div class="text-center py-5 text-muted">No history records found.</div>';
                        return;
                    }

                    container.innerHTML = data.logs.map(function (log) {
                        var note = log.note ? log.note : '<span class="text-muted fst-italic">No note</span>';
                        var icon = (log.to_status || '').toLowerCase() === 'ready' ? 'fa-calendar-check' : 'fa-sync-alt';

                        return `
                                    <div class="timeline-item">
                                        <div class="timeline-icon">
                                            <i class="fas ${icon}"></i>
                                        </div>
                                        <div class="history-card">
                                            <div class="history-date">
                                                <div class="text-dark">${log.date}</div>
                                            </div>
                                            <div class="history-content">
                                                <div class="history-note">${note}</div>
                                                <div class="history-status-change">
                                                    <span class="status-pill status-pill-${(log.from_status || '').toLowerCase()}">${capitalize(log.from_status)}</span>
                                                    <i class="fas fa-long-arrow-alt-right mx-1"></i>
                                                    <span class="status-pill status-pill-${(log.to_status || '').toLowerCase()}">${capitalize(log.to_status)}</span>
                                                </div>
                                            </div>
                                            <div class="history-office">
                                                ${log.territory || '—'}
                                            </div>
                                            <div class="history-user">
                                                ${log.changed_by || 'System'}
                                            </div>
                                        </div>
                                    </div>
                                `;
                    }).join('');
                })
                .catch(function (err) {
                    document.getElementById('historyTimelineBody').innerHTML =
                        '<div class="text-center py-5 text-muted">Error loading history.</div>';
                });
        }

        /* ------------------------------------------------------------------
         * DATATABLE INITIALIZATION
         * ------------------------------------------------------------------ */
        $(document).ready(function () {
            const tableConfig = {
                // pageLength: 2,
                // lengthMenu: [2, 4, 8, 16],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: false,
                responsive: false,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: {
                        previous: '< Previous',
                        next: 'Next >'
                    }
                },
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
            };

            function initDataTable(tableId) {
                if (!$.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable(tableConfig);
                }
            }

            // Initialize active tab on load
            const activeTabId = $('.tab-pane.active').find('table').attr('id');
            if (activeTabId) {
                initDataTable(activeTabId);
            }

            // Lazy initialization on tab switch
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetId = $(e.target).data('bs-target').replace('#', '');
                const tableId = $('#' + targetId).find('table').attr('id');
                if (tableId) {
                    initDataTable(tableId);
                    // Adjust columns for responsiveness/alignment
                    $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
                }
            });
        });

    </script>
@endpush