@extends('admin.includes.layout')

@section('title', 'All Schedules')

@push('styles')
    <style>
        .employee-section {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 1.25rem;
            overflow: hidden;
        }
        .employee-header {
            background: rgba(255, 184, 28, 0.4);
            padding: 8px 14px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .employee-header img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }
        .employee-header .badge-territory {
            font-size: 0.75rem;
            background: rgba(0,0,0,0.15);
            color: #000;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 500;
        }
        .no-schedule {
            padding: 10px 14px;
            color: #6c757d;
            font-style: italic;
            font-size: 0.875rem;
            background: #fafafa;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        .schedule-table thead tr {
            border-bottom: 2px solid #dee2e6;
            background: #f8f9fa;
        }
        .schedule-table thead th {
            padding: 8px 14px;
            font-weight: 600;
            color: #555;
        }
        .schedule-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }
        .schedule-table tbody tr:hover {
            background: #fffbf0;
        }
        .schedule-table tbody td {
            padding: 8px 14px;
            vertical-align: middle;
        }
        .schedule-table tfoot tr {
            border-top: 2px solid #dee2e6;
            background: #f8f9fa;
            font-weight: 600;
        }
        .schedule-table tfoot td {
            padding: 8px 14px;
        }
        .week-nav {
            background: #ffb81c;
            padding: 8px 10px;
            border-radius: 4px 4px 0 0;
        }
    </style>
@endpush

@section('content')

<div class="container-fluid my-3">

    {{-- WEEK NAV --}}
    <div class="week-nav mb-3">
        <div class="d-flex justify-content-between align-items-center">

            <a href="{{ route('admin.all_schedules.index', ['date' => $start->copy()->subWeek()->toDateString()]) }}"
               class="btn btn-light btn-sm">
                &lt;&lt; Previous Week
            </a>

            <div>
                Week of: {{ $start->format('l d/m/y') }} &mdash; {{ $end->format('l d/m/y') }}
                <a href="{{ route('admin.all_schedules.index', ['date' => now()->toDateString()]) }}"
                   class="btn btn-light btn-sm ms-2">
                    Current Week
                </a>
            </div>

            <a href="{{ route('admin.all_schedules.index', ['date' => $start->copy()->addWeek()->toDateString()]) }}"
               class="btn btn-light btn-sm">
                Next Week &gt;&gt;
            </a>

        </div>
    </div>

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

        <div class="employee-section">

            {{-- Header --}}
            <div class="employee-header">
                @if ($employee->profile_image)
                    <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}">
                @else
                    <div style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;border:2px solid #fff;">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>
                @endif

                <span>{{ $employee->name }}</span>

                @if ($employee->territory)
                    <span class="badge-territory">{{ $employee->territory->name }}</span>
                @endif

                @if ($employee->staff_type)
                    <span class="badge-territory text-capitalize">{{ $employee->staff_type }}</span>
                @endif

                <span class="ms-auto" style="font-size:0.8rem;font-weight:400;">
                    {{ $employeeSlots->count() }} slot(s) &bull; {{ round($totalHours, 2) }}h total
                </span>
            </div>

            {{-- Slots Table or No Schedule --}}
            @if ($employeeSlots->isEmpty())
                <div class="no-schedule">No schedule this week.</div>
            @else
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Customer</th>
                            <th>Time</th>
                            <th>Subtotal</th>
                            <th></th>
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
                                <td>{{ $startTime->format('jS F Y') }}</td>
                                <td>{{ $order->service->lead->company->name ?? '-' }}</td>
                                <td>
                                    {{ $startTime->format('jS F Y, g:i A') }} &rarr; {{ $endTime->format('jS F Y, g:i A') }}
                                </td>
                                <td>{{ round($slot->scheduled_hours ?? 0, 2) }} hours</td>
                                <td>
                                    <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}"
                                       class="btn btn-outline-secondary btn-sm" style="font-size:0.75rem;">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">Total Hours</td>
                            <td colspan="2">{{ round($totalHours, 2) }} hours</td>
                        </tr>
                    </tfoot>
                </table>
            @endif

        </div>

    @endforeach

</div>

@endsection
