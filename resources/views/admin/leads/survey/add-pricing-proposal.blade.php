@extends('admin.includes.layout')

@section('title', 'Add Pricing Proposal')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" id="add-pricing-form" enctype="multipart/form-data">
                        @csrf

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Add Pricing Proposal</h1>
                                    <p class="text-muted">Create pricing proposals for the survey</p>
                                </div>

                                <div>
                                    <button type="button" id="savePricingBtn" class="btn btn-success">Save Pricing
                                        Proposal</button>
                                </div>
                            </div>

                            <!-- ================================
                            FACILITIES & EQUIPMENT SECTION
                            ================================ -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Facilities & Equipment</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
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

                                        <table class="table table-bordered align-middle">
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
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Partial Cost of Service</th>
                                                    <td>
                                                        <input type="text" name="partial_cost_service"
                                                            class="form-control" value="">
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
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Education</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="education"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Technology</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="technology"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Response</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="response"
                                                            value="">
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
                                                        <input type="text" class="form-control" name="logistics_expense"
                                                            value="">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th>Multiplier</th>
                                                    <td id="multiplier" data-value="5.882">
                                                        5.882
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

                                        <table class="table table-bordered align-middle">
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

                                        <table class="table table-bordered align-middle">
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

            // awareness & technology = total / 10
            let splitValue = total / 10;

            $('input[name="awareness"]').val(splitValue.toFixed(2));
            $('input[name="technology"]').val(splitValue.toFixed(2));
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
                        setTimeout(() => location.reload(), 2000);
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
