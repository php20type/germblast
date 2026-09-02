@extends('admin.includes.layout')

@section('title', 'Reports - Products')

@push('styles')
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
        .report-table th {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 24px;
        }
        .report-table td {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
            padding: 12px 24px;
            border-bottom: 1px solid #f3f4f6;
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
        
        /* Table overrides */
        .product-table th, .product-table td {
            font-size: 13px;
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
                                <h3 class="mb-1 text-uppercase">PRODUCTS</h3>
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
                                                <li><a class="dropdown-item status-filter {{ $status === $st ? 'active' : '' }}" href="#" data-status="{{ $st }}">{{ ucfirst($st) }}</a></li>
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
                            @include('admin.reports.partials.products_list')
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
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initTooltips();

        // Handle AJAX status filtering
        $(document).on('click', '.status-filter', function(e) {
            e.preventDefault();
            var status = $(this).data('status');
            var url = new URL(window.location.href);
            url.searchParams.set('status', status);
            
            // Update the button text
            var btn = $(this).closest('.dropdown').find('button');
            btn.html('<i class="fas fa-filter text-primary"></i> ' + status.charAt(0).toUpperCase() + status.slice(1) + ' <i class="fas fa-chevron-down ms-1" style="font-size: 10px;"></i>');
            
            // Update active state in dropdown
            $('.status-filter').removeClass('active');
            $(this).addClass('active');

            // Fetch partial via AJAX
            $.ajax({
                url: url.toString(),
                type: 'GET',
                success: function(response) {
                    $('#products-content').html(response);
                    initTooltips();
                    window.history.pushState({}, '', url);
                }
            });
        });
        
        // Ensure pagination clicks use AJAX too
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#products-content').html(response);
                    initTooltips();
                    window.history.pushState({}, '', url);
                }
            });
        });
        
        // Ensure Value/Quantity toggles use AJAX too
        $(document).on('click', '.active-toggle, .text-muted.fw-bold', function(e) {
            // Check if it's our value/qty toggle links inside #products-content
            if ($(this).closest('.rounded-pill.border').length) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#products-content').html(response);
                        initTooltips();
                        window.history.pushState({}, '', url);
                    }
                });
            }
        });
    });
</script>
@endpush
