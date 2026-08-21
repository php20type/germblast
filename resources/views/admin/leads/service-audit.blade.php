@extends('admin.includes.layout')

@section('title', 'Service Audit')

@push('styles')
    <style>
        /* Boxed Table System from Consumable/Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Column specific alignment matching original logic */
        .equipment-report-table thead th:nth-child(1),
        .equipment-report-table tbody td:nth-child(1) {
            text-align: left !important;
        }

        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
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
    </style>
@endpush

@section('content')
    <!-- Service Audit Page Layout -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content (Full Width, No Sidebar) -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <div class="sales-dashboard">
                            
                            <!-- Header -->
                            <div class="heading-area-sec mb-4">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">
                                        Service Audit for {{ $order->service->lead->company->name ?? 'Unknown Company' }} <span style="font-size: 24px;">📌</span>
                                    </h3>
                                    <p class="text-muted mb-0" style="font-size: 18px; font-weight: 400;">
                                        Price: {{ number_format($order->service->price_per_service ?? 0, 2) }}
                                    </p>
                                </div>
                                <div class="right-part-sec">
                                    <div>
                                        <a class="btn btn-outline-dark" href="javascript:history.back()">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </a>

                                        <a class="btn btn-export"
                                            href="{{ route('admin.lead.service.service_dashboard', $order->id) }}">
                                            SERVICE VIEW 
                                        </a>

                                        <a class="btn btn-export"
                                            href="{{ route('admin.lead.service.fulfill_order', $order->id) }}">
                                            ADMIN VIEW
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Slots List Card -->
                            <div class="section-card mx-4 mb-4">
                                <div class="section-header">
                                    <h5 class="section-title">Scheduled Slots</h5>
                                </div>
                                
                                @forelse($slots as $slot)
                                    <div class="slot-item {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                                        <div class="text-secondary mb-2" style="font-size: 14px;">
                                            <!-- No order ID displayed per user request -->
                                            {{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('m/d/y h:i a') }} - 
                                            {{ \Carbon\Carbon::parse($slot->scheduled_end_time)->format('m/d/y h:i a') }}
                                        </div>
                                        <div class="fw-semibold text-muted mb-1" style="font-size: 13px; font-style: italic;">
                                            Staff
                                        </div>
                                        <ul class="list-unstyled ms-3 mb-0" style="font-size: 13px;">
                                            @forelse($slot->staff as $staff)
                                                <li class="mb-1">
                                                    ◦ {!! $staff->is_leader ? '<strong>Leader</strong> ' : '' !!}{{ $staff->user->name ?? 'Unknown' }}
                                                </li>
                                            @empty
                                                <li class="text-muted">No staff assigned</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                @empty
                                    <div class="text-muted text-center py-4">No scheduled slots found for this order.</div>
                                @endforelse
                            </div>

                            <!-- Employee Table Card -->
                            <div class="px-4 pb-4">
                                <div class="section-card p-0" style="border: none; box-shadow: none;">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Employee Performance Matrix</h5>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover w-100 equipment-report-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Employee</th>
                                                    <th>Hourly Rate</th>
                                                    <th>Overtime Rate</th>
                                                    <th>Hours</th>
                                                    <th>Overtime Hours</th>
                                                    @foreach($slots as $index => $slot)
                                                        <th>Scheduled Day {{ $index + 1 }}</th>
                                                    @endforeach
                                                    <th>Actual Worked</th>
                                                    <th>Deviation From Schedule</th>
                                                    <th>Budgeted $</th>
                                                    <th>Extended Actual Cost</th>
                                                    <th>Total With Benefits</th>
                                                    <th>Budget $ Variance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($employees as $emp)
                                                    <tr>
                                                        <td class="text-start fw-bold">{{ $emp['user']->name ?? 'Unknown' }}</td>
                                                        <td>{{ number_format($emp['hourlyRate'], 2) }}</td>
                                                        <td>{{ number_format($emp['overtimeRate'], 2) }}</td>
                                                        <td>{{ number_format($emp['regularHours'], 2) }}</td>
                                                        <td>{{ number_format($emp['overtimeHours'], 2) }}</td>
                                                        
                                                        @foreach($emp['scheduledDays'] as $hours)
                                                            <td class="text-danger fw-bold">{{ $hours ? number_format($hours, 1) : '' }}</td>
                                                        @endforeach
                                                        
                                                        <td>{{ number_format($emp['actualWorkedHours'], 2) }}</td>
                                                        <td>{{ number_format($emp['deviationFromSchedule'], 2) }}</td>
                                                        <td>{{ number_format($emp['budgetedAmount'], 2) }}</td>
                                                        <td>{{ number_format($emp['extendedActualCost'], 2) }}</td>
                                                        <td>{{ number_format($emp['totalWithBenefits'], 2) }}</td>
                                                        <td>{{ number_format($emp['budgetVariance'], 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="{{ 11 + count($slots) }}" class="text-muted py-4">
                                                            No employee logs or slot assignments found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                
                                                <!-- Totals Row -->
                                                @if(count($employees) > 0)
                                                    <tr class="fw-bold" style="background-color: #fafafa;">
                                                        <td class="text-start">Total / Average</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>{{ number_format(collect($employees)->sum('regularHours'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('overtimeHours'), 2) }}</td>
                                                        
                                                        @foreach($slots as $index => $slot)
                                                            <td class="text-danger">
                                                                {{ number_format(collect($employees)->sum(function($emp) use ($index) { return (float)($emp['scheduledDays'][$index] ?? 0); }), 1) }}
                                                            </td>
                                                        @endforeach
                                                        
                                                        <td>{{ number_format(collect($employees)->sum('actualWorkedHours'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('deviationFromSchedule'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('budgetedAmount'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('extendedActualCost'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('totalWithBenefits'), 2) }}</td>
                                                        <td>{{ number_format(collect($employees)->sum('budgetVariance'), 2) }}</td>
                                                    </tr>
                                                @endif
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
