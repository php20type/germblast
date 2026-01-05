@extends('admin.includes.layout')

@section('title', 'Edit Water Management')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form
                        action="{{ route('admin.companies.water.management.update', [$company->id, $waterManagement->id]) }}"
                        method="POST" id="water-management-form">
                        @csrf

                        <div class="sales-dashboard">

                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="display-6 mb-2 fw-bold">Water Management</h1>
                                    <p class="text-muted">Edit Water Management Phase</p>
                                </div>
                                <button type="submit" class="btn btn-success">Update Survey</button>
                            </div>

                            {{-- BASIC DETAILS --}}
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">Basic Details</h3>
                                </div>

                                <table class="table table-bordered align-middle">
                                    <tbody>
                                        <tr>
                                            <th>Survey Name</th>
                                            <td>
                                                <input type="text" name="survey_name" class="form-control"
                                                    value="{{ $waterManagement->survey_name }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Municipal Water Supplier</th>
                                            <td>
                                                <input type="text" name="municipal_water_supplier"
                                                    value="{{ $waterManagement->municipal_water_supplier }}"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- WMP TEAM --}}
                            <div class="section-card">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <h3 class="section-title mb-0">WMP Team & Role</h3>
                                    <button type="button" class="btn btn-sm btn-primary" id="add-wmp-team">+ Add</button>
                                </div>

                                <div id="wmp-team-wrapper">

                                    @forelse ($waterManagement->waterManagementTeams as $team)
                                        <table class="table table-bordered align-middle wmp-team-block">
                                            <tbody>
                                                <tr>
                                                    <th colspan="2" class="text-end">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-wmp-team">✕</button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <input type="text" name="wmp_team_name[]"
                                                            value="{{ $team->name }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Role</th>
                                                    <td>
                                                        <input type="text" name="wmp_team_role[]"
                                                            value="{{ $team->role }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>
                                                        <input type="email" name="wmp_team_email[]"
                                                            value="{{ $team->email }}" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @empty
                                        {{-- fallback --}}
                                        <table class="table table-bordered align-middle wmp-team-block">
                                            <tbody>
                                                <tr>
                                                    <th colspan="2" class="text-end">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-wmp-team">✕</button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td><input type="text" name="wmp_team_name[]" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Role</th>
                                                    <td><input type="text" name="wmp_team_role[]" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><input type="email" name="wmp_team_email[]" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforelse

                                </div>


                            </div>

                            {{-- FACILITY RISK FACTORS --}}
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">Facility Risk Factors</h3>
                                </div>

                                <table class="table table-bordered align-middle">
                                    <tbody>

                                        <tr>
                                            <th>Healthcare Facility</th>
                                            <td>
                                                <select name="is_healthcare_facility" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->is_healthcare_facility == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->is_healthcare_facility == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Houses Elderly Patients</th>
                                            <td>
                                                <select name="houses_elderly_patients" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->houses_elderly_patients == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->houses_elderly_patients == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Multiple Housing Units</th>
                                            <td>
                                                <select name="has_multiple_housing_units" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_multiple_housing_units == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_multiple_housing_units == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>More Than Two Floors</th>
                                            <td>
                                                <select name="has_more_than_two_floors" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_more_than_two_floors == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_more_than_two_floors == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Cooling Tower</th>
                                            <td>
                                                <select name="has_cooling_tower" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_cooling_tower == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_cooling_tower == 0 ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Hot Tub or Spa</th>
                                            <td>
                                                <select name="has_hot_tub_or_spa" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_hot_tub_or_spa == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_hot_tub_or_spa == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Indoor Fountain</th>
                                            <td>
                                                <select name="has_indoor_fountain" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_indoor_fountain == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_indoor_fountain == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Central Mister / Humidifier</th>
                                            <td>
                                                <select name="has_central_mister_or_humidifier" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->has_central_mister_or_humidifier == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->has_central_mister_or_humidifier == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Organ Transplant Conducted</th>
                                            <td>
                                                <select name="conducts_organ_transplant" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->conducts_organ_transplant == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->conducts_organ_transplant == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>History of Legionella</th>
                                            <td>
                                                <select name="history_of_legionella" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="1"
                                                        {{ $waterManagement->history_of_legionella == 1 ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="0"
                                                        {{ $waterManagement->history_of_legionella == 0 ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>

                            {{-- MONITORING --}}
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">Current Monitoring Activities</h3>
                                </div>

                                <textarea name="current_monitoring_activities" class="form-control" rows="5">{{ $waterManagement->current_monitoring_activities }}</textarea>
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
        $(document).ready(function() {

            const wmpTeamTemplate = `
                <table class="table table-bordered align-middle wmp-team-block">
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-end">
                                <button type="button" class="btn btn-sm btn-danger remove-wmp-team">✕</button>
                            </th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><input type="text" name="wmp_team_name[]" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td><input type="text" name="wmp_team_role[]" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input type="email" name="wmp_team_email[]" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
                `;


            $('#add-wmp-team').on('click', function() {
                $('#wmp-team-wrapper').append(wmpTeamTemplate);
            });


            $(document).on('click', '.remove-wmp-team', function() {

                if ($('.wmp-team-block').length === 1) {
                    toastr.warning('At least one team is required.');
                    return;
                }

                $(this).closest('.wmp-team-block').remove();
            });




            /* ============================
               JQUERY VALIDATION
            ============================ */
            $("#water-management-form").validate({
                ignore: [],

                rules: {

                    /* BASIC DETAILS */
                    survey_name: {
                        required: true
                    },
                    municipal_water_supplier: {
                        required: true
                    },

                    /* WMP TEAM */
                    'wmp_team_name[]': {
                        required: true
                    },
                    'wmp_team_role[]': {
                        required: true
                    },
                    'wmp_team_email[]': {
                        required: true,
                        email: true
                    },

                    /* FACILITY RISK FACTORS */
                    is_healthcare_facility: {
                        required: true
                    },
                    houses_elderly_patients: {
                        required: true
                    },
                    has_multiple_housing_units: {
                        required: true
                    },
                    has_more_than_two_floors: {
                        required: true
                    },
                    has_cooling_tower: {
                        required: true
                    },
                    has_hot_tub_or_spa: {
                        required: true
                    },
                    has_indoor_fountain: {
                        required: true
                    },
                    has_central_mister_or_humidifier: {
                        required: true
                    },
                    conducts_organ_transplant: {
                        required: true
                    },
                    history_of_legionella: {
                        required: true
                    }
                },

                messages: {

                    survey_name: "Survey name is required.",
                    municipal_water_supplier: "Municipal water supplier is required.",

                    'wmp_team_name[]': "Team member name is required.",
                    'wmp_team_role[]': "Team member role is required.",
                    'wmp_team_email[]': "Valid email is required.",

                    is_healthcare_facility: "Please select an option.",
                    houses_elderly_patients: "Please select an option.",
                    has_multiple_housing_units: "Please select an option.",
                    has_more_than_two_floors: "Please select an option.",
                    has_cooling_tower: "Please select an option.",
                    has_hot_tub_or_spa: "Please select an option.",
                    has_indoor_fountain: "Please select an option.",
                    has_central_mister_or_humidifier: "Please select an option.",
                    conducts_organ_transplant: "Please select an option.",
                    history_of_legionella: "Please select an option."
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
                    error.insertAfter(element);
                }
            });

            /* ============================
               AJAX SUBMIT (EDIT)
            ============================ */
            $('#water-management-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);

                if (!form.valid()) {
                    return;
                }

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),

                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message ||
                                'Water management data updated successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    },

                    error: function(xhr) {

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(function(message) {
                                    toastr.error(message);
                                });
                            });
                            return;
                        }

                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Something went wrong while updating water management data.'
                        );
                    }
                });
            });

        });
    </script>
@endpush
