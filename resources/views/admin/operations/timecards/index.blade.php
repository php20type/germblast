@extends('admin.includes.layout')

@section('title', 'All Time Sheets')

@push('styles')
    <style>
        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-bottom: 1px solid #e5e7eb !important;
            border-right: 1px solid #e5e7eb !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #e5e7eb !important;
            border-right: 1px solid #e5e7eb !important;
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
        .equipment-report-table tbody td:nth-child(1):not(.dataTables_empty) {
            text-align: left !important;
        }

        .dataTables_empty {
            text-align: center !important;
            padding: 50px !important;
            color: #6b7280 !important;
            font-size: 15px !important;
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
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        <div class="sales-dashboard">
                            <!-- Header -->
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">ALL TIME SHEETS</h3>
                                    <p class="text-muted mb-0">This page displays everyone's time sheets</p>
                                </div>
                            </div>

                            <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <div>
                                        <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                            Week of: {{ $start->format('M d, Y') }}
                                        </h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border" style="border-color: #e5e7eb !important;">
                                        <a href="{{ route('admin.timecards.index', ['date' => $start->copy()->subWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Previous Week">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.timecards.index', ['date' => now()->toDateString()]) }}" class="calendar-nav-btn {{ $start->toDateString() === now()->startOfWeek()->toDateString() ? 'btn-today' : '' }}">
                                            Current Week
                                        </a>
                                        <span class="text-muted opacity-25 px-1">|</span>
                                        <a href="{{ route('admin.timecards.index', ['date' => $start->copy()->addWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Next Week">
                                            Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Reg</th>
                                                <th>Drive</th>
                                                <th>Ride</th>
                                                <th>OT</th>
                                                <th>Train</th>
                                                <th>Floor</th>
                                                <th>Covid</th>
                                                <th>mRGB</th>
                                                <th>WH</th>
                                                <th class="text-primary">Total</th>
                                                <th>Break</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td><a href="{{ route('admin.timecards.details', $user->id) }}"
                                                            class="text-decoration-none">{{ $user->name }}</a></td>
                                                    <td>{{ $user->totals['reg'] > 0 ? number_format($user->totals['reg'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['drive'] > 0 ? number_format($user->totals['drive'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['ride'] > 0 ? number_format($user->totals['ride'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['ot'] > 0 ? number_format($user->totals['ot'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['train'] > 0 ? number_format($user->totals['train'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['floor'] > 0 ? number_format($user->totals['floor'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['covid'] > 0 ? number_format($user->totals['covid'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['mrgb'] > 0 ? number_format($user->totals['mrgb'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['wh'] > 0 ? number_format($user->totals['wh'], 2) : '-' }}
                                                    </td>
                                                    <td class="text-primary fw-bold">
                                                        {{ $user->totals['total'] > 0 ? number_format($user->totals['total'], 2) : '-' }}
                                                    </td>
                                                    <td>{{ $user->totals['break'] > 0 ? number_format($user->totals['break'], 2) : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold bg-light">
                                                <td class="text-start">Totals</td>
                                                <td>{{ $grand_totals['reg'] > 0 ? number_format($grand_totals['reg'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['drive'] > 0 ? number_format($grand_totals['drive'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['ride'] > 0 ? number_format($grand_totals['ride'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['ot'] > 0 ? number_format($grand_totals['ot'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['train'] > 0 ? number_format($grand_totals['train'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['floor'] > 0 ? number_format($grand_totals['floor'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['covid'] > 0 ? number_format($grand_totals['covid'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['mrgb'] > 0 ? number_format($grand_totals['mrgb'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['wh'] > 0 ? number_format($grand_totals['wh'], 2) : '-' }}
                                                </td>
                                                <td class="text-primary">
                                                    {{ $grand_totals['total'] > 0 ? number_format($grand_totals['total'], 2) : '-' }}
                                                </td>
                                                <td>{{ $grand_totals['break'] > 0 ? number_format($grand_totals['break'], 2) : '-' }}
                                                </td>
                                            </tr>
                                        </tfoot>
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