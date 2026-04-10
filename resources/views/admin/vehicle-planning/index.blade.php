@extends('admin.includes.layout')

@section('title', 'Vehicle Planning')

@push('styles')
    <style>
        .company-link {
            color: #1a5fb4;
            text-decoration: none;
        }
        .company-link:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')

<div class="container-fluid my-3">

    {{-- HEADER BAR --}}
    <div style="background:#ffb81c; padding:8px 10px; border-radius:4px 4px 0 0;">
        <div class="d-flex justify-content-between align-items-center">

            <a href="{{ route('admin.vehicle.planning', ['date' => $start->copy()->subWeek()->toDateString()]) }}"
               class="btn btn-light btn-sm">
                << Previous Week
            </a>

            <div>
                Week of: {{ $start->format('l d/m/y') }}
                <a href="{{ route('admin.vehicle.planning', ['date' => now()->toDateString()]) }}" class="btn btn-light btn-sm ms-2">
                    Current Week
                </a>
            </div>

            <a href="{{ route('admin.vehicle.planning', ['date' => $start->copy()->addWeek()->toDateString()]) }}"
               class="btn btn-light btn-sm">
                Next Week >>
            </a>

        </div>
    </div>

    {{-- MAIN GRID --}}
    <div style="background:#e5e5e5; padding:10px; border:1px solid #999;">

        <div class="d-flex flex-wrap gap-2">

            @for($i = 0; $i < 7; $i++)
                @php
                    $dateItem = $start->copy()->addDays($i);
                    $dayKey = $dateItem->format('Y-m-d');
                    $daySlots = $slots[$dayKey] ?? collect();
                @endphp

                {{-- DAY COLUMN --}}
                <div style="flex:1; background:#f9f9f9; border:1px solid #999; border-radius:6px;">

                    {{-- DAY HEADER --}}
                    <div style="padding:8px; border-bottom:1px solid #ccc;">
                        {{ $dateItem->format('l d/m/y') }}
                    </div>

                    {{-- SLOTS --}}
                    <div style="padding:8px;">

                        @forelse($daySlots as $slot)

                            <div style="background:#cfe3f1; padding:8px; margin-bottom:10px; border-radius:4px;">

                                {{-- COMPANY --}}
                                <div style="font-weight:600;">
                                    <a href="{{ route('admin.lead.service.fulfill_order', $slot->serviceOrder->id) }}"
                                        class="company-link">
                                        {{ $slot->serviceOrder->service->lead->company->name ?? '-' }}
                                    </a>
                                </div>

                                {{-- TIME --}}
                                <div style="font-size:12px; color:#1a5fb4; margin-bottom:6px;">
                                    {{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($slot->scheduled_end_time)->format('h:i A') }}
                                </div>

                                {{-- CURRENT VEHICLES --}}
                                <div style="font-size:12px; margin-bottom:4px;">
                                    Current Vehicles (+ last 4 VIN)
                                </div>

                                @foreach($slot->vehicles as $vehicle)
                                    <div style="display:flex; justify-content:space-between; align-items:center; background:#d9edf7; padding:4px 6px; margin-bottom:4px; border:1px solid #bcdff1;
                                        border-radius:3px;">
                                        <span style="font-size:12px;">
                                            {{ $vehicle->name }}
                                        </span>

                                        <form action="{{ route('admin.lead.slot.vehicle.remove', [$slot->id, $vehicle->id]) }}" method="POST">
                                            @csrf
                                            <button style="background:#d9534f; color:#fff; border:none; padding:2px 6px; border-radius:2px;">
                                                X
                                            </button>
                                        </form>

                                    </div>
                                @endforeach

                                {{-- ADD VEHICLE --}}
                                <div style="margin-top:6px; font-size:12px;">
                                    Add Vehicle:
                                </div>

                                <form action="{{ route('admin.lead.slot.vehicle.assign', $slot->id) }}" method="POST">
                                    @csrf

                                    <select name="vehicle_ids[]" style="width:100%; margin-bottom:4px;" class="form-select">
                                        <option value="">Select a vehicle/VIN</option>

                                        @foreach($vehicles as $vehicle)
                                            @if(!$slot->vehicles->pluck('id')->contains($vehicle->id))
                                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <button class="btn btn-sm bg-primary text-white" style="width:100%;">
                                        Add
                                    </button>
                                </form>

                            </div>

                        @empty
                            <div style="font-size:12px; color:#777;">
                                No slots
                            </div>
                        @endforelse

                    </div>
                </div>

            @endfor

        </div>
    </div>

</div>

@endsection
