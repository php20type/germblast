@extends('admin.includes.layout')

@section('title', 'Edit Biological Response Intake')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.companies.biological.response.update', [$company->id, $intake->id]) }}"
                        method="POST" id="biological-response-intake-form">
                        @csrf

                        <div class="sales-dashboard">

                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="display-6 mb-2 fw-bold">Edit Biological Response Intake</h1>
                                    <p class="text-muted">Update project and insurance details</p>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Update Intake
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
                                                    <th>Project Name</th>
                                                    <td>
                                                        <input type="text" name="project_name" class="form-control"
                                                            value="{{ old('project_name', $intake->project_name) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Project Address</th>
                                                    <td>
                                                        <input type="text" name="project_address" class="form-control"
                                                            value="{{ old('project_address', $intake->project_address) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>City</th>
                                                    <td>
                                                        <input type="text" name="project_city" class="form-control"
                                                            value="{{ old('project_city', $intake->project_city) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <input type="text" name="project_state" class="form-control"
                                                            value="{{ old('project_state', $intake->project_state) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Zip</th>
                                                    <td>
                                                        <input type="text" name="project_zip" class="form-control"
                                                            value="{{ old('project_zip', $intake->project_zip) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Project Leader</th>
                                                    <td>
                                                        <input type="text" name="project_leader" class="form-control"
                                                            value="{{ old('project_leader', $intake->project_leader) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Comments</th>
                                                    <td>
                                                        <textarea name="comments" class="form-control" rows="3">{{ old('comments', $intake->comments) }}</textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- FRONTEND MANAGEMENT --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Frontend Management Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Facility Type</th>
                                                    <td>
                                                        <select name="facility_type" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="Residential"
                                                                {{ old('facility_type', $intake->facility_type) === 'Residential' ? 'selected' : '' }}>
                                                                Residential
                                                            </option>
                                                            <option value="Institutional"
                                                                {{ old('facility_type', $intake->facility_type) === 'Institutional' ? 'selected' : '' }}>
                                                                Institutional
                                                            </option>
                                                            <option value="Municipal"
                                                                {{ old('facility_type', $intake->facility_type) === 'Municipal' ? 'selected' : '' }}>
                                                                Municipal
                                                            </option>
                                                            <option value="Health"
                                                                {{ old('facility_type', $intake->facility_type) === 'Health' ? 'selected' : '' }}>
                                                                Health
                                                            </option>
                                                            <option value="Commercial"
                                                                {{ old('facility_type', $intake->facility_type) === 'Commercial' ? 'selected' : '' }}>
                                                                Commercial
                                                            </option>
                                                            <option value="Industrial"
                                                                {{ old('facility_type', $intake->facility_type) === 'Industrial' ? 'selected' : '' }}>
                                                                Industrial
                                                            </option>
                                                        </select>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Casualties / Illnesses</th>
                                                    <td>
                                                        <select name="casualties_or_illnesses" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="Death"
                                                                {{ old('casualties_or_illnesses', $intake->casualties_or_illnesses) === 'Death' ? 'selected' : '' }}>
                                                                Death
                                                            </option>
                                                            <option value="Illness"
                                                                {{ old('casualties_or_illnesses', $intake->casualties_or_illnesses) === 'Illness' ? 'selected' : '' }}>
                                                                Illness
                                                            </option>
                                                            <option value="None"
                                                                {{ old('casualties_or_illnesses', $intake->casualties_or_illnesses) === 'None' ? 'selected' : '' }}>
                                                                None
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimated Man Hours</th>
                                                    <td>
                                                        <input type="number" name="estimated_man_hours"
                                                            class="form-control"
                                                            value="{{ old('estimated_man_hours', $intake->estimated_man_hours) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimated People</th>
                                                    <td>
                                                        <input type="number" name="estimated_people" class="form-control"
                                                            value="{{ old('estimated_people', $intake->estimated_people) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Type of Loss</th>
                                                    <td>
                                                        <select name="type_of_loss" class="form-select">
                                                            <option value="">Select One</option>
                                                            <option value="Drug"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Drug' ? 'selected' : '' }}>
                                                                Drug
                                                            </option>
                                                            <option value="Trauma"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Trauma' ? 'selected' : '' }}>
                                                                Trauma
                                                            </option>
                                                            <option value="Zoonotic"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Zoonotic' ? 'selected' : '' }}>
                                                                Zoonotic
                                                            </option>
                                                            <option value="Infectious Disease"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Infectious Disease' ? 'selected' : '' }}>
                                                                Infectious Disease
                                                            </option>
                                                            <option value="Food Borne"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Food Borne' ? 'selected' : '' }}>
                                                                Food Borne
                                                            </option>
                                                            <option value="Terrorism"
                                                                {{ old('type_of_loss', $intake->type_of_loss) === 'Terrorism' ? 'selected' : '' }}>
                                                                Terrorism
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Areas to be treated</th>
                                                    <td>
                                                        <input type="text" name="treated_areas" class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- INSURANCE INFORMATION --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Insurance Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Insurance Notified</th>
                                                    <td>
                                                        <select name="insurance_notified" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('insurance_notified', $intake->insurance_notified) == 0 ? 'selected' : '' }}>
                                                                No
                                                            </option>
                                                            <option value="1"
                                                                {{ old('insurance_notified', $intake->insurance_notified) == 1 ? 'selected' : '' }}>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Insurance Company</th>
                                                    <td>
                                                        <input type="text" name="insurance_company_name"
                                                            class="form-control"
                                                            value="{{ old('insurance_company_name', $intake->insurance_company_name) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Insurance Phone</th>
                                                    <td>
                                                        <input type="text" name="insurance_phone" class="form-control"
                                                            value="{{ old('insurance_phone', $intake->insurance_phone) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Coverage Determination</th>
                                                    <td>
                                                        <select name="coverage_determination" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('coverage_determination', $intake->coverage_determination) == 0 ? 'selected' : '' }}>
                                                                No
                                                            </option>
                                                            <option value="1"
                                                                {{ old('coverage_determination', $intake->coverage_determination) == 1 ? 'selected' : '' }}>
                                                                Yes
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Coverage Amount</th>
                                                    <td>
                                                        <input type="number" step="0.01" name="coverage_amount"
                                                            class="form-control"
                                                            value="{{ old('coverage_amount', $intake->coverage_amount) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Deductible</th>
                                                    <td>
                                                        <input type="number" step="0.01" name="deductible"
                                                            class="form-control"
                                                            value="{{ old('deductible', $intake->deductible) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Claim Number</th>
                                                    <td>
                                                        <input type="text" name="claim_number" class="form-control"
                                                            value="{{ old('claim_number', $intake->claim_number) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Adjuster Phone</th>
                                                    <td>
                                                        <input type="text" name="adjuster_phone" class="form-control"
                                                            value="{{ old('adjuster_phone', $intake->adjuster_phone) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Insurance Email</th>
                                                    <td>
                                                        <input type="email" name="insurance_email" class="form-control"
                                                            value="{{ old('insurance_email', $intake->insurance_email) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Limit / Cap</th>
                                                    <td>
                                                        <input type="number" step="0.01" name="limit_or_cap"
                                                            class="form-control"
                                                            value="{{ old('limit_or_cap', $intake->limit_or_cap) }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            {{-- DEATH INFORMATION --}}
                            <div class="row" id="death-section" style="display:none;">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Death Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Cause of Death</th>
                                                    <td>
                                                        <input type="text" name="cause_of_death" class="form-control"
                                                            value="{{ old('cause_of_death', $intake->cause_of_death) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>How Many</th>
                                                    <td>
                                                        <input type="number" name="number_of_deaths"
                                                            class="form-control"
                                                            value="{{ old('number_of_deaths', $intake->number_of_deaths) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Bodies Unattended</th>
                                                    <td>
                                                        <select name="body_unattended" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('body_unattended', $intake->body_unattended) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('body_unattended', $intake->body_unattended) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Unattended Days</th>
                                                    <td>
                                                        <input type="number" name="unattended_days" class="form-control"
                                                            value="{{ old('unattended_days', $intake->unattended_days) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>More than 2 rooms</th>
                                                    <td>
                                                        <select name="death_more_than_2_rooms" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                            {{ old('death_more_than_2_rooms', $intake->more_than_2_rooms) == 0 ? 'selected' : '' }}>No</option>
                                                            <option value="1"
                                                            {{ old('death_more_than_2_rooms', $intake->more_than_2_rooms) == 1 ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>High consequence infectious disease</th>
                                                    <td>
                                                        <select name="death_high_consequence_infectious_disease"
                                                            class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                            {{ old('death_high_consequence_infectious_disease', $intake->high_consequence_infectious_disease) == 0 ? 'selected' : '' }}>No</option>
                                                            <option value="1"
                                                            {{ old('death_high_consequence_infectious_disease', $intake->high_consequence_infectious_disease) == 1 ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            {{-- ILLNESS INFORMATION --}}
                            <div class="row" id="illness-section" style="display:none;">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Illness Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Has person travelled outside the country within past 3 weeks?</th>
                                                    <td>
                                                        <select name="person_travelled_outside" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('person_travelled_outside', $intake->person_travelled_outside) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('person_travelled_outside', $intake->person_travelled_outside) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Is there a diagnosis?</th>
                                                    <td>
                                                        <select name="diagnosis" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('diagnosis', $intake->diagnosis) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('diagnosis', $intake->diagnosis) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>How many diagnosis?</th>
                                                    <td>
                                                        <input type="number" name="number_of_diagnosis"
                                                            class="form-control"
                                                            value="{{ old('number_of_diagnosis', $intake->number_of_diagnosis) }}">
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <th>More than 2 rooms ?</th>
                                                    <td>
                                                        <select name="illness_more_than_2_rooms" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                            {{ old('illness_more_than_2_rooms', $intake->more_than_2_rooms) == 0 ? 'selected' : '' }}>No</option>
                                                            <option value="1"
                                                            {{ old('illness_more_than_2_rooms', $intake->more_than_2_rooms) == 1 ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>High consequence infectious disease</th>
                                                    <td>
                                                        <select name="illness_high_consequence_infectious_disease"
                                                            class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                            {{ old('illness_high_consequence_infectious_disease', $intake->high_consequence_infectious_disease) == 0 ? 'selected' : '' }}>No</option>
                                                            <option value="1"
                                                            {{ old('illness_high_consequence_infectious_disease', $intake->high_consequence_infectious_disease) == 1 ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- POLICE INFORMATION --}}
                            <div class="row" id="police-section" style="display:none;">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Additional Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Police Cleared the scene?</th>
                                                    <td>
                                                        <select name="police_cleanup" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('police_cleanup', $intake->police_cleanup) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('police_cleanup', $intake->police_cleanup) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Phone Number</th>
                                                    <td>
                                                        <input type="text" name="police_number" class="form-control"
                                                            value="{{ old('police_number', $intake->police_number) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Overdose?</th>
                                                    <td>
                                                        <select name="overdose" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('overdose', $intake->overdose) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('overdose', $intake->overdose) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Gunshot Wound?</th>
                                                    <td>
                                                        <select name="gunshot" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="0"
                                                                {{ old('gunshot', $intake->gunshot) == 0 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="1"
                                                                {{ old('gunshot', $intake->gunshot) == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- ADDITIONAL CONTACT --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Additional Contact Information</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Contact Name</th>
                                                    <td>
                                                        <input type="text" name="contact_name" class="form-control"
                                                            value="{{ old('contact_name', $intake->contact_name) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Contact Title</th>
                                                    <td>
                                                        <input type="text" name="contact_title" class="form-control"
                                                            value="{{ old('contact_title', $intake->contact_title) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Contact Phone</th>
                                                    <td>
                                                        <input type="text" name="contact_phone" class="form-control"
                                                            value="{{ old('contact_phone', $intake->contact_phone) }}">
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
        $(document).ready(function() {

            // Tagify with existing values
            let input = document.querySelector('input[name=treated_areas]');
            let tagify = new Tagify(input);

            tagify.addTags(@json($intake->treatedAreas->map(fn($a) => ['value' => $a->area_name])));

            function resetSection(sectionSelector) {
                $(sectionSelector)
                    .find('input, select')
                    .val('');
            }

            function toggleCasualtySections(value) {

                // Always hide & disable first
                $('#death-section, #illness-section, #police-section')
                    .hide()
                    .find('input, select')
                    .prop('disabled', true);

                // Reset values when switching to NONE
                if (value === 'None' || value === '') {
                    resetSection('#death-section');
                    resetSection('#illness-section');
                    resetSection('#police-section');
                    return;
                }

                if (value === 'Death') {
                    resetSection('#illness-section'); // clear illness if switching
                    $('#death-section, #police-section')
                        .show()
                        .find('input, select')
                        .prop('disabled', false);
                }

                if (value === 'Illness') {
                    resetSection('#death-section'); // clear death if switching
                    $('#illness-section, #police-section')
                        .show()
                        .find('input, select')
                        .prop('disabled', false);
                }
            }

            // On change
            $('select[name="casualties_or_illnesses"]').on('change', function() {
                toggleCasualtySections($(this).val());
            });

            // IMPORTANT: Run once on page load (EDIT)
            toggleCasualtySections($('select[name="casualties_or_illnesses"]').val());

            $("#biological-response-intake-form").validate({
                ignore: [],
                rules: {

                    /* ====================
                       BASIC INFORMATION
                    ==================== */
                    project_name: {
                        required: true
                    },
                    project_address: {
                        required: true
                    },
                    project_city: {
                        required: true
                    },
                    project_state: {
                        required: true
                    },
                    project_zip: {
                        required: true
                    },
                    project_leader: {
                        required: true
                    },
                    comments: {
                        required: true
                    },
                    /* ====================
                       FRONTEND MANAGEMENT
                    ==================== */
                    facility_type: {
                        required: true
                    },
                    casualties_or_illnesses: {
                        required: true
                    },
                    estimated_man_hours: {
                        required: true,
                        number: true
                    },
                    estimated_people: {
                        required: true,
                        number: true
                    },
                    type_of_loss: {
                        required: true
                    },
                    treated_areas: {
                        required: true
                    },

                    /* ====================
                       ADDITIONAL CONTACT
                    ==================== */
                    contact_name: {
                        required: true
                    },
                    contact_title: {
                        required: true
                    },
                    contact_phone: {
                        required: true
                    },

                    /* ====================
                       INSURANCE
                    ==================== */
                    insurance_notified: {
                        required: true
                    },
                    insurance_company_name: {
                        required: true
                    },
                    insurance_phone: {
                        required: true
                    },
                    coverage_determination: {
                        required: true
                    },
                    coverage_amount: {
                        required: true,
                        number: true
                    },
                    deductible: {
                        required: true,
                        number: true
                    },
                    claim_number: {
                        required: true
                    },
                    adjuster_phone: {
                        required: true
                    },
                    insurance_email: {
                        required: true,
                        email: true
                    },
                    limit_or_cap: {
                        required: true,
                        number: true
                    }
                },

                messages: {
                    project_name: "Project name is required.",
                    project_address: "Project address is required.",
                    project_city: "City is required.",
                    project_state: "State is required.",
                    project_zip: "Zip is required.",
                    project_leader: "Project leader is required.",
                    comments: "Comments are required.",

                    facility_type: "Facility type is required.",
                    casualties_or_illnesses: "This field is required.",
                    estimated_man_hours: "Estimated man hours are required.",
                    estimated_people: "Estimated people are required.",
                    type_of_loss: "Type of loss is required.",
                    treated_areas: "Areas to be treated are required.",

                    contact_name: "Contact name is required.",
                    contact_title: "Contact title is required.",
                    contact_phone: "Contact phone is required.",

                    insurance_notified: "Please select an option.",
                    insurance_company_name: "Insurance company is required.",
                    insurance_phone: "Insurance phone is required.",
                    coverage_determination: "Coverage status is required.",
                    coverage_amount: "Coverage amount is required.",
                    deductible: "Deductible is required.",
                    claim_number: "Claim number is required.",
                    adjuster_phone: "Adjuster phone is required.",
                    insurance_email: "Insurance email is required.",
                    limit_or_cap: "Limit / cap is required.",
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

            $('#biological-response-intake-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);

                // Stop if jQuery validation fails
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
                                'Biological response intake saved successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
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
                            'Something went wrong while saving intake.'
                        );
                    }
                });
            });


        });
    </script>
@endpush
