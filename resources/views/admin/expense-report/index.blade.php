@extends('admin.includes.layout')

@section('title', 'Expense Reports')

@push('styles')
<style>
    .expense-section-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .expense-section-header {
        background: #ffb81c;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .expense-section-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .expense-section-header .section-count {
        background: rgba(0,0,0,0.15);
        color: #000;
        border-radius: 20px;
        padding: 2px 10px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .section-search-wrap {
        position: relative;
        min-width: 220px;
    }
    .section-search-wrap input {
        padding-left: 30px;
        font-size: 0.82rem;
        height: 32px;
        border-radius: 20px;
        border: none;
        background: rgba(255,255,255,0.85);
    }
    .section-search-wrap input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0,0,0,0.15);
        background: #fff;
    }

</style>
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">

                    <!-- Header -->
                    <div class="heading-area-sec">
                        <div class="left-part-sec">
                            <h3 class="mb-1">All EXPENSE REPORTS <i class="fas fa-thumbtack pinned-icon"></i></h3>
                            <p class="text-muted mb-0">Manage and review all employee expense reports</p>
                        </div>
                        <div class="right-part">
                            <a href="{{ route('admin.expense-report.personal.create') }}" class="btn btn-export">+ Add Personal Expense Report</a>
                            <a href="{{ route('admin.expense-report.corporate.create') }}" class="btn btn-export">+ Add Corporate Expense Report</a>
                        </div>
                    </div>

                    <!-- Global Search & Filter -->
                    <div class="filter-section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
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

                    {{-- ─── OPEN REPORTS ─── --}}
                    <div class="expense-section-card">
                        <div class="expense-section-header">
                            <p>
                                <span class="section-count" id="open-count">{{ $openReports->count() }}</span>
                                Open Reports
                            </p>
                            <div class="section-search-wrap">
                                <input type="search" class="form-control section-search"
                                       data-target="open"
                                       placeholder="Search open reports..">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                    @include('admin.expense-report.partials.expense-report-table-rows', ['reports' => $openReports])
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ─── SUBMITTED REPORTS ─── --}}
                    <div class="expense-section-card">
                        <div class="expense-section-header">
                            <p>
                                <span class="section-count" id="submitted-count">{{ $submittedReports->count() }}</span>
                                Submitted Reports
                            </p>
                            <div class="section-search-wrap">
                                <input type="search" class="form-control section-search"
                                       data-target="submitted"
                                       placeholder="Search submitted reports..">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                <tbody id="submitted-table-body">
                                    @include('admin.expense-report.partials.expense-report-table-rows', ['reports' => $submittedReports])
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ─── FILLED REPORTS ─── --}}
                    <div class="expense-section-card">
                        <div class="expense-section-header">
                            <p>
                                <span class="section-count" id="filled-count">{{ $filledReports->count() }}</span>
                                Filled Reports
                            </p>
                            <div class="section-search-wrap">
                                <input type="search" class="form-control section-search"
                                       data-target="filled"
                                       placeholder="Search filled reports..">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                <tbody id="filled-table-body">
                                    @include('admin.expense-report.partials.expense-report-table-rows', ['reports' => $filledReports])
                                </tbody>
                            </table>
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
    $('#expense-search').on('keyup', function () {
        clearTimeout(globalTimer);
        globalTimer = setTimeout(fetchAll, 300);
    });

    $('#type-filter').on('change', fetchAll);

    // Individual section search — debounced per section
    $(document).on('keyup', '.section-search', function () {
        const target = $(this).data('target');

        // Clear global search when section search is used
        $('#expense-search').val('');

        clearTimeout(sectionTimers[target]);
        sectionTimers[target] = setTimeout(() => fetchSection(target), 300);
    });

});
</script>
@endpush
