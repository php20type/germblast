@extends('admin.includes.layout')

@section('title', 'Workforce Coverage')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
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

        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
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
                    
                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">WORKFORCE COVERAGE <span style="font-size: 24px;">📌</span></h3>
                            <p class="text-muted mb-0">View the workforce coverage matrix across all days and hours.</p>
                        </div>
                    </div>

                    <!-- Filter Control Bar (Matching All Schedules) -->
                    <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <!-- Left Side: Current Range Header -->
                            <div>
                                <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                    Month of: {{ $selectedDate->format('M Y') }}
                                </h4>
                            </div>

                            <!-- Right Side: Unified Navigation Segment Control -->
                            <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border" style="border-color: #e5e7eb !important;">
                                <a href="{{ route('admin.operations.workforce-coverage', ['date' => $selectedDate->copy()->subMonth()->toDateString()]) }}"
                                    class="calendar-nav-btn" title="Previous Month">
                                    <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Month
                                </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.operations.workforce-coverage', ['date' => now()->startOfMonth()->toDateString()]) }}"
                                     class="calendar-nav-btn {{ $selectedDate->toDateString() === now()->startOfMonth()->toDateString() ? 'btn-today' : '' }}">
                                     Current Month
                                 </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.operations.workforce-coverage', ['date' => $selectedDate->copy()->addMonth()->toDateString()]) }}"
                                    class="calendar-nav-btn" title="Next Month">
                                    Next Month <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="px-4 pb-4">
                        <table class="table w-100 equipment-report-table">
                            <thead>
                                <tr>
                                    <th>Hour</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Sunday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hours = [
                                        '12 am', '1 am', '2 am', '3 am', '4 am', '5 am', '6 am', '7 am', '8 am', '9 am', '10 am', '11 am',
                                        '12 pm', '1 pm', '2 pm', '3 pm', '4 pm', '5 pm', '6 pm', '7 pm', '8 pm', '9 pm', '10 pm', '11 pm'
                                    ];
                                    $dayKeys = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                @endphp

                                @foreach($hours as $index => $hour)
                                    <tr>
                                        <td>{{ $hour }}</td>
                                        @foreach($dayKeys as $dayKey)
                                            @php
                                                $employeesInSlot = $coverage[$dayKey][$index] ?? [];
                                                $count = count($employeesInSlot);
                                                $title = $index . ":00 Count " . $count;
                                                
                                                $popoverContent = '';
                                                foreach ($employeesInSlot as $emp) {
                                                    $popoverContent .= htmlspecialchars($emp['name']) . " " . htmlspecialchars($emp['time']) . "<br>";
                                                }
                                            @endphp
                                            <td>
                                                @if($count > 0)
                                                    <a tabindex="0" 
                                                       role="button"
                                                       class="text-primary text-decoration-none cursor-pointer"
                                                       data-bs-toggle="popover" 
                                                       data-bs-trigger="focus hover" 
                                                       data-bs-placement="bottom"
                                                       data-bs-html="true"
                                                       title="{{ $title }}" 
                                                       data-bs-content="{{ $popoverContent }}">
                                                        Count {{ $count }}
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    trigger: 'hover focus',
                    delay: { "show": 100, "hide": 100 }
                });
            });
        });
    </script>
@endpush
