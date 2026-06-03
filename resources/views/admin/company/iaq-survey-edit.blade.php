@extends('admin.includes.layout')

@section('title', 'IAQ Survey')

@push('styles')
    <style>
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

        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.company.iaq.survey.update', [$company->id, $survey->id]) }}"
                        method="POST" id="iaq-survey-form">
                        @csrf

                        <div class="main-content">

                            {{-- HEADER --}}
                            <div class="heading-area-sec border-bottom-0 pb-0">
                                <div class="left-part-sec">
                                    <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">
                                        IAQ SURVEY <span style="font-size: 24px;">💨</span>
                                    </h3>
                                    <p class="text-muted mb-2" style="font-size: 16px;">
                                        Edit Indoor Air Quality Survey
                                    </p>
                                </div>
                                <div class="right-part-sec">
                                    <button type="submit" class="btn btn-export fw-semibold">
                                        Update Survey
                                    </button>
                                </div>
                            </div>

                            <div class="my-4"></div>

                            <div class="dashboard-body px-4 pb-4">

                                {{-- BASIC INFORMATION --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header">
                                                <h3 class="section-title">Basic Information</h3>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <th>Survey Name</th>
                                                            <td>
                                                                <input type="text" name="survey_name" id="survey_name"
                                                                    class="form-control"
                                                                    value="{{ old('survey_name', $survey->survey_name) }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Building Description</th>
                                                            <td>
                                                                <textarea name="building_description" class="form-control" rows="3">{{ old('building_description', $survey->building_description) }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Reported Issues</th>
                                                            <td>
                                                                <textarea name="reported_issues" class="form-control" rows="3">{{ old('reported_issues', $survey->reported_issues) }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">General Walkthrough</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Odor</th>
                                                        <td>
                                                            <select name="odor" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->odor == 0 ? 'selected' : '' }}>No</option>
                                                                <option value="1"
                                                                    {{ $survey->odor == 1 ? 'selected' : '' }}>Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="odor_desc" class="form-control" rows="3">{{ old('odor_desc', $survey->odor_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Dirty or Unsanitary Conditions?</th>
                                                        <td>
                                                            <select name="dirty_unsanitary" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->dirty_unsanitary == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->dirty_unsanitary == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="dirty_unsanitary_desc" class="form-control" rows="3">{{ old('dirty_unsanitary_desc', $survey->dirty_unsanitary_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Visible Microbial Growth</th>
                                                        <td>
                                                            <select name="visible_microbial" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->visible_microbial == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->visible_microbial == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="visible_microbial_desc" class="form-control" rows="3">{{ old('visible_microbial_desc', $survey->visible_microbial_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Staining or Discoloration <br> of Building Materials</th>
                                                        <td>
                                                            <select name="material_staining" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->material_staining == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->material_staining == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="material_staining_desc" class="form-control" rows="3">{{ old('material_staining_desc', $survey->material_staining_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Adequate Ventilation and Exhaust Air</th>
                                                        <td>
                                                            <select name="adequate_ventilation" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->adequate_ventilation == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ $survey->adequate_ventilation == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="adequate_ventilation_desc" class="form-control" rows="3">{{ old('adequate_ventilation_desc', $survey->adequate_ventilation_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Blocked or Obstructed HVAC Ductwork</th>
                                                        <td>
                                                            <select name="hvac_duct_blocked" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->hvac_duct_blocked == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->hvac_duct_blocked == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="hvac_duct_blocked_desc" class="form-control" rows="3">{{ old('hvac_duct_blocked_desc', $survey->hvac_duct_blocked_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Filter Adequate and Healthy</th>
                                                        <td>
                                                            <select name="filter_adequate" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->filter_adequate == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->filter_adequate == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="filter_adequate_desc" class="form-control" rows="3">{{ old('filter_adequate_desc', $survey->filter_adequate_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Change Frequency</th>
                                                        <td>
                                                            <input type="text" name="filter_change_freq"
                                                                id="filter_change_freq" class="form-control"
                                                                value="{{ old('filter_change_freq', $survey->filter_change_freq) }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Filter Adequate and Healthy</th>
                                                        <td>
                                                            <select name="filter_adequate_and_healthy" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->filter_adequate_and_healthy == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ $survey->filter_adequate_and_healthy == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="filter_adequate_and_healthy_describe" class="form-control" rows="3">{{ old('filter_adequate_and_healthy_describe', $survey->filter_adequate_and_healthy_describe) }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Change Frequency</th>
                                                        <td>
                                                            <input type="text" name="change_frequency"
                                                                id="change_frequency" class="form-control"
                                                                value="{{ old('change_frequency', $survey->change_frequency) }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Storage of Chemicals or Hazardous <br> Substances in Breathing Space
                                                        </th>
                                                        <td>
                                                            <select name="chemical_storage" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->chemical_storage == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->chemical_storage == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="chemical_storage_desc" class="form-control" rows="3">{{ old('chemical_storage_desc', $survey->chemical_storage_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Temperature Within ASHRE <br> Recommendations</th>
                                                        <td>
                                                            <select name="temp_within_ashre" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->temp_within_ashre == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->temp_within_ashre == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="temp_within_ashre_desc" class="form-control" rows="3">{{ old('temp_within_ashre_desc', $survey->temp_within_ashre_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Overcrowding in Space</th>
                                                        <td>
                                                            <select name="overcrowding" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->overcrowding == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->overcrowding == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="overcrowding_desc" class="form-control" rows="3">{{ old('overcrowding_desc', $survey->overcrowding_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Activities to Contribute to Poor IAQ</th>
                                                        <td>
                                                            <select name="poor_iaq_activities" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->poor_iaq_activities == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ $survey->poor_iaq_activities == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="poor_iaq_activities_desc" class="form-control" rows="3">{{ old('poor_iaq_activities_desc', $survey->poor_iaq_activities_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Water Intrusion or Evidence of Recent Water Intrusion</th>
                                                        <td>
                                                            <select name="water_intrusion" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->water_intrusion == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->water_intrusion == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="water_intrusion_desc" class="form-control" rows="3">{{ old('water_intrusion_desc', $survey->water_intrusion_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Carpet in Area in Question</th>
                                                        <td>
                                                            <select name="carpet_present" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->carpet_present == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->carpet_present == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="carpet_present_desc" class="form-control" rows="3">{{ old('carpet_present_desc', $survey->carpet_present_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cleaning Frequency</th>
                                                        <td>
                                                            <input type="text" name="carpet_clean_freq"
                                                                id="carpet_clean_freq" class="form-control"
                                                                value="{{ old('carpet_clean_freq', $survey->carpet_clean_freq) }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Pest Management Activities</th>
                                                        <td>
                                                            <select name="pest_management" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->pest_management == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->pest_management == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="pest_management_desc" class="form-control" rows="3">{{ old('pest_management_desc', $survey->pest_management_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Frequency</th>
                                                        <td>
                                                            <input type="text" name="pest_management_freq"
                                                                id="pest_management_freq" class="form-control"
                                                                value="{{ old('pest_management_freq', $survey->pest_management_freq) }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Dirty Air Diffusers</th>
                                                        <td>
                                                            <select name="dirty_air_diffusers" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->dirty_air_diffusers == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ $survey->dirty_air_diffusers == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="dirty_air_diffusers_desc" class="form-control" rows="3">{{ old('dirty_air_diffusers_desc', $survey->dirty_air_diffusers_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>MHVAC Equipment in Good Working Order</th>
                                                        <td>
                                                            <select name="mhvac_equipment" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="0"
                                                                    {{ $survey->mhvac_equipment == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="1"
                                                                    {{ $survey->mhvac_equipment == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>Describe</th>
                                                        <td>
                                                            <textarea name="mhvac_equipment_desc" class="form-control" rows="3">{{ old('mhvac_equipment_desc', $survey->mhvac_equipment_desc) }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Location</th>
                                                        <td>
                                                            <input type="text" name="location" id="location"
                                                                class="form-control"
                                                                value="{{ old('location', $survey->location) }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <td>
                                                            <select name="parameter" class="form-select">
                                                                <option value="">Select One</option>
                                                                <option value="MEA Plate"
                                                                    {{ $survey->parameter == 'MEA Plate' ? 'selected' : '' }}>
                                                                    MEA Plate</option>
                                                                <option value="TSA Plate"
                                                                    {{ $survey->parameter == 'TSA Plate' ? 'selected' : '' }}>
                                                                    TSA Plate</option>
                                                                <option value="AIR-O-Cell"
                                                                    {{ $survey->parameter == 'AIR-O-Cell' ? 'selected' : '' }}>
                                                                    AIR-O-Cell</option>
                                                                <option value="PM 5"
                                                                    {{ $survey->parameter == 'PM 5' ? 'selected' : '' }}>PM 5
                                                                </option>
                                                                <option value="PM 10"
                                                                    {{ $survey->parameter == 'PM 10' ? 'selected' : '' }}>PM 10
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Volume</th>
                                                        <td>
                                                            <input type="text" name="volume" id="volume"
                                                                class="form-control"
                                                                value="{{ old('volume', $survey->volume) }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sampler</th>
                                                        <td>
                                                            <input type="text" name="sampler" id="sampler"
                                                                class="form-control"
                                                                value="{{ old('sampler', $survey->sampler) }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Result</th>
                                                        <td>
                                                            <textarea name="result" id="result" class="form-control">{{ old('result', $survey->result) }}</textarea>
                                                        </td>
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
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

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
                    odor: {
                        required: true
                    },
                    dirty_unsanitary: {
                        required: true
                    },
                    visible_microbial: {
                        required: true
                    },
                    material_staining: {
                        required: true
                    },
                    adequate_ventilation: {
                        required: true
                    },
                    hvac_duct_blocked: {
                        required: true
                    },
                    filter_adequate: {
                        required: true
                    },
                    chemical_storage: {
                        required: true
                    },
                    temp_within_ashre: {
                        required: true
                    },
                    overcrowding: {
                        required: true
                    },
                    poor_iaq_activities: {
                        required: true
                    },
                    water_intrusion: {
                        required: true
                    },
                    carpet_present: {
                        required: true
                    },
                    pest_management: {
                        required: true
                    },
                    dirty_air_diffusers: {
                        required: true
                    },
                    mhvac_equipment: {
                        required: true
                    },

                    /* SAMPLING DETAILS */
                    location: {
                        required: true
                    },
                    parameter: {
                        required: true
                    },
                    volume: {
                        required: true
                    },
                    sampler: {
                        required: true
                    }
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
               AJAX SUBMIT
            ============================ */
            $('#iaq-survey-form').on('submit', function(e) {
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
                            text: response.message || 'IAQ survey updated successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },

                    error: function(xhr) {

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
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
