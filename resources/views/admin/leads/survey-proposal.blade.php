@extends('admin.includes.layout')

@section('title', 'Survey Proposal')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" class="" id="add-survey-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Survey & Proposal</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Survey Proposal
                                    </button>
                                </div>
                            </div>

                            {{-- District Numbers --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">District Numbers</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Client</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="client_name"
                                                            value="{{ $surveyProposal->client_name ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ isset($surveyProposal->date) ? date('Y-m-d', strtotime($surveyProposal->date)) : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="{{ $surveyProposal->description ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="enrollment"
                                                            value="{{ $surveyProposal->enrollment ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>WADA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="wada" value="{{ $surveyProposal->wada ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ABA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="aba" value="{{ $surveyProposal->aba ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Recommended Number of Service Technicians</th>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="service_technicians"
                                                            value="{{ $surveyProposal->service_technicians ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Distance to Client</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="distance"
                                                            value="{{ $surveyProposal->distance ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Man Hours</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="man_hours"
                                                            value="{{ $surveyProposal->man_hours ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimate</th>
                                                    <td><span
                                                            class="fw-bold">${{ $surveyProposal->estimate ?? '0.00' }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            {{-- Site Survey Specialist Narrative --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">Site Survey Specialist Narrative</h3>
                                                <p class="section-subtitle">Enter your thoughts on the survey. Details are
                                                    best
                                                </p>
                                            </div>
                                        </div>

                                        <textarea class="form-control mb-2" name="specialist_narrative" rows="6" placeholder="Enter narrative here...">{{ $surveyProposal->specialist_narrative ?? '' }}</textarea>

                                        <p class="text-muted small">
                                            Last Updated By:
                                            <strong>Chance Brown</strong>
                                        </p>

                                    </div>
                                </div>
                            </div>


                            {{-- Create Facility --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Facility</h3>
                                            <div class="text-end">
                                                <a href="{{ route('admin.survey.proposal.facility', $surveyProposal->id) }}"
                                                    class="btn btn-success"target="_blank">
                                                    Add Facility
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Facility list --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Facility Type</th>
                                                        <th>Address</th>
                                                        <th>Square Footage</th>
                                                        <th>Man Hours</th>
                                                        <th>Cost</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @if ($facilities->isEmpty())
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No facilities
                                                                added yet.</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($facilities as $facility)
                                                            <tr>
                                                                {{-- <td>{{ $facility->facility_name }}</td> --}}
                                                                <td>
                                                                    <a href="{{ route('admin.survey.facility.edit', $facility->id) }}"
                                                                        target="_blank">
                                                                        {{ $facility->facility_name }}
                                                                    </a>
                                                                </td>
                                                                <td>{{ ucfirst($facility->facility_type) }}</td>
                                                                <td>{{ $facility->address }}</td>
                                                                <td>{{ $facility->square_footage }}</td>
                                                                <td>{{ $facility->man_hours }}</td>
                                                                <td>${{ number_format($facility->man_hours_cost, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    <tr>
                                                        <th colspan="3" class="text-start">Total</th>
                                                        <th>{{ $totalSquareFootage }}</th>
                                                        <th>{{ number_format($totalFacilityManHours, 2) }}</th>
                                                        <th>${{ number_format($totalFacilityCost, 2) }}</th>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Create Evaluation --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Equipment Evaluation</h3>
                                            <div class="text-end">
                                                <a href="{{ route('admin.survey.proposal.equipment', $surveyProposal->id) }}"
                                                    class="btn btn-success" target="_blank">
                                                    Add Evaluation
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Evaluation List --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Evaluation List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Man Hours (Washing)</th>
                                                        <th>Cost (Washing)</th>
                                                        <th>Man Hours (Cleaning)</th>
                                                        <th>Cost (Cleaning)</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @if ($equipments->isEmpty())
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">
                                                                No equipment evaluations added yet.
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ($equipments as $evaluation)
                                                            <tr>
                                                                {{-- <td>{{ $evaluation->name ?? 'Evaluation' }}</td> --}}
                                                                <td>
                                                                    <a href="{{ route('admin.survey.equipment.edit', $evaluation->id) }}"
                                                                        target="_blank">
                                                                        {{ $evaluation->name }}
                                                                    </a>
                                                                </td>

                                                                <td>{{ $evaluation->wash_man_hours ?? 0 }}</td>
                                                                <td>${{ number_format($evaluation->wash_man_hours_cost ?? 0, 2) }}
                                                                </td>

                                                                <td>{{ $evaluation->cleaning_man_hours ?? 0 }}</td>
                                                                <td>${{ number_format($evaluation->cleaning_man_hours_cost ?? 0, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    <tr>
                                                        <th class="text-start">Total</th>

                                                        <th>{{ number_format($totalWashHours, 2) }}</th>
                                                        <th>${{ number_format($totalWashCost, 2) }}</th>

                                                        <th>{{ number_format($totalCleanHours, 2) }}</th>
                                                        <th>${{ number_format($totalCleanCost, 2) }}</th>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Pricing Summary --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <!-- SECTION HEADER -->
                                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                            <h3 class="section-title">Pricing Summary</h3>

                                            <button type="button" id="createPricingBtn" class="btn btn-success">
                                                Add Pricing Summary
                                            </button>
                                        </div>


                                        <div id="pricing-proposal" style="display:none;" class="p-3 border rounded"
                                            data-survey-id="{{ $surveyProposal->id ?? '' }}" data-pricing-id="">

                                            <!-- PRICING TABLE -->
                                            <table class="table table-bordered align-middle">

                                                <!-- SECTION HEADER -->
                                                <tr class="table-light align-middle">
                                                    <th colspan="2" class="fw-bold">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center w-100">

                                                            <span>Select Facilities & Equipment for Proposal</span>

                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger delete-pricing-btn"
                                                                title="Delete pricing">
                                                                Delete Pricing
                                                            </button>

                                                        </div>
                                                    </th>
                                                </tr>

                                                <!-- FACILITIES SELECT -->
                                                <tr>
                                                    <td style="width:35%">Facilities in Proposal</td>
                                                    <td>
                                                        <select name="facility_ids[]" id="facility_select"
                                                            class="form-control select2" multiple>
                                                            @foreach ($facilities as $facility)
                                                                <option value="{{ $facility->id }}">
                                                                    {{ $facility->facility_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <!-- EQUIPMENT SELECT -->
                                                <tr>
                                                    <td>Equipment Packages in Proposal</td>
                                                    <td>
                                                        <select name="equipment_ids[]" id="equipment_select"
                                                            class="form-control select2" multiple>
                                                            @foreach ($equipments as $equipment)
                                                                <option value="{{ $equipment->id }}">
                                                                    {{ $equipment->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <!-- MAIN TOTAL -->
                                                <tr class="table-light">
                                                    <th colspan="2" class="fw-bold">Total Labor Cost for All Areas
                                                        Included
                                                        in Pricing</th>
                                                </tr>

                                                <tr>
                                                    <td style="width:35%">Estimated Pricing Total</td>
                                                    <td><input type="text" class="form-control" name="pricing_total"
                                                            >
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Partial Cost of Service</td>
                                                    <td><input type="text" class="form-control"
                                                            name="partial_cost_service"></td>
                                                </tr>

                                                <!-- INCLUDED COSTS -->
                                                <tr class="table-light">
                                                    <th colspan="2" class="fw-bold">Estimated Costs Already
                                                        Included in
                                                        Pricing Model</th>
                                                </tr>

                                                <tr>
                                                    <td>Awareness</td>
                                                    <td><input type="text" class="form-control" name="awareness"
                                                            ></td>
                                                </tr>

                                                <tr>
                                                    <td>Education</td>
                                                    <td><input type="text" class="form-control" name="education"
                                                            ></td>
                                                </tr>

                                                <tr>
                                                    <td>Technology</td>
                                                    <td><input type="text" class="form-control" name="technology"
                                                            >
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Response</td>
                                                    <td><input type="text" class="form-control" name="response"
                                                            ></td>
                                                </tr>

                                                <!-- NOT INCLUDED COSTS -->
                                                <tr class="table-light">
                                                    <th colspan="2" class="fw-bold">Estimated Cost Not Included in
                                                        Pricing
                                                        Model</th>
                                                </tr>

                                                <tr>
                                                    <td>Logistics Expense</td>
                                                    <td><input type="text" class="form-control"
                                                            name="logistics_expense">
                                                    </td>
                                                </tr>

                                                <!-- PROPOSAL SETTINGS -->
                                                <tr class="table-light">
                                                    <th colspan="2" class="fw-bold">Proposal Settings</th>
                                                </tr>

                                                <tr>
                                                    <td>Proposal Name
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="text" class="form-control" name="proposal_name">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Proposal Order
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="number" class="form-control" name="proposal_order">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Override Pricing
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                            name="override_pricing">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Discounts (%)
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="text" class="form-control" name="discounts">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Description
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="descriptions" rows="2"></textarea>
                                                    </td>
                                                </tr>

                                                <!-- CONTRACT DETAILS -->
                                                <tr class="table-light">
                                                    <th colspan="2" class="fw-bold">Contract Details</th>
                                                </tr>

                                                <tr>
                                                    <td>Services per Year
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="number" class="form-control"
                                                            name="services_per_year">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Contract Terms (Years)
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td><input type="number" class="form-control" name="contract_terms">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Prepayment Discount
                                                        <span class="text-danger">*</span>
                                                    </td>
                                                    <td>
                                                        <select name="prepayment_discount" class="form-control">
                                                            <option value="">Select Option</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <button type="button" id="saveFullPricingBtn"
                                                            class="btn btn-success">
                                                            Save Pricing Proposal
                                                        </button>
                                                    </td>
                                                </tr>


                                            </table>

                                        </div>

                                        @foreach ($pricingProposals as $pricing)
                                            <div class="pricing-edit-block mt-4 p-3 border rounded"
                                                data-pricing-id="{{ $pricing->id }}">

                                                <table class="table table-bordered align-middle">

                                                    <!-- SECTION HEADER -->
                                                    <tr class="table-light align-middle">
                                                        <th colspan="2" class="fw-bold p-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center w-100">
                                                                <span>Edit Pricing Proposal — #{{ $pricing->id }}</span>

                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger delete-pricing-btn"
                                                                    data-id="{{ $pricing->id }}">
                                                                    Delete Pricing
                                                                </button>
                                                            </div>
                                                        </th>
                                                    </tr>

                                                    <!-- FACILITIES -->
                                                    <tr>
                                                        <td style="width:35%">Facilities in Proposal</td>
                                                        <td>
                                                            <select class="form-control select2 facility-select" multiple
                                                                data-id="{{ $pricing->id }}">
                                                                @foreach ($facilities as $facility)
                                                                    <option value="{{ $facility->id }}"
                                                                        {{ in_array($facility->id, $pricing->facilities->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                                        {{ $facility->facility_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <!-- EQUIPMENT -->
                                                    <tr>
                                                        <td>Equipment Packages in Proposal</td>
                                                        <td>
                                                            <select class="form-control select2 equipment-select" multiple
                                                                data-id="{{ $pricing->id }}">
                                                                @foreach ($equipments as $equipment)
                                                                    <option value="{{ $equipment->id }}"
                                                                        {{ in_array($equipment->id, $pricing->equipment->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                                        {{ $equipment->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <!-- TOTALS -->
                                                    <tr class="table-light">
                                                        <th colspan="2">Calculated Totals</th>
                                                    </tr>

                                                    <tr>
                                                        <td>Estimated Pricing Total</td>
                                                        <td><input type="text" class="form-control pricing-total"
                                                                value="{{ $pricing->pricing_total ?? '' }}" readonly></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Partial Cost of Service</td>
                                                        <td><input type="text" class="form-control partial-cost"
                                                                value="{{ $pricing->partial_cost_service ?? '' }}"
                                                                readonly></td>
                                                    </tr>

                                                    <!-- INCLUDED COSTS -->
                                                    <tr class="table-light">
                                                        <th colspan="2">Included Costs</th>
                                                    </tr>

                                                    <tr>
                                                        <td>Awareness</td>
                                                        <td><input type="text" class="form-control"
                                                                value="{{ $pricing->awareness ?? '' }}" readonly></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Education</td>
                                                        <td><input type="text" class="form-control"
                                                                value="{{ $pricing->education ?? '' }}" readonly></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Technology</td>
                                                        <td><input type="text" class="form-control"
                                                                value="{{ $pricing->technology ?? '' }}" readonly></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Response</td>
                                                        <td><input type="text" class="form-control"
                                                                value="{{ $pricing->response ?? '' }}" readonly></td>
                                                    </tr>

                                                    <!-- NOT INCLUDED -->
                                                    <tr class="table-light">
                                                        <th colspan="2">Not Included</th>
                                                    </tr>

                                                    <tr>
                                                        <td>Logistics Expense</td>
                                                        <td><input type="text" class="form-control"
                                                                value="{{ $pricing->logistics_expense ?? '' }}" readonly>
                                                        </td>
                                                    </tr>

                                                    <!-- PROPOSAL SETTINGS -->
                                                    <tr class="table-light">
                                                        <th colspan="2">Proposal Settings</th>
                                                    </tr>

                                                    <tr>
                                                        <td>Proposal Name *</td>
                                                        <td><input type="text" class="form-control proposal_name"
                                                                value="{{ $pricing->proposal_name ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Proposal Order *</td>
                                                        <td><input type="number" class="form-control proposal_order"
                                                                value="{{ $pricing->proposal_order ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Override Pricing</td>
                                                        <td><input type="text" class="form-control override_pricing"
                                                                value="{{ $pricing->override_pricing ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Discounts (%) *</td>
                                                        <td><input type="text" class="form-control discounts"
                                                                value="{{ $pricing->discounts ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Description *</td>
                                                        <td>
                                                            <textarea class="form-control descriptions" rows="2">{{ $pricing->descriptions ?? '' }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <!-- CONTRACT DETAILS -->
                                                    <tr class="table-light">
                                                        <th colspan="2">Contract Details</th>
                                                    </tr>

                                                    <tr>
                                                        <td>Services per Year *</td>
                                                        <td><input type="number" class="form-control services_per_year"
                                                                value="{{ $pricing->services_per_year ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Contract Terms (Years) *</td>
                                                        <td><input type="number" class="form-control contract_terms"
                                                                value="{{ $pricing->contract_terms ?? '' }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Prepayment Discount *</td>
                                                        <td>
                                                            <select class="form-control prepayment_discount">
                                                                <option value="">Select Option</option>
                                                                <option value="1"
                                                                    {{ $pricing->prepayment_discount == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="0"
                                                                    {{ $pricing->prepayment_discount == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <!-- SAVE BUTTON -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="button"
                                                                class="btn btn-primary saveExistingPricingBtn"
                                                                data-id="{{ $pricing->id }}">
                                                                Update Pricing Proposal
                                                            </button>
                                                        </td>
                                                    </tr>

                                                </table>

                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>


                            {{-- Presentation --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Presentation</h3>
                                        </div>

                                        <table class="table table-bordered align-middle" id="proposal_presentation">
                                            <tbody>

                                                <!-- PRICING SELECT -->
                                                <tr>
                                                    <td style="width:35%">Select Pricing Proposals You Want In The Contract</td>
                                                    <td>
                                                        <select name="pricing_proposal_ids[]" id="pricing_select"
                                                            class="form-control select2" multiple>
                                                            @foreach ($pricingProposals as $pricing_proposal)
                                                                <option value="{{ $pricing_proposal->id }}">
                                                                    {{ $pricing_proposal->proposal_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <div class="btn btn-success">
                                            View Proposal
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Supplemental Offer --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Supplemental Offer</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Title</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="supplemental_title"
                                                            value="{{ $surveyProposal->supplemental_title ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Body</th>
                                                    <td>
                                                        <textarea name="supplemental_body" class="form-control" rows="5">{{ $surveyProposal->supplemental_body ?? '' }}</textarea>
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
        $(document).ready(function() {

            /* ---------------------------
               INITIALIZE SELECT2
            ----------------------------*/
            $('#facility_select').select2({
                dropdownParent: $('#pricing-proposal'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#equipment_select').select2({
                dropdownParent: $('#pricing-proposal'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

             $('#pricing_select').select2({
                dropdownParent: $('#proposal_presentation'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            /* ---------------------------
               CREATE NEW EMPTY PRICING PROPOSAL
            ----------------------------*/
            $('#createPricingBtn').on('click', function() {

                let surveyId = $('#pricing-proposal').data('survey-id');

                $.ajax({
                    url: '/admin/pricing-proposal/create-empty',
                    type: 'POST',
                    data: {
                        survey_proposal_id: surveyId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {

                        // attach id to div
                        $('#pricing-proposal').attr('data-pricing-id', res.pricing_id);

                        // show form
                        $('#pricing-proposal').slideDown();

                        Swal.fire({
                            icon: "success",
                            title: "Created!",
                            text: "Pricing Proposal Created.",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });


            /* ---------------------------
            VALIDATION FOR PRICING FORM
            ----------------------------*/
            function validatePricingFields() {
                let isValid = true;

                // Required Fields
                if (!$('input[name="proposal_name"]').val()) isValid = false;
                if (!$('input[name="proposal_order"]').val()) isValid = false;
                if (!$('input[name="discounts"]').val()) isValid = false;
                if (!$('textarea[name="descriptions"]').val()) isValid = false;
                if (!$('input[name="services_per_year"]').val()) isValid = false;
                if (!$('input[name="contract_terms"]').val()) isValid = false; // FIXED
                if (!$('select[name="prepayment_discount"]').val()) isValid = false;

                // At least one facility or equipment
                let facilities = $('#facility_select').val() || [];
                let equipment = $('#equipment_select').val() || [];

                if (facilities.length === 0 && equipment.length === 0) isValid = false;

                return isValid;
            }


            /* ---------------------------
               SAVE FULL PRICING PROPOSAL
            ----------------------------*/
            $('#saveFullPricingBtn').on('click', function() {

                if (!validatePricingFields()) {
                    toastr.error("Please input required fields.");
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to save this pricing proposal?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, save",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    let pricingId = $('#pricing-proposal').data('pricing-id');

                    $.ajax({
                        url: '/admin/pricing-proposal/save-full',
                        type: 'POST',
                        data: {
                            pricing_proposal_id: pricingId,

                            facility_ids: $('#facility_select').val() || [],
                            equipment_ids: $('#equipment_select').val() || [],

                            proposal_name: $('input[name="proposal_name"]').val(),
                            proposal_order: $('input[name="proposal_order"]').val(),
                            override_pricing: $('input[name="override_pricing"]').val(),
                            discounts: $('input[name="discounts"]').val(),
                            descriptions: $('textarea[name="descriptions"]').val(),

                            services_per_year: $('input[name="services_per_year"]').val(),
                            contract_terms: $('input[name="contract_terms"]').val(),
                            prepayment_discount: $('select[name="prepayment_discount"]')
                                .val(),

                            _token: $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(res) {
                            Swal.fire({
                                icon: "success",
                                title: "Saved Successfully!",
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },

                        error: function(xhr) {
                            let msg = "Something went wrong.";

                            // Laravel validation or custom error message
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Error Saving",
                                text: msg
                            });
                        }
                    });
                });
            });



            $(document).on("click", ".saveExistingPricingBtn", function() {
                let id = $(this).data("id");
                let block = $(this).closest(".pricing-edit-block");

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to update this pricing proposal?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, update",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: "/admin/pricing-proposal/update",
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                            id: id,

                            facility_ids: block.find(".facility-select").val() || [],
                            equipment_ids: block.find(".equipment-select").val() || [],

                            proposal_name: block.find(".proposal_name").val(),
                            proposal_order: block.find(".proposal_order").val(),
                            override_pricing: block.find(".override_pricing").val(),
                            discounts: block.find(".discounts").val(),
                            descriptions: block.find(".descriptions").val(),

                            services_per_year: block.find(".services_per_year").val(),
                            contract_terms: block.find(".contract_terms").val(),
                            prepayment_discount: block.find(".prepayment_discount").val(),
                        },

                        success: function(res) {
                            Swal.fire({
                                icon: "success",
                                title: "Updated Successfully!",
                                timer: 1200,
                                showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });
                        },

                        error: function(xhr) {
                            let msg = "Update failed!";

                            // If Laravel validation or error exists
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: msg,
                            });
                        },
                    });
                });
            });

            $(document).on("click", ".delete-pricing-btn", function() {
                let btn = $(this);

                // Priority 1: Edit mode (button contains data-id)
                let pricingId = btn.data("id");

                // Priority 2: Create mode (id stored in #pricing-proposal)
                if (!pricingId) {
                    pricingId = $("#pricing-proposal").data("pricing-id");
                }

                // Still not found?
                if (!pricingId) {
                    Swal.fire({
                        icon: "error",
                        title: "No Pricing Found",
                        text: "Cannot delete — pricing ID is missing."
                    });
                    return;
                }

                Swal.fire({
                    title: "Delete Pricing?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: "/admin/pricing-proposal/delete",
                        type: "POST",
                        data: {
                            id: pricingId,
                            _token: $('meta[name="csrf-token"]').attr("content")
                        },

                        success: function() {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },

                        error: function(xhr) {
                            let msg = "Failed to delete pricing.";

                            if (xhr.responseJSON?.message) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: msg
                            });
                        }
                    });
                });
            });


            /* ---------------------------
               VALIDATION FOR MAIN SURVEY FORM (unchanged)
            ----------------------------*/
            $("#add-survey-form").validate({
                ignore: [],
                rules: {
                    client_name: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    enrollment: {
                        required: true,
                        number: true
                    },
                    wada: {
                        required: true,
                        number: true
                    },
                    aba: {
                        required: true,
                        number: true
                    },
                    service_technicians: {
                        required: true,
                        number: true
                    },
                    distance: {
                        required: true,
                        number: true
                    },
                    man_hours: {
                        required: true,
                        number: true
                    },
                    specialist_narrative: {
                        required: true
                    },
                    supplemental_title: {
                        required: true
                    },
                    supplemental_body: {
                        required: true
                    }
                },
                messages: {},
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                }
            });


            /* ---------------------------
               SAVE SURVEY FORM AJAX
            ----------------------------*/
            $('#add-survey-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-survey-form').valid()) return;

                $.ajax({
                    url: "{{ route('admin.leads.survey.proposal.store', $lead->id) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Saved!",
                            text: res.message || "Survey Proposal Saved Successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        toastr.error("Something went wrong while saving the proposal.");
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endpush
