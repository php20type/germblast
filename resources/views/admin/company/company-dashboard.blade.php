@extends('admin.includes.layout')

@section('title', 'Company Dashboard')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <div class="sales-dashboard">

                        {{-- HEADER --}}
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 mb-2 fw-bold">{{ $company->name }} - Company Dashboard</h1>
                                <p class="text-muted">Overview of IAQ, Biological Response, Services and Surveys</p>
                            </div>
                        </div>

                        {{-- IAQ DEVICES & ZONES --}}
                        <div class="row">

                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">IAQ Zones</h3>
                                        @can('company.dashboard.edit')
                                            <a href="#" class="btn btn-sm btn-primary" onclick="addZone()">Add Zone</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Zone Name</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($iaqZones as $zone)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                            <a href="javascript:void(0)"
                                                                onclick="editZone({{ $zone->id }})">
                                                                {{ $zone->name }}
                                                            </a>
                                                        @else
                                                            {{ $zone->name }}
                                                        @endcan
                                                    </td>
                                                    <td>{{ $zone->companyLocation->location_name ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-muted text-center">
                                                        No zones created yet.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">IAQ Devices</h3>
                                        @can('company.dashboard.edit')
                                            <a href="#" class="btn btn-sm btn-primary" onclick="addDevice()">Add Meter</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Zone</th>
                                                <th>Location</th>
                                                <th>Node ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($iaqDevices as $device)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                            <a href="javascript:void(0)"
                                                                onclick="editDevice({{ $device->id }})">
                                                                {{ $device->name }}
                                                            </a>
                                                        @else
                                                            {{ $device->name }}
                                                        @endcan
                                                    </td>
                                                    <td>{{ $device->iaqZone->name ?? '-' }}</td>
                                                    <td>{{ $device->iaqZone->companyLocation->location_name ?? '-' }}</td>
                                                    <td>{{ $device->node_id ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">
                                                        No IAQ devices added yet.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- BIOLOGICAL RESPONSE INTAKE --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">Biological Response Intake</h3>
                                        @can('company.dashboard.edit')
                                            <a href="{{ route('admin.company.biological.response', $company->id) }}"
                                                class="btn btn-sm btn-success">Add Intake</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Project Leader</th>
                                                <th>Project Zip</th>
                                                <th>Type of Loss</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($biologicalResponseIntakes as $intake)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                            <a href="{{ route('admin.company.biological.response.edit', [$company->id, $intake->id]) }}">
                                                                {{ $intake->project_name }}
                                                            </a>
                                                        @else
                                                            {{ $intake->project_name }}
                                                        @endcan
                                                    </td>
                                                    <td>{{ $intake->project_leader }}</td>
                                                    <td>{{ $intake->project_zip }}</td>
                                                    <td>{{ $intake->type_of_loss }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">
                                                        No biological response records found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- BIOLOGICAL READINESS INTAKE --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">Biological Readiness Intake</h3>
                                        {{-- <button class="btn btn-sm btn-success">Add Intake</button> --}}
                                        @can('company.dashboard.edit')
                                            <a href="{{ route('admin.company.biological.readiness', $company->id) }}"
                                                class="btn btn-sm btn-success">Add Intake</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Status</th>
                                                <th>Length</th>
                                                <th>Total</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($biologicalReadiness as $readiness)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                            <a href="{{ route('admin.company.biological.readiness.edit', [$company->id, $readiness->id]) }}">{{ $readiness->project_name }}</a>
                                                        @else
                                                            {{ $readiness->project_name }}
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        {{ $readiness->status }}
                                                    </td>

                                                    <td>{{ $readiness->length }}</td>

                                                    <td>{{ $readiness->line_total }}</td>

                                                    <td>{{ $readiness->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-muted text-center">
                                                        No readiness records available.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- IAQ SURVEY --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">Indoor Air Quality</h3>
                                        @can('company.dashboard.edit')
                                            <a href="{{ route('admin.company.iaq.survey', $company->id) }}"
                                            class="btn btn-sm btn-success">Create IAQ Survey</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Survey Name</th>
                                                <th>Date</th>
                                                <th>Building Description</th>
                                                <th>Reported Issues</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($iaqSurveys as $survey)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                        <a
                                                            href="{{ route('admin.company.iaq.survey.edit', [$company->id, $survey->id]) }}">{{ $survey->survey_name ?? '-' }}</a>
                                                        @else
                                                            {{ $survey->survey_name ?? '-' }}
                                                        @endcan
                                                    </td>

                                                    <td>
                                                        {{ $survey->created_at->format('d M Y') }}
                                                    </td>

                                                    <td>
                                                        {{ \Illuminate\Support\Str::words($survey->building_description, 10, '...') }}
                                                    </td>

                                                    <td>
                                                        {{ \Illuminate\Support\Str::words($survey->reported_issues, 10, '...') }}
                                                    </td>

                                                    <td>
                                                        {{ $survey->location ?? '-' }}
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-muted text-center">
                                                        No IAQ surveys created.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- WATER MANAGEMENT --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">Water Management</h3>
                                        @can('company.dashboard.edit')
                                        <a href="{{ route('admin.company.water.management', $company->id) }}"
                                            class="btn btn-sm btn-success">Create H2O Survey</a>
                                        @endcan
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Survey Name</th>
                                                <th>Date</th>
                                                <th>Municipal Water Supplier</th>
                                                <th>No. of Teams</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($waterManagement as $water)
                                                <tr>
                                                    <td>
                                                        @can('company.dashboard.edit')
                                                        <a
                                                            href="{{ route('admin.company.water.management.edit', [$company->id, $water->id]) }}">
                                                        {{ $water->survey_name ?? '-' }}
                                                        </a>
                                                        @else
                                                            {{ $water->survey_name ?? '-' }}
                                                        @endcan
                                                    </td>

                                                    <td>{{ $water->created_at->format('d M Y') }}</td>

                                                    <td>{{ $water->municipal_water_supplier ?? '-' }}</td>

                                                    <td>
                                                        {{ $water->waterManagementTeams->count() }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">
                                                        No water surveys created.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- SERVICES --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">Services</h3>
                                        <div>
                                            <button class="btn btn-sm btn-primary">Schedule Response</button>
                                            <button class="btn btn-sm btn-secondary">Schedule RGB</button>
                                        </div>
                                    </div>

                                    {{-- <p class="small text-muted">
                                        Legend: <span class="text-primary">Pending</span>,
                                        <span class="text-success">Completed</span>,
                                        <span class="text-danger">Cancelled</span>
                                    </p> --}}
                                    <p class="small text-muted">
                                        Legend:
                                        <span class="text-primary">Pending</span>,
                                        <span class="text-warning">Scheduled</span>,
                                        <span class="text-info">In Progress</span>,
                                        <span class="text-success">Completed</span>,
                                        <span class="text-danger">Cancelled</span>
                                    </p>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Dates</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ( $serviceOrders as $order)
                                                @php
                                                    $rowClass = match($order->status) {
                                                        'pending'     => 'table-primary',
                                                        'scheduled'   => 'table-warning',
                                                        'in_progress' => 'table-info',
                                                        'completed'   => 'table-success',
                                                        'cancelled'   => 'table-danger',
                                                        default       => ''
                                                    };
                                                @endphp
                                                <tr class="{{ $rowClass }} small">
                                                    <td>
                                                        <a href="{{ route('admin.lead.service.fulfill_order', $order->id) }}">
                                                            Order ID: {{ $order->order_no }}
                                                        </a>
                                                        -
                                                        <strong>{{ $order->service->service_name }}</strong> <br>

                                                        Number Of Service: {{ $order->service->number_of_services }} <br>
                                                        Price Per Service: ${{ number_format($order->service->price_per_service,2) }} <br>
                                                        Total Price: ${{ number_format($order->service->total_price,2) }} <br>
                                                        Estimated Man Hours: 12
                                                    </td>
                                                    <td>
                                                        Intended Date: <br>
                                                        <span class="text-muted small ms-4">{{ $order->intended_date }}</span>
                                                         <br>
                                                        @if($order->orderSlots->count())
                                                            Scheduled Slots: <br>
                                                            @foreach($order->orderSlots as $slot)
                                                                <span class="text-muted small ms-4">
                                                                    {{ $slot->scheduled_start_time }} — {{ $slot->scheduled_end_time }}
                                                                </span><br>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted small">No slots scheduled yet.</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-muted text-center">
                                                        No services scheduled.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- IAQ Zone Modal --}}
    <div class="modal fade" id="AddIAQZone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add IAQ Zone</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.company.iaq-zones.store', $company->id) }}" method="POST"
                        class="company-form" id="add-iaq-zone">
                        @csrf

                        <div class="row mx-0">

                            {{-- Location Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            {{-- Country --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <span class="text-danger">*</span>
                                    <select name="company_location_id" class="form-select select2"
                                        id="company_location_select">
                                        <option value="">Select One</option>
                                        @foreach ($companyLocations as $companyLocation)
                                            <option value="{{ $companyLocation->id }}">
                                                {{ $companyLocation->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Zone
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- IAQ Devices Modal --}}
    <div class="modal fade" id="AddIAQDevice" tabindex="-1" aria-labelledby="AddIAQDeviceLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="AddIAQDeviceLabel">Add IAQ Device</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form action="{{ route('admin.company.iaq-devices.store', $company->id) }}" method="POST"
                        class="company-form" id="add-iaq-device">
                        @csrf

                        <div class="row mx-0">

                            {{-- Device Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Eg. IAQ Meter 01">
                                </div>
                            </div>

                            {{-- IAQ Zone --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">IAQ Zone</label>
                                    <span class="text-danger">*</span>
                                    <select name="iaq_zone_id" class="form-select select2" id="iaq_zone_select">
                                        <option value="">Select One</option>
                                        @foreach ($iaqZones as $zone)
                                            <option value="{{ $zone->id }}">
                                                {{ $zone->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Node ID --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Node ID</label>
                                    <input type="text" name="node_id" class="form-control" placeholder="Node ID">
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Device
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Edit IAQ Zone Modal --}}
    <div class="modal fade" id="EditIAQZone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Edit IAQ Zone</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form method="POST" id="edit-iaq-zone-form">
                        @csrf

                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="edit_zone_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <span class="text-danger">*</span>
                                    <select name="company_location_id" id="edit_company_location"
                                        class="form-select select2">
                                        @foreach ($companyLocations as $location)
                                            <option value="{{ $location->id }}">
                                                {{ $location->location_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Location
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Edit Edit IAQ Device Modal --}}
    <div class="modal fade" id="EditIAQDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Edit IAQ Device</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">
                    <form method="POST" id="edit-iaq-device-form">
                        @csrf
                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="edit_device_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">IAQ Zone</label>
                                    <span class="text-danger">*</span>
                                    <select name="iaq_zone_id" id="edit_iaq_zone" class="form-select select2">
                                        @foreach ($iaqZones as $zone)
                                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Node ID</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="node_id" id="edit_node_id" class="form-control">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Location
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        function addZone() {
            $('#AddIAQZone').modal('show');
        }

        function addDevice() {
            $('#AddIAQDevice').modal('show');
        }

        function editZone(zoneId) {
            $.get(
                "{{ route('admin.company.iaq-zones.edit', [$company->id, 'ZONE_ID']) }}"
                .replace('ZONE_ID', zoneId),
                function(res) {

                    $('#edit_zone_name').val(res.data.name);
                    $('#edit_company_location')
                        .val(res.data.company_location_id)
                        .trigger('change');

                    $('#edit-iaq-zone-form')
                        .attr('action',
                            "{{ route('admin.company.iaq-zones.update', [$company->id, 'ZONE_ID']) }}"
                            .replace('ZONE_ID', zoneId)
                        );

                    $('#EditIAQZone').modal('show');
                }
            );
        }

        function editDevice(deviceId) {
            $.get(
                "{{ route('admin.company.iaq-devices.edit', [$company->id, 'DEVICE_ID']) }}"
                .replace('DEVICE_ID', deviceId),
                function(res) {

                    $('#edit_device_name').val(res.data.name);
                    $('#edit_node_id').val(res.data.node_id);
                    $('#edit_iaq_zone')
                        .val(res.data.iaq_zone_id)
                        .trigger('change');

                    $('#edit-iaq-device-form')
                        .attr('action',
                            "{{ route('admin.company.iaq-devices.update', [$company->id, 'DEVICE_ID']) }}"
                            .replace('DEVICE_ID', deviceId)
                        );

                    $('#EditIAQDevice').modal('show');
                }
            );
        }

        $(document).ready(function() {

            $('#company_location_select').select2({
                dropdownParent: $('#AddIAQZone'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#iaq_zone_select').select2({
                dropdownParent: $('#AddIAQDevice'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#edit_company_location').select2({
                dropdownParent: $('#EditIAQZone'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#edit_iaq_zone').select2({
                dropdownParent: $('#EditIAQDevice'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });


            $("#add-iaq-zone").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    company_location_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter zone name."
                    },
                    company_location_id: {
                        required: "Please select a location."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#add-iaq-zone').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong'
                        });
                    }
                });
            });


            $("#add-iaq-device").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    iaq_zone_id: {
                        required: true
                    },
                    node_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter device name."
                    },
                    iaq_zone_id: {
                        required: "Please select IAQ zone."
                    },
                    node_id: {
                        required: "Please enter node ID."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#add-iaq-device').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to add device'
                        });
                    }
                });
            });


            $("#edit-iaq-zone-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    company_location_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter zone name."
                    },
                    company_location_id: {
                        required: "Please select a location."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#edit-iaq-zone-form').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update zone'
                        });
                    }
                });
            });


            $("#edit-iaq-device-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    iaq_zone_id: {
                        required: true
                    },
                    node_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter device name."
                    },
                    iaq_zone_id: {
                        required: "Please select IAQ zone."
                    },
                    node_id: {
                        required: "Please enter node ID."
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');

                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).next('.select2-container')
                            .find('.select2-selection')
                            .removeClass('is-invalid');
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            $('#edit-iaq-device-form').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to update device'
                        });
                    }
                });
            });



        });
    </script>
@endpush
