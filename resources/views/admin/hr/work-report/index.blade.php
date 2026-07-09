@extends('admin.includes.layout')

@section('title', 'Employee Work Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Equipment Report Table Boxed Styling from EQ */
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

        .calendar-nav-btn {
            color: #4b5563 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 16px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }

        .calendar-nav-btn:hover {
            background-color: #f3f4f6 !important;
            color: #1f2937 !important;
        }

        .calendar-nav-btn.btn-today {
            background-color: #ffb400 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(255, 180, 0, 0.15) !important;
        }

        .calendar-nav-btn.btn-today:hover {
            background-color: #e6a200 !important;
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">

                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Employee Work Report</h3>
                                <p class="text-muted mb-0">Track and analyze employee hours and monthly payroll statistics.</p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->
                                <div>
                                    <span class="text-secondary text-uppercase fw-bold d-block"
                                        style="font-size: 11px; letter-spacing: 0.5px;">Active Schedule Period</span>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Month of: {{ $monthDate->format('F Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.work-report.index', ['month' => $monthDate->copy()->subMonth()->format('Y-m')]) }}"
                                        class="calendar-nav-btn" title="Previous Month">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 12px;"></i> Prev Month
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.work-report.index', ['month' => now()->format('Y-m')]) }}"
                                        class="calendar-nav-btn btn-today">
                                        Current Month
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.work-report.index', ['month' => $monthDate->copy()->addMonth()->format('Y-m')]) }}"
                                        class="calendar-nav-btn" title="Next Month">
                                        Next Month <i class="fas fa-chevron-right ms-1" style="font-size: 12px;"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- Table Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="workReportTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Week 1 Actual (hrs)</th>
                                            <th>Week 2 Actual (hrs)</th>
                                            <th>Week 3 Actual (hrs)</th>
                                            <th>Week 4 Actual (hrs)</th>
                                            <th>Total Regular (hrs)</th>
                                            <th>Total Overtime (hrs)</th>
                                            <th>Regular Pay</th>
                                            <th>Overtime Pay</th>
                                            <th>Total Monthly Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportData as $row)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold text-dark d-block">{{ $row['name'] }}</span>
                                                    <div class="small text-muted" style="font-size: 11px;">
                                                        Regular : ${{ number_format($row['employee']->hourly_rate ?? 0, 2) }}/hr
                                                    </div>
                                                    <div class="small text-muted" style="font-size: 11px;">
                                                        Overtime : ${{ number_format($row['employee']->overtime_rate ?? 0, 2) }}/hr
                                                    </div>
                                                    <div class="small text-muted" style="font-size: 11px;">
                                                        Weekly : 40 hrs
                                                    </div>
                                                </td>
                                                <td>{{ $row['w1Actual'] > 0 ? number_format($row['w1Actual'], 2) : '-' }}</td>
                                                <td>{{ $row['w2Actual'] > 0 ? number_format($row['w2Actual'], 2) : '-' }}</td>
                                                <td>{{ $row['w3Actual'] > 0 ? number_format($row['w3Actual'], 2) : '-' }}</td>
                                                <td>{{ $row['w4Actual'] > 0 ? number_format($row['w4Actual'], 2) : '-' }}</td>
                                                <td class="fw-semibold text-primary">{{ number_format($row['totalRegular'], 2) }}</td>
                                                <td class="fw-semibold text-warning">{{ number_format($row['totalOvertime'], 2) }}</td>
                                                <td>${{ number_format($row['regularPay'], 2) }}</td>
                                                <td>${{ number_format($row['overtimePay'], 2) }}</td>
                                                <td class="fw-bold text-success">${{ number_format($row['totalMonthlyPay'], 2) }}</td>
                                            </tr>
                                        @endforeach
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#workReportTable').DataTable({
                pageLength: 25,
                ordering: true,
                order: [[0, 'asc']],
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            });
        });
    </script>
@endpush
