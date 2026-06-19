@extends('admin.includes.layout')

@section('title', 'Team Availability')

@push('styles')
    <style>
        .company-link {
            color: #1a5fb4;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .company-link:hover {
            text-decoration: underline;
            color: #0d47a1;
        }

        .bg-today-light {
            background-color: rgba(255, 180, 0, 0.02) !important;
        }

        .border-today-accent {
            border-top: 3px solid #ffb400 !important;
        }

        /* Calendar column borders */
        .calendar-week-grid {
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            overflow: hidden;
            background: #ffffff;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }

        .calendar-day-col {
            border-right: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 1200px) {
            .calendar-week-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .calendar-week-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .calendar-week-grid {
                grid-template-columns: 1fr;
            }
        }

        .calendar-day-header {
            background-color: #fafafa;
            border-bottom: 1px solid #e5e7eb !important;
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
                <div class="col-md-12 p-0">

                    <div class="main-content">
                        <!-- Header (matching GermBlast standard index layout) -->
                        <div class="heading-area-sec mb-0 border-bottom-0">
                            <div class="left-part-sec">
                                <h3 class="mb-1">TEAM AVAILABILITY
                                    <span style="font-size: 24px;">👥</span>
                                </h3>
                                <p class="text-muted mb-0">Manage week-by-week service slot planning and staff assignments
                                </p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->
                                <div>
                                    <span class="text-secondary text-uppercase fw-bold d-block"
                                        style="font-size: 9px; letter-spacing: 0.5px;">Active Schedule Period</span>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Week of: {{ $start->format('M d, Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.team.availability', ['date' => $start->copy()->subWeek()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Previous Week">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.team.availability', ['date' => now()->toDateString()]) }}"
                                        class="calendar-nav-btn btn-today">
                                        Current Week
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.team.availability', ['date' => $start->copy()->addWeek()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Next Week">
                                        Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- Calendar Weekly Matrix Grid -->
                        <div class="px-4 pb-4 mt-3">
                            <div class="calendar-week-grid">
                                @foreach(range(0, 6) as $dayOffset)
                                    @php
                                        $dateItem = $start->copy()->addDays($dayOffset);
                                        $dayKey = $dateItem->format('Y-m-d');
                                        $daySlots = $slots[$dayKey] ?? collect();
                                        $isToday = $dateItem->isToday();
                                    @endphp

                                    {{-- DAY COLUMN --}}
                                    <div class="calendar-day-col {{ $isToday ? 'bg-today-light' : '' }}">

                                        {{-- DAY HEADER --}}
                                        <div
                                            class="calendar-day-header py-3 px-2 text-center {{ $isToday ? 'border-today-accent' : '' }}">
                                            <span class="d-block fw-bold text-secondary text-uppercase mb-1"
                                                style="font-size: 10px; letter-spacing: 0.5px;">
                                                {{ $dateItem->format('l') }}
                                            </span>
                                            <span class="d-block fw-bold text-dark" style="font-size: 13px;">
                                                {{ $dateItem->format('M d, Y') }}
                                            </span>
                                            @if($isToday)
                                                <span class="badge bg-warning text-dark mt-1"
                                                    style="font-size: 9px; font-weight: 600;">TODAY</span>
                                            @endif
                                        </div>

                                        {{-- DAY BODY / SLOTS --}}
                                        <div class="p-2 flex-grow-1 d-flex flex-column gap-2" style="min-height: 450px;">
                                            @forelse($daySlots as $slot)
                                                {{-- SLOT CONTAINER --}}
                                                <div class="p-3 rounded-3 position-relative"
                                                    style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #3b82f6;">

                                                    {{-- COMPANY LINK --}}
                                                    <div class="fw-bold text-dark mb-1" style="font-size: 12px; line-height: 1.3;">
                                                        <a href="{{ route('admin.lead.service.fulfill_order', $slot->serviceOrder->id) }}"
                                                            class="company-link text-primary hover-underline">
                                                            {{ $slot->serviceOrder->service->lead->company->name ?? '-' }}
                                                        </a>
                                                    </div>

                                                    {{-- SERVICE ORDER HYPERLINK --}}
                                                    <div class="mb-2" style="font-size: 13px;">
                                                        <a href="{{ route('admin.lead.service.fulfill_order', $slot->serviceOrder->id) }}"
                                                            class="company-link text-primary hover-underline fw-bold">
                                                            <i class="fas fa-file-invoice me-1"></i>Service Order #{{ $slot->serviceOrder->order_no ?? $slot->serviceOrder->id }}
                                                        </a>
                                                    </div>

                                                    {{-- SLOT TIME --}}
                                                    <div class="text-muted fw-semibold mb-2" style="font-size: 12px;">
                                                        <i class="far fa-clock me-1 text-primary"
                                                            style="opacity: 0.7; font-size: 11px;"></i>
                                                        {{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('h:i A') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($slot->scheduled_end_time)->format('h:i A') }}
                                                    </div>

                                                    {{-- ASSIGNED STAFF MEMBERS --}}
                                                    <div class="assigned-staff-list mb-1">
                                                        @forelse($slot->staff as $staffMember)
                                                            <div class="d-flex align-items-center mb-1 p-1 px-2 rounded bg-white border"
                                                                style="font-size: 13px; border-color: #e5e7eb !important;">
                                                                <span class="text-dark fw-medium">
                                                                    <i class="fas fa-user text-primary me-1"
                                                                        style="font-size: 11px; opacity: 0.8;"></i>
                                                                    {{ $staffMember->user->name ?? 'N/A' }}
                                                                    @if($staffMember->is_leader)
                                                                        <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;">L</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @empty
                                                            <div class="text-muted text-center py-2" style="font-size: 13px; font-style: italic; border: 1px dashed #bfdbfe; border-radius: 6px;">
                                                                No staff assigned
                                                            </div>
                                                        @endforelse
                                                    </div>

                                                    {{-- AVAILABLE STAFF --}}
                                                    <div class="mt-3 pt-2 border-top" style="border-top: 1px dashed #bfdbfe !important;">
                                                        <div class="fw-bold text-success mb-2 p-2 rounded" style="background-color: #e6f4ea; color: #137333 !important; font-size: 13px; letter-spacing: 0.5px;">
                                                            Available
                                                        </div>
                                                        <div class="d-flex flex-column gap-2">
                                                            @forelse($slot->availableStaff as $available)
                                                                <div class="p-2 rounded bg-white border" style="font-size: 13px; border-color: #e5e7eb !important;">
                                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                                        <span class="text-dark fw-bold d-inline-flex align-items-center flex-wrap gap-1">
                                                                            {{ $available['user']->name }}
                                                                            <i class="fas fa-fire" style="color: #4a5568; font-size: 12px;"></i>
                                                                            @if($available['on_vacation'])
                                                                                <span class="badge" style="background-color: #fee2e2; color: #dc2626; font-size: 10px; font-weight: 600; padding: 0.15rem 0.35rem;">VACATION</span>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div class="text-muted" style="font-size: 12px;">
                                                                        {{ $available['available_time'] }}
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="text-muted text-center py-1" style="font-size: 12px; font-style: italic;">
                                                                    No staff available
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>

                                                </div>
                                            @empty
                                                {{-- NO SLOTS TEMPLATE --}}
                                                <div class="py-4 text-center text-muted"
                                                    style="font-size: 13px; margin-top: auto; margin-bottom: auto;">
                                                    <i class="far fa-calendar-minus d-block mb-1 text-muted"
                                                        style="font-size: 16px; opacity: 0.5;"></i>
                                                    No slots
                                                </div>
                                            @endforelse
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Histogram - Employee Hour Distribution Section -->
                        <div class="px-4 pb-4 mt-4">
                            <div class="card p-4 border rounded-3 bg-white" style="border-color: #e5e7eb !important;">
                                <h4 class="text-center fw-bold text-dark mb-4" style="font-size: 20px; letter-spacing: 0.5px;">Histogram - Employee Hour Distribution</h4>
                                
                                @php
                                    $maxCount = 0;
                                    foreach ($buckets as $key => $list) {
                                        $maxCount = max($maxCount, count($list));
                                    }
                                    $yMax = max(8, ceil(($maxCount + 1) / 2) * 2);
                                    
                                    $bucketNames = [
                                        '0' => '0 Hours',
                                        '<5' => 'Less than 5 Hours',
                                        '<10' => 'Less than 10 Hours',
                                        '<15' => 'Less than 15 Hours',
                                        '<20' => 'Less than 20 Hours',
                                        '<25' => 'Less than 25 Hours',
                                        '<30' => 'Less than 30 Hours',
                                        '<35' => 'Less than 35 Hours',
                                        '<40' => 'Less than 40 Hours',
                                        '>40' => 'More than 40 Hours',
                                    ];

                                    $jsBuckets = [];
                                    foreach($buckets as $key => $list) {
                                        $jsBuckets[$key] = array_map(function($item) {
                                            return [
                                                'name' => $item['employee']->name,
                                                'hours' => $item['hours']
                                            ];
                                        }, $list);
                                    }
                                @endphp

                                <div style="height: 350px; width: 100%; position: relative;">
                                    <canvas id="employeeHourChart"></canvas>
                                </div>
                            </div>

                            <!-- Buckets Detail Table -->
                            <div class="card border rounded-3 bg-white overflow-hidden mt-4" style="border-color: #e5e7eb !important;">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="vertical-align: middle;">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="ps-4 text-secondary text-uppercase fw-bold" style="font-size: 13px; width: 30%; border-bottom: 1px solid #e5e7eb !important;">Bucket</th>
                                                <th class="pe-4 text-secondary text-uppercase fw-bold" style="font-size: 13px; width: 70%; border-bottom: 1px solid #e5e7eb !important;">Employees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($buckets as $key => $list)
                                                <tr style="border-bottom: 1px solid #f3f4f6 !important;">
                                                    <td class="ps-4 fw-bold text-dark" style="font-size: 14px; vertical-align: top; padding-top: 15px; padding-bottom: 15px;">
                                                        {{ $bucketNames[$key] }}
                                                    </td>
                                                    <td class="pe-4 py-3" style="font-size: 14px; color: #4b5563; line-height: 1.6; vertical-align: top;">
                                                        @foreach($list as $item)
                                                            <div>{{ $item['employee']->name }} - {{ $item['hours'] }} hours.</div>
                                                        @endforeach
                                                    </td>
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
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            const ctx = document.getElementById('employeeHourChart').getContext('2d');
            const bucketData = {!! json_encode($jsBuckets) !!};
            const bucketNames = {!! json_encode($bucketNames) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['0', '<5', '<10', '<15', '<20', '<25', '<30', '<35', '<40', '>40'],
                    datasets: [{
                        label: 'Count of Employees',
                        data: [
                            bucketData['0'] ? bucketData['0'].length : 0,
                            bucketData['<5'] ? bucketData['<5'].length : 0,
                            bucketData['<10'] ? bucketData['<10'].length : 0,
                            bucketData['<15'] ? bucketData['<15'].length : 0,
                            bucketData['<20'] ? bucketData['<20'].length : 0,
                            bucketData['<25'] ? bucketData['<25'].length : 0,
                            bucketData['<30'] ? bucketData['<30'].length : 0,
                            bucketData['<35'] ? bucketData['<35'].length : 0,
                            bucketData['<40'] ? bucketData['<40'].length : 0,
                            bucketData['>40'] ? bucketData['>40'].length : 0
                        ],
                        backgroundColor: '#f97316',
                        hoverBackgroundColor: '#ea580c',
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                boxWidth: 20,
                                boxHeight: 12,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(31, 41, 55, 0.98)',
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 12,
                            cornerRadius: 6,
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            yAlign: 'bottom',
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    const label = context[0].label;
                                    return bucketNames[label] || label;
                                },
                                label: function(context) {
                                    const label = context.label;
                                    const items = bucketData[label] || [];
                                    if (items.length === 0) {
                                        return 'No employees';
                                    }
                                    return items.map(item => `• ${item.name} (${item.hours}h)`);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: {{ $yMax }},
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                color: '#f3f4f6'
                            },
                            title: {
                                display: true,
                                text: 'NUMBER OF EMPLOYEES',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                padding: { bottom: 10 }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
