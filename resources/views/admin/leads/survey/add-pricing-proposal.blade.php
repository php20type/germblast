@extends('admin.includes.layout')

@section('title', 'Add Pricing Proposal')

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
            text-align: left !important;
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

                    <form action="#" method="POST" id="add-pricing-form" enctype="multipart/form-data">
                        @csrf

                        <div class="main-content">
                            {{-- HEADER --}}
                            <div class="heading-area-sec mb-3 px-4 pt-4 d-flex justify-content-between align-items-center">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">
                                        Add Pricing Proposal <span style="font-size: 24px;">💰</span>
                                    </h3>
                                    <p class="text-muted mb-0">
                                        Create pricing proposals for the survey
                                    </p>
                                </div>
                                <div class="right-part d-flex align-items-center gap-2">
                                    <a class="btn btn-outline-dark" href="{{ route('admin.lead.survey.proposal', $surveyProposal->lead_id) }}">
                                        <i class="fas fa-arrow-left me-1"></i> Back
                                    </a>
                                </div>
                            </div>

                            <div class="my-4"></div>

                            <div class="dashboard-body px-4 pb-4">

                                <!-- ================================
                                FACILITIES & EQUIPMENT SECTION
                                ================================ -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-card">

                                            <div class="section-header">
                                                <h3 class="section-title">Facilities & Equipment</h3>
                                            </div>

                                            <table class="equipment-report-table align-middle">
                                            <tbody>

                                                <!-- FACILITIES -->
                                                <tr>
                                                    <th style="width:35%">Facilities in Proposal</th>
                                                    <td>
                                                        <select name="facility_ids[]" id="facility_select"
                                                            class="form-control select2" multiple>
                                                            @foreach ($facilities as $facility)
                                                                <option value="{{ $facility->id }}"
                                                                    data-cost="{{ $facility->total_cost }}">
                                                                    {{ $facility->facility_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <!-- EQUIPMENT -->
                                                <tr>
                                                    <th>Equipment Packages in Proposal</th>
                                                    <td>
                                                        <select name="equipment_ids[]" id="equipment_select"
                                                            class="form-control select2" multiple>
                                                            @foreach ($equipments as $equipment)
                                                                <option value="{{ $equipment->id }}"
                                                                    data-cost="{{ $equipment->total_cost }}">
                                                                    {{ $equipment->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <!-- ================================
                            COST BREAKDOWN SECTION
                            ================================ -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Cost Breakdown</h3>
                                        </div>

                                        <table class="equipment-report-table align-middle">
                                            <tbody>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">
                                                        Total Labor Cost for All Areas Included
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Estimated Pricing Total</th>
                                                    <td>
                                                        <input type="text" name="pricing_total" class="form-control"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Partial Cost of Service</th>
                                                    <td>
                                                        <input type="text" name="partial_cost_service"
                                                            class="form-control" value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">Estimated Costs Already
                                                        Included</th>
                                                </tr>

                                                <tr>
                                                    <th>Awareness</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="awareness"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Education</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="education"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Technology</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="technology"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Response</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="response"
                                                            value="" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">
                                                        Estimated Costs Not Included
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Logistics Expense</th>
                                                    <td>
                                                        28.75
                                                        <input type="hidden" name="logistics_expense" value="28.75">
                                                    </td>
                                                </tr>


                                                {{-- Old multiplier (5.882) - replaced 2026-07-24 per verified ICIMatrix value of 3.9
                                                <tr>
                                                    <th>Multiplier</th>
                                                    <td id="multiplier" data-value="5.882">
                                                        5.882
                                                    </td>
                                                </tr>
                                                --}}
                                                <tr>
                                                    <th>Multiplier</th>
                                                    <td id="multiplier" data-value="3.9">
                                                        3.9
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                            <!-- ================================
                            PROPOSAL SETTINGS SECTION
                            ================================ -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Proposal Settings</h3>
                                        </div>

                                        <table class="equipment-report-table align-middle">
                                            <tbody>

                                                <tr>
                                                    <th style="width:35%">Proposal Name<span class="text-danger">*</span>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="proposal_name">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Proposal Order <span class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="number" class="form-control" name="proposal_order" value="0">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Override Pricing<span class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="text" class="form-control" name="override_pricing" value="0.00">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Discounts (%)<span class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="number" class="form-control" name="discounts" value="0.00">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Services<span class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="text" class="form-control" name="services"
                                                            placeholder="Type a service and press Enter">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description<span class="text-danger">*</span></th>
                                                    <td>
                                                        <textarea class="form-control" name="descriptions" rows="2"></textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                            <!-- ================================
                            CONTRACT DETAILS SECTION
                            ================================ -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Contract Details</h3>
                                        </div>

                                        <table class="equipment-report-table align-middle">
                                            <tbody>

                                                <tr>
                                                    <th style="width:35%">Services per Year<span
                                                            class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="services_per_year">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Contract Terms (Years)<span class="text-danger">*</span></th>
                                                    <td>
                                                        <input type="number" class="form-control" name="contract_terms">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Prepayment Discount<span class="text-danger">*</span></th>
                                                    <td>
                                                        <select name="prepayment_discount" class="form-control">
                                                            <option value="">Select Option</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <button type="button" id="savePricingBtn" class="btn btn-success">
                                            Save Pricing Proposal
                                        </button>
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
        function calculatePartialCost() {
            let partial = 0;

            // FACILITY COSTS
            $('#facility_select option:selected').each(function() {
                let cost = parseFloat($(this).data('cost')) || 0;
                partial += cost;
            });

            // EQUIPMENT COSTS
            $('#equipment_select option:selected').each(function() {
                let cost = parseFloat($(this).data('cost')) || 0;
                partial += cost;
            });

            $('input[name="partial_cost_service"]').val(partial.toFixed(2));

            calculateTotal();
        }

        function calculateTotal() {
            let partial = parseFloat($('input[name="partial_cost_service"]').val()) || 0;
            let multiplier = parseFloat($('#multiplier').data('value')) || 0;

            let total = partial * multiplier;

            $('input[name="pricing_total"]').val(total.toFixed(2));

            let awarenessVal = total / 10;
            let educationVal = total / 10;
            let technologyVal = total * 0.015;
            let responseVal = total * 0.09;
            let logisticsVal = 28.75;

            $('input[name="awareness"]').val(awarenessVal.toFixed(2));
            $('input[name="education"]').val(educationVal.toFixed(2));
            $('input[name="technology"]').val(technologyVal.toFixed(2));
            $('input[name="response"]').val(responseVal.toFixed(2));
            $('input[name="logistics_expense"]').val(logisticsVal.toFixed(2));
        }


        // Trigger on select change
        $('#facility_select, #equipment_select').on('change select2:unselect', function() {
            calculatePartialCost();
        });


        $(document).ready(function() {

            var input = document.querySelector('input[name=services]');
            if (input) new Tagify(input);

            /* ---------------------------
               INITIALIZE SELECT2
            ----------------------------*/
            $('#facility_select').select2({
                dropdownParent: $('#add-pricing-form'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });

            $('#equipment_select').select2({
                dropdownParent: $('#add-pricing-form'),
                placeholder: 'Choose...',
                allowClear: true,
                width: '100%'
            });


            $('#savePricingBtn').on('click', function() {
                $('#add-pricing-form').submit();
            });

            $("#add-pricing-form").validate({
                ignore: [],
                rules: {
                    proposal_name: {
                        required: true
                    },
                    proposal_order: {
                        required: true,
                        number: true
                    },
                    override_pricing: {
                        required: true
                    },
                    discounts: {
                        required: true,
                        number: true
                    },
                    descriptions: {
                        required: true
                    },
                    services_per_year: {
                        required: true,
                        number: true
                    },
                    contract_terms: {
                        required: true,
                        number: true
                    },
                    services: {
                        required: true
                    },
                    prepayment_discount: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: el => $(el).addClass('is-invalid'),
                unhighlight: el => $(el).removeClass('is-invalid')
            });

            $('#add-pricing-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-pricing-form').valid()) return;

                $.ajax({
                    url: "{{ route('admin.pricing_proposal.store', $surveyProposal->id) }}",
                    method: "POST",
                    data: $(this).serialize(),

                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Saved!",
                            text: res.message || "Pricing Proposal Saved Successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => window.location.href = "{{ route('admin.lead.survey.proposal', $surveyProposal->lead_id) }}", 2000);
                    },

                    error: function(xhr) {
                        toastr.error("Something went wrong while saving the pricing proposal.");
                        console.log(xhr.responseText);
                    }
                });
            });


        });
    </script>
@endpush



