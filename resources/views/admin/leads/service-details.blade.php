@extends('admin.includes.layout')

@section('title', 'Service Details')

@push('styles')
<style>
    .summary-item {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 4px;
        border-left: 4px solid #007bff;
    }

    .summary-label {
        display: block;
        font-weight: 600;
        color: #495057;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
        margin: 0;
    }

    .summary-value.text-danger {
        color: #dc3545 !important;
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

                    <form action="#" method="POST" class="" id="add-survey-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Service Details</h1>
                                    <p class="text-muted">Congrats! You won a lead! Now fill this info out</p>
                                </div>

                                {{-- <div>
                                   <button type="submit" class="btn btn-success">
                                            Save
                                    </button>
                                </div> --}}
                            </div>

                            {{-- District Numbers --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        {{-- <div class="section-header">
                                            <h3 class="section-title">District Numbers</h3>
                                        </div> --}}

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="service_name"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Service Price (per service)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="service_price"
                                                            value="">
                                                    </td>
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
                                                    <td>
                                                        <input type="text" class="form-control" name="po_number"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Outline</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="outline" value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" class="text-end">
                                                        <button type="submit" class="btn btn-success">
                                                                Add Service Outline
                                                        </button>
                                                        <a href="{{ route('admin.lead.fulfill_order') }}" class="btn btn-primary ms-2">
                                                            <i class="fas fa-check-circle"></i> Fulfill Order
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <!-- Service Listing Section Start -->
                    <div class="sales-dashboard mt-4">
                        <!-- Orders List -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Scheduled Orders</h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Order: 51072</strong> - Intended Date: 02/26
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Order: 51073</strong> - Intended Date: 02/26
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Order: 51074</strong> - Intended Date: 02/26
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Order: 51075</strong> - Intended Date: 02/26
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Order: 51070</strong> - Intended Date: 12/69
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Order: 51071</strong> - Intended Date: 12/69
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Add Service Listing Form -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Add Service Listing</h5>
                                    </div>

                                    <form action="#" method="POST" id="add-service-listing-form">
                                        @csrf

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="start_time" class="form-label">Start Time</label>
                                                <input type="time" class="form-control" id="start_time"
                                                    name="start_time" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="end_time" class="form-label">End Time</label>
                                                <input type="time" class="form-control" id="end_time"
                                                    name="end_time" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="arrival_time" class="form-label">Arrival Time</label>
                                                <input type="time" class="form-control" id="arrival_time"
                                                    name="arrival_time">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="office" class="form-label">Office</label>
                                                <select class="form-select" id="office" name="office">
                                                    <option value="">Select Office</option>
                                                    <option value="lubbock_tx">Lubbock, TX</option>
                                                    <option value="dallas_tx">Dallas, TX</option>
                                                    <option value="houston_tx">Houston, TX</option>
                                                    <option value="austin_tx">Austin, TX</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="recurrence_count" class="form-label">Recurrence Count</label>
                                                <input type="number" class="form-control" id="recurrence_count"
                                                    name="recurrence_count" min="1" placeholder="Enter number of recurrences">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="recurrence_rules" class="form-label">Recurrence Rules</label>
                                                <select class="form-select" id="recurrence_rules" name="recurrence_rules">
                                                    <option value="N/A" selected>N/A</option>
                                                    <option value="daily">Daily</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="quarterly">Quarterly</option>
                                                    <option value="annually">Annually</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-end">
                                                <button type="reset" class="btn btn-outline-secondary me-2">
                                                    Clear
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    Add Service Listing
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Service Listing Section End -->

                    <!-- Profitability Analysis Section Start -->
                    <div class="sales-dashboard mt-4">
                        <div class="dashboard-header section-card">
                            <div class="container-fluid px-0">
                                <h2 class="display-6 mb-2 fw-bold">Profitability Analysis</h2>
                                <p class="text-muted mb-0"><strong>Proposal Value: $1,926.00</strong></p>
                            </div>
                        </div>

                        <!-- Regular Services Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Regular Services</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Completion Date</th>
                                                    <th>Amount Billed</th>
                                                    <th>Labor Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>51072</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51073</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51074</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51075</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51070</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51071</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>51151</strong></td>
                                                    <td>Future Service</td>
                                                    <td>$0.00</td>
                                                    <td>$0.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Response Services Table -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header mb-3">
                                        <h5 class="section-title">Response Services</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Completion Date</th>
                                                    <th>Amount Billed</th>
                                                    <th>Labor Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">No response services recorded</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="summary-item">
                                                <label class="summary-label">Total Billed</label>
                                                <p class="summary-value">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="summary-item">
                                                <label class="summary-label">Total Labor Cost</label>
                                                <p class="summary-value">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="summary-item">
                                                <label class="summary-label">Commission Expense</label>
                                                <p class="summary-value">$192.60</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="summary-item">
                                                <label class="summary-label">Delta</label>
                                                <p class="summary-value text-danger">-$192.60</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Profitability Analysis Section End -->
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>

@endsection

@push('scripts')

@endpush
