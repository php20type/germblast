@extends('admin.includes.layout')

@section('title', 'Edit Pricing Proposal')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" id="edit-pricing-form">
                        @csrf

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Edit Pricing Proposal</h1>
                                    <p class="text-muted">Modify the existing pricing proposal</p>
                                </div>

                                <div>
                                    <button type="button" id="updatePricingBtn" class="btn btn-success">
                                        Update Pricing Proposal
                                    </button>
                                </div>
                            </div>

                            <!-- ================================
                                    FACILITIES & EQUIPMENT
                                ================================= -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th style="width:35%">Facilities in Proposal</th>
                                                    <td>
                                                        <select name="facility_ids[]" id="facility_select"
                                                            class="form-control select2" multiple>

                                                            @foreach ($allFacilities as $facility)
                                                                <option value="{{ $facility->id }}"
                                                                    data-cost="{{ $facility->total_cost }}"
                                                                    {{ $pricingProposal->facilities->contains($facility->id) ? 'selected' : '' }}>
                                                                    {{ $facility->facility_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Equipment Packages in Proposal</th>
                                                    <td>
                                                        <select name="equipment_ids[]" id="equipment_select"
                                                            class="form-control select2" multiple>

                                                            @foreach ($allEquipments as $equipment)
                                                                <option value="{{ $equipment->id }}"
                                                                    data-cost="{{ $equipment->total_cost }}"
                                                                    {{ $pricingProposal->equipment->contains($equipment->id) ? 'selected' : '' }}>
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
                                        COST BREAKDOWN
                                ================================= -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">Total Labor Cost for All
                                                        Areas Included</th>
                                                </tr>

                                                <tr>
                                                    <th>Estimated Pricing Total</th>
                                                    <td>
                                                        <input type="text" name="pricing_total" class="form-control"
                                                            value="{{ $pricingProposal->pricing_total ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Partial Cost of Service</th>
                                                    <td>
                                                        <input type="text" name="partial_cost_service"
                                                            class="form-control"
                                                            value="{{ $pricingProposal->partial_cost_service ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">Estimated Costs Already
                                                        Included</th>
                                                </tr>

                                                <tr>
                                                    <th>Awareness</th>
                                                    <td><input type="text" name="awareness" class="form-control"
                                                            value="{{ $pricingProposal->awareness ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Education</th>
                                                    <td><input type="text" name="education" class="form-control"
                                                            value="{{ $pricingProposal->education ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Technology</th>
                                                    <td><input type="text" name="technology" class="form-control"
                                                            value="{{ $pricingProposal->technology ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Response</th>
                                                    <td><input type="text" name="response" class="form-control"
                                                            value="{{ $pricingProposal->response ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" class="bg-light fw-bold">Estimated Costs Not Included
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Logistics Expense</th>
                                                    <td><input type="text" name="logistics_expense" class="form-control"
                                                            value="{{ $pricingProposal->logistics_expense ?? '' }}"></td>
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
                                        PROPOSAL SETTINGS
                                ================================= -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th style="width:35%">Proposal Name *</th>
                                                    <td><input type="text" class="form-control" name="proposal_name"
                                                            value="{{ $pricingProposal->proposal_name ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Proposal Order *</th>
                                                    <td><input type="number" class="form-control" name="proposal_order"
                                                            value="{{ $pricingProposal->proposal_order ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Override Pricing *</th>
                                                    <td><input type="text" class="form-control" name="override_pricing"
                                                            value="{{ $pricingProposal->override_pricing ?? '0.00' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Discounts (%) *</th>
                                                    <td><input type="number" class="form-control" name="discounts"
                                                            value="{{ $pricingProposal->discounts ?? '0.00' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Services *</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="services"
                                                            value='@json(
                                                                $pricingProposal->pricingServices->map(fn($s) => [
                                                                        'value' => $s->service_name,
                                                                    ]))'>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description *</th>
                                                    <td>
                                                        <textarea class="form-control" name="descriptions" rows="2">{{ $pricingProposal->descriptions ?? '' }}</textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <!-- ================================
                                        CONTRACT DETAILS
                                ================================= -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th style="width:35%">Services per Year *</th>
                                                    <td><input type="number" class="form-control"
                                                            name="services_per_year"
                                                            value="{{ $pricingProposal->services_per_year ?? '' }}"
                                                            placeholder="Type a service and press Enter"></td>
                                                </tr>

                                                <tr>
                                                    <th>Contract Terms (Years) *</th>
                                                    <td><input type="number" class="form-control" name="contract_terms"
                                                            value="{{ $pricingProposal->contract_terms ?? '' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Prepayment Discount *</th>
                                                    <td>
                                                        <select name="prepayment_discount" class="form-control">
                                                            <option value="">Select Option</option>
                                                            <option value="1"
                                                                {{ $pricingProposal->prepayment_discount == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="0"
                                                                {{ $pricingProposal->prepayment_discount == 0 ? 'selected' : '' }}>
                                                                No</option>
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

            // Select2
            $('#facility_select, #equipment_select').select2({
                dropdownParent: $('#edit-pricing-form'),
                allowClear: true,
                width: '100%'
            });

            // Validation
            $("#edit-pricing-form").validate({
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
                    prepayment_discount: {
                        required: true
                    },
                    services: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: el => $(el).addClass('is-invalid'),
                unhighlight: el => $(el).removeClass('is-invalid')
            });

            // Submit Button
            $('#updatePricingBtn').on('click', function() {
                $('#edit-pricing-form').submit();
            });

            // AJAX UPDATE
            $('#edit-pricing-form').on('submit', function(e) {
                e.preventDefault();

                if (!$('#edit-pricing-form').valid()) return;

                $.ajax({
                    url: "{{ route('admin.pricing_proposal.update', $pricingProposal->id) }}",
                    method: "POST",
                    data: $(this).serialize(),

                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Updated!",
                            text: res.message ||
                                "Pricing Proposal Updated Successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 2000);
                    },

                    error: function(xhr) {
                        toastr.error("Error updating pricing proposal");
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
