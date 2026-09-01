@extends('admin.includes.layout')

@section('title', 'Labor Analysis')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }


        
        /* Section Card Refinement */
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

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        /* Calendar Navigation Button */
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
        
        /* Modern Soft Tabs Styling & Scrollbar */
        .navbar-tabs {
            overflow-x: auto !important;
            overflow-y: hidden !important;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            transition: scrollbar-color 0.3s ease;
            -webkit-overflow-scrolling: touch;
        }

        .navbar-tabs:hover {
            scrollbar-color: #cbd5e1 transparent;
        }

        .navbar-tabs::-webkit-scrollbar {
            height: 5px;
        }

        .navbar-tabs::-webkit-scrollbar-thumb {
            background-color: transparent;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .navbar-tabs:hover::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
        }

        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
            flex-wrap: nowrap;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            white-space: nowrap !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
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
        }

        .navbar-tabs .badge {
            background-color: #6b7280 !important;
            font-weight: 500;
            padding: 4px 8px;
            font-size: 11px;
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <div class="col-md-10 p-0">
                <div class="main-content">
                    
                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">Labor Analysis</h3>
                            <p class="text-muted mb-0">View monthly labor statistics across different territories.</p>
                        </div>
                    </div>

                    <div class="px-4 pb-4">
                    <div class="filter-section py-3 px-4 mx-0 my-3 rounded-3 border bg-white"
                        style="border-color: #e5e7eb !important;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                            <!-- Left Side: Current Range Header -->
                            <div>
                                <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                    Month of: {{ $startOfMonth->format('F Y') }}
                                </h4>
                            </div>

                            <!-- Right Side: Unified Navigation Segment Control -->
                            <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                style="border-color: #e5e7eb !important;">
                                <a href="{{ route('admin.service.labor_analysis', ['month' => $startOfMonth->copy()->subMonth()->format('Y-m'), 'office' => $selectedOfficeId]) }}"
                                    class="calendar-nav-btn" title="Previous Month">
                                    <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Month
                                </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.service.labor_analysis', ['month' => now()->format('Y-m'), 'office' => $selectedOfficeId]) }}"
                                     class="calendar-nav-btn {{ $startOfMonth->format('Y-m') === now()->format('Y-m') ? 'btn-today' : '' }}">
                                     Current Month
                                 </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.service.labor_analysis', ['month' => $startOfMonth->copy()->addMonth()->format('Y-m'), 'office' => $selectedOfficeId]) }}"
                                    class="calendar-nav-btn" title="Next Month">
                                    Next Month <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    
                    <hr class="mb-0 mt-4" style="opacity: 0.1;">

                        <!-- TABS for Offices -->
                        <div class="navbar-tabs px-4">
                            <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                @foreach($allTerritories as $territory)
                                    <a href="{{ route('admin.service.labor_analysis', ['month' => $selectedMonth, 'office' => $territory->id]) }}" 
                                       class="nav-link {{ $selectedOfficeId == $territory->id ? 'active' : '' }}">
                                        {{ $territory->name }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                        
                        <hr class="mb-4 mt-0" style="opacity: 0.1;">

                        @if(empty($laborData))
                            <div class="alert alert-info mt-3">No service orders found for this month and selected office.</div>
                        @else
                            @foreach($laborData as $officeData)
                            <div class="section-card">
                                <div class="section-header d-flex align-items-center gap-3">
                                    <h3 class="section-title text-primary">{{ $officeData['office_name'] }}</h3>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="fw-bold mb-3 text-secondary" style="font-size: 14px;">Orders List</h5>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-hover equipment-report-table w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Price</th>
                                                        <th style="width: 1%; white-space: nowrap;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($officeData['orders'] as $order)
                                                        <tr>
                                                            <td>
                                                                <span class="text-dark fw-bold">
                                                                    {{ $order->order_no ?? 'ORD-'.$order->id }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if($order->service && $order->service->lead && $order->service->lead->company_id)
                                                                    <span class="fw-bold text-dark">
                                                                        {{ $order->service->lead->company->name ?? 'Unknown Customer' }}
                                                                    </span>
                                                                @else
                                                                    Unknown Customer
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($order->service && $order->service->total_price)
                                                                    ${{ number_format($order->service->total_price, 2) }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td style="white-space: nowrap;">
                                                                <div class="d-flex gap-2">
                                                                    <a href="{{ route('admin.lead.service.service_dashboard', $order->id) }}" class="btn btn-outline-primary">
                                                                        Go to Order
                                                                    </a>
                                                                    @if($order->service && $order->service->lead && $order->service->lead->company_id)
                                                                        <a href="{{ route('admin.company.show', $order->service->lead->company_id) }}" class="btn btn-outline-secondary">
                                                                            Go to Customer
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center py-4 text-muted">No orders assigned to this office.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <h5 class="fw-bold mb-3 text-secondary" style="font-size: 14px;">Grand Total Estimate</h5>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-hover equipment-report-table w-100">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-start fw-bold">Total Orders</td>
                                                        <td class="fw-bold text-end">{{ $officeData['total_orders'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start fw-bold">Grand Total of Orders</td>
                                                        <td class="fw-bold text-end">${{ number_format($officeData['total_price'], 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start fw-bold">Total Scheduled Service Hours</td>
                                                        <td class="fw-bold text-end">{{ number_format($officeData['total_scheduled_hours'], 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-start fw-bold">Total Unique Staff Assigned</td>
                                                        <td class="fw-bold text-end">{{ $officeData['unique_staff_count'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
