@extends('admin.includes.layout')

@section('title', 'Fulfill Order')

@push('styles')

@endpush

@section('content')
    <div class="companies-section my-4">
        <!-- Header Section -->
        <div class="fulfill-order-header">
            <div class="container-fluid px-4 py-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="service-info mb-3">
                            <h2 class="service-name mb-1">Testing Company</h2>
                        </div>
                        <!-- Tabs Navigation -->
                        <nav class="nav nav-fill w-100 nav-tabs border-bottom" id="fulfillOrderTabs" role="tablist">
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content Section -->
        <div class="tab-content" id="fulfillOrderTabContent">
            <!-- Scheduling Tab -->
            <div class="tab-pane fade show active" id="scheduling" role="tabpanel" aria-labelledby="scheduling-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Scheduling Information</h5>
                                </div>

                                <!-- Scheduled Orders List -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Scheduled Orders</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51072</strong>
                                            <span class="text-muted">Intended Date: 02/26</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51073</strong>
                                            <span class="text-muted">Intended Date: 02/26</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51074</strong>
                                            <span class="text-muted">Intended Date: 02/26</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51075</strong>
                                            <span class="text-muted">Intended Date: 02/26</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51070</strong>
                                            <span class="text-muted">Intended Date: 12/69</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <strong>Order: 51071</strong>
                                            <span class="text-muted">Intended Date: 12/69</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Scheduling Details -->
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="schedule-item">
                                            <label class="form-label fw-bold">Start Time</label>
                                            <p class="form-control-plaintext">09:00 AM</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="schedule-item">
                                            <label class="form-label fw-bold">End Time</label>
                                            <p class="form-control-plaintext">12:00 PM</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="schedule-item">
                                            <label class="form-label fw-bold">Arrival Time</label>
                                            <p class="form-control-plaintext">08:45 AM</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="schedule-item">
                                            <label class="form-label fw-bold">Office</label>
                                            <p class="form-control-plaintext">Lubbock, TX</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmations Tab -->
            <div class="tab-pane fade" id="confirmations" role="tabpanel" aria-labelledby="confirmations-tab">
                <div class="container-fluid px-4 py-4">
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
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Facilities</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Location</label>
                                        <p class="form-control-plaintext">Customer Site - 123 Main St, Lubbock, TX 79404</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Access Instructions</label>
                                        <p class="form-control-plaintext">Key under mat by front door</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Hazards</label>
                                        <p class="form-control-plaintext">No hazards identified</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Equipment Required</label>
                                        <p class="form-control-plaintext">Pest control equipment required</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staffing Tab -->
            <div class="tab-pane fade" id="staffing" role="tabpanel" aria-labelledby="staffing-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Staffing</h5>
                                </div>

                                <!-- Assigned Technicians -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Assigned Technicians</h6>
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>Lead Technician</td>
                                            </tr>
                                            <tr>
                                                <td>Sarah Davis</td>
                                                <td>Assistant Technician</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Supervisor</label>
                                        <p class="form-control-plaintext">Robert Brown</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Required Certifications</label>
                                        <p class="form-control-plaintext">Pesticide Applicator License</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Tab -->
            <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Notes</h5>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Internal Notes</label>
                                    <div class="alert alert-light border">Customer requested afternoon service. Building has 3 floors.</div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Customer Notes</label>
                                    <div class="alert alert-light border">Please fix the problem in the basement area</div>
                                </div>

                                <div>
                                    <label class="form-label fw-bold">Created At</label>
                                    <p class="form-control-plaintext">02/20/2026 by Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoicing Tab -->
            <div class="tab-pane fade" id="invoicing" role="tabpanel" aria-labelledby="invoicing-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Invoicing</h5>
                                </div>

                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <td>INV-2026-0001</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Date</th>
                                            <td>02/20/2026</td>
                                        </tr>
                                        <tr>
                                            <th>Due Date</th>
                                            <td>03/20/2026</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                        </tr>
                                        <tr class="border-top">
                                            <th>Service Charge</th>
                                            <td class="fw-bold">$963.00</td>
                                        </tr>
                                        <tr>
                                            <th>Tax Amount</th>
                                            <td class="fw-bold">$76.35</td>
                                        </tr>
                                        <tr class="table-light fw-bold">
                                            <th>Total Amount</th>
                                            <td class="fw-bold text-success">$1,039.35</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Clocks Tab -->
            <div class="tab-pane fade" id="job-clocks" role="tabpanel" aria-labelledby="job-clocks-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Job Clocks</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Clock In</label>
                                        <p class="form-control-plaintext">09:05 AM</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Clock Out</label>
                                        <p class="form-control-plaintext">11:55 AM</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Total Hours</label>
                                        <p class="form-control-plaintext">2.83 hours</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge bg-secondary">Not Started</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Tab -->
            <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">Reports</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Service Report</label>
                                        <p class="form-control-plaintext">Not generated</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Photos Attached</label>
                                        <p class="form-control-plaintext">0</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Issues Found</label>
                                        <p class="form-control-plaintext">None</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Recommendations</label>
                                        <p class="form-control-plaintext">Regular quarterly maintenance</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- To Customer Tab -->
            <div class="tab-pane fade" id="to-customer" role="tabpanel" aria-labelledby="to-customer-tab">
                <div class="container-fluid px-4 py-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header mb-3">
                                    <h5 class="section-title">To Customer</h5>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Last Contact</label>
                                        <p class="form-control-plaintext">02/25/2026</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Next Follow Up</label>
                                        <p class="form-control-plaintext">03/20/2026</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Preferred Contact Method</label>
                                        <p class="form-control-plaintext">Email</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <p class="form-control-plaintext">customer@example.com</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <p class="form-control-plaintext">(806) 555-1234</p>
                                    </div>
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

@endpush
