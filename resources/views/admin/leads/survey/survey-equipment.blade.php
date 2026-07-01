@extends('admin.includes.layout')

@section('title', 'Equipment Evaluation')

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

                    <form action="#" method="POST" id="add-equipment-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="survey_proposal_id" value="{{ $surveyProposal->id }}">

                        <div class="main-content">
                            {{-- HEADER --}}
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">
                                        Equipment Evaluation <span style="font-size: 24px;">📋</span>
                                    </h3>
                                    <p class="text-muted mb-0">
                                        Record survey results on this page
                                    </p>
                                </div>
                                <div class="right-part d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-success">
                                        Save Evaluations
                                    </button>
                                </div>
                            </div>

                            <div class="my-4"></div>

                            <div class="dashboard-body px-4 pb-4">

                                {{-- Name --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header">
                                                <h3 class="section-title">Create Equipment Evaluation</h3>
                                            </div>

                                            <table class="equipment-report-table align-middle">
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


                                        <table class="equipment-report-table align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="utility_file[]"
                                                            id="utility_file" multiple>
                                                        {{-- Preview Box --}}
                                                        <div id="utility-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
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

                                        <table class="equipment-report-table align-middle">
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

                                        <table class="equipment-report-table align-middle">
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
                        setTimeout(() => window.location.href = "{{ route('admin.lead.survey.proposal', $surveyProposal->lead_id) }}", 2000);
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
            setupPreview('utility_file', 'utility-preview');
        });
    </script>
@endpush
