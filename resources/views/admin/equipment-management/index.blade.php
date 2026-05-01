@extends('admin.includes.layout')

@section('title', 'Equipment Report')

@section('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }
    </style>
@endsection


@section('content')

    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <div class="sales-dashboard">

                        <!-- HEADER (same style usage) -->
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center"
                            style="background:#ffb400;">
                            <div class="container-fluid px-0">
                                <h1 class="display-6 mb-0 text-white">Equipment Report</h1>
                            </div>
                            {{-- <button class="btn text-white fs-4">+</button> --}}
                            <button class="btn text-white fs-4" data-bs-toggle="modal"
                                data-bs-target="#addEquipmentModal">+</button>
                        </div>

                    </div>

                    <!-- TABS (EXACT fulfill order structure) -->
                    <nav class="nav nav-fill w-100 nav-tabs border-bottom mb-3" role="tablist">

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dirty">Dirty <span
                                class="badge bg-secondary" id="dirty-count">{{ $dirtyCount }}</span></button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ready">Ready <span
                                class="badge bg-secondary" id="ready-count">{{ $readyCount }}</span></button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inuse">In Use <span
                                class="badge bg-secondary" id="inuse-count">{{ $inUseCount }}</span></button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#broken">Broken <span
                                class="badge bg-secondary" id="broken-count">{{ $brokenCount }}</span></button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lost">Lost <span
                                class="badge bg-secondary" id="lost-count">{{ $lostCount }}</span></button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#decommissioned">Decommissioned <span
                                class="badge bg-secondary"
                                id="decommissioned-count">{{ $decommissionedCount }}</span></button>

                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">All <span
                                class="badge bg-secondary" id="all-count">{{ $allCount }}</span></button>

                    </nav>

                    <!-- TAB CONTENT (same pattern as fulfill order) -->
                    <div class="tab-content">

                        <div class="tab-pane fade show" id="dirty">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="dirty"
                                            placeholder="Search dirty equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="dirty-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $dirtyTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show" id="ready">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="ready"
                                            placeholder="Search ready equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="ready-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $readyTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show" id="inuse">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="inuse"
                                            placeholder="Search in use equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="inuse-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $inUseTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show" id="broken">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="broken"
                                            placeholder="Search broken equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="broken-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $brokenTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show" id="lost">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="lost"
                                            placeholder="Search lost equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="lost-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $lostTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show" id="decommissioned">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search"
                                            data-target="decommissioned" placeholder="Search decommissioned equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="decommissioned-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $decommissionedTypes])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="all">
                            <div class="sales-dashboard">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <input type="search" class="form-control section-search" data-target="all"
                                            placeholder="Search all equipment...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card" id="all-table-body">
                                            @include('admin.equipment-management.partials.equipment-table-rows', ['types' => $allTypes])
                                        </div>
                                    </div>
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

    {{-- ============================================================ --}}
    {{-- EQUIPMENT STATUS HISTORY MODAL --}}
    {{-- ============================================================ --}}
    <div class="modal fade" id="equipmentHistoryModal" tabindex="-1" aria-labelledby="equipmentHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header border-bottom">
                    <div>
                        <h5 class="modal-title mb-0" id="historyModalTitle">Equipment Status History</h5>
                        <small class="text-muted" id="historyModalSubtitle"></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3 text-muted fw-normal small" style="width:150px;">Date</th>
                                <th class="text-muted fw-normal small">Note / Status Change</th>
                                <th class="text-muted fw-normal small" style="width:140px;">Office</th>
                                <th class="text-muted fw-normal small text-end pe-3" style="width:150px;">Changed By</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Loading&hellip;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
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

            document.getElementById('historyModalTitle').textContent = 'Equipment Status History';
            document.getElementById('historyModalSubtitle').textContent = '';
            document.getElementById('historyTableBody').innerHTML =
                '<tr><td colspan="4" class="text-center py-4 text-muted">Loading&hellip;</td></tr>';

            historyModal.show();

            // Fetch logs
            fetch('/admin/equipment-management/' + id + '/history', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    var eq = data.equipment;
                    document.getElementById('historyModalTitle').textContent =
                        'Equipment Status History';
                    document.getElementById('historyModalSubtitle').textContent =
                        eq.type + '  ·  Barcode: ' + eq.barcode + '  ·  Serial #: ' + (eq.serial_number || 'N/A') + '  ·  Current Status: ' + eq.status;

                    var tbody = document.getElementById('historyTableBody');

                    if (!data.logs || data.logs.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No history records found.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = data.logs.map(function (log) {
                        var note = log.note ? log.note : '<span class="text-muted fst-italic">No note</span>';
                        var statusChange = '';
                        if (log.from_status && log.to_status) {
                            statusChange = '<span class="badge bg-secondary me-1">' + log.from_status + '</span>'
                                + '<span class="text-muted me-1">→</span>'
                                + '<span class="badge bg-primary">' + log.to_status + '</span>';
                        }
                        return '<tr>'
                            + '<td class="text-muted small text-nowrap">' + log.date + '</td>'
                            + '<td><span class="text-primary">' + note + '</span>'
                            + (statusChange ? '<br><small class="mt-1 d-inline-block">' + statusChange + '</small>' : '')
                            + '</td>'
                            + '<td class="text-muted small">' + (log.territory || '') + '</td>'
                            + '<td class="text-end small">' + log.changed_by + '</td>'
                            + '</tr>';
                    }).join('');
                })
                .catch(function () {
                    document.getElementById('historyTableBody').innerHTML =
                        '<tr><td colspan="4" class="text-center py-4 text-danger">Failed to load history. Please try again.</td></tr>';
                });
        }
        /* ------------------------------------------------------------------
         * AJAX SEARCH AND FILTERING
         * ------------------------------------------------------------------ */
        $(document).ready(function () {
            let globalTimer, sectionTimers = {};

            // ── Global search (hits all tabs) ──────────────────────────
            function fetchAll() {
                const search = $('#equipment-search').val();

                // Clear individual search boxes when global search runs
                $('.section-search').val('');

                $.ajax({
                    url: "{{ route('admin.equipment-management.index') }}",
                    method: "GET",
                    data: { search },
                    success: function (res) {
                        $('#dirty-table-body').html(res.dirty_table);
                        $('#ready-table-body').html(res.ready_table);
                        $('#inuse-table-body').html(res.inuse_table);
                        $('#broken-table-body').html(res.broken_table);
                        $('#lost-table-body').html(res.lost_table);
                        $('#decommissioned-table-body').html(res.decommissioned_table);
                        $('#all-table-body').html(res.all_table);

                        $('#dirty-count').text(res.dirty_count);
                        $('#ready-count').text(res.ready_count);
                        $('#inuse-count').text(res.inuse_count);
                        $('#broken-count').text(res.broken_count);
                        $('#lost-count').text(res.lost_count);
                        $('#decommissioned-count').text(res.decommissioned_count);
                        $('#all-count').text(res.all_count);

                        $('#total-count').text(res.all_count + ' Equipment Found');
                    }
                });
            }

            // ── Individual section search ───────────────────────────────────
            function fetchSection(target) {
                const search = $(`[data-target="${target}"]`).val();
                const status = target; // 'dirty', 'ready', 'inuse', 'broken', 'lost', 'decommissioned', 'all'

                $.ajax({
                    url: "{{ route('admin.equipment-management.index') }}",
                    method: "GET",
                    data: { search, status },
                    success: function (res) {
                        const tableKey = target + '_table';
                        const countKey = target + '_count';
                        $(`#${target}-table-body`).html(res[tableKey]);
                        $(`#${target}-count`).text(res[countKey]);

                        // Note: Since 'all' tab shows everything, updating one specific status tab
                        // doesn't immediately update 'all' unless we fetch all. This is normal
                        // per-tab filtering behavior as requested.
                    }
                });
            }

            // Global search — debounced
            $('#equipment-search').on('keyup', function () {
                clearTimeout(globalTimer);
                globalTimer = setTimeout(fetchAll, 300);
            });

            // Individual tab search — debounced per section
            $(document).on('keyup', '.section-search', function () {
                const target = $(this).data('target');

                // Clear global search when section search is used
                $('#equipment-search').val('');

                clearTimeout(sectionTimers[target]);
                sectionTimers[target] = setTimeout(() => fetchSection(target), 300);
            });
        });

    </script>
@endpush