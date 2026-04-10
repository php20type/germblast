@extends('admin.includes.layout')

@section('title', 'Expense Reports')

@section('content')

    <!-- Expense Reports Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
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

                       <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            <input type="search" class="form-control"
                                                placeholder="Search by employee or report #.."
                                                aria-label="Search"
                                                id="expense-search">
                                        </div>
                                        <span class="company-count">{{ $count }} Expense Reports Found</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-end dropdown">

                                        <div class="me-2">
                                            <select class="form-select" id="status-filter" name="status">
                                                <option value="">All Status</option>
                                                <option value="Open">Open</option>
                                                <option value="Submitted">Submitted</option>
                                                <option value="Filled">Filled</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Open Status Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover">
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
                                    <tbody id="expense-table-body">
                                        {{-- @include('admin.expense-report.partials.expense-report-table-rows') --}}
                                        @forelse($openReports as $report)
                                            <tr>
                                                <td>
                                                    {{ $report->report_date ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.expense-report.edit', $report->id) }}">
                                                        {{ $report->user->name ?? 'N/A' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $report->report_type ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $report->status === 'Approved' ? 'success' : ($report->status === 'Rejected' ? 'danger' : ($report->status === 'Filled' ? 'warning' : 'secondary')) }}">
                                                        {{ $report->status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $report->items->count() ?? 0 }} items</span>
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($report->total_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-4">
                                                    No expense reports found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Submitted Status Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover">
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
                                    <tbody id="expense-table-body">
                                        @forelse($submittedReports as $report)
                                            <tr>
                                                <td>
                                                    {{ $report->report_date ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.expense-report.edit', $report->id) }}">
                                                        {{ $report->user->name ?? 'N/A' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $report->report_type ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $report->status === 'Approved' ? 'success' : ($report->status === 'Rejected' ? 'danger' : ($report->status === 'Filled' ? 'warning' : 'secondary')) }}">
                                                        {{ $report->status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $report->items->count() ?? 0 }} items</span>
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($report->total_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-4">
                                                    No expense reports found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Filled Status Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover">
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
                                    <tbody id="expense-table-body">
                                        @forelse($filledReports as $report)
                                            <tr>
                                                <td>
                                                    {{ $report->report_date ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.expense-report.edit', $report->id) }}">
                                                        {{ $report->user->name ?? 'N/A' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $report->report_type ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $report->status === 'Approved' ? 'success' : ($report->status === 'Rejected' ? 'danger' : ($report->status === 'Filled' ? 'warning' : 'secondary')) }}">
                                                        {{ $report->status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $report->items->count() ?? 0 }} items</span>
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($report->total_amount, 2) }}</strong>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-4">
                                                    No expense reports found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="action-bar" id="actionBar">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- Expense Reports Section End  -->

        </div>

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                function fetchExpenseReports() {
                    let search = $('#expense-search').val();
                    let status = $('#status-filter').val();

                    $.ajax({
                        url: "{{ route('admin.expense-report.index') }}",
                        method: "GET",
                        data: {
                            search: search,
                            status: status,
                        },
                        success: function(response) {
                            $('#expense-table-body').html(response.table);
                            $('.company-count').text(response.count + ' Expense Reports Found');
                        },
                        error: function() {
                            console.error('Error fetching expense report data');
                        }
                    });
                }

                // Search functionality
                $('#expense-search').on('keyup', function() {
                    fetchExpenseReports();
                });

                // Filter by status
                $('#status-filter').on('change', function() {
                    fetchExpenseReports();
                });
            });
        </script>
    @endpush
