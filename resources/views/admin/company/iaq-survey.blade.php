@extends('admin.includes.layout')

@section('title', 'IAQ Survey')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.companies.iaq.survey.store', $company->id) }}" method="POST"
                        id="iaq-survey-form">
                        @csrf

                        <div class="sales-dashboard">

                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="display-6 mb-2 fw-bold">IAQ Survey</h1>
                                    <p class="text-muted">Create Indoor Air Quality Survey</p>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    Save Survey
                                </button>
                            </div>

                             {{-- BASIC INFORMATION --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Basic Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Survey Name</th>
                                                    <td>
                                                        <input type="text" name="survey_name" id="survey_name" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Building Description</th>
                                                    <td>
                                                        <textarea name="building_description" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reported Issues</th>
                                                    <td>
                                                        <textarea name="reported_issues" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">General Walkthrough</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Odor</th>
                                                    <td>
                                                        <select name="odor" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="odor_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Dirty or Unsanitary Conditions?</th>
                                                    <td>
                                                        <select name="dirty_unsanitary" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="dirty_unsanitary_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Visible Microbial Growth</th>
                                                    <td>
                                                        <select name="visible_microbial" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="visible_microbial_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Staining or Discoloration <br> of Building Materials</th>
                                                    <td>
                                                        <select name="material_staining" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="material_staining_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Adequate Ventilation and Exhaust Air</th>
                                                    <td>
                                                        <select name="adequate_ventilation" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="adequate_ventilation_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Blocked or Obstructed HVAC Ductwork</th>
                                                    <td>
                                                        <select name="hvac_duct_blocked" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="hvac_duct_blocked_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Filter Adequate and Healthy</th>
                                                    <td>
                                                        <select name="filter_adequate" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="filter_adequate_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Change Frequency</th>
                                                    <td>
                                                        <input type="text" name="filter_change_freq" id="filter_change_freq" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Filter Adequate and Healthy</th>
                                                    <td>
                                                        <select name="filter_adequate_and_healthy" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="filter_adequate_and_healthy_describe" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Change Frequency</th>
                                                    <td>
                                                        <input type="text" name="change_frequency" id="change_frequency" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Storage of Chemicals or Hazardous <br> Substances in Breathing Space</th>
                                                    <td>
                                                        <select name="chemical_storage" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="chemical_storage_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Temperature Within ASHRE <br> Recommendations</th>
                                                    <td>
                                                        <select name="temp_within_ashre" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="temp_within_ashre_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Overcrowding in Space</th>
                                                    <td>
                                                        <select name="overcrowding" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="overcrowding_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Activities to Contribute to Poor IAQ</th>
                                                    <td>
                                                        <select name="poor_iaq_activities" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="poor_iaq_activities_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Water Intrusion or Evidence of Recent Water Intrusion</th>
                                                    <td>
                                                        <select name="water_intrusion" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="water_intrusion_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Carpet in Area in Question</th>
                                                    <td>
                                                        <select name="carpet_present" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="carpet_present_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Cleaning Frequency</th>
                                                    <td>
                                                        <input type="text"
                                                            name="carpet_clean_freq"
                                                            id="carpet_clean_freq"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Pest Management Activities</th>
                                                    <td>
                                                        <select name="pest_management" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="pest_management_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Frequency</th>
                                                    <td>
                                                        <input type="text"
                                                            name="pest_management_freq"
                                                            id="pest_management_freq"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Dirty Air Diffusers</th>
                                                    <td>
                                                        <select name="dirty_air_diffusers" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="dirty_air_diffusers_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>MHVAC Equipment in Good Working Order</th>
                                                    <td>
                                                        <select name="mhvac_equipment" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th>Describe</th>
                                                    <td>
                                                        <textarea name="mhvac_equipment_desc" class="form-control" rows="3"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Location</th>
                                                    <td>
                                                        <input type="text"
                                                            name="location"
                                                            id="location"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <td>
                                                        <select name="parameter" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="MEA Plate">MEA Plate</option>
                                                            <option value="TSA Plate">TSA Plate</option>
                                                            <option value="AIR-O-Cell">AIR-O-Cell</option>
                                                            <option value="PM 5">PM 5</option>
                                                            <option value="PM 10">PM 10</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Volume</th>
                                                    <td>
                                                        <input type="text"
                                                            name="volume"
                                                            id="volume"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Sampler</th>
                                                    <td>
                                                        <input type="text"
                                                            name="sampler"
                                                            id="sampler"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Result</th>
                                                    <td>
                                                        <textarea name="result" id="result" class="form-control"></textarea>
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
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {

    /* ============================
       JQUERY VALIDATION
    ============================ */
    $("#iaq-survey-form").validate({
        ignore: [],
        rules: {

            /* BASIC INFORMATION */
            survey_name: {
                required: true
            },
            building_description: {
                required: true
            },
            reported_issues: {
                required: true
            },

            /* GENERAL WALKTHROUGH (Yes/No required) */
            odor: { required: true },
            dirty_unsanitary: { required: true },
            visible_microbial: { required: true },
            material_staining: { required: true },
            adequate_ventilation: { required: true },
            hvac_duct_blocked: { required: true },
            filter_adequate: { required: true },
            chemical_storage: { required: true },
            temp_within_ashre: { required: true },
            overcrowding: { required: true },
            poor_iaq_activities: { required: true },
            water_intrusion: { required: true },
            carpet_present: { required: true },
            pest_management: { required: true },
            dirty_air_diffusers: { required: true },
            mhvac_equipment: { required: true },

            /* SAMPLING DETAILS */
            location: { required: true },
            parameter: { required: true },
            volume: { required: true },
            sampler: { required: true }
        },

        messages: {
            survey_name: "Survey name is required.",
            building_description: "Building description is required.",
            reported_issues: "Reported issues are required.",

            odor: "Please select odor status.",
            dirty_unsanitary: "Please select an option.",
            visible_microbial: "Please select an option.",
            material_staining: "Please select an option.",
            adequate_ventilation: "Please select an option.",
            hvac_duct_blocked: "Please select an option.",
            filter_adequate: "Please select an option.",
            chemical_storage: "Please select an option.",
            temp_within_ashre: "Please select an option.",
            overcrowding: "Please select an option.",
            poor_iaq_activities: "Please select an option.",
            water_intrusion: "Please select an option.",
            carpet_present: "Please select an option.",
            pest_management: "Please select an option.",
            dirty_air_diffusers: "Please select an option.",
            mhvac_equipment: "Please select an option.",

            location: "Location is required.",
            parameter: "Parameter is required.",
            volume: "Volume is required.",
            sampler: "Sampler is required."
        },

        errorElement: 'span',
        errorClass: 'invalid-feedback d-block',

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });

    /* ============================
       AJAX SUBMIT
    ============================ */
    $('#iaq-survey-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);

        if (!form.valid()) {
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'IAQ survey saved successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },

            error: function (xhr) {

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while saving IAQ survey.'
                );
            }
        });
    });

});
</script>
@endpush

