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
                                                                    <option value="">Select Office</option>
                                                                    <option>Lubbock, TX</option>
                                                                    <option>Dallas, TX</option>
                                                                    <option>Houston, TX</option>
                                                                    <option>Austin, TX</option>
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
                                                            <td>{{ $slot->scheduled_office }}</td>
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
                                                            <td>{{ $slot->scheduled_office }}</td>
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
                                                                            @foreach(['Lubbock, TX', 'Dallas, TX', 'Houston, TX', 'Austin, TX'] as $office)
                                                                                <option {{ $slot->scheduled_office == $office ? 'selected' : '' }}>{{ $office }}</option>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


                                        </div>
                                    </div>
                                </div>

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
                                                            <p class="mb-1">{{ $note->notes }}</p>
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


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

@endsection

@push('scripts')
<script>

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
</script>
@endpush
