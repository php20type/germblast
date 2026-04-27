@extends('admin.includes.layout')

@section('title', 'Survey Facility')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" id="add-facility-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="survey_proposal_id" value="{{ $surveyProposal->id }}">


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
                                                    <th>Country</th>
                                                    <td>
                                                        <select name="country_id" class="form-select select2" id="facility_country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <select name="state_id" class="form-select select2" id="facility_state" disabled>
                                                            <option value="">Select State</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>City</th>
                                                    <td>
                                                        <select name="city_id" class="form-select select2" id="facility_city" disabled>
                                                            <option value="">Select City</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
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
                                                </tr> --}}

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
                                                        <input type="file" class="form-control" name="map_file"
                                                            id="map_file">
                                                        {{-- Preview Box --}}
                                                        <div id="map-preview" class="mt-2" style="display: none;">
                                                            <img src="" class="img-fluid rounded"
                                                                style="width: 90px; height: 90px; object-fit: cover; border: 1px solid #ccc;">
                                                        </div>
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
                                                        <input type="file" class="form-control" name="atp_file"
                                                            id="atp_file">
                                                        {{-- Preview Box --}}
                                                        <div id="atp-preview" class="mt-2" style="display: none;">
                                                            <img src="" class="img-fluid rounded"
                                                                style="width: 90px; height: 90px; object-fit: cover; border: 1px solid #ccc;">
                                                        </div>
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

                                                @foreach ($facilityRoomTypes as $types)
                                                    <tr>
                                                        <th>{{ $types->name }}</th>
                                                        <td><input type="number" class="form-control"
                                                                name="{{ $types->input_name }}" value="0">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><span id="man_hours">0</span></td>
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
        $(document).ready(function() {

            let facilityRules = {
                facility_name: {
                    required: true
                },
                address: {
                    required: true
                },
                country_id: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                zip: {
                    required: true
                },
                facility_type: {
                    required: true
                },

                // MAP fields
                map_name: {
                    required: true
                },
                map_file: {
                    required: true
                },

                // ATP fields
                atp_location: {
                    required: true
                },
                atp_value: {
                    required: true,
                    number: true
                },
                atp_file: {
                    required: true
                }
            };

            // ---- Dynamic Survey Detail Fields ----
            @foreach ($facilityRoomTypes as $type)
                facilityRules["{{ $type->input_name }}"] = {
                    required: true,
                    number: true
                };
            @endforeach

            $("#add-facility-form").validate({
                ignore: [],
                rules: facilityRules,

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


            // AJAX SUBMIT
            $('#add-facility-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-facility-form').valid()) {
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.survey.proposal.facility.store', $surveyProposal->id) }}",
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

        });
        document.addEventListener("DOMContentLoaded", function() {

            // Reusable preview function
            function setupPreview(inputId, previewId) {
                let input = document.getElementById(inputId);
                let previewContainer = document.getElementById(previewId);

                if (!input || !previewContainer) return; // Element doesn't exist, stop script

                let previewImage = previewContainer.querySelector('img');

                input.addEventListener('change', function(event) {
                    if (event.target.files && event.target.files[0]) {

                        let reader = new FileReader();

                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';
                        };

                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            }

            // Attach previews
            setupPreview('atp_file', 'atp-preview');
            setupPreview('map_file', 'map-preview');

        });

        // INIT SELECT2
        $('#facility_country, #facility_state, #facility_city').select2({
            placeholder: 'Select option',
            allowClear: true,
            width: '100%'
        });


          // Country → States
            $('#facility_country').on('change', function() {
                let countryId = $(this).val();
                $('#facility_state').empty()
                    .append('<option value="">Select State</option>').prop('disabled', true).trigger(
                        'change');
                $('#facility_city').empty()
                    .append('<option value="">Select City</option>').prop('disabled', true).trigger(
                        'change');

                if (!countryId) return;
                $.get(`/states/${countryId}`, function(states) {
                    $('#facility_state').prop('disabled', false);
                    $.each(states, function(i, state) {
                        $('#facility_state').append(
                            `<option value="${state.state_id}">${state.name}</option>`
                        );
                    });
                });
            });


            // State → Cities
            $('#facility_state').on('change', function() {
                let stateId = $(this).val();
                $('#facility_city').empty().append('<option value="">Select City</option>').prop('disabled',
                    true).trigger('change');
                if (!stateId) return;
                $.get(`/cities/${stateId}`, function(cities) {
                    $('#facility_city').prop('disabled', false);
                    $.each(cities, function(i, city) {
                        $('#facility_city').append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                });
            });

    </script>
@endpush
