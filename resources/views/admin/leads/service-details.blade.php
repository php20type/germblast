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
    </style>
@endpush

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <form action="{{ route('admin.lead.service.store', $lead->id) }}" method="POST" class="" id="add-service-details-form">
                        @csrf

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Service Details</h1>
                                    <p class="text-muted">Congrats! You won a lead! Now fill this info out</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h5 class="section-title">Create New Service</h5>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Name of the Service</th>
                                                    <td><input type="text" class="form-control" name="service_name"
                                                            value=""></td>
                                                </tr>

                                                <tr>
                                                    <th>Service Price (per service)</th>
                                                    <td><input type="text" class="form-control" name="price_per_service"
                                                            value=""></td>
                                                </tr>

                                                <tr>
                                                    <th>Number of Services</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="number_of_services"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>PO Number</th>
                                                    <td><input type="text" class="form-control" name="po_number"
                                                            value=""></td>
                                                </tr>

                                                <tr>
                                                    <th>Outline</th>
                                                    <td><input type="text" class="form-control" name="outlines"
                                                            value="" placeholder="Type a outline and press Enter"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" class="text-end">
                                                        <button type="submit" class="btn btn-success">Add Service
                                                            Outline</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- Services & Scheduling Section Start -->
                    <div class="sales-dashboard">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="section-card">
                                    <!-- Scheduled Orders -->
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Service and Order Details</h5>
                                    </div>

                                    @forelse($services as $service)
                                    <!-- Services Table -->
                                    <div class="table-responsive mb-2">
                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Name</th>
                                                    <td><input type="text" class="form-control" name="service_name" value="{{ $service->service_name ?? '' }}" readonly></td>
                                                </tr>

                                                <tr>
                                                    <th>No. of Services</th>
                                                    <td><input type="number" class="form-control" name="number_of_services" value="{{ $service->number_of_services ?? '' }}" readonly></td>
                                                </tr>

                                                <tr>
                                                    <th>Service Price (per service)</th>
                                                    <td><input type="text" class="form-control" name="price_per_service" value="{{ $service->price_per_service ?? '' }}" readonly></td>
                                                </tr>

                                                <tr>
                                                    <th>Service Outline</th>
                                                    <td><input type="text" class="form-control" name="outlines"
                                                        value='@json(
                                                                $service->outlines->map(fn($outline) => [
                                                                        'value' => $outline->outline_name,
                                                                    ]))' readonly></td>
                                                </tr>

                                                <form action="{{ route('admin.lead.service.add_date') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                                                    <tr>
                                                        <th>Services</th>
                                                        <td>
                                                            <input type="date" class="form-control" name="intended_date" required>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" class="text-end">
                                                            <button type="submit" class="btn btn-success">
                                                                Add Date
                                                            </button>
                                                        </td>
                                                    </tr>

                                                </form>

                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Recurrence Schedule Table -->
                                    <div class="table-responsive mb-2 mt-4">
                                        <h6 class="fw-bold mb-3 text-secondary"><i class="fas fa-redo me-1"></i> Configure Recurring Service Schedule</h6>
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <form action="{{ route('admin.lead.service.add_recurrence') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="service_id" value="{{ $service->id }}">



                                                     <tr>
                                                         <th>Start Time</th>
                                                         <td>
                                                             <input type="time" class="form-control" name="scheduled_start_time">
                                                         </td>
                                                     </tr>

                                                     <tr>
                                                         <th>End Time</th>
                                                         <td>
                                                             <input type="time" class="form-control" name="scheduled_end_time">
                                                         </td>
                                                     </tr>

                                                    <tr>
                                                        <th>Arrival Time</th>
                                                        <td>
                                                            <input type="time" class="form-control" name="scheduled_arrival_time">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Office</th>
                                                        <td>
                                                            <select class="form-control form-select" name="scheduled_office">
                                                                @foreach($offices as $office)
                                                                    <option value="{{ $office->name }}" {{ $office->name === 'Lubbock, TX' ? 'selected' : '' }}>{{ $office->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Recurrence Count</th>
                                                        <td>
                                                            <input type="number" class="form-control" name="scheduled_recurrence_count" min="1" required placeholder="Number of recurring orders to generate">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Recurrence Rules</th>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <select class="form-control form-select" name="recurrence_rule_1" style="width: auto;">
                                                                    <option value="N/A">N/A</option>
                                                                    <option value="First">First</option>
                                                                    <option value="Second">Second</option>
                                                                    <option value="Third">Third</option>
                                                                    <option value="Fourth">Fourth</option>
                                                                    <option value="Last">Last</option>
                                                                </select>

                                                                <select class="form-control form-select" name="recurrence_rule_2" style="width: auto;">
                                                                    <option value="N/A">N/A</option>
                                                                    <option value="Sunday">Sunday</option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                    <option value="Saturday">Saturday</option>
                                                                </select>

                                                                <span class="text-muted">of a</span>

                                                                <select class="form-control form-select" name="recurrence_rule_3" style="width: auto;">
                                                                    <option value="N/A">N/A</option>
                                                                    <option value="Week">Week</option>
                                                                    <option value="Month">Month</option>
                                                                    <option value="Quarter">Quarter</option>
                                                                    <option value="Half-Year">Half-Year</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" class="text-end">
                                                            <button type="submit" class="btn btn-primary">
                                                                Submit
                                                            </button>
                                                        </td>
                                                    </tr>

                                                </form>

                                            </tbody>
                                        </table>
                                    </div>


                                    @forelse($service->orders as $order)

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <i class="fa fa-circle me-2" style="font-size: 10px"></i>
                                                <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}">
                                                    <strong>Order: {{ $order->order_no }}</strong>
                                                </a>
                                                <span class="status-pill status-pill-{{ $order->status ?? 'pending' }} ms-2" style="font-size: 10px !important; padding: 4px 10px !important;">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}
                                                </span>
                                                - Intended Date: {{ $order->intended_date }}
                                            </li>
                                        </ul>

                                        @empty
                                            <p class="text-center">No orders created for the above service yet.</p>
                                        @endforelse

                                    @empty
                                        <p>No services found.</p>
                                    @endforelse

                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Profitability Analysis</h5>
                                    </div>
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Proposal Value: ${{ number_format($totalRevenue, 2) }}</h5>
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
    $(document).ready(function() {

        document.querySelectorAll('input[name="outlines"]').forEach(function(el){
            new Tagify(el);
        });

    });
</script>

@endpush
