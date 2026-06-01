@extends('admin.includes.layout')

@section('title', 'All Schedules')

@push('styles')
    <style>
        /* Calendar Navigation Button from Vehicle Planning */
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

        /* Modern Soft Badges */
        .badge-territory {
            font-size: 0.75rem !important;
            background-color: rgba(255, 184, 28, 0.15) !important;
            color: #d39100 !important;
            padding: 4px 10px !important;
            border-radius: 20px !important;
            font-weight: 600 !important;
            border: 1px solid rgba(255, 184, 28, 0.25) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
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
    </style>
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">

                    <!-- Header (matching GermBlast standard index layout) -->
                    <div class="heading-area-sec mb-0 border-bottom-0 pb-0">
                        <div class="left-part-sec">
                            <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">ALL SCHEDULES <span style="font-size: 24px;">📅</span></h3>
                            <p class="text-muted mb-0" style="font-size: 16px;">Manage and review all employee schedules and weekly shifts</p>
                        </div>
                    </div>

                    <hr class="mx-4 my-4" style="opacity: 0.1;">

                    <!-- Restyled Header Filter Control Bar (Matching Vehicle Planning exactly) -->
                    <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                        style="border-color: #e5e7eb !important;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                            <!-- Left Side: Current Range Header -->
                            <div>
                                <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                    Week of: {{ $start->format('M d, Y') }}
                                </h4>
                            </div>

                            <!-- Right Side: Unified Navigation Segment Control -->
                            <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                style="border-color: #e5e7eb !important;">
                                <a href="{{ route('admin.all_schedules.index', ['date' => $start->copy()->subWeek()->toDateString()]) }}"
                                    class="calendar-nav-btn" title="Previous Week">
                                    <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.all_schedules.index', ['date' => now()->toDateString()]) }}"
                                     class="calendar-nav-btn {{ $start->toDateString() === now()->startOfWeek()->toDateString() ? 'btn-today' : '' }}">
                                     Current Week
                                 </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.all_schedules.index', ['date' => $start->copy()->addWeek()->toDateString()]) }}"
                                    class="calendar-nav-btn" title="Next Week">
                                    Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- Main Grid Content -->
                    <div class="px-4 pb-4 mt-3">

                        {{-- EMPLOYEE SECTIONS --}}
                        @foreach ($employees as $employee)

                            @php
                                $employeeSlots = collect();
                                foreach ($slots as $dayDate => $daySlots) {
                                    foreach ($daySlots as $slot) {
                                        $isAssigned = $slot->staff->contains(fn($s) => $s->user_id === $employee->id);
                                        if ($isAssigned) {
                                            $employeeSlots->push(['date' => $dayDate, 'slot' => $slot]);
                                        }
                                    }
                                }
                                $totalHours = $employeeSlots->sum(fn($e) => $e['slot']->scheduled_hours ?? 0);
                            @endphp

                            <div class="section-card">

                                {{-- Header --}}
                                <div class="section-header d-flex align-items-center gap-3">
                                    @if ($employee->profile_image)
                                        <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                                    @else
                                        <div style="width:40px;height:40px;border-radius:50%;background:#ffb400;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.95rem;border:2px solid #ffb400;">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="section-title mb-1">{{ $employee->name }}</h3>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($employee->territory)
                                                <span class="badge-territory">{{ $employee->territory->name }}</span>
                                            @endif

                                            @if ($employee->staff_type)
                                                <span class="badge-territory text-capitalize">{{ $employee->staff_type }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <span class="ms-auto fw-semibold text-secondary" style="font-size:0.9rem;">
                                        {{ $employeeSlots->count() }} slot(s) &bull; {{ round($totalHours, 2) }}h total
                                    </span>
                                </div>

                                {{-- Slots Table or No Schedule --}}
                                @if ($employeeSlots->isEmpty())
                                    <div class="text-muted py-4 px-2 text-center" style="font-size: 14px; font-style: italic;">No schedule this week.</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover w-100 equipment-report-table">
                                            <thead>
                                                <tr>
                                                    <th>Day</th>
                                                    <th>Customer</th>
                                                    <th>Time Range</th>
                                                    <th>Hours Subtotal</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($employeeSlots as $entry)
                                                    @php
                                                        $slot      = $entry['slot'];
                                                        $order     = $slot->serviceOrder;
                                                        $startTime = \Carbon\Carbon::parse($slot->scheduled_start_time);
                                                        $endTime   = \Carbon\Carbon::parse($slot->scheduled_end_time);
                                                    @endphp
                                                    <tr>
                                                        <td class="fw-semibold text-dark">{{ $startTime->format('jS F Y') }}</td>
                                                        <td class="fw-bold text-dark">{{ $order->service->lead->company->name ?? '-' }}</td>
                                                        <td class="text-secondary">
                                                            {{ $startTime->format('g:i A') }} &rarr; {{ $endTime->format('g:i A') }}
                                                        </td>
                                                        <td><span class="badge bg-secondary text-white rounded-pill px-2 py-1">{{ round($slot->scheduled_hours ?? 0, 2) }} hours</span></td>
                                                        <td>
                                                            <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}"
                                                               class="btn btn-sm btn-export px-3" style="font-size:0.78rem;">
                                                                View Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: rgba(255, 184, 28, 0.05);">
                                                    <td colspan="3" class="text-end fw-bold text-dark" style="padding: 15px 20px !important;">Total Hours</td>
                                                    <td colspan="2" class="text-start" style="padding: 15px 20px !important;">
                                                        <strong class="text-dark">{{ round($totalHours, 2) }} hours</strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
