@extends('admin.includes.layout')

@section('title', 'Survey Facility')

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


                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Edit Facility</h1>
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
                                                    <th>City</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="city"
                                                            value="{{ $facility->city ?? ' ' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="state"
                                                            value="{{ $facility->state ?? ' ' }}">
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
                                                            <option value="hospital"
                                                                {{ $facility->facility_type == 'hospital' ? 'selected' : '' }}>
                                                                Hospital
                                                            </option>
                                                            <option value="clinic"
                                                                {{ $facility->facility_type == 'clinic' ? 'selected' : '' }}>
                                                                Clinic
                                                            </option>
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
                                                        <input type="file" class="form-control" name="map_file" id="map_file">
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
                                                                    <p class="mb-1 fw-semibold">{{ $map->file_name }}</p>
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
                                                        <input type="file" class="form-control" name="atp_file" id="atp_file">
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
                                                                    <p class="mb-1 fw-semibold">{{ $atp->file_name }}</p>
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
                                                    <td><input type="number" class="form-control" name="square_footage"
                                                            value="{{ $facility->square_footage ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Offices</th>
                                                    <td><input type="number" class="form-control" name="offices"
                                                            value="{{ $facility->offices ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Community Bathrooms</th>
                                                    <td><input type="number" class="form-control"
                                                            name="standard_bathrooms"
                                                            value="{{ $facility->standard_bathrooms ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Single Bathrooms</th>
                                                    <td><input type="number" class="form-control"
                                                            name="single_bathrooms"
                                                            value="{{ $facility->single_bathrooms ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><input type="number" class="form-control" name="man_hours"
                                                            value="{{ $facility->man_hours ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><span
                                                            id="man_hours_cost">${{ $facility->man_hours_cost ?? '' }}</span>
                                                    </td>
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
        $("#update-facility-form").validate({
            ignore: [],
            rules: {
                // Facility Info
                facility_name: {
                    required: true
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                zip: {
                    required: true
                },
                facility_type: {
                    required: true
                },
                // Survey Details
                square_footage: {
                    required: true,
                    number: true
                },
                offices: {
                    required: true,
                    number: true
                },
                standard_bathrooms: {
                    required: true,
                    number: true
                },
                single_bathrooms: {
                    required: true,
                    number: true
                },
                man_hours: {
                    required: true,
                    number: true
                },
            },

            messages: {
                facility_name: {
                    required: "Facility name is required."
                },
                address: {
                    required: "Address is required."
                },
                city: {
                    required: "City is required."
                },
                state: {
                    required: "State is required."
                },
                zip: {
                    required: "Zip code is required."
                },
                facility_type: {
                    required: "Select a facility type."
                },
                square_footage: {
                    required: "Square footage required.",
                    number: "Must be numeric."
                },
                offices: {
                    required: "Enter office count.",
                    number: "Must be numeric."
                },
                standard_bathrooms: {
                    required: "Enter community bathrooms.",
                    number: "Must be numeric."
                },
                single_bathrooms: {
                    required: "Enter single bathrooms.",
                    number: "Must be numeric."
                },
                man_hours: {
                    required: "Enter total man hours.",
                    number: "Must be numeric."
                },
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
        $('#update-facility-form').submit(function(e) {
            e.preventDefault();

            if (!$('#update-facility-form').valid()) {
                return;
            }

            // Required for file uploads!
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
    </script>
@endpush
