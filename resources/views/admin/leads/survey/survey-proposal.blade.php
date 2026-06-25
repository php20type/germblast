@extends('admin.includes.layout')

@section('title', 'Survey Proposal')

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

        /* Legacy Row Styling Mappings */
        .equipment-report-table tbody tr.table-primary td {
            background-color: #cfe2ff !important;
        }

        .equipment-report-table tbody tr.table-warning td {
            background-color: #fff3cd !important;
        }

        .equipment-report-table tbody tr.table-info td {
            background-color: #cff4fc !important;
        }

        .equipment-report-table tbody tr.table-success td {
            background-color: #d1e7dd !important;
        }

        .equipment-report-table tbody tr.table-danger td {
            background-color: #f8d7da !important;
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
            margin-bottom: 20px !important;
        }

        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
        }

        /* Custom Premium Status Badges & Selectors */
        .status-pill {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-pending {
            background-color: rgba(134, 134, 134, 0.12) !important;
            color: #636363 !important;
            border-color: rgba(134, 134, 134, 0.2) !important;
        }

        .status-pill-scheduled {
            background-color: rgba(255, 184, 28, 0.12) !important;
            color: #d39100 !important;
            border-color: rgba(255, 184, 28, 0.25) !important;
        }

        .status-pill-confirmed {
            background-color: rgba(13, 110, 253, 0.12) !important;
            color: #0d6efd !important;
            border-color: rgba(13, 110, 253, 0.2) !important;
        }

        .status-pill-in_progress {
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #926d00 !important;
            border-color: rgba(255, 193, 7, 0.3) !important;
        }

        .status-pill-completed {
            background-color: rgba(6, 150, 151, 0.12) !important;
            color: #069697 !important;
            border-color: rgba(6, 150, 151, 0.25) !important;
        }

        .status-pill-cancelled {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
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

                    <form action="#" method="POST" class="" id="add-survey-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="main-content">
                            {{-- HEADER --}}
                            <div
                                class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">
                                        SURVEY & PROPOSAL <span style="font-size: 24px;">📋</span>
                                    </h3>
                                    <p class="text-muted mb-0">
                                        Record survey results on this page
                                    </p>
                                </div>
                                <div class="right-part d-flex align-items-center gap-2">
                                    @if ($isEditable)
                                        <button type="submit" class="btn btn-success">
                                            Save Survey Proposal
                                        </button>
                                    @elseif (auth()->user()->isSalesManager() || auth()->user()->isSuperAdmin() && !$isEditable && $surveyProposal->status !== 'approved')
                                        <button type="button" class="btn btn-success" id="approveProposalBtn">
                                            <i class="ti ti-check me-1"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            <i class="ti ti-x me-1"></i> Reject
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="my-4"></div>

                            <div class="dashboard-body px-4 pb-4">

                                {{-- District Numbers --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header">
                                                <h3 class="section-title">District Numbers</h3>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width: 30%;">Client</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="client_name"
                                                                    value="{{ $surveyProposal->company->name ?? '' }}"
                                                                    readonly>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Date</th>
                                                            <td>
                                                                <input type="date" class="form-control" name="date"
                                                                    value="{{ isset($surveyProposal->date) ? date('Y-m-d', strtotime($surveyProposal->date)) : '' }}"
                                                                    {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Description</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="description"
                                                                    value="{{ $surveyProposal->description ?? '' }}" {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Enrollment</th>
                                                            <td>
                                                                <input type="number" class="form-control" name="enrollment"
                                                                    value="{{ $surveyProposal->enrollment ?? 0 }}" {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>WADA</th>
                                                            <td>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="wada" value="{{ $surveyProposal->wada ?? 0 }}" {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>ABA</th>
                                                            <td>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    name="aba" value="{{ $surveyProposal->aba ?? 0 }}" {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Recommended Number of Service Technicians</th>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="service_technicians"
                                                                    value="{{ $surveyProposal->service_technicians ?? 0 }}"
                                                                    {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Distance to Client</th>
                                                            <td>
                                                                <input type="number" class="form-control" name="distance"
                                                                    value="{{ $surveyProposal->distance ?? 0 }}" {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Man Hours</th>
                                                            <td>
                                                                <input type="number" class="form-control" name="man_hours"
                                                                    value="{{ $surveyProposal->man_hours ?? 0 }}" {{ !$isEditable ? 'readonly' : '' }}>
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
                                </div>

                                {{-- Site Survey Specialist Narrative --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header">
                                                <div>
                                                    <h3 class="section-title">Site Survey Specialist Narrative</h3>
                                                    <p class="section-subtitle mb-0 mt-1 text-muted">Enter your thoughts on
                                                        the survey. Details are best</p>
                                                </div>
                                            </div>

                                            <textarea class="form-control mb-2" name="specialist_narrative" rows="6"
                                                placeholder="Enter narrative here..." {{ !$isEditable ? 'readonly' : '' }}>{{ $surveyProposal->specialist_narrative ?? '' }}</textarea>

                                            <p class="text-muted small mb-0 mt-2">
                                                Last Updated By:
                                                <strong>Chance Brown</strong>
                                            </p>

                                        </div>
                                    </div>
                                </div>


                                {{-- Facility list --}}
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="section-card">
                                            <div class="section-header d-flex justify-content-between align-items-center">
                                                <h3 class="section-title">Facility List</h3>
                                                <div>
                                                    @if ($isEditable)
                                                        <a href="{{ route('admin.survey.proposal.facility', $surveyProposal->id) }}"
                                                            class="btn btn-sm btn-export" target="_blank">
                                                            Add Facility
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="ti ti-lock me-1"></i> Add Facility
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Facility Type</th>
                                                            <th>Address</th>
                                                            <th>Square Footage</th>
                                                            <th>Man Hours</th>
                                                            <th>Cost</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @if ($facilities->isEmpty())
                                                            <tr>
                                                                <td colspan="7" class="text-center text-muted">No
                                                                    facilities
                                                                    added yet.</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($facilities as $facility)
                                                                <tr>
                                                                    <td>
                                                                        @if ($isEditable)
                                                                            <a href="{{ route('admin.survey.proposal.facility.edit', $facility->id) }}"
                                                                                target="_blank"
                                                                                class="text-decoration-none text-primary">
                                                                                {{ $facility->facility_name }}
                                                                            </a>
                                                                        @else
                                                                            {{ $facility->facility_name }}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ ucfirst($facility->facility_type) }}</td>
                                                                    <td>{{ $facility->address }}</td>
                                                                    <td>{{ $facility->square_footage }}</td>
                                                                    <td>{{ $facility->man_hours }}</td>
                                                                    <td>${{ number_format($facility->man_hours_cost, 2) }}</td>
                                                                    <td>
                                                                        @if ($isEditable)
                                                                            @if(!$facility->is_added_to_company)
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-primary add-to-company-btn"
                                                                                    data-id="{{ $facility->id }}">
                                                                                    Add to Company
                                                                                </button>
                                                                            @else
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-success" disabled>
                                                                                    Added
                                                                                </button>
                                                                            @endif
                                                                        @else
                                                                            <button class="btn btn-secondary btn-sm"
                                                                                disabled>
                                                                                <i class="ti ti-lock me-1"></i> Add to Company
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif

                                                        <tr>
                                                            <th colspan="3" class="text-start">Total</th>
                                                            <th>{{ $totalSquareFootage }}</th>
                                                            <th>{{ number_format($totalFacilityManHours, 2) }}</th>
                                                            <th>${{ number_format($totalFacilityCost, 2) }}</th>
                                                            <th></th>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>


                                {{-- Evaluation List --}}
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="section-card">
                                            <div class="section-header d-flex justify-content-between align-items-center">
                                                <h3 class="section-title">Evaluation List</h3>
                                                <div>
                                                    @if ($isEditable)
                                                        <a href="{{ route('admin.survey.proposal.equipment', $surveyProposal->id) }}"
                                                            class="btn btn-sm btn-export" target="_blank">
                                                            Add Evaluation
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="ti ti-lock me-1"></i> Add Evaluation
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle">
                                                    <thead>
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
                                                                    <td>
                                                                        @if ($isEditable)
                                                                            <a href="{{ route('admin.survey.proposal.equipment.edit', $evaluation->id) }}"
                                                                                target="_blank"
                                                                                class="text-decoration-none text-primary">
                                                                                {{ $evaluation->name }}
                                                                            </a>
                                                                        @else
                                                                            {{ $evaluation->name }}
                                                                        @endif
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


                                {{-- Pricing Proposal List --}}
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="section-card">
                                            <div class="section-header d-flex justify-content-between align-items-center">
                                                <h3 class="section-title">Pricing Proposal List</h3>
                                                <div>
                                                    @if ($isEditable)
                                                        <a href="{{ route('admin.survey.proposal.pricing.proposal', $surveyProposal->id) }}"
                                                            class="btn btn-sm btn-export" target="_blank">
                                                            Add Pricing Summary
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="ti ti-lock me-1"></i> Add Pricing Summary
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Estimated Pricing Total</th>
                                                            <th>Facilities</th>
                                                            <th>Equipments</th>
                                                            <th>Services Per Year</th>
                                                            <th>Contract Terms (Years)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if ($pricingProposals->isEmpty())
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">
                                                                    No pricing proposal added yet.
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($pricingProposals as $pricingProposal)
                                                                <tr>
                                                                    <td>
                                                                        @if ($isEditable)
                                                                            <a href="{{ route('admin.pricing_proposal.edit', $pricingProposal->id) }}"
                                                                                target="_blank"
                                                                                class="text-decoration-none text-primary">
                                                                                {{ $pricingProposal->proposal_name ?? 'Unnamed Proposal' }}
                                                                            </a>
                                                                        @else
                                                                            {{ $pricingProposal->proposal_name ?? 'Unnamed Proposal' }}
                                                                        @endif
                                                                    </td>

                                                                    <td>${{ number_format($pricingProposal->pricing_total ?? 0, 2) }}
                                                                    </td>

                                                                    <td>
                                                                        @if ($pricingProposal->facilities->isNotEmpty())
                                                                            {{ $pricingProposal->facilities->pluck('facility_name')->implode(', ') }}
                                                                        @else
                                                                            <span class="text-muted">None</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        @if ($pricingProposal->equipment->isNotEmpty())
                                                                            {{ $pricingProposal->equipment->pluck('name')->implode(', ') }}
                                                                        @else
                                                                            <span class="text-muted">None</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>{{ $pricingProposal->services_per_year ?? '-' }}</td>

                                                                    <td>{{ $pricingProposal->contract_terms ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>

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

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle"
                                                    id="proposal_presentation">
                                                    <tbody>

                                                        <!-- PRICING SELECT -->
                                                        <tr>
                                                            <th style="width:35%">Select Pricing Proposals You Want In The
                                                                Contract
                                                            </th>
                                                            <td>
                                                                <select name="pricing_proposal_ids[]" id="pricing_select"
                                                                    class="form-control select2" multiple>
                                                                    @foreach ($pricingProposals as $pricing_proposal)
                                                                        <option value="{{ $pricing_proposal->id }}">
                                                                            {{ $pricing_proposal->proposal_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                            @php
                                                $viewRoute = route('admin.survey.proposal.view', $surveyProposal->id);
                                                $downloadRoute = route(
                                                    'admin.survey.proposal.download',
                                                    $surveyProposal->id,
                                                );
                                            @endphp

                                            <div class="d-flex justify-content-end align-items-center mt-3">

                                                <a href="#" id="proposalViewBtn"
                                                    class="btn btn-sm btn-primary mx-2" target="_blank">
                                                    <i class="ti ti-eye me-1"></i> View Proposal
                                                </a>

                                                <a href="#" id="proposalDownloadBtn"
                                                    class="btn btn-sm btn-success">
                                                    <i class="ti ti-download me-1"></i> Download Proposal
                                                </a>

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

                                            <div class="table-responsive">
                                                <table class="equipment-report-table align-middle">
                                                    <tbody>

                                                        <tr>
                                                            <th style="width: 35%">Title</th>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="supplemental_title"
                                                                    value="{{ $surveyProposal->supplemental_title ?? '' }}"
                                                                    {{ !$isEditable ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Body</th>
                                                            <td>
                                                                <textarea name="supplemental_body" class="form-control"
                                                                    rows="5" {{ !$isEditable ? 'readonly' : '' }}>{{ $surveyProposal->supplemental_body ?? '' }}</textarea>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Manager Actions / Suggestions Section --}}
                                <div class="row company-details-section">
                                    <div class="col-md-12">
                                        <div class="section-card">
                                            <div class="section-header">
                                                <h3 class="section-title">
                                                    @if (auth()->user()->isSalesManager())
                                                        Manager Actions & Suggestions
                                                    @else
                                                        Manager Suggestions
                                                    @endif
                                                </h3>
                                            </div>

                                            {{-- Timeline of Actions --}}
                                            <div class="timeline-container">
                                                <div class="timeline position-relative" id="proposalTimeline">

                                                    @if ($proposalActions->isEmpty())
                                                        <div class="text-center py-5">
                                                            <i class="ti ti-info-circle display-6 text-muted mb-3"></i>
                                                            <p class="text-muted">No actions or suggestions yet</p>
                                                        </div>
                                                    @else

                                                        @foreach ($proposalActions as $action)
                                                            <div class="timeline-item">

                                                                {{-- ICON --}}
                                                                <div class="timeline-icon">
                                                                    @if ($action->status === 'approved')
                                                                        <i class="fas fa-check"></i>
                                                                    @elseif ($action->status === 'rejected')
                                                                        <i class="fas fa-times"></i>
                                                                    @else
                                                                        <i class="fas fa-comment"></i>
                                                                    @endif
                                                                </div>

                                                                <div class="timeline-content">

                                                                    {{-- HEADER --}}
                                                                    <div class="timeline-header">
                                                                        <div class="timestamp">
                                                                            {{ $action->created_at->format('g:i A \o\n M j, Y') }}
                                                                        </div>
                                                                    </div>

                                                                    {{-- BODY --}}
                                                                    <div class="timeline-body">

                                                                        <div class="row align-items-start">
                                                                            <div class="col-12">

                                                                                {{-- USER + BADGE --}}
                                                                                <p class="mb-1">
                                                                                    <span class="author-link">
                                                                                        {{ $action->user->name }}
                                                                                    </span>
                                                                                    <span
                                                                                        class="badge bg-{{ $action->action_color }} ms-2">
                                                                                        {{ $action->action_label }}
                                                                                    </span>
                                                                                </p>

                                                                                {{-- STATUS CHANGE --}}
                                                                                @if ($action->old_status !== null && $action->new_status !== null)
                                                                                    <div class="text-muted mb-2">
                                                                                        Status changed from
                                                                                        <strong>{{ ucfirst(str_replace('_', ' ', $action->old_status)) }}</strong>
                                                                                        to
                                                                                        <strong>{{ ucfirst(str_replace('_', ' ', $action->new_status)) }}</strong>
                                                                                    </div>
                                                                                @endif

                                                                                {{-- COMMENT --}}
                                                                                @if ($action->comment)
                                                                                    <div class="comment-box d-flex flex-column">
                                                                                        <div class="comment-text">
                                                                                            {{ $action->comment }}
                                                                                        </div>
                                                                                    </div>
                                                                                @endif


                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @endif

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                @if (!$isEditable)
                                    <div class="alert alert-warning border-warning d-flex align-items-center mb-3" role="alert">
                                        <i class="ti ti-alert-triangle fs-4 me-3"></i>
                                        <div>
                                            <h5 class="alert-heading mb-1">
                                                <i class="ti ti-lock me-1"></i> This Survey Proposal is Locked
                                            </h5>
                                            <p class="mb-0">
                                                <strong>Current Status:</strong>
                                                {{ ucfirst(str_replace('_', ' ', $surveyProposal->status ?? 'Unknown')) }}
                                                <br>
                                                <small>Changes are not allowed until the status is changed to "Draft" or
                                                    "Rejected"
                                                    by management.</small>
                                            </p>
                                        </div>
                                    </div>
                                @endif

                            </div> {{-- dashboard-body closed --}}
                        </div> {{-- main-content closed --}}
                    </form>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>

    {{-- Reject Proposal Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="rejectModalLabel">Reject Proposal</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form id="rejectForm">

                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Reason</label><span class="text-danger">*</span>

                                    <textarea class="form-control" id="rejectComment" name="comment" rows="5" required
                                        placeholder="Please provide a reason for rejection..."></textarea>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="button" class="btn btn-danger" id="submitRejectBtn">
                                Reject Proposal
                            </button>
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

            /* ---------------------------
               INITIALIZE SELECT2
            ----------------------------*/
            $('#pricing_select').select2({
                dropdownParent: $('#proposal_presentation'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            /* ---------------------------
               VALIDATION FOR MAIN SURVEY FORM (unchanged)
            ----------------------------*/
            $("#add-survey-form").validate({
                ignore: [],
                rules: {
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
                highlight: function (el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function (el) {
                    $(el).removeClass('is-invalid');
                }
            });


            /* ---------------------------
               SAVE SURVEY FORM AJAX
            ----------------------------*/
            $('#add-survey-form').submit(function (e) {
                e.preventDefault();

                // Check if proposal is editable
                @if (!$isEditable)
                    Swal.fire({
                        icon: 'error',
                        title: 'Proposal Locked',
                        text: 'This survey proposal is locked and cannot be edited. Current status: {{ ucfirst(str_replace('_', ' ', $surveyProposal->status ?? 'Unknown')) }}',
                    });
                    return false;
                @endif

                        if (!$('#add-survey-form').valid()) return;

                $.ajax({
                    url: "{{ route('admin.lead.survey.proposal.store', $lead->id) }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (res) {
                        Swal.fire({
                            icon: "success",
                            title: "Saved!",
                            text: res.message || "Survey Proposal Saved Successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Proposal Locked',
                                text: xhr.responseJSON?.message ||
                                    'This proposal is locked and cannot be edited.',
                            });
                        } else {
                            toastr.error("Something went wrong while saving the proposal.");
                        }
                        console.log(xhr.responseText);
                    }
                });
            });


            $("#proposalViewBtn").on("click", function (e) {
                e.preventDefault();

                let selected = $('#pricing_select').val();

                if (!selected || selected.length === 0) {
                    toastr.error("Please select at least 1 proposal.");
                    return;
                }

                let url = "{{ route('admin.survey.proposal.view', $surveyProposal->id) }}?pricing_ids=" +
                    selected.join(',');
                window.open(url, "_blank");
            });

            $("#proposalDownloadBtn").on("click", function (e) {
                e.preventDefault();

                let selected = $('#pricing_select').val();

                if (!selected || selected.length === 0) {
                    toastr.error("Please select at least 1 proposal.");
                    return;
                }

                let url =
                    "{{ route('admin.survey.proposal.download', $surveyProposal->id) }}?pricing_ids=" +
                    selected.join(',');
                window.location.href = url;
            });


            /* ---------------------------
               MANAGER SUGGESTION ACTIONS
            ----------------------------*/

            // Approve Proposal
            $('#approveProposalBtn').on('click', function () {
                Swal.fire({
                    title: 'Approve Proposal?',
                    text: 'This will approve the proposal and change its status to "Approved".',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.survey.proposal.approve', $surveyProposal->id) }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Approved!',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                // setTimeout(() => location.reload(), 2000);
                                setTimeout(() => {
                                    window.location.href = res.redirect;
                                }, 1500);

                            },
                            error: function (xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Failed to approve proposal.');
                            }
                        });
                    }
                });
            });

            // Reject Proposal
            $('#submitRejectBtn').on('click', function () {
                const comment = $('#rejectComment').val().trim();

                if (!comment) {
                    toastr.error('Please provide a rejection reason.');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.survey.proposal.reject', $surveyProposal->id) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        comment: comment
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Rejected!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#rejectModal').modal('hide');
                        $('#rejectComment').val('');
                        // setTimeout(() => location.reload(), 2000);
                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 1500);

                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to reject proposal.');
                    }
                });
            });


            $(document).on('click', '.add-to-company-btn', function (e) {
                e.preventDefault(); // extra safety
                let btn = $(this);
                let id = btn.data('id');

                $.ajax({
                    url: `/admin/survey/proposal/facility/${id}/add-to-company`,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        toastr.success(res.message);
                        btn.prop('disabled', true).addClass('btn-success').removeClass('btn-primary').text('Added');

                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                });
            });

        });
    </script>
@endpush