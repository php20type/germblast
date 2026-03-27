@extends('admin.includes.layout')

@section('title', 'Fulfill Order')

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <div class="sales-dashboard">
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                            <div class="container-fluid px-0">
                                <h1 class="display-6 mb-2 fw-bold">FulFill Order</h1>
                                <p class="text-muted">Order ID: ORD001</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                        <nav class="nav nav-fill w-100 nav-tabs border-bottom mb-3" id="fulfillOrderTabs" role="tablist">
                            <button class="nav-link active" id="scheduling-tab" data-bs-toggle="tab"
                                data-bs-target="#scheduling" type="button" role="tab" aria-controls="scheduling"
                                aria-selected="true">
                                Scheduling
                            </button>
                            <button class="nav-link" id="confirmations-tab" data-bs-toggle="tab"
                                data-bs-target="#confirmations" type="button" role="tab" aria-controls="confirmations"
                                aria-selected="false">
                                Confirmations
                            </button>
                            <button class="nav-link" id="facilities-tab" data-bs-toggle="tab"
                                data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities"
                                aria-selected="false">
                                Facilities
                            </button>
                            <button class="nav-link" id="staffing-tab" data-bs-toggle="tab"
                                data-bs-target="#staffing" type="button" role="tab" aria-controls="staffing"
                                aria-selected="false">
                                Staffing
                            </button>
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes"
                                type="button" role="tab" aria-controls="notes" aria-selected="false">
                                Notes
                            </button>
                            <button class="nav-link" id="invoicing-tab" data-bs-toggle="tab"
                                data-bs-target="#invoicing" type="button" role="tab" aria-controls="invoicing"
                                aria-selected="false">
                                Invoicing
                            </button>
                            <button class="nav-link" id="job-clocks-tab" data-bs-toggle="tab"
                                data-bs-target="#job-clocks" type="button" role="tab" aria-controls="job-clocks"
                                aria-selected="false">
                                Job Clocks
                            </button>
                            <button class="nav-link" id="reports-tab" data-bs-toggle="tab"
                                data-bs-target="#reports" type="button" role="tab" aria-controls="reports"
                                aria-selected="false">
                                Reports
                            </button>
                            <a class="nav-link"
                            href="{{ route('admin.company.show', $order->service->lead->company->id) }}"
                            role="tab">
                                To Customer
                            </a>
                        </nav>

                    <!-- Tab Content Section -->
                    <div class="tab-content" id="fulfillOrderTabContent">

                        <!-- Scheduling Tab -->
                        <div class="tab-pane fade show active" id="scheduling" role="tabpanel" aria-labelledby="scheduling-tab">
                            <div class="sales-dashboard">

                                <!-- Scheduling Slots -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Schedule Service for the Following Time</h5>
                                            </div>

                                            <form action="{{ route('admin.lead.service.fulfill_order.book',$order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_order_id" value="{{ $order->id }}">

                                                <table class="table table-bordered align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <th>Start Time</th>
                                                            <td><input type="datetime-local" class="form-control" name="scheduled_start_time"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>End Time</th>
                                                            <td><input type="datetime-local" class="form-control" name="scheduled_end_time"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Arrival Time</th>
                                                            <td><input type="time" class="form-control" name="scheduled_arrival_time"></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Office</th>
                                                            <td>
                                                                <select class="form-select" name="scheduled_office">
                                                                    @foreach($territories as $territory)
                                                                        <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Recurrence</th>
                                                            <td>
                                                                <select class="form-select" name="scheduled_recurrence_rule">
                                                                    <option value="N/A">N/A</option>
                                                                    <option>Daily</option>
                                                                    <option>Weekly</option>
                                                                    <option>Monthly</option>
                                                                    <option>Quarterly</option>
                                                                    <option>Annually</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Meet</th>
                                                            <td>
                                                                <select class="form-select" name="meet">
                                                                    <option value="office">Meet @ Office</option>
                                                                    <option value="facility">Meet @ Facility</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Overnight</th>
                                                            <td>
                                                                <select class="form-select" name="overnight">
                                                                    <option value="0">Not Overnight</option>
                                                                    <option value="1">Overnight</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-end">
                                                                <button type="submit" class="btn btn-success">Book It</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <!-- Booked Slots -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Scheduled Slots</h5>
                                            </div>

                                            <table class="table table-bordered align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Arrival Time</th>
                                                        <th>Office</th>
                                                        <th>Hours</th>
                                                        <th>Meet</th>
                                                        <th>Overnight</th>
                                                        <th>Recurrence</th>
                                                        <th>Clock In</th>
                                                        <th>Clock Out</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($order->orderSlots as $slot)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $slot->scheduled_start_time }}</td>
                                                            <td>{{ $slot->scheduled_end_time }}</td>
                                                            <td>{{ $slot->scheduled_arrival_time }}</td>
                                                            {{-- <td>{{ $slot->scheduled_office }}</td> --}}
                                                            <td>{{ $slot->office->name ?? 'N/A' }}</td>
                                                            <td>{{ $slot->scheduled_hours }}</td>
                                                            <td>{{ ucfirst($slot->meet) }}</td>
                                                            <td>{{ $slot->overnight ? 'Yes' : 'No' }}</td>
                                                            <td>{{ $slot->scheduled_recurrence_rule }}</td>
                                                            <td>{{ $slot->clocked_in_at ?? '-' }}</td>
                                                            <td>{{ $slot->clocked_out_at ?? '-' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center text-muted">No slots booked yet.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Confirmations Tab -->
                        <div class="tab-pane fade" id="confirmations" role="tabpanel" aria-labelledby="confirmations-tab">
                            <div class="sales-dashboard">

                                @forelse($order->orderSlots as $slot)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">

                                                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="section-title mb-0">Slot #{{ $loop->iteration }}</h5>
                                                    @if($slot->is_confirmed)
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            <i class="fas fa-check-circle me-1"></i> Confirmed
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary fs-6 px-3 py-2">Not Confirmed</span>
                                                    @endif
                                                </div>

                                                {{-- Slot Details --}}
                                                <table class="table table-bordered align-middle mb-3">
                                                    <tbody>
                                                        <tr>
                                                            <th>Start Time</th>
                                                            <td>{{ $slot->scheduled_start_time }}</td>
                                                            <th>End Time</th>
                                                            <td>{{ $slot->scheduled_end_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Arrival Time</th>
                                                            <td>{{ $slot->scheduled_arrival_time }}</td>
                                                            <th>Office</th>
                                                            {{-- <td>{{ $slot->scheduled_office }}</td> --}}
                                                            <td>{{ $slot->office->name ?? 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hours</th>
                                                            <td>{{ $slot->scheduled_hours }}</td>
                                                            <th>Meet</th>
                                                            <td>{{ ucfirst($slot->meet) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Overnight</th>
                                                            <td>{{ $slot->overnight ? 'Yes' : 'No' }}</td>
                                                            <th>Recurrence</th>
                                                            <td>{{ $slot->scheduled_recurrence_rule }}</td>
                                                        </tr>
                                                        @if($slot->is_confirmed)
                                                            <tr>
                                                                <th>Confirmed At</th>
                                                                <td>{{ $slot->confirmed_at }}</td>
                                                                <th>Confirmed By</th>
                                                                <td>{{ $slot->confirmedBy->name ?? '-' }}</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>

                                                {{-- Action Buttons --}}
                                                <div class="d-flex gap-2 justify-content-end">

                                                    {{-- Confirm Button --}}
                                                    @if(!$slot->is_confirmed)
                                                        <form action="{{ route('admin.lead.service.slot.confirm', $slot->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-check me-1"></i> Confirm Slot
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Edit Button --}}
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#editSlot{{ $slot->id }}">
                                                        <i class="fas fa-edit me-1"></i> Edit Slot
                                                    </button>

                                                </div>

                                                {{-- Edit Form (collapsible) --}}
                                                <div class="collapse mt-3" id="editSlot{{ $slot->id }}">
                                                    <form action="{{ route('admin.lead.service.slot.update', $slot->id) }}" method="POST">
                                                        @csrf
                                                        <table class="table table-bordered align-middle">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Start Time</th>
                                                                    <td><input type="datetime-local" class="form-control" name="scheduled_start_time" value="{{ $slot->scheduled_start_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>End Time</th>
                                                                    <td><input type="datetime-local" class="form-control" name="scheduled_end_time" value="{{ $slot->scheduled_end_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Arrival Time</th>
                                                                    <td><input type="time" class="form-control" name="scheduled_arrival_time" value="{{ $slot->scheduled_arrival_time }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Office</th>
                                                                    <td>
                                                                        <select class="form-select" name="scheduled_office">
                                                                            <option value="">Select Office</option>
                                                                            @foreach($territories as $territory)
                                                                                <option value="{{ $territory->id }}"
                                                                                    {{ $slot->scheduled_office == $territory->id ? 'selected' : '' }}>
                                                                                    {{ $territory->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Recurrence</th>
                                                                    <td>
                                                                        <select class="form-select" name="scheduled_recurrence_rule">
                                                                            @foreach(['N/A', 'Daily', 'Weekly', 'Monthly', 'Quarterly', 'Annually'] as $rule)
                                                                                <option {{ $slot->scheduled_recurrence_rule == $rule ? 'selected' : '' }}>{{ $rule }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Meet</th>
                                                                    <td>
                                                                        <select class="form-select" name="meet">
                                                                            <option value="office" {{ $slot->meet == 'office' ? 'selected' : '' }}>Meet @ Office</option>
                                                                            <option value="facility" {{ $slot->meet == 'facility' ? 'selected' : '' }}>Meet @ Facility</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Overnight</th>
                                                                    <td>
                                                                        <select class="form-select" name="overnight">
                                                                            <option value="0" {{ !$slot->overnight ? 'selected' : '' }}>Not Overnight</option>
                                                                            <option value="1" {{ $slot->overnight ? 'selected' : '' }}>Overnight</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-end">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="fas fa-save me-1"></i> Update Slot
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No slots found for this order.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                        <!-- Facilities Tab -->
                        <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                            <div class="sales-dashboard">

                                @forelse($order->orderSlots->where('is_confirmed', true) as $slot)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">

                                                <div class="section-header mb-3">
                                                    <h5 class="section-title mb-0">Slot #{{ $loop->iteration }}</h5>
                                                    <small class="text-muted">
                                                        {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}
                                                    </small>
                                                </div>

                                                {{-- Assigned Facilities --}}
                                                @if($slot->facilities->count())
                                                    <ul class="list-group list-group-flush mb-3">
                                                        @foreach($slot->facilities as $facility)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <i class="fas fa-building me-2 text-muted"></i>
                                                                    {{ $facility->companyLocation->location_name }}
                                                                </span>
                                                                <form action="{{ route('admin.lead.service.slot.facility.remove', $facility->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted mb-3">No facilities assigned yet.</p>
                                                @endif

                                                {{-- Add Facility Form --}}
                                                <form action="{{ route('admin.lead.service.slot.facility.add', $slot->id) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex gap-2">
                                                            <select class="form-select" name="company_location_id" required>
                                                                <option value="">-- Select Location --</option>
                                                                @foreach($companyLocations as $location)
                                                                    {{-- Skip already-added ones --}}
                                                                    @unless($slot->facilities->pluck('company_location_id')->contains($location->id))
                                                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                                                    @endunless
                                                                @endforeach
                                                            </select>
                                                        <button type="submit" class="btn btn-success">
                                                            Add
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No slots found for this order.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                        <!-- Staffing Tab -->
                        <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="staffing-tab">
                            <div class="sales-dashboard">

                                @php $confirmedSlots = $order->orderSlots->where('is_confirmed', true); @endphp

                                @if($confirmedSlots->count())

                                    <div class="section-card mt-3">
                                        <nav class="nav nav-tabs mb-3" id="staffingSlotTabs" role="tablist">
                                            @foreach($confirmedSlots as $slot)
                                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                    id="staffing-slot-{{ $slot->id }}-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#staffing-slot-{{ $slot->id }}"
                                                    type="button" role="tab">
                                                    Slot #{{ $loop->iteration }}
                                                    <small class="text-muted ms-1">{{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d') }}</small>
                                                </button>
                                            @endforeach
                                        </nav>

                                        <div class="tab-content" id="staffingSlotTabContent">
                                            @foreach($confirmedSlots as $slot)
                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                    id="staffing-slot-{{ $slot->id }}"
                                                    role="tabpanel">

                                                    {{-- Time & Facility Info --}}
                                                    <div class="border rounded p-3 mb-3 bg-light">
                                                        <p class="mb-1"><strong>Office:</strong> {{ $slot->office->name ?? 'N/A' }}</p>
                                                        <p class="mb-1"><strong>Schedule:</strong> {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}</p>
                                                        <p class="mb-0"><strong>Arrival Time:</strong> {{ $slot->scheduled_arrival_time }}</p>
                                                    </div>

                                                    {{-- Facilities --}}
                                                    @if($slot->facilities->count())
                                                        <div class="mb-3">
                                                            <p class="fw-semibold mb-2">Facilities</p>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach($slot->facilities as $facility)
                                                                    <div class="border rounded p-2 text-center bg-white" style="min-width: 160px;">
                                                                        <i class="fas fa-map-marker-alt text-danger mb-1"></i>
                                                                        <p class="mb-0 small fw-semibold">{{ $facility->companyLocation->location_name ?? '-' }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Two Column Layout --}}
                                                    <div class="row g-3">

                                                        {{-- LEFT: Assigned Team --}}
                                                        <div class="col-md-5">
                                                            <div class="border rounded p-3 h-100">
                                                                <h6 class="fw-bold mb-3">Team</h6>

                                                                @forelse($slot->staff as $staffMember)
                                                                    <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 bg-success bg-opacity-25">
                                                                        <div>
                                                                            <span class="fw-semibold small">{{ $staffMember->user->name }}</span><br>
                                                                            <small class="text-muted">{{ $staffMember->slot_hours }} hrs</small>
                                                                            @php $roles = $staffMember->user->getRoleNames()->implode(' | '); @endphp
                                                                            @if($roles)
                                                                                <br><small class="text-muted">{{ $roles }}</small>
                                                                            @endif
                                                                        </div>
                                                                        <form action="{{ route('admin.lead.service.slot.staff.remove', $staffMember->id) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @empty
                                                                    <p class="text-muted small">No team members assigned yet.</p>
                                                                @endforelse

                                                            </div>
                                                        </div>

                                                        {{-- RIGHT: Available Service Technicians --}}
                                                        <div class="col-md-7">
                                                            <div class="border rounded p-3 h-100">
                                                                <h6 class="fw-bold mb-3">Service Technicians</h6>

                                                                @php
                                                                    $territoryId     = $slot->scheduled_office;
                                                                    $staffForTerritory = $allStaff[$territoryId] ?? collect();
                                                                    $assignedUserIds = $slot->staff->pluck('user_id')->toArray();
                                                                @endphp

                                                                @if($staffForTerritory->isEmpty())
                                                                    <p class="text-muted small">No technicians found for this office.</p>
                                                                @else
                                                                    <form action="{{ route('admin.lead.service.slot.staff.assign', $slot->id) }}" method="POST">
                                                                        @csrf

                                                                        {{-- Leaders --}}
                                                                        @if(isset($staffForTerritory['leader']) && $staffForTerritory['leader']->count())
                                                                            <p class="text-muted small fw-semibold mb-2">Leaders</p>
                                                                            @foreach($staffForTerritory['leader'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php $roles = $tech->getRoleNames()->implode(' | '); @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: #4caf50;">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}">
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="text-white small mb-0" style="cursor:pointer;">
                                                                                                {{ $tech->name }}
                                                                                                @if($roles) &nbsp;|&nbsp; {{ $roles }} @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Technicians --}}
                                                                        @if(isset($staffForTerritory['technician']) && $staffForTerritory['technician']->count())
                                                                            <p class="text-muted small fw-semibold mt-3 mb-2">Technicians</p>
                                                                            @foreach($staffForTerritory['technician'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php $roles = $tech->getRoleNames()->implode(' | '); @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: #4caf50;">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}">
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="text-white small mb-0" style="cursor:pointer;">
                                                                                                {{ $tech->name }}
                                                                                                @if($roles) &nbsp;|&nbsp; {{ $roles }} @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Corporate --}}
                                                                        @if(isset($staffForTerritory['corporate']) && $staffForTerritory['corporate']->count())
                                                                            <p class="text-muted small fw-semibold mt-3 mb-2">Corporate</p>
                                                                            @foreach($staffForTerritory['corporate'] as $tech)
                                                                                @if(!in_array($tech->id, $assignedUserIds))
                                                                                    @php $roles = $tech->getRoleNames()->implode(' | '); @endphp
                                                                                    <div class="d-flex justify-content-between align-items-center rounded p-2 mb-1"
                                                                                        style="background-color: #4caf50;">
                                                                                        <div class="d-flex align-items-center gap-2">
                                                                                            <input type="checkbox"
                                                                                                class="form-check-input mt-0"
                                                                                                name="user_ids[]"
                                                                                                value="{{ $tech->id }}"
                                                                                                id="staff-{{ $slot->id }}-{{ $tech->id }}">
                                                                                            <label for="staff-{{ $slot->id }}-{{ $tech->id }}"
                                                                                                class="text-white small mb-0" style="cursor:pointer;">
                                                                                                {{ $tech->name }}
                                                                                                @if($roles) &nbsp;|&nbsp; {{ $roles }} @endif
                                                                                            </label>
                                                                                        </div>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-info rounded-circle p-1 view-user-slots"
                                                                                            data-user="{{ $tech->id }}"
                                                                                            data-date="{{ $slot->scheduled_start_time }}"
                                                                                            style="width:28px;height:28px;">
                                                                                            <i class="fas fa-question" style="font-size:11px;"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif

                                                                        {{-- Add Selected Button --}}
                                                                        <div class="mt-3 text-end">
                                                                            <button type="submit" class="btn btn-success px-4">
                                                                                Add Selected
                                                                            </button>
                                                                        </div>

                                                                    </form>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- Summary Footer --}}
                                                    @php
                                                        $totalHours    = $slot->staff->sum('slot_hours');
                                                        $totalCost     = $slot->staff->sum('cost');
                                                        $invoiceAmount = $order->service->price_per_service ?? 0;
                                                        $peoplePct     = $invoiceAmount > 0 ? round(($totalCost / $invoiceAmount) * 100) : 0;
                                                    @endphp
                                                    <div class="mt-3 pt-3 border-top d-flex gap-4">
                                                        <small class="text-muted">People Percentage: <strong>{{ $peoplePct }}%</strong></small>
                                                        <small class="text-muted">Invoice: <strong>${{ number_format($invoiceAmount, 2) }}</strong></small>
                                                        <small class="text-muted">Hours: <strong>{{ $totalHours }}</strong></small>
                                                        <small class="text-muted">Cost: <strong>${{ number_format($totalCost, 2) }}</strong></small>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @else
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No confirmed slots found. Confirm slots in the Confirmations tab first.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <!-- Notes Tab -->
                        <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                            <div class="sales-dashboard mt-4">

                                {{-- Contract Details --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Contract Details</h5>
                                            </div>

                                            @forelse($order->service->outlines as $outline)
                                                <div class="border-bottom py-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <p class="mb-1 fw-semibold">{{ ucwords($outline->outline_name) }}</p>
                                                        </div>
                                                        <span class="text-muted small">{{ $outline->range }}% complete</span>
                                                    </div>

                                                    {{-- Progress Bar --}}
                                                    <div class="progress mb-2" style="height: 6px;">
                                                        <div class="progress-bar bg-success"
                                                            role="progressbar"
                                                            style="width: {{ $outline->range }}%"
                                                            aria-valuenow="{{ $outline->range }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>

                                                    {{-- Edit Form --}}
                                                    <form action="{{ route('admin.lead.service.outline.update', $outline->id) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        <div class="row mt-2 g-2">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                        class="form-control"
                                                                        name="range"
                                                                        value="{{ $outline->range ?? 0 }}"
                                                                        min="0" max="100" step="1"
                                                                        placeholder="0">
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <textarea name="description"
                                                                    class="form-control"
                                                                    placeholder="Add description...">{{ $outline->description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="text-end">
                                                                <button type="submit" class="btn btn-success">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @empty
                                                <p class="text-muted">No contract details found.</p>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>

                                {{-- Service Notes --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Service Notes</h5>
                                                <small class="text-muted">Enter new notes in the form below:</small>
                                            </div>

                                            {{-- Existing Notes List --}}
                                            @if($order->notes->count())
                                                <div class="mb-4">
                                                    @foreach($order->notes as $note)
                                                        <div class="border rounded p-3 mb-2">
                                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                                <small class="text-muted">
                                                                    {{ $note->user->name ?? '-' }} &bull; {{ $note->created_at->format('d M Y, h:i A') }}
                                                                </small>
                                                                @if($note->notify_sales_team)
                                                                    <span class="badge bg-warning text-dark">Sales Team Notified</span>
                                                                @endif
                                                            </div>
                                                            <p class="mb-1">{!! nl2br(e($note->notes)) !!}</p>
                                                            @if($note->image_path)
                                                                <img src="{{ asset('storage/' . $note->image_path) }}"
                                                                    class="img-thumbnail mt-2"
                                                                    style="max-height: 150px;">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Add Note Form --}}
                                            <form action="{{ route('admin.lead.service.order.notes.add', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <table class="table table-bordered align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <th>Notes</th>
                                                            <td>
                                                                <textarea class="form-control" name="notes" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Upload Photo <small class="text-muted">(optional)</small></th>
                                                            <td>
                                                                <input type="file" class="form-control" name="photo">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <small class="text-muted">Note: Use the Contracts section to document service that was performed. Discrepancies, damage, or other issues that the sales team should be notified about should be documented and the checkbox checked.</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" name="notify_sales_team" id="notify_sales_team">
                                                                    <label class="form-check-label" for="notify_sales_team">Notify Sales Team</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-end">
                                                                <button type="submit" class="btn btn-success">Add Notes</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                {{-- Inventory Consumption --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Inventory Consumption</h5>
                                            </div>

                                            <form action="{{ route('admin.lead.service.order.inventory.update', $order->id) }}" method="POST">
                                                @csrf
                                                <table class="table table-bordered align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Quantity Used</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach([
                                                            'microfiber'       => 'Microfiber',
                                                            'swabs'            => 'Swabs',
                                                            'oxivir_jars'      => 'Oxivir Concentrate Jars',
                                                            'opticide_gallons' => 'Opticide Gallons',
                                                            'halomist'         => 'Halomist',
                                                            'water'            => 'Water',
                                                        ] as $field => $label)
                                                            <tr>
                                                                <td>{{ $label }}</td>
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        name="{{ $field }}"
                                                                        value="{{ $order->$field ?? 0 }}"
                                                                        min="0">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="text-end">
                                                                <button type="submit" class="btn btn-success">Save Inventory</button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Invoicing Tab -->
                        <div class="tab-pane fade" id="invoicing" role="tabpanel" aria-labelledby="invoicing-tab">
                            <div class="sales-dashboard">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <h5 class="section-title mb-4">Invoices</h5>

                                            {{-- Invoice Document --}}
                                            <div class="border rounded p-4 mb-4">

                                                {{-- Invoice Header --}}
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        {{-- Logo --}}
                                                        <img src="{{ asset('img/logo/logo.png') }}"
                                                            alt="GermBlast"
                                                            style="max-height: 60px;">
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                        <h4 class="fw-bold">Invoice</h4>
                                                        <p class="mb-1 small">Invoice Number: <strong>49107</strong></p>
                                                        <p class="mb-1 small">Invoice Date: <strong>March 02, 2026</strong></p>
                                                        <p class="mb-1 small">Due Date: <strong class="text-danger">March 02, 2026</strong></p>
                                                        <p class="mb-0 small">Amount Due: <strong>$419.58</strong></p>
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Service Provider + Customer --}}
                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <p class="fw-bold mb-1">Service Provider</p>
                                                        <p class="mb-0 small">Infection Controls, Inc.</p>
                                                        <p class="mb-0 small">1414 Avenue J</p>
                                                        <p class="mb-0 small">Lubbock, TX 79401</p>
                                                        <p class="mb-0 small">877.771.3558</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="fw-bold mb-1">Customer</p>
                                                        <p class="mb-0 small">Faith Church Lubbock</p>
                                                        <p class="mb-0 small">Faith Church Lubbock</p>
                                                        <p class="mb-0 small">3616 58th Street</p>
                                                        <p class="mb-0 small">Lubbock, TX 79413</p>
                                                        <p class="mb-0 small">806.300.5184</p>
                                                    </div>
                                                </div>

                                                <hr>

                                                {{-- Line Items --}}
                                                <h6 class="fw-bold mb-3">Line Items</h6>

                                                {{-- Line Item Row --}}
                                                <div class="row align-items-center mb-2 g-2">
                                                    <div class="col-md-4">
                                                        <select class="form-select form-select-sm">
                                                            <option selected>GermBlast Flat Fee</option>
                                                            <option>Travel Fee</option>
                                                            <option>Supply Fee</option>
                                                            <option>Additional Service</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Qty</span>
                                                            <input type="number" class="form-control" value="1" min="1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control" value="419.58" min="0" step="0.01">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="small">Total = <strong>$419.58</strong></span>
                                                    </div>
                                                    <div class="col-md-2 d-flex gap-1">
                                                        <button class="btn btn-sm btn-primary">Update</button>
                                                        <button class="btn btn-sm btn-danger">Delete Line</button>
                                                    </div>
                                                </div>

                                                {{-- Total --}}
                                                <p class="small mt-2">Total of Line Items <strong>$419.58</strong></p>

                                                {{-- Add Line Button --}}
                                                <button class="btn btn-sm btn-outline-secondary mb-4">
                                                    Add Another Line
                                                </button>

                                                {{-- Notes --}}
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Notes:</label>
                                                    <textarea class="form-control" rows="4"></textarea>
                                                </div>
                                                <button class="btn btn-sm btn-secondary mb-3">Update Notes</button>

                                                {{-- Status --}}
                                                <p class="small text-muted mb-0">Status: <strong>Complete</strong></p>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Job Clocks Tab --}}
                        <div class="tab-pane fade" id="job-clocks" role="tabpanel" aria-labelledby="job-clocks-tab">
                            <div class="sales-dashboard">

                                @forelse($order->orderSlots->where('is_confirmed', true) as $slot)
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">

                                                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="section-title mb-0">Slot #{{ $loop->iteration }}</h5>
                                                    <small class="text-muted">
                                                        {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}
                                                    </small>
                                                </div>

                                                {{-- Clock History Table --}}
                                                @if($slot->clocks->count())
                                                    <table class="table table-bordered table-sm align-middle mb-3">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Type</th>
                                                                <th>Clocked In</th>
                                                                <th>Clocked Out</th>
                                                                <th>Hours</th>
                                                                <th>By</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($slot->clocks as $clock)
                                                                <tr>
                                                                    <td>
                                                                        @if($clock->type === 'service')
                                                                            <span class="badge bg-primary">Service</span>
                                                                        @elseif($clock->type === 'travel')
                                                                            <span class="badge bg-info text-dark">Travel</span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">Break</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $clock->clocked_in_at ?? '-' }}</td>
                                                                    <td>{{ $clock->clocked_out_at ?? '-' }}</td>
                                                                    <td>{{ $clock->clocked_hours ? $clock->clocked_hours . ' hrs' : '-' }}</td>
                                                                    <td>{{ $clock->clockedBy->name ?? '-' }}</td>
                                                                    <td>
                                                                        @if($clock->clocked_out_at)
                                                                            <span class="badge bg-success">Done</span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">Running</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot class="table-light">
                                                            <tr>
                                                                <th colspan="3" class="text-end">Total Clocked Hours</th>
                                                                <th colspan="3">{{ $slot->clocks->sum('clocked_hours') }} hrs</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                @else
                                                    <p class="text-muted mb-3">No clock entries yet.</p>
                                                @endif

                                                {{-- Live Clock Display --}}
                                                <div class="p-3 border rounded bg-light mb-3">
                                                    <h5 class="mb-0 live-clock"></h5>
                                                    <small class="text-muted live-date"></small>
                                                </div>

                                                {{-- Active Clock or Clock In Form --}}
                                                @php
                                                    $runningClock = $slot->clocks->whereNull('clocked_out_at')->first();
                                                @endphp

                                                @if($runningClock)
                                                    {{-- Something is running — show active state + clock out --}}
                                                    <div class="border rounded p-3 bg-light">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <div>
                                                                @if($runningClock->type === 'service')
                                                                    <span class="badge bg-primary fs-6 px-3 py-2">Service</span>
                                                                @elseif($runningClock->type === 'travel')
                                                                    <span class="badge bg-info text-dark fs-6 px-3 py-2">Travel</span>
                                                                @else
                                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Break</span>
                                                                @endif
                                                                <span class="ms-2 text-muted small">
                                                                    Started: {{ $runningClock->clocked_in_at }}
                                                                </span>
                                                            </div>
                                                            <small class="text-muted">
                                                                ⏱ Since Clock In:
                                                                <strong>
                                                                    <span data-clockin-time="{{ $runningClock->clocked_in_at }}"></span>
                                                                </strong>
                                                            </small>
                                                        </div>

                                                        <div class="d-flex justify-content-end">
                                                            <form action="{{ route('admin.lead.service.clock_out') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                                                <input type="hidden" name="type" value="{{ $runningClock->type }}">
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-stop-circle me-1"></i>
                                                                    Clock Out — {{ ucfirst($runningClock->type) }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                @else
                                                    {{-- Nothing running — show type selector + clock in --}}
                                                    <form action="{{ route('admin.lead.service.clock_in') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <select class="form-select" name="type" required>
                                                                <option value="">-- Select Type --</option>
                                                                <option value="service">Service</option>
                                                                <option value="travel">Travel</option>
                                                                <option value="break">Break</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-success px-4 text-nowrap">
                                                                <i class="fas fa-play-circle me-1"></i> Clock In
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="section-card">
                                                <p class="text-center text-muted mb-0">No slots found for this order.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                        <!-- Reports Tab -->
                        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                            <div class="sales-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>



                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="userSlotsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>User Monthly Schedule</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Office</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Hours</th>
                            </tr>
                        </thead>
                        <tbody id="userSlotsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>

    // document.addEventListener("DOMContentLoaded", function () {

    //     // On page load → check hash
    //     let hash = window.location.hash;

    //     if (hash) {
    //         let triggerEl = document.querySelector(`[data-bs-target="${hash}"]`);
    //         if (triggerEl) {
    //             new bootstrap.Tab(triggerEl).show();
    //         }
    //     }

    //     // On tab click → update URL hash
    //     document.querySelectorAll('#fulfillOrderTabs button[data-bs-toggle="tab"]').forEach(tab => {
    //         tab.addEventListener('shown.bs.tab', function (e) {
    //             let target = e.target.getAttribute('data-bs-target');
    //             history.replaceState(null, null, target);
    //         });
    //     });

    // });

    // Live Clock — update all .live-clock and .live-date elements
    function updateClock() {
        const now = new Date();

        let hours = now.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeStr = `${hours}:${minutes}:${seconds} ${ampm}`;

        const options = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
        const dateStr = now.toLocaleDateString('en-US', options);

        document.querySelectorAll('.live-clock').forEach(el => el.textContent = timeStr);
        document.querySelectorAll('.live-date').forEach(el => el.textContent = dateStr);
    }

    setInterval(updateClock, 1000);
    updateClock();

    // Since Clock In — per slot
    function updateTimeSinceClockIn() {
        document.querySelectorAll('[data-clockin-time]').forEach(function(el) {
            const clockInTime = new Date(el.dataset.clockinTime);
            const now = new Date();
            const diff = now - clockInTime;

            const totalSeconds = Math.floor(diff / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            el.textContent = `${hours}h ${minutes}m ${seconds}s`;
        });
    }

    setInterval(updateTimeSinceClockIn, 1000);
    updateTimeSinceClockIn();

    $(document).on('click', '.view-user-slots', function () {
        let userId = $(this).data('user');
        let date   = $(this).data('date');

        $.get("{{ route('admin.lead.service.user.monthly_slots') }}", {
            user_id: userId,
            date: date
        }, function (res) {
            let html = '';

            if (res.length === 0) {
                html = `<tr><td colspan="4" class="text-center">No bookings</td></tr>`;
            } else {
                res.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.office}</td>
                            <td>${row.start_time}</td>
                            <td>${row.end_time}</td>
                            <td>${row.hours}</td>
                        </tr>
                    `;
                });
            }

            $('#userSlotsBody').html(html);
            $('#userSlotsModal').modal('show');
        });
    });
</script>
@endpush
