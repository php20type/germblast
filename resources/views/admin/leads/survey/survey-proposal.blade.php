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
                                                                    <a href="{{ route('admin.survey.proposal.facility.edit', $facility->id) }}"
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
                                                                    <a href="{{ route('admin.survey.proposal.equipment.edit', $evaluation->id) }}"
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
                                            <a href="{{ route('admin.survey.proposal.pricing.proposal', $surveyProposal->id) }}"
                                                class="btn btn-success" target="_blank">
                                                Add Pricing Summary
                                            </a>
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
                                                                    <a href="{{ route('admin.pricing_proposal.edit', $pricingProposal->id) }}"
                                                                        target="_blank">
                                                                        {{ $pricingProposal->proposal_name ?? 'Unnamed Proposal' }}
                                                                    </a>
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
                                                                    {{ $pricing_proposal->proposal_name }}</option>
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

            $('#pricing_select').select2({
                dropdownParent: $('#proposal_presentation'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });


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
                        toastr.error("Something went wrong while saving the proposal.");
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


        });
    </script>
@endpush
