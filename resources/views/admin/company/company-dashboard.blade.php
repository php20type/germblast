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
                                <h1 class="display-6 mb-2 fw-bold">Company Dashboard</h1>
                                <p class="text-muted">Overview of IAQ, Biological Response, Services and Surveys</p>
                            </div>
                        </div>

                        {{-- IAQ DEVICES & ZONES --}}
                        <div class="row">

                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">IAQ Zones</h3>
                                        <a href="#" class="btn btn-sm btn-primary" onclick="addZone()">Add Zone</a>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Zone Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-muted text-center">
                                                    No zones created yet.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header d-flex justify-content-between">
                                        <h3 class="section-title">IAQ Devices</h3>
                                        <a href="#" class="btn btn-sm btn-primary" onclick="addDevice()">Add Meter</a>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Zone</th>
                                                <th>Location</th>
                                                <th>Node ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class="text-muted text-center">
                                                    No IAQ devices added yet.
                                                </td>
                                            </tr>
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
                                        <button class="btn btn-sm btn-success">Add Intake</button>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Project Leader</th>
                                                <th>Service ID</th>
                                                <th>Type of Loss</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-muted text-center">
                                                    No biological response records found.
                                                </td>
                                            </tr>
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
                                        <button class="btn btn-sm btn-success">Add Intake</button>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Status</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-muted text-center">
                                                    No readiness records available.
                                                </td>
                                            </tr>
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
                                        <button class="btn btn-sm btn-success">Create IAQ Survey</button>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Number</th>
                                                <th>Created By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-muted text-center">
                                                    No IAQ surveys created.
                                                </td>
                                            </tr>
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
                                        <button class="btn btn-sm btn-success">Create H2O Survey</button>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Number</th>
                                                <th>Created By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-muted text-center">
                                                    No water surveys created.
                                                </td>
                                            </tr>
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

                                    <p class="small text-muted">
                                        Legend: <span class="text-primary">Open</span>,
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
                                            <tr>
                                                <td colspan="2" class="text-muted text-center">
                                                    No services scheduled.
                                                </td>
                                            </tr>
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
                    <form action="{{ route('admin.companies.iaq-zones.store', $company->id) }}" method="POST"
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
                                Save Location
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
                    <form action="{{ route('admin.companies.iaq-devices.store', $company->id) }}" method="POST"
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


@endsection
@push('scripts')
    <script>
        function addZone() {
            $('#AddIAQZone').modal('show');
        }

        function addDevice() {
            $('#AddIAQDevice').modal('show');
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


        });
    </script>
@endpush
