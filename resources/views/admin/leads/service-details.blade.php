@extends('admin.includes.layout')

@section('title', 'Service Details')

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
                                                        {{-- <a href="{{ route('admin.lead.fulfill_order') }}"
                                                            class="btn btn-primary ms-2">
                                                            <i class="fas fa-check-circle"></i> Fulfill Order
                                                        </a> --}}
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
                    <div class="sales-dashboard mt-4">
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


                                    @forelse($service->orders as $order)

                                        <ul class="list-group list-group-flush mb-3">
                                            <li class="list-group-item">
                                                <i class="fa fa-circle me-2" style="font-size: 10px"></i><strong>Order: {{ $order->order_no }}</strong> - Intended Date: {{ $order->intended_date }}
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
                    </div>
                    <!-- Services & Scheduling Section End -->


                    <div class="sales-dashboard mt-4">
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
