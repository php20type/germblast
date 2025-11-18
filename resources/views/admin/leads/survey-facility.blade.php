@extends('admin.includes.layout')

@section('title', 'Survey Facility')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" class="" id="add-facility-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Add Facility</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Facility
                                    </button>
                                </div>
                            </div>

                            {{-- Create Facility --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Facility</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Facility Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="facility_name">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Address</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="address">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>City</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="city">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="state">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Zip</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="zip">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Facility Type</th>
                                                    <td>
                                                        <select name="facility_type" class="form-control">
                                                            <option value="hospital">Hospital</option>
                                                            <option value="clinic">Clinic</option>
                                                            <option value="elementary school">Elementary School</option>
                                                            <option value="middle school">Middle School</option>
                                                            <option value="high school">High School</option>
                                                            <option value="high school athletics">High School Athletics
                                                            </option>
                                                            <option value="middle school athletics">Middle School Athletics
                                                            </option>
                                                            <option value="buses">Buses</option>
                                                            <option value="office">Office</option>
                                                            <option value="office building">Office Building</option>
                                                            <option value="church">Church</option>
                                                            <option value="daycare">Daycare</option>
                                                            <option value="hotel">Hotel</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>


                            {{-- Create Facility --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility Maps</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Map Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="map_name">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="map_file">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            {{-- Facility Maps list --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility Maps List</h3>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Create Facility --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility ATP Sampling</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>


                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Location</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="atp_location">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ATP Value</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="atp_value">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="atp_file">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                            {{-- Facility Atp list --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility ATP List</h3>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Survey Details --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Survey Details</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        Room Type
                                                    </th>
                                                    <th>
                                                        Count
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Square Footage</th>
                                                    <td><input type="number" class="form-control" name="square_footage">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Offices</th>
                                                    <td><input type="number" class="form-control" name="offices"></td>
                                                </tr>

                                                <tr>
                                                    <th>Community Bathrooms</th>
                                                    <td><input type="number" class="form-control"
                                                            name="standard_bathrooms"></td>
                                                </tr>

                                                <tr>
                                                    <th>Single Bathrooms</th>
                                                    <td><input type="number" class="form-control"
                                                            name="single_bathrooms"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><input type="number" class="form-control" name="man_hours"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><span id="man_hours_cost">$0.00</span></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>
@endsection


@push('scripts')

    <script>
    // ---------------------------
    // JQUERY VALIDATION
    // ---------------------------
    $("#add-facility-form").validate({
        ignore: [],
        rules: {
            // Facility Info
            facility_name: { required: true },
            address: { required: true },
            city: { required: true },
            state: { required: true },
            zip: { required: true },
            facility_type: { required: true },

            // Facility Maps
            map_name: { required: true },
            map_file: { required: true },

            // ATP Sampling
            atp_location: { required: true },
            atp_value: { required: true, number: true },
            atp_file: { required: true },

            // Survey Details
            square_footage: { required: true, number: true },
            offices: { required: true, number: true },
            standard_bathrooms: { required: true, number: true },
            single_bathrooms: { required: true, number: true },
            man_hours: { required: true, number: true },
        },

        messages: {
            facility_name: { required: "Facility name is required." },
            address: { required: "Address is required." },
            city: { required: "City is required." },
            state: { required: "State is required." },
            zip: { required: "Zip code is required." },
            facility_type: { required: "Select a facility type." },

            map_name: { required: "Enter map name." },
            map_file: { required: "Please upload a map image." },

            atp_location: { required: "ATP location is required." },
            atp_value: { required: "ATP value is required.", number: "Enter a valid number." },
            atp_file: { required: "Please upload ATP photo." },

            square_footage: { required: "Square footage required.", number: "Must be numeric." },
            offices: { required: "Enter office count.", number: "Must be numeric." },
            standard_bathrooms: { required: "Enter community bathrooms.", number: "Must be numeric." },
            single_bathrooms: { required: "Enter single bathrooms.", number: "Must be numeric." },
            man_hours: { required: "Enter total man hours.", number: "Must be numeric." },
        },

        errorElement: 'span',
        errorClass: 'invalid-feedback d-block',

        highlight: function(element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },

        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });


    // ---------------------------
    // AJAX SUBMIT (with Swal)
    // ---------------------------
    $('#add-facility-form').submit(function(e) {
        e.preventDefault();

        if (!$('#add-facility-form').valid()) {
            return;
        }

        // Required for file uploads!
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.leads.survey.facility.store', $lead->id) }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                Swal.fire({
                    icon: "success",
                    title: "Facility Saved!",
                    text: res.message || "Facility added successfully!",
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => location.reload(), 2000);
            },

            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong while saving the facility.",
                });

                console.log(xhr.responseText);
            }
        });
    });
</script>


@endpush
