@extends('admin.includes.layout')

@section('title', 'Expense Reports')

@push('styles')
<style>
    /* Modern Soft Tabs Styling from Equipment Management */
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

    /* Boxed Table System from Equipment Management */
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
        text-align: center;
        white-space: nowrap;
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
        text-align: center;
        white-space: nowrap;
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

    .status-pill-open {
        background-color: rgba(13, 110, 253, 0.12) !important;
        color: #0d6efd !important;
        border-color: rgba(13, 110, 253, 0.2) !important;
    }

    .status-pill-submitted {
        background-color: rgba(255, 184, 28, 0.12) !important;
        color: #d39100 !important;
        border-color: rgba(255, 184, 28, 0.25) !important;
    }

    .status-pill-filled {
        background-color: rgba(6, 150, 151, 0.12) !important;
        color: #069697 !important;
        border-color: rgba(6, 150, 151, 0.25) !important;
    }

    .status-pill-approved {
        background-color: rgba(6, 150, 151, 0.12) !important;
        color: #069697 !important;
        border-color: rgba(6, 150, 151, 0.25) !important;
    }

    .status-pill-rejected {
        background-color: rgba(234, 61, 47, 0.12) !important;
        color: #ea3d2f !important;
        border-color: rgba(234, 61, 47, 0.2) !important;
    }

    .section-search-wrap {
        position: relative;
        min-width: 240px;
    }
    .section-search-wrap input {
        padding-left: 15px;
        font-size: 0.82rem;
        height: 38px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        background: rgba(255, 255, 255, 0.85);
        transition: all 0.2s ease;
    }
    .section-search-wrap input:focus {
        outline: none;
        border-color: #ffb400;
        box-shadow: 0 0 0 2px rgba(255, 180, 0, 0.15);
        background: #fff;
    }
</style>
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">

                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">ALL EXPENSE REPORTS <span style="font-size: 24px;">📌</span></h3>
                            <p class="text-muted mb-0">Manage and review all employee expense reports</p>
                        </div>
                        <div class="right-part-sec">
                            <a href="{{ route('admin.expense-report.personal.create') }}" class="btn btn-export" style="margin-right: 10px;">+ PERSONAL EXPENSE</a>
                            <a href="{{ route('admin.expense-report.corporate.create') }}" class="btn btn-export">+ CORPORATE EXPENSE</a>
                        </div>
                    </div>

                    <!-- Global Search & Filter -->
                    <div class="filter-section px-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 position-relative">
                                    <div class="search-form">
                                        <input type="search" class="form-control" id="expense-search"
                                               placeholder="Search all reports..">
                                    </div>
                                    <span class="company-count" id="total-count">{{ $count }} Expense Reports Found</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-end">
                                    <select class="form-select w-auto" id="type-filter">
                                        <option value="">All Types</option>
                                        <option value="Personal">Personal</option>
                                        <option value="Corporate">Corporate</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sales-dashboard">
                        <!-- TABS -->
                        <div class="navbar-tabs px-4 pt-3">
                            <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#open">Open <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="open-count">{{ $openReports->count() }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#submitted">Submitted <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="submitted-count">{{ $submittedReports->count() }}</span></button>

                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#filled">Filled <span
                                        class="badge bg-secondary text-white rounded-pill ms-1"
                                        id="filled-count">{{ $filledReports->count() }}</span></button>
                            </nav>
                        </div>

                        <hr class="mb-4 mt-0" style="opacity: 0.1;">

                        <!-- TAB CONTENT -->
                        <div class="tab-content px-4 pb-4">
                            <!-- Open Reports Tab -->
                            <div class="tab-pane fade show active" id="open" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted" style="font-size: 14px;">Review open reports ready for modification or submission.</span>
                                    <div class="section-search-wrap">
                                        <input type="search" class="form-control section-search"
                                               data-target="open"
                                               placeholder="Search by employee name">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Employee</th>
                                                <th>Report Type</th>
                                                <th>Status</th>
                                                <th>Items</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="open-table-body">
                                            @include('admin.expense-report.partials.expense-report-table-rows', [
                                                'reports' => $openReports,
                                                'type' => 'open'
                                            ])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Submitted Reports Tab -->
                            <div class="tab-pane fade" id="submitted" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted" style="font-size: 14px;">Review submitted reports waiting for approval.</span>
                                    <div class="section-search-wrap">
                                        <input type="search" class="form-control section-search"
                                               data-target="submitted"
                                               placeholder="Search by employee name">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Submitted At</th>
                                                <th>Employee</th>
                                                <th>Report Type</th>
                                                <th>Status</th>
                                                <th>Items</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="submitted-table-body">
                                            @include('admin.expense-report.partials.expense-report-table-rows', [
                                                'reports' => $submittedReports,
                                                'type' => 'submitted'
                                            ])
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Filled Reports Tab -->
                            <div class="tab-pane fade" id="filled" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted" style="font-size: 14px;">Completed and reimbursed reports history.</span>
                                    <div class="section-search-wrap">
                                        <input type="search" class="form-control section-search"
                                               data-target="filled"
                                               placeholder="Search by employee name">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Submitted At</th>
                                                <th>Filled At</th>
                                                <th>Employee</th>
                                                <th>Report Type</th>
                                                <th>Status</th>
                                                <th>Items</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="filled-table-body">
                                            @include('admin.expense-report.partials.expense-report-table-rows', [
                                                'reports' => $filledReports,
                                                'type' => 'filled'
                                            ])
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
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    let globalTimer, sectionTimers = {};

    const statusMap = {
        open:      'Open',
        submitted: 'Submitted',
        filled:    'Filled',
    };

    // ── Global search (hits all 3 tables) ──────────────────────────
    function fetchAll() {
        const search      = $('#expense-search').val();
        const report_type = $('#type-filter').val();

        // Clear individual search boxes when global search runs
        $('.section-search').val('');

        $.ajax({
            url: "{{ route('admin.expense-report.index') }}",
            method: "GET",
            data: { search, report_type },
            success: function (res) {
                $('#open-table-body').html(res.open_table);
                $('#submitted-table-body').html(res.submitted_table);
                $('#filled-table-body').html(res.filled_table);
                $('#open-count').text(res.open_count);
                $('#submitted-count').text(res.submitted_count);
                $('#filled-count').text(res.filled_count);
                $('#total-count').text(res.total_count + ' Expense Reports Found');
            }
        });
    }

    // ── Individual section search ───────────────────────────────────
    function fetchSection(target) {
        const search      = $(`[data-target="${target}"]`).val();
        const report_type = $('#type-filter').val();
        const status      = statusMap[target];

        $.ajax({
            url: "{{ route('admin.expense-report.index') }}",
            method: "GET",
            data: { search, report_type, status },
            success: function (res) {
                // Only update the relevant table
                const tableKey = target + '_table';
                const countKey = target + '_count';
                $(`#${target}-table-body`).html(res[tableKey]);
                $(`#${target}-count`).text(res[countKey]);

                // Recalculate total shown count from all 3 badges
                const total = parseInt($('#open-count').text() || 0)
                            + parseInt($('#submitted-count').text() || 0)
                            + parseInt($('#filled-count').text() || 0);
                $('#total-count').text(total + ' Expense Reports Found');
            }
        });
    }

    // Global search — debounced
    $('#expense-search').on('keyup search input', function () {
        clearTimeout(globalTimer);
        globalTimer = setTimeout(fetchAll, 300);
    });

    $('#type-filter').on('change', fetchAll);

    // Individual section search — debounced per section
    $(document).on('keyup search input', '.section-search', function () {
        const target = $(this).data('target');

        // Clear global search when section search is used
        $('#expense-search').val('');

        clearTimeout(sectionTimers[target]);
        sectionTimers[target] = setTimeout(() => fetchSection(target), 300);
    });

});
</script>
@endpush
