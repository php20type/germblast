@extends('admin.includes.layout')

@section('title', 'Vehicle Planning')

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
                <!-- Sidebar -->
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">

                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Vehicle Planning</h3>
                                <p class="text-muted mb-0">Manage week-by-week service slot planning and vehicle assignments</p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->

                                <div>
                                    <span class="text-secondary text-uppercase fw-bold d-block"
                                        style="font-size: 11px; letter-spacing: 0.5px;">Active Schedule Period</span>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Week of: {{ $start->format('M d, Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.vehicle.planning', ['date' => $start->copy()->subWeek()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Previous Week">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 12px;"></i> Prev Week
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.vehicle.planning', ['date' => now()->toDateString()]) }}"
                                        class="calendar-nav-btn btn-today">
                                        Current Week
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.vehicle.planning', ['date' => $start->copy()->addWeek()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Next Week">
                                        Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 12px;"></i>
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
                                                style="font-size: 12px; letter-spacing: 0.5px;">
                                                {{ $dateItem->format('l') }}
                                            </span>
                                            <span class="d-block fw-bold text-dark" style="font-size: 14px;">
                                                {{ $dateItem->format('M d, Y') }}
                                            </span>
                                            @if($isToday)
                                                <span class="badge bg-warning text-dark mt-1"
                                                    style="font-size: 10px; font-weight: 600;">TODAY</span>
                                            @endif
                                        </div>

                                        {{-- DAY BODY / SLOTS --}}
                                        <div class="p-2 flex-grow-1 d-flex flex-column gap-2" style="min-height: 450px;">
                                            @forelse($daySlots as $slot)
                                                {{-- SLOT CONTAINER --}}
                                                <div class="p-3 rounded-3 position-relative"
                                                    style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #3b82f6;">

                                                    {{-- COMPANY LINK --}}
                                                    <div class="fw-bold text-dark mb-1" style="font-size: 14px; line-height: 1.3;">
                                                        <a href="{{ route('admin.lead.service.service_dashboard', $slot->serviceOrder->id) }}"
                                                            class="company-link text-primary hover-underline">
                                                            {{ $slot->serviceOrder->service->lead->company->name ?? '-' }}
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

                                                    {{-- ASSIGNED VEHICLES --}}
                                                    <div class="assigned-vehicles-list mb-1">
                                                        @foreach($slot->vehicles as $vehicle)
                                                            <div class="d-flex justify-content-between align-items-center mb-1 p-1 px-2 rounded bg-white border"
                                                                style="font-size: 13px; border-color: #e5e7eb !important;">
                                                                <span class="text-dark fw-medium">
                                                                    <i class="fas fa-truck text-primary me-1"
                                                                        style="font-size: 11px; opacity: 0.8;"></i>
                                                                    {{ $vehicle->name }}
                                                                </span>
                                                                <form
                                                                    action="{{ route('admin.lead.slot.vehicle.remove', [$slot->id, $vehicle->id]) }}"
                                                                    method="POST" class="m-0">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-link text-danger p-0 border-0 ms-1"
                                                                        style="font-size: 13px; line-height: 1;">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- ADD VEHICLE FORM --}}
                                                    <div class="mt-2 pt-2 border-top"
                                                        style="border-top: 1px dashed #bfdbfe !important;">
                                                        <form action="{{ route('admin.lead.slot.vehicle.assign', $slot->id) }}"
                                                            method="POST" class="m-0">
                                                            @csrf
                                                            <div class="mb-1">
                                                                <select name="vehicle_ids[]"
                                                                    class="form-select form-select-sm bg-white"
                                                                    style="font-size: 13px; border-radius: 4px; padding: 0.2rem 0.4rem !important;"
                                                                    required>
                                                                    <option value="">Add vehicle...</option>
                                                                    @foreach($vehicles as $vehicle)
                                                                        @if(!$slot->vehicles->pluck('id')->contains($vehicle->id))
                                                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-export btn-sm py-1 w-100 text-center text-uppercase fw-bold"
                                                                style="font-size: 12px; border-radius: 4px !important;">
                                                                Add
                                                            </button>
                                                        </form>
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

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
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
                });
    </script>
@endpush