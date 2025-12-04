@extends('admin.includes.layout')

@section('title', 'Equipment Evaluation')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" id="add-equipment-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="survey_proposal_id" value="{{ $surveyProposal->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Equipment Evaluation</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Evaluations
                                    </button>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Equipment Evaluation</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter name">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>

                            {{-- utilities and drains photos --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">Utilities and Drains</h3>
                                                <p class="section-subtitle">Upload Photos of the electrical connections,
                                                    water connections and drain area for Wash.
                                                    <br>
                                                    Describe (in detail) where the utilities can be found.
                                                </p>
                                            </div>
                                            <div class="text-end">
                                            </div>
                                        </div>


                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="utility_file"
                                                            id="utility_file">
                                                        {{-- Preview Box --}}
                                                        <div id="utility-preview" class="mt-2" style="display: none;">
                                                            <img src="" class="img-fluid rounded"
                                                                style="width: 90px; height: 90px; object-fit: cover; border: 1px solid #ccc;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Photos --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Uploaded Pictures</h3>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- wash information --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Wash Information</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                @foreach ($washingTypes as $types)
                                                    <tr>
                                                        <th>{{ $types->name }}</th>
                                                        <td><input type="number" class="form-control"
                                                                name="{{ $types->input_name }}" value="0">
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><span id="wash_man_hours">0</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        <span id="wash_man_hours_cost">$0.00</span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            {{-- Equipment Cleaning Information --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Equipment Cleaning Information</h3>
                                            <div class="text-end">
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                @foreach ($cleaningTypes as $types)
                                                    <tr>
                                                        <th>{{ $types->name }}</th>
                                                        <td><input type="number" class="form-control"
                                                                name="{{ $types->input_name }}" value="0">
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><span id="cleaning_man_hours">0</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><span id="cleaning_man_hours_cost">$0.00</span></td>
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
            // Build dynamic validation rules:
            let dynamicRules = {
                utility_file: {
                    required: true
                },
                description: {
                    required: true
                },
                name: {
                    required: true
                }
            };

            // Add rules for ALL equipment input fields
            @foreach ($equipmentTypes as $type)
                dynamicRules["{{ $type->input_name }}"] = {
                    required: true,
                    number: true
                };
            @endforeach

            // Initialize validator
            $("#add-equipment-form").validate({
                ignore: [],
                rules: dynamicRules,
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

            // AJAX Submit Handler
            $('#add-equipment-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-equipment-form').valid()) {
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.survey.proposal.equipment.store', $surveyProposal->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Equipment Evaluation Saved!",
                            text: res.message || "Evaluation saved successfully!",
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => location.reload(), 2000);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the evaluation.');
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
            setupPreview('utility_file', 'utility-preview');
        });
    </script>
@endpush
