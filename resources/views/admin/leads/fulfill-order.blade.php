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
                            <button class="nav-link" id="to-customer-tab" data-bs-toggle="tab"
                                data-bs-target="#to-customer" type="button" role="tab" aria-controls="to-customer"
                                aria-selected="false">
                                To Customer
                            </button>
                        </nav>

                    <!-- Tab Content Section -->
                    <div class="tab-content" id="fulfillOrderTabContent">

                        <!-- Scheduling Tab -->
                        <div class="tab-pane fade show active" id="scheduling" role="tabpanel" aria-labelledby="scheduling-tab">
                            <div class="sales-dashboard">
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
                            </div>
                        </div>


                        <!-- Confirmations Tab -->
                        <div class="tab-pane fade" id="confirmations" role="tabpanel" aria-labelledby="confirmations-tab">
                            <div class="sales-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Confirmations</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Customer Confirmed</label>
                                                    <p class="form-control-plaintext">
                                                        <span class="badge bg-success">Yes</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Date Confirmed</label>
                                                    <p class="form-control-plaintext">02/25/2026</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Confirmation Method</label>
                                                    <p class="form-control-plaintext">Phone Call</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold">Confirmed By</label>
                                                    <p class="form-control-plaintext">John Smith</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Facilities Tab -->
                        <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                            <div class="sales-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


                                        </div>
                                    </div>
                                </div>

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
                            {{-- <div class="sales-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


                                        </div>
                                    </div>
                                </div>

                            </div> --}}
                            {{-- Contract Details --}}
                            <div class="sales-dashboard mt-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Contract Details</h5>
                                            </div>

                                            @forelse($order->service->outlines as $outline)
                                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <div>
                                                        <p class="mb-1 fw-semibold">{{ $outline->outline_name }}</p>
                                                        <span class="badge bg-danger">CC</span>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm">X</button>
                                                </div>
                                            @empty
                                                <p class="text-muted">No contract details found.</p>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Add Additional Areas --}}
                            <div class="sales-dashboard mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Add Additional Areas</h5>
                                                <small class="text-muted">Note: these will only appear on this invoice</small>
                                            </div>

                                            <form action="#" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_order_id" value="{{ $order->id }}">
                                                <table class="table table-bordered align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <th>Departments</th>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <input type="text" class="form-control" name="department">
                                                                    <button type="submit" class="btn btn-success">Add</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Service Notes --}}
                            <div class="sales-dashboard mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Service Notes</h5>
                                                <small class="text-muted">Enter new notes in the form below:</small>
                                            </div>

                                            <form action="#" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="service_order_id" value="{{ $order->id }}">
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
                            </div>

                            {{-- Inventory Consumption --}}
                            <div class="sales-dashboard mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header mb-3">
                                                <h5 class="section-title">Inventory Consumption</h5>
                                            </div>

                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr><td>Microfiber</td></tr>
                                                    <tr><td>Swabs</td></tr>
                                                    <tr><td>Oxivir Concentrate Jars</td></tr>
                                                    <tr><td>Opticide gallons</td></tr>
                                                    <tr><td>Halomist</td></tr>
                                                </tbody>
                                            </table>

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

                        <!-- Job Clocks Tab -->
                        <div class="tab-pane fade" id="job-clocks" role="tabpanel" aria-labelledby="job-clocks-tab">
                            <div class="sales-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">


                                        </div>
                                    </div>
                                </div>

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

                        <!-- To Customer Tab -->
                        <div class="tab-pane fade" id="to-customer" role="tabpanel" aria-labelledby="to-customer-tab">
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

@endpush
