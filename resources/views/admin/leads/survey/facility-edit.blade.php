@extends('admin.includes.layout')

@section('title', 'Survey Facility')

@push('styles')
    <style>
        /* Equipment Report Table Boxed Styling */
        .equipment-report-table {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            border-bottom: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table tbody th {
            background-color: #fff !important;
            border-bottom: 1px solid #f3f4f6 !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 15px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left !important;
        }

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td,
        .equipment-report-table tbody tr:last-child th {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child,
        .equipment-report-table tbody tr:last-child th:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child,
        .equipment-report-table tbody tr:last-child th:last-child {
            border-bottom-right-radius: 12px !important;
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
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.survey.proposal.facility.update', $facility->id) }}" method="POST"
                        id="update-facility-form" enctype="multipart/form-data">

                        @csrf
                        <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                        <div class="main-content">
                            {{-- HEADER --}}
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">
                                        Edit Facility <span style="font-size: 24px;">🏢</span>
                                    </h3>
                                    <p class="text-muted mb-0">
                                        Record survey results on this page
                                    </p>
                                </div>
                                <div class="right-part d-flex align-items-center gap-2">
                                    <a class="btn btn-outline-secondary" href="{{ route('admin.lead.survey.proposal', $facility->surveyProposal->lead_id) }}">
                                        <i class="fas fa-arrow-left me-1"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        Save Facility
                                    </button>
                                </div>
                            </div>

                            <div class="my-4"></div>

                            <div class="dashboard-body px-4 pb-4">

                                {{-- Create Facility --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header">
                                                <h3 class="section-title">Create Facility</h3>
                                                <div class="text-end">
                                                </div>
                                            </div>

                                            <table class="equipment-report-table align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Facility Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="facility_name"
                                                            value="{{ $facility->facility_name ?? ' ' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Address</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="address"
                                                            value="{{ $facility->address ?? ' ' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Country</th>
                                                    <td>
                                                        <select name="country_id" id="facility_country" class="form-control">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ $facility->country_id == $country->id ? 'selected' : '' }}>
                                                                    {{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <select name="state_id" id="facility_state" class="form-control" {{ $facility->state_id ? '' : 'disabled' }}>
                                                            <option value="">Select State</option>
                                                            @foreach ($states as $state)
                                                                <option value="{{ $state->id }}"
                                                                    {{ $facility->state_id == $state->id ? 'selected' : '' }}>
                                                                    {{ $state->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>City</th>
                                                    <td>
                                                        <select name="city_id" id="facility_city" class="form-control" {{ $facility->city_id ? '' : 'disabled' }}>
                                                            <option value="">Select City</option>
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}"
                                                                    {{ $facility->city_id == $city->id ? 'selected' : '' }}>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Zip</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="zip"
                                                            value="{{ $facility->zip ?? ' ' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Facility Type</th>
                                                    <td>
                                                        <select name="facility_type" class="form-control">
                                                            <option value="hospital" {{ $facility->facility_type == 'hospital' ? 'selected' : '' }}>Hospital</option>
                                                            <option value="clinic" {{ $facility->facility_type == 'clinic' ? 'selected' : '' }}>Clinic</option>
                                                            <option value="elementary school" {{ $facility->facility_type == 'elementary school' ? 'selected' : '' }}>Elementary School</option>
                                                            <option value="middle school" {{ $facility->facility_type == 'middle school' ? 'selected' : '' }}>Middle School</option>
                                                            <option value="high school" {{ $facility->facility_type == 'high school' ? 'selected' : '' }}>High School</option>
                                                            <option value="high school athletics" {{ $facility->facility_type == 'high school athletics' ? 'selected' : '' }}>High School Athletics</option>
                                                            <option value="middle school athletics" {{ $facility->facility_type == 'middle school athletics' ? 'selected' : '' }}>Middle School Athletics</option>
                                                            <option value="buses" {{ $facility->facility_type == 'buses' ? 'selected' : '' }}>Buses</option>
                                                            <option value="office" {{ $facility->facility_type == 'office' ? 'selected' : '' }}>Office</option>
                                                            <option value="office building" {{ $facility->facility_type == 'office building' ? 'selected' : '' }}>Office Building</option>
                                                            <option value="church" {{ $facility->facility_type == 'church' ? 'selected' : '' }}>Church</option>
                                                            <option value="daycare" {{ $facility->facility_type == 'daycare' ? 'selected' : '' }}>Daycare</option>
                                                            <option value="hotel" {{ $facility->facility_type == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                                            <option value="other" {{ $facility->facility_type == 'other' ? 'selected' : '' }}>Other</option>
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

                                        <table class="equipment-report-table align-middle">
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
                                                        <input type="file" class="form-control" name="map_file[]"
                                                            id="map_file" multiple>
                                                        <div id="map-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
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

                                        <div class="row">
                                            @forelse ($facilityMaps as $map)
                                                <div class="col-md-3 mb-3">
                                                    <div class="p-3 border rounded">

                                                        <div class="preview row align-items-center">

                                                            {{-- LEFT: Image --}}
                                                            <div class="img-upload col-4 text-center">
                                                                @if (in_array(strtolower(pathinfo($map->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                    <img src="{{ asset('storage/' . $map->file_path) }}"
                                                                        alt="{{ $map->file_name }}"
                                                                        class="img-fluid rounded"
                                                                        style="width: 70px; height: 70px; object-fit: cover;">
                                                                @else
                                                                    <i class="fa-regular fa-file fs-1 text-secondary"></i>
                                                                @endif
                                                            </div>

                                                            {{-- MIDDLE: File Name + Size --}}
                                                            <div class="text-upload col-6">
                                                                <a href="{{ asset('storage/' . $map->file_path) }}"
                                                                    download>
                                                                    <p class="mb-1 fw-semibold text-break">{{ $map->file_name }}</p>
                                                                    <p class="text-muted mb-0 small">
                                                                        {{ number_format(Storage::disk('public')->size($map->file_path) / 1024, 2) }}
                                                                        KB
                                                                    </p>
                                                                </a>
                                                            </div>

                                                            {{-- RIGHT: Delete --}}
                                                            <div class="col-2 text-end">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger delete-map-btn"
                                                                    data-id="{{ $map->id }}" title="Delete file">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-md-12">
                                                    <p class="text-muted">No facility maps uploaded yet.</p>
                                                </div>
                                            @endforelse
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


                                        <table class="equipment-report-table align-middle">
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
                                                        <input type="file" class="form-control" name="atp_file[]"
                                                            id="atp_file" multiple>
                                                        <div id="atp-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
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

                                        <div class="row">
                                            @forelse ($facilityAtps as $atp)
                                                <div class="col-md-3 mb-3">
                                                    <div class="p-3 border rounded">

                                                        <div class="preview row align-items-center">

                                                            {{-- LEFT: Image Preview --}}
                                                            <div class="img-upload col-4 text-center">
                                                                @if (in_array(strtolower(pathinfo($atp->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                    <img src="{{ asset('storage/' . $atp->file_path) }}"
                                                                        alt="{{ $atp->file_name }}"
                                                                        class="img-fluid rounded"
                                                                        style="width: 70px; height: 70px; object-fit: cover;">
                                                                @else
                                                                    <i class="fa-regular fa-file fs-1 text-secondary"></i>
                                                                @endif
                                                            </div>

                                                            {{-- MIDDLE: File Info + ATP Details --}}
                                                            <div class="text-upload col-6">
                                                                <a href="{{ asset('storage/' . $atp->file_path) }}"
                                                                    download>
                                                                    <p class="mb-1 fw-semibold text-break">{{ $atp->file_name }}</p>
                                                                    <p class="text-muted mb-0 small">
                                                                        {{ number_format(Storage::disk('public')->size($atp->file_path) / 1024, 2) }}
                                                                        KB
                                                                    </p>
                                                                </a>

                                                                {{-- ATP extra info --}}
                                                                <p class="mb-1 small"><strong>Location:</strong>
                                                                    {{ $atp->location }}</p>
                                                                <p class="mb-0 small"><strong>Value:</strong>
                                                                    {{ $atp->atp_value }}</p>
                                                            </div>

                                                            {{-- RIGHT: Delete Button --}}
                                                            <div class="col-2 text-end">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger delete-atp-btn"
                                                                    data-id="{{ $atp->id }}" title="Delete file">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-md-12">
                                                    <p class="text-muted">No ATP samples uploaded yet.</p>
                                                </div>
                                            @endforelse
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

                                        <table class="equipment-report-table align-middle">
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
                                                    <tr class="room-type-row" data-input-name="{{ $types->input_name }}" data-categories="{{ json_encode($types->facility_types) }}">
                                                        <th>{{ $types->name }}</th>
                                                        <td><input type="number" class="form-control"
                                                                name="{{ $types->input_name }}" value="{{ $facility->room_counts[$types->input_name] ?? 0 }}"
>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><span id="man_hours">{{ $facility->man_hours ?? 0 }}</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><span id="man_hours_cost">${{ number_format($facility->man_hours_cost ?? 0, 2) }}</span></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
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
                }
            };

            // ---- Dynamic Survey Detail Fields ----
            @foreach ($facilityRoomTypes as $type)
                facilityRules["{{ $type->input_name }}"] = {
                    required: true,
                    number: true
                };
            @endforeach

            $("#update-facility-form").validate({
                ignore: ":hidden",
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

            // Dynamic Category Filtering
            function updateRoomTypesVisibility() {
                let selectedType = $('select[name="facility_type"]').val() || 'other';
                
                $('.room-type-row').each(function() {
                    let categories = $(this).data('categories');
                    if (!categories || categories.length === 0 || categories.includes(selectedType)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            
            $('select[name="facility_type"]').on('change', function() {
                $('.room-type-row input').val(0);
                updateRoomTypesVisibility();
            });
            updateRoomTypesVisibility(); // Initialize on load


            // AJAX SUBMIT
            $('#update-facility-form').submit(function(e) {
            e.preventDefault();

            if (!$('#update-facility-form').valid()) {
                return;
            }

            let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.survey.proposal.facility.update', $facility->id) }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Facility Saved!",
                            text: res.message || "Facility updated successfully!",
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => window.location.href = "{{ route('admin.lead.survey.proposal', $facility->surveyProposal->lead_id) }}", 2000);
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

            // Delete Map
            $(document).on('click', '.delete-map-btn', function() {
                let mapId = $(this).data('id');
                let btn = $(this);

                $('#update-facility-form').append(`<input type="hidden" name="deleted_maps[]" value="${mapId}">`);
                btn.closest('.col-md-3').remove();
            });

            // Delete ATP
            $(document).on('click', '.delete-atp-btn', function() {
                let atpId = $(this).data('id');
                let btn = $(this);

                $('#update-facility-form').append(`<input type="hidden" name="deleted_atps[]" value="${atpId}">`);
                btn.closest('.col-md-3').remove();
            });

            let countryId = $('#facility_country').val();
            let stateId = "{{ $facility->state_id }}";
            let cityId = "{{ $facility->city_id }}";

            if (countryId) {
                $.get(`/states/${countryId}`, function(states) {
                    $('#facility_state').prop('disabled', false).empty()
                        .append('<option value="">Select State</option>');

                    $.each(states, function(i, state) {
                        let selected = state.state_id == stateId ? 'selected' : '';
                        $('#facility_state').append(
                            `<option value="${state.state_id}" ${selected}>${state.name}</option>`
                        );
                    });

                    $('#facility_state').trigger('change');
                });
            }

            if (stateId) {
                $.get(`/cities/${stateId}`, function(cities) {
                    $('#facility_city').prop('disabled', false).empty()
                        .append('<option value="">Select City</option>');

                    $.each(cities, function(i, city) {
                        let selected = city.id == cityId ? 'selected' : '';
                        $('#facility_city').append(
                            `<option value="${city.id}" ${selected}>${city.name}</option>`
                        );
                    });

                    $('#facility_city').trigger('change');
                });
            }


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

        });


        document.addEventListener("DOMContentLoaded", function() {

            // Reusable preview function
            function setupPreview(inputId, previewId) {
                let input = document.getElementById(inputId);
                let previewContainer = document.getElementById(previewId);

                if (!input || !previewContainer) return;

                // Create a DataTransfer object to hold files
                let dataTransfer = new DataTransfer();

                input.addEventListener('change', function(event) {
                    let files = event.target.files;
                    
                    // Add new files to our dataTransfer object
                    for (let i = 0; i < files.length; i++) {
                        dataTransfer.items.add(files[i]);
                    }
                    
                    // Update input files
                    input.files = dataTransfer.files;
                    
                    renderPreviews();
                });

                function renderPreviews() {
                    previewContainer.innerHTML = ''; // clear current
                    
                    let files = input.files;
                    
                    for (let i = 0; i < files.length; i++) {
                        let file = files[i];
                        let reader = new FileReader();
                        
                        reader.onload = function(e) {
                            let div = document.createElement('div');
                            div.style.position = 'relative';
                            div.style.display = 'inline-block';
                            
                            let img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-fluid rounded';
                            img.style.width = '90px';
                            img.style.height = '90px';
                            img.style.objectFit = 'cover';
                            img.style.border = '1px solid #ccc';
                            
                            let closeBtn = document.createElement('button');
                            closeBtn.innerHTML = '&times;';
                            closeBtn.className = 'btn btn-sm btn-danger';
                            closeBtn.style.position = 'absolute';
                            closeBtn.style.top = '-5px';
                            closeBtn.style.right = '-5px';
                            closeBtn.style.padding = '0px 5px';
                            closeBtn.style.borderRadius = '50%';
                            closeBtn.style.lineHeight = '1';
                            
                            closeBtn.onclick = function(e) {
                                e.preventDefault();
                                // Remove file from dataTransfer
                                let newDataTransfer = new DataTransfer();
                                for(let j = 0; j < input.files.length; j++) {
                                    if(j !== i) {
                                        newDataTransfer.items.add(input.files[j]);
                                    }
                                }
                                input.files = newDataTransfer.files;
                                dataTransfer = newDataTransfer; // update reference
                                renderPreviews(); // re-render
                            };
                            
                            div.appendChild(img);
                            div.appendChild(closeBtn);
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }

            // Attach previews
            setupPreview('atp_file', 'atp-preview');
            setupPreview('map_file', 'map-preview');
        });
    </script>
@endpush
