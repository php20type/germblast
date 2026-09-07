@extends('admin.includes.layout')

@section('title', 'Reports - New Leads')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }

        .kpi-card {
            background: transparent;
            padding: 15px 0;
            text-align: left;
            border-right: 1px solid #e5e7eb;
        }

        .kpi-card:last-child {
            border-right: none;
        }

        .kpi-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .kpi-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        .btn-chart-filter {
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #4b5563;
            font-size: 13px;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
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

        .calendar-nav-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            background: transparent;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .calendar-nav-btn:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .calendar-nav-btn.btn-today {
            background-color: white;
            color: #111827;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .calendar-nav-btn.btn-today:hover {
            background-color: #f9fafb;
        }
    </style>
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Reports Sidebar -->
            @include('admin.reports.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    
                    <div class="sales-dashboard">
                        <!-- HEADER (Standard GermBlast Layout) -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">SALES <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">How many sales did we make?</p>
                            </div>
                            <div class="right-part-sec mt-1 d-flex gap-2">
                                <!-- Action buttons removed per request -->
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.reports.sales', ['period' => request('period', 'year'), 'offset' => $offset - 1]) }}"
                                        class="calendar-nav-btn" title="Previous Period">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Period
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.reports.sales', ['period' => request('period', 'year'), 'offset' => 0]) }}"
                                         class="calendar-nav-btn {{ $offset === 0 ? 'btn-today' : '' }}">
                                         Current Period
                                     </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.reports.sales', ['period' => request('period', 'year'), 'offset' => $offset + 1]) }}"
                                        class="calendar-nav-btn {{ $offset >= 0 ? 'disabled text-muted' : '' }}" title="Next Period"
                                        style="{{ $offset >= 0 ? 'pointer-events: none;' : '' }}">
                                        Next Period <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <div class="corp-section-card mt-3">
                                <!-- Chart Filters -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex bg-white rounded-pill border" style="padding: 2px;">
                                            <button id="btnToggleValue" class="btn btn-sm text-primary fw-bold px-3 rounded-pill active-toggle" style="background: rgba(255, 184, 28, 0.1);"><i class="fas fa-dollar-sign me-1"></i> Value</button>
                                            <button id="btnToggleQuantity" class="btn btn-sm text-muted fw-bold px-3 rounded-pill"><i class="fas fa-hashtag me-1"></i> Quantity</button>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex gap-3 text-muted fw-bold" style="font-size: 13px;">
                                            <a href="{{ route('admin.reports.sales', ['period' => 'day']) }}" class="text-decoration-none {{ request('period') === 'day' ? 'text-primary border-bottom border-primary border-2 pb-1' : 'text-muted pb-1 cursor-pointer' }}">Day</a>
                                            <a href="{{ route('admin.reports.sales', ['period' => 'week']) }}" class="text-decoration-none {{ request('period') === 'week' ? 'text-primary border-bottom border-primary border-2 pb-1' : 'text-muted pb-1 cursor-pointer' }}">Week</a>
                                            <a href="{{ route('admin.reports.sales', ['period' => 'month']) }}" class="text-decoration-none {{ request('period') === 'month' ? 'text-primary border-bottom border-primary border-2 pb-1' : 'text-muted pb-1 cursor-pointer' }}">Month</a>
                                            <a href="{{ route('admin.reports.sales', ['period' => 'quarter']) }}" class="text-decoration-none {{ request('period') === 'quarter' ? 'text-primary border-bottom border-primary border-2 pb-1' : 'text-muted pb-1 cursor-pointer' }}">Quarter</a>
                                            <a href="{{ route('admin.reports.sales', ['period' => 'year']) }}" class="text-decoration-none {{ request('period', 'year') === 'year' ? 'text-primary border-bottom border-primary border-2 pb-1' : 'text-muted pb-1 cursor-pointer' }}">Year</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart Legend -->
                                <div class="text-end mb-2">
                                    <span style="font-size: 12px; font-weight: 600; color: #6b7280;">
                                        <span style="display:inline-block; width:10px; height:10px; background-color:#374151; margin-right:4px; border-radius:2px;"></span> Leads
                                    </span>
                                </div>

                                <!-- Chart Area -->
                                <div class="chart-container">
                                    <canvas id="newLeadsChart"></canvas>
                                </div>

                                <!-- KPI Row -->
                                <div class="row mt-5 pt-4 border-top mx-0">
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-value">${{ number_format($totalValue, 2) }}</div>
                                        <div class="kpi-label">Total value</div>
                                    </div>
                                    <div class="col-md-3 kpi-card text-center">
                                        <div class="kpi-value">${{ number_format($avgValuePerWeek, 0) }}</div>
                                        <div class="kpi-label">Avg value per week</div>
                                    </div>
                                    <div class="col-md-3 kpi-card text-center">
                                        <div class="kpi-value">{{ number_format($avgTimeOpen, 1) }} days</div>
                                        <div class="kpi-label">Avg time open</div>
                                    </div>
                                    <div class="col-md-3 kpi-card text-end">
                                        <div class="kpi-value">${{ number_format($avgLeadValue / 1000, 2) }}k</div>
                                        <div class="kpi-label">Avg lead value</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Table -->
                            <div class="corp-section-card p-0 mt-4" style="overflow: hidden;">
                            <div class="navbar-tabs pt-3">
                                <nav class="nav nav-tabs mb-0 w-100 nav-fill" id="reportTab" role="tablist">
                                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" style="text-transform: uppercase;">DETAILS</button>
                                    <button class="nav-link" id="leads-tab" data-bs-toggle="tab" data-bs-target="#leads" type="button" role="tab" style="text-transform: uppercase;">LEADS</button>
                                </nav>
                            </div>
                            
                            <hr class="mx-4 mb-0 mt-0" style="opacity: 0.1;">
                                <div class="tab-content" id="reportTabContent">
                                    <div class="tab-pane fade show active p-0" id="details" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0 equipment-report-table w-100" id="detailsTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50%;">Date</th>
                                                        <th style="width: 50%;">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="background-color: rgba(255, 184, 28, 0.05);">
                                                        <td><strong class="text-dark">Totals</strong></td>
                                                        <td><strong class="text-dark">${{ number_format($totalValue / 1000000, 2) }}m</strong></td>
                                                    </tr>
                                                    @foreach(array_reverse($tableData) as $row)
                                                    <tr>
                                                        <td class="fw-semibold text-dark">{{ $row['date'] }}</td>
                                                        <td>${{ number_format($row['value'] / 1000, 2) }}k</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-4" id="leads" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-hover w-100 equipment-report-table" id="leadsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Lead name</th>
                                                        <th>Age</th>
                                                        <th>Value</th>
                                                        <th>Assignee</th>
                                                        <th>Stage</th>
                                                        <th>Confidence</th>
                                                        <th>Close date</th>
                                                        <th>Sources</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($groupedLeads as $lead)
                                                        <tr>
                                                            <td>
                                                                @can('lead.detail.view')
                                                                    <a href="{{ route('admin.lead.show', $lead['id']) }}" class="text-decoration-none text-dark fw-semibold">{{ $lead['name'] }}</a>
                                                                @else
                                                                    <span class="fw-semibold text-dark">{{ $lead['name'] }}</span>
                                                                @endcan
                                                                <div class="small text-muted" style="font-size: 12px;">{{ $lead['company_name'] }}</div>
                                                            </td>
                                                            <td>{{ $lead['created_at'] }}</td>
                                                            <td>${{ number_format($lead['total_price'], 2) }}</td>
                                                            <td>{{ $lead['assignee'] }}</td>
                                                            <td>{{ $lead['stage_name'] }}</td>
                                                            <td>{{ $lead['confidence'] }}%</td>
                                                            <td>{{ $lead['close_date'] }}</td>
                                                            <td>{{ $lead['sources'] }}</td>
                                                        </tr>
                                                    @empty
                                                        {{-- Handled by DataTables --}}
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
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        let activeTab = urlParams.get('tab');
        if (activeTab) {
            const tabElement = document.getElementById(activeTab + '-tab');
            if (tabElement) {
                const tab = new bootstrap.Tab(tabElement);
                tab.show();
            }
        }

        const tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabElements.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                const newTab = event.target.getAttribute('id').replace('-tab', '');
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.set('tab', newTab);
                window.history.replaceState(null, null, newUrl);
            });
        });

        const dtConfig = {
            pageLength: 25,
            ordering: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
            language: {
                search: '',
                searchPlaceholder: 'Search...',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: { previous: 'Previous', next: 'Next' }
            }
        };
        $('#detailsTable').DataTable(dtConfig);
        $('#leadsTable').DataTable(dtConfig);

        const ctx = document.getElementById('newLeadsChart').getContext('2d');
        
        // Data from Controller
        const labels = {!! json_encode($chartData['labels'] ?? []) !!};
        const values = {!! json_encode($chartData['values'] ?? []) !!};
        const quantities = {!! json_encode($chartData['quantities'] ?? []) !!};
        
        let currentMode = 'value'; // 'value' or 'quantity'

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Leads',
                    data: values,
                    backgroundColor: '#f97316', 
                    hoverBackgroundColor: '#ea580c',
                    borderRadius: 6,
                    barThickness: 'flex',
                    maxBarThickness: 35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false 
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    if (currentMode === 'value') {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    } else {
                                        label += context.parsed.y + ' leads';
                                    }
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            },
                            callback: function(value, index, values) {
                                if (currentMode === 'value') {
                                    if(value >= 1000) {
                                        return '$' + (value / 1000) + 'k';
                                    }
                                    return '$' + value;
                                } else {
                                    return value; // plain number for quantity
                                }
                            }
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            },
                            maxRotation: 0,
                            minRotation: 0,
                            autoSkip: true,
                            maxTicksLimit: 12
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // Toggle Logic
        const btnValue = document.getElementById('btnToggleValue');
        const btnQuantity = document.getElementById('btnToggleQuantity');

        function setToggleActive(activeBtn, inactiveBtn) {
            activeBtn.classList.remove('text-muted');
            activeBtn.classList.add('text-primary');
            activeBtn.style.background = 'rgba(255, 184, 28, 0.1)';
            
            inactiveBtn.classList.remove('text-primary');
            inactiveBtn.classList.add('text-muted');
            inactiveBtn.style.background = 'transparent';
        }

        btnValue.addEventListener('click', function() {
            if (currentMode !== 'value') {
                currentMode = 'value';
                setToggleActive(btnValue, btnQuantity);
                chart.data.datasets[0].data = values;
                chart.update();
            }
        });

        btnQuantity.addEventListener('click', function() {
            if (currentMode !== 'quantity') {
                currentMode = 'quantity';
                setToggleActive(btnQuantity, btnValue);
                chart.data.datasets[0].data = quantities;
                chart.update();
            }
        });
    });
</script>
@endpush
