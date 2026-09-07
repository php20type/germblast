@extends('admin.includes.layout')

@section('title', 'Reports - Products')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .kpi-card {
            background: transparent;
            padding: 15px 20px;
            text-align: left;
            border-right: 1px solid #e5e7eb;
        }
        .kpi-card:first-child {
            padding-left: 0;
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

        /* Stacked Bar Styles */
        .stacked-bar-container {
            display: flex;
            height: 40px;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .stacked-segment {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            overflow: hidden;
            white-space: nowrap;
        }
        .segment-0 { background-color: #374151; } /* Dark Blue/Gray */
        .segment-1 { background-color: #38bdf8; } /* Light Blue */
        .segment-2 { background-color: #818cf8; } /* Indigo/Purple */
        .segment-3 { background-color: #fcd34d; color: #374151 !important; } /* Yellow */
        .segment-4 { background-color: #fb923c; } /* Orange */
        .segment-other { background-color: #e5e7eb; color: #374151 !important; } /* Gray */

        .legend-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 12px;
            color: #4b5563;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
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
                        <!-- HEADER -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">PRODUCTS <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">Which products are driving revenue?</p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Filters -->
                                <div class="d-flex align-items-center gap-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm border fw-semibold d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-filter text-primary"></i> {{ ucfirst($status) }} <i class="fas fa-chevron-down ms-1" style="font-size: 10px;"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach(['open', 'won', 'lost', 'cancelled', 'pending'] as $st)
                                                <li><a class="dropdown-item status-filter {{ $status === $st ? 'active' : '' }}" href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset, 'sort' => $sort, 'status' => $st]) }}">{{ ucfirst($st) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-3">
                                    <span class="text-muted fw-semibold" style="font-size: 13px;">Lead close date</span>
                                    <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                        style="border-color: #e5e7eb !important;">
                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset - 1, 'sort' => $sort]) }}"
                                            class="calendar-nav-btn" title="Previous Period">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Period
                                        </a>

                                        <span class="text-muted opacity-25 px-1">|</span>

                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => 0, 'sort' => $sort]) }}"
                                             class="calendar-nav-btn {{ $offset === 0 ? 'btn-today' : '' }}">
                                             {{ $startDate->format('M jS, Y') }} - {{ $endDate->format('M jS, Y') }}
                                         </a>

                                        <span class="text-muted opacity-25 px-1">|</span>

                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset + 1, 'sort' => $sort]) }}"
                                            class="calendar-nav-btn {{ $offset >= 0 ? 'disabled text-muted' : '' }}" title="Next Period"
                                            style="{{ $offset >= 0 ? 'pointer-events: none;' : '' }}">
                                            Next Period <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="px-4 pb-4" id="products-content">
                            <!-- TOP PRODUCTS CHART SECTION -->
                            <div class="corp-section-card mt-3 bg-white p-4 rounded border">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold m-0" style="color: #1f2937;">Top products</h5>
                                    
                                    <!-- Toggle -->
                                    <div class="d-flex bg-white rounded-pill border p-1">
                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset, 'sort' => 'revenue', 'status' => $status]) }}" 
                                            class="btn btn-sm px-3 rounded-pill text-decoration-none {{ $sort == 'revenue' ? 'text-primary fw-bold active-toggle' : 'text-muted fw-bold' }}" 
                                            style="{{ $sort == 'revenue' ? 'background: rgba(255, 184, 28, 0.1);' : '' }}">
                                            <i class="fas fa-dollar-sign me-1"></i> Value
                                        </a>
                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset, 'sort' => 'quantity', 'status' => $status]) }}" 
                                            class="btn btn-sm px-3 rounded-pill text-decoration-none {{ $sort == 'quantity' ? 'text-primary fw-bold active-toggle' : 'text-muted fw-bold' }}"
                                            style="{{ $sort == 'quantity' ? 'background: rgba(255, 184, 28, 0.1);' : '' }}">
                                            <i class="fas fa-hashtag me-1"></i> Quantity
                                        </a>
                                    </div>
                                </div>

                                @php
                                    $metric = $sort == 'revenue' ? 'revenue' : 'quantity';
                                    $totalMetricValue = $sort == 'revenue' ? $totalValue : $totalQuantity;
                                @endphp

                                <!-- STACKED BAR -->
                                <div class="stacked-bar-container">
                                    @if($totalMetricValue > 0)
                                        @foreach($chartData['top'] as $index => $item)
                                            @php
                                                $pct = ($item[$metric] / $totalMetricValue) * 100;
                                            @endphp
                                            @if($pct > 0)
                                                <div class="stacked-segment segment-{{ $index }}" style="width: {{ $pct }}%;"
                                                     data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                                     title="<div class='text-start'><strong>{{ $item['name'] }}</strong><br>Revenue: US${{ number_format($item['revenue'], 0) }}<br>Quantity: {{ number_format($item['quantity']) }}<br>Leads: {{ $item['leads_count'] }}</div>">
                                                    @if($pct > 5)
                                                        <span>{{ number_format($pct, 0) }}%</span>
                                                        <span>
                                                            {{ $sort == 'revenue' ? 'US$' . number_format($item['revenue'] / 1000, 1) . 'k' : number_format($item['quantity']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach

                                        @if($chartData['other']['count'] > 0 && $chartData['other'][$metric] > 0)
                                            @php
                                                $otherPct = ($chartData['other'][$metric] / $totalMetricValue) * 100;
                                            @endphp
                                            <div class="stacked-segment segment-other" style="width: {{ $otherPct }}%;"
                                                 data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                                 title="<div class='text-start'><strong>Other ({{ $chartData['other']['count'] }} products)</strong><br>Revenue: US${{ number_format($chartData['other']['revenue'], 0) }}<br>Quantity: {{ number_format($chartData['other']['quantity']) }}</div>">
                                                @if($otherPct > 5)
                                                    <span>{{ number_format($otherPct, 0) }}%</span>
                                                    <span>
                                                        {{ $sort == 'revenue' ? 'US$' . number_format($chartData['other']['revenue'] / 1000, 1) . 'k' : number_format($chartData['other']['quantity']) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div class="stacked-segment segment-other w-100 text-muted">No data available</div>
                                    @endif
                                </div>

                                <!-- LEGEND -->
                                <div class="legend-container">
                                    @foreach($chartData['top'] as $index => $item)
                                        <div class="legend-item">
                                            <div class="legend-color segment-{{ $index }}"></div>
                                            <span>{{ $item['name'] }}</span>
                                        </div>
                                    @endforeach
                                    @if($chartData['other']['count'] > 0)
                                        <div class="legend-item">
                                            <div class="legend-color segment-other"></div>
                                            <span>Other ({{ $chartData['other']['count'] }} products)</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- KPI Row -->
                                <div class="row mt-4 pt-4 border-top mx-0">
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Total quantity</div>
                                        <div class="kpi-value">{{ number_format($totalQuantity) }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Unique products</div>
                                        <div class="kpi-value">{{ $uniqueProductsCount }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Total value</div>
                                        <div class="kpi-value">US${{ number_format($totalValue, 0) }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card border-0">
                                        <div class="kpi-label mb-1">Number of leads</div>
                                        <div class="kpi-value">{{ number_format($totalLeadsCount) }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRODUCTS TABLE -->
                            <div class="table-responsive mt-4">
                                <table id="productsTable" class="table table-hover mb-0 equipment-report-table w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%;">Product</th>
                                            <th style="width: 20%;">Category</th>
                                            <th style="width: 15%;">SKU</th>
                                            <th class="text-end" style="width: 15%;">
                                                @if($sort == 'revenue') <i class="fas fa-arrow-down text-primary me-1"></i> @endif Revenue
                                            </th>
                                            <th class="text-end" style="width: 10%;">
                                                @if($sort == 'quantity') <i class="fas fa-arrow-down text-primary me-1"></i> @endif Quantity
                                            </th>
                                            <th class="text-end" style="width: 10%;">Leads</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                        <tr>
                                            <td class="text-dark fw-semibold">{{ $product['name'] }}</td>
                                            <td><div class="small text-muted" style="font-size: 12px;">{{ $product['category'] }}</div></td>
                                            <td><div class="small text-muted" style="font-size: 12px;">{{ $product['sku'] }}</div></td>
                                            <td class="text-end text-muted fw-semibold">US${{ number_format($product['revenue'], 0) }}</td>
                                            <td class="text-end text-muted">{{ number_format($product['quantity']) }}</td>
                                            <td class="text-end">
                                                <a href="#" class="text-primary text-decoration-none fw-semibold">{{ $product['leads_count'] }} leads</a>
                                            </td>
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

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initTooltips();

        $('#productsTable').DataTable({
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
        });
    });
</script>
@endpush
