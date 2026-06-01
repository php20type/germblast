@extends('admin.includes.layout')

@section('title', 'Service Details')

@push('styles')
    <style>
        /* Custom Premium Status Badges */
        .status-pill {
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 4px 10px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-pending {
            background-color: rgba(134, 134, 134, 0.12) !important;
            color: #636363 !important;
            border-color: rgba(134, 134, 134, 0.2) !important;
        }

        .status-pill-scheduled {
            background-color: rgba(255, 184, 28, 0.12) !important;
            color: #d39100 !important;
            border-color: rgba(255, 184, 28, 0.25) !important;
        }

        .status-pill-confirmed {
            background-color: rgba(13, 110, 253, 0.12) !important;
            color: #0d6efd !important;
            border-color: rgba(13, 110, 253, 0.2) !important;
        }

        .status-pill-in_progress {
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #926d00 !important;
            border-color: rgba(255, 193, 7, 0.3) !important;
        }

        .status-pill-completed {
            background-color: rgba(6, 150, 151, 0.12) !important;
            color: #069697 !important;
            border-color: rgba(6, 150, 151, 0.25) !important;
        }

        .status-pill-cancelled {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
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
                    <div class="main-content pb-2">

                        <!-- Header -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">
                                    SERVICE DETAILS <span style="font-size: 24px;">📌</span>
                                </h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">
                                    Congrats! You won a lead! Fill in the service details and schedule configurations below.
                                </p>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        <!-- Card 1: Create New Service -->
                        <div class="section-card mx-4 mb-4">
                            <div class="section-header mb-3">
                                <h5 class="section-title text-uppercase">CREATE NEW SERVICE</h5>
                            </div>

                            <form action="{{ route('admin.lead.service.store', $lead->id) }}" method="POST" id="add-service-details-form">
                                @csrf

                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th style="width: 30%; background-color: #fafafa;" class="fw-semibold text-dark">Name of the Service</th>
                                            <td>
                                                <input type="text" class="form-control" name="service_name" required placeholder="e.g. Standard GermBlast Service">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #fafafa;" class="fw-semibold text-dark">Service Price (per service)</th>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" class="form-control" name="price_per_service" required placeholder="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #fafafa;" class="fw-semibold text-dark">Number of Services</th>
                                            <td>
                                                <input type="number" class="form-control" name="number_of_services" required placeholder="1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #fafafa;" class="fw-semibold text-dark">PO Number</th>
                                            <td>
                                                <input type="text" class="form-control" name="po_number" placeholder="Optional PO number">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: #fafafa;" class="fw-semibold text-dark">Outline</th>
                                            <td>
                                                <input type="text" class="form-control" name="outlines" placeholder="Type an outline tag and press Enter">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-end bg-light">
                                                <button type="submit" class="btn btn-export px-4 py-2">
                                                    Add Service Outline
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <!-- Card 2: Service and Order Details -->
                        <div class="section-card mx-4 mb-4">
                            <div class="section-header mb-4">
                                <h5 class="section-title text-uppercase">SERVICE AND ORDER DETAILS</h5>
                            </div>

                            @forelse($services as $service)
                                <div class="p-4 mb-4 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                                    
                                    <!-- Service Summary Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold text-dark mb-0">{{ $service->service_name }}</h5>
                                        <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill fw-semibold">
                                            {{ $service->number_of_services }} Service(s) @ ${{ number_format($service->price_per_service, 2) }}
                                        </span>
                                    </div>

                                    <!-- Service General details -->
                                    <table class="table table-bordered align-middle mb-4">
                                        <tbody>
                                            <tr>
                                                <th style="width: 30%; background-color: #fafafa;" class="text-secondary fw-semibold">Service Outlines</th>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @forelse($service->outlines as $outline)
                                                            <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded" style="font-size: 0.78rem; font-weight: 500;">
                                                                {{ $outline->outline_name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted" style="font-size:0.85rem;">No outlines specified.</span>
                                                        @endforelse
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Scheduling Section Split -->
                                    <div class="row g-4 mb-4">
                                        <!-- Single Date Schedule -->
                                        <div class="col-md-6 border-end">
                                            <h6 class="fw-bold text-dark mb-3">Add Single Date</h6>
                                            <form action="{{ route('admin.lead.service.add_date') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label text-muted" style="font-size:0.8rem;">Intended Date</label>
                                                    <input type="date" class="form-control" name="intended_date" required>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-success w-100 py-2">
                                                    Add Date
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Recurring Schedule -->
                                        <div class="col-md-6">
                                            <h6 class="fw-bold text-dark mb-3">Configure Recurring Schedule</h6>
                                            <form action="{{ route('admin.lead.service.add_recurrence') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                                <div class="row g-2 mb-2">
                                                    <div class="col-6">
                                                        <label class="form-label text-muted mb-1" style="font-size:0.75rem;">Start Time</label>
                                                        <input type="time" class="form-control" name="scheduled_start_time">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-muted mb-1" style="font-size:0.75rem;">End Time</label>
                                                        <input type="time" class="form-control" name="scheduled_end_time">
                                                    </div>
                                                </div>

                                                <div class="row g-2 mb-2">
                                                    <div class="col-6">
                                                        <label class="form-label text-muted mb-1" style="font-size:0.75rem;">Arrival Time</label>
                                                        <input type="time" class="form-control" name="scheduled_arrival_time">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-muted mb-1" style="font-size:0.75rem;">Office</label>
                                                        <select class="form-select" name="scheduled_office">
                                                            @foreach($offices as $office)
                                                                <option value="{{ $office->name }}" {{ $office->name === 'Lubbock, TX' ? 'selected' : '' }}>{{ $office->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label text-muted mb-1" style="font-size:0.75rem;">Recurrence Count</label>
                                                    <input type="number" class="form-control" name="scheduled_recurrence_count" min="1" required placeholder="Number of recurring orders to generate">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label text-muted mb-1" style="font-size:0.75rem;">Recurrence Rules</label>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <select class="form-select" name="recurrence_rule_1">
                                                            <option value="N/A">N/A</option>
                                                            <option value="First">First</option>
                                                            <option value="Second">Second</option>
                                                            <option value="Third">Third</option>
                                                            <option value="Fourth">Fourth</option>
                                                            <option value="Last">Last</option>
                                                        </select>

                                                        <select class="form-select" name="recurrence_rule_2">
                                                            <option value="N/A">N/A</option>
                                                            <option value="Sunday">Sunday</option>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                        </select>

                                                        <span class="text-muted mx-1" style="font-size: 0.8rem;">of</span>

                                                        <select class="form-select" name="recurrence_rule_3">
                                                            <option value="N/A">N/A</option>
                                                            <option value="Week">Week</option>
                                                            <option value="Month">Month</option>
                                                            <option value="Quarter">Quarter</option>
                                                            <option value="Half-Year">Half-Year</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100 py-2">
                                                    Submit
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Generated Orders List -->
                                    <div class="mt-4">
                                        <h6 class="fw-bold text-dark mb-2">Generated Orders</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" style="border: 1px solid #e5e7eb; border-collapse: separate; border-spacing: 0; border-radius: 8px; overflow: hidden;">
                                                <thead>
                                                    <tr style="background-color: #fafafa;">
                                                        <th style="padding: 12px 15px; font-size: 13px; font-weight: 600; color: #374151;">Order No</th>
                                                        <th style="padding: 12px 15px; font-size: 13px; font-weight: 600; color: #374151;">Intended Date</th>
                                                        <th style="padding: 12px 15px; font-size: 13px; font-weight: 600; color: #374151;">Status</th>
                                                        <th style="padding: 12px 15px; font-size: 13px; font-weight: 600; color: #374151;" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($service->orders as $order)
                                                        <tr style="border-bottom: 1px solid #e5e7eb;">
                                                            <td style="padding: 12px 15px; font-size: 13px;">
                                                                <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}" class="fw-bold text-decoration-none text-primary">
                                                                    {{ $order->order_no }}
                                                                </a>
                                                            </td>
                                                            <td style="padding: 12px 15px; font-size: 13px;">
                                                                {{ \Carbon\Carbon::parse($order->intended_date)->format('M d, Y') }}
                                                            </td>
                                                            <td style="padding: 12px 15px;">
                                                                <span class="status-pill status-pill-{{ $order->status ?? 'pending' }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}
                                                                </span>
                                                            </td>
                                                            <td style="padding: 12px 15px;" class="text-end">
                                                                <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}" class="btn btn-export btn-sm py-1 px-3">
                                                                    View Details
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted py-3">
                                                                No orders created for this service yet.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    No services added to this lead yet. Use the form above to add one!
                                </div>
                            @endforelse
                        </div>

                        <!-- Card 3: Profitability Analysis -->
                        <div class="section-card border-0 mx-4" style="background-color: rgba(25, 135, 84, 0.05) !important; border-left: 4px solid #198754 !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-success mb-1 text-uppercase">PROFITABILITY ANALYSIS</h5>
                                    <p class="text-muted mb-0" style="font-size:0.9rem;">Calculated summary of won service proposal value</p>
                                </div>
                                <div class="text-end">
                                    <span class="text-secondary fw-semibold d-block" style="font-size: 0.85rem;">Proposal Value</span>
                                    <span class="fs-3 fw-bold text-success">${{ number_format($totalRevenue, 2) }}</span>
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

<script>
    $(document).ready(function() {

        document.querySelectorAll('input[name="outlines"]').forEach(function(el){
            new Tagify(el);
        });

    });
</script>

@endpush


