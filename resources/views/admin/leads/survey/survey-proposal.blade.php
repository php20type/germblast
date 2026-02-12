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
                                    @if ($isEditable)
                                        <button type="submit" class="btn btn-success">
                                            Save Survey Proposal
                                        </button>
                                    @elseif (auth()->user()->isSalesManager() && !$isEditable)
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-success" id="approveProposalBtn">
                                                <i class="ti ti-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal">
                                                <i class="ti ti-x me-1"></i> Reject
                                            </button>
                                        </div>
                                    @endif
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
                                                            value="{{ $surveyProposal->company->name ?? '' }}" readonly>
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
                                                            value="{{ $surveyProposal->description ?? '' }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="enrollment"
                                                            value="{{ $surveyProposal->enrollment ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>WADA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="wada" value="{{ $surveyProposal->wada ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ABA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="aba" value="{{ $surveyProposal->aba ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
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
                                                            value="{{ $surveyProposal->distance ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Man Hours</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="man_hours"
                                                            value="{{ $surveyProposal->man_hours ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
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

                                        <textarea class="form-control mb-2" name="specialist_narrative" rows="6" placeholder="Enter narrative here..."
                                            {{ !$isEditable ? 'readonly' : '' }}>{{ $surveyProposal->specialist_narrative ?? '' }}</textarea>

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
                                                @if ($isEditable)
                                                    <a href="{{ route('admin.survey.proposal.facility', $surveyProposal->id) }}"
                                                        class="btn btn-success"target="_blank">
                                                        Add Facility
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary" disabled>
                                                        <i class="ti ti-lock me-1"></i> Add Facility
                                                    </button>
                                                @endif
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
                                                            <td colspan="6" class="text-center text-muted">No
                                                                facilities
                                                                added yet.</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($facilities as $facility)
                                                            <tr>
                                                                {{-- <td>{{ $facility->facility_name }}</td> --}}
                                                                <td>
                                                                    @if ($isEditable)
                                                                        <a href="{{ route('admin.survey.proposal.facility.edit', $facility->id) }}"
                                                                            target="_blank">
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
                                                @if ($isEditable)
                                                    <a href="{{ route('admin.survey.proposal.equipment', $surveyProposal->id) }}"
                                                        class="btn btn-success" target="_blank">
                                                        Add Evaluation
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary" disabled>
                                                        <i class="ti ti-lock me-1"></i> Add Evaluation
                                                    </button>
                                                @endif
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
                                                                    @if ($isEditable)
                                                                        <a href="{{ route('admin.survey.proposal.equipment.edit', $evaluation->id) }}"
                                                                            target="_blank">
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


                            {{-- Pricing Summary --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <!-- SECTION HEADER -->
                                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                                            <h3 class="section-title">Pricing Summary</h3>
                                            @if ($isEditable)
                                                <a href="{{ route('admin.survey.proposal.pricing.proposal', $surveyProposal->id) }}"
                                                    class="btn btn-success" target="_blank">
                                                    Add Pricing Summary
                                                </a>
                                            @else
                                                <button class="btn btn-secondary" disabled>
                                                    <i class="ti ti-lock me-1"></i> Add Pricing Summary
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pricing Proposal List --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Pricing Proposal List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0">
                                                <thead class="bg-light">
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
                                                                            target="_blank">
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

                                        <table class="table table-bordered align-middle" id="proposal_presentation">
                                            <tbody>

                                                <!-- PRICING SELECT -->
                                                <tr>
                                                    <td style="width:35%">Select Pricing Proposals You Want In The Contract
                                                    </td>
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

                                        @php
                                            $viewRoute = route('admin.survey.proposal.view', $surveyProposal->id);
                                            $downloadRoute = route(
                                                'admin.survey.proposal.download',
                                                $surveyProposal->id,
                                            );
                                        @endphp

                                        <div class="d-flex justify-content-end align-items-center">

                                            <a href="#" id="proposalViewBtn" class="btn btn-primary btn-sm mx-2"
                                                target="_blank">
                                                <i class="ti ti-eye me-1"></i> View Proposal
                                            </a>

                                            <a href="#" id="proposalDownloadBtn" class="btn btn-success btn-sm">
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

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Title</th>
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
                                                        <textarea name="supplemental_body" class="form-control" rows="5" {{ !$isEditable ? 'readonly' : '' }}>{{ $surveyProposal->supplemental_body ?? '' }}</textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            {{-- Manager Actions / Suggestions Section --}}
                            <div class="row">
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
                                        {{-- <div id="actionsList">
                                            @if ($proposalActions->isEmpty())
                                                <div class="text-center py-5">
                                                    <i class="ti ti-info-circle display-6 text-muted mb-3"></i>
                                                    <p class="text-muted">No actions or suggestions yet</p>
                                                </div>
                                            @else
                                                <div class="timeline timeline-one-side" data-timeline-content="axis">
                                                    @foreach ($proposalActions as $action)
                                                        <div class="timeline-block">
                                                            <span class="timeline-step badge bg-{{ $action->action_color }}">
                                                                @if ($action->status === 'approved')
                                                                    <i class="ti ti-check"></i>
                                                                @elseif ($action->status === 'rejected')
                                                                    <i class="ti ti-x"></i>
                                                                @else
                                                                    <i class="ti ti-messagecircle"></i>
                                                                @endif
                                                            </span>
                                                            <div class="timeline-content">
                                                                <div class="card border-0 shadow-sm mb-0">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                                            <div>
                                                                                <h6 class="mb-0 fw-bold text-dark">
                                                                                    {{ $action->user->name }}
                                                                                    <span class="badge bg-{{ $action->action_color }} ms-2">
                                                                                        {{ $action->action_label }}
                                                                                    </span>
                                                                                </h6>
                                                                                <small class="text-muted d-block mt-1">
                                                                                    <i class="ti ti-calendar me-1"></i>{{ $action->created_at->format('M d, Y H:i A') }}
                                                                                </small>
                                                                            </div>
                                                                        </div>

                                                                        @if ($action->old_status !== null && $action->new_status !== null)
                                                                            <div class="alert alert-light mb-2 border border-light">
                                                                                <small class="text-muted">
                                                                                    Status changed from <strong>{{ ucfirst(str_replace('_', ' ', $action->old_status)) }}</strong>
                                                                                    to <strong>{{ ucfirst(str_replace('_', ' ', $action->new_status)) }}</strong>
                                                                                </small>
                                                                            </div>
                                                                        @endif

                                                                        @if ($action->comment)
                                                                            <div class="mt-2">
                                                                                <p class="mb-0 text-dark">{{ $action->comment }}</p>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div> --}}

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
                                                                    <i class="ti ti-check"></i>
                                                                @elseif ($action->status === 'rejected')
                                                                    <i class="ti ti-x"></i>
                                                                @else
                                                                    <i class="ti ti-messagecircle"></i>
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
                                <div class="alert alert-warning border-warning d-flex align-items-center mb-3"
                                    role="alert">
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

                        </div>
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
        $(document).ready(function() {

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


            $("#proposalViewBtn").on("click", function(e) {
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

            $("#proposalDownloadBtn").on("click", function(e) {
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
            $('#approveProposalBtn').on('click', function() {
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
                            success: function(res) {
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
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Failed to approve proposal.');
                            }
                        });
                    }
                });
            });

            // Reject Proposal
            $('#submitRejectBtn').on('click', function() {
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
                    success: function(res) {
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
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to reject proposal.');
                    }
                });
            });

        });
    </script>
@endpush
