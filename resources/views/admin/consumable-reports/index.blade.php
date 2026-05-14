@extends('admin.includes.layout')

@section('title', 'Consumable Report')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    tr.row-flagged td {
        background-color: #ffe5e5 !important;
        color: #c0392b;
    }
    #consumableTable thead th,
    #consumableTable tbody td {
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
        font-size: 0.82rem;
    }
    #consumableTable thead th:nth-child(1),
    #consumableTable thead th:nth-child(2),
    #consumableTable thead th:nth-child(3),
    #consumableTable tbody td:nth-child(1),
    #consumableTable tbody td:nth-child(2),
    #consumableTable tbody td:nth-child(3) {
        text-align: left;
    }
    .compliance-wrapper {
        max-width: 400px;
        margin-top: 20px;
    }
    .compliance-wrapper h6 {
        font-weight: 700;
        font-size: 0.9rem;
        background: #f0f0f0;
        padding: 6px 10px;
        border: 1px solid #dee2e6;
        border-bottom: none;
        margin: 0;
        text-align: center;
    }
    .compliance-table th,
    .compliance-table td {
        text-align: center;
        font-size: 0.85rem;
    }
    .compliance-table .val-bad {
        color: #e74c3c;
        font-weight: 700;
    }
</style>
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <div class="sales-dashboard">

                    {{-- Header (same pattern as equipment management) --}}
                    <div class="dashboard-header section-card d-flex justify-content-between align-items-center"
                        style="background:#ffb400;">
                        <div class="container-fluid px-0">
                            <h1 class="display-6 mb-0 text-white">Consumable Report</h1>
                        </div>
                        <button class="btn text-white fs-4" data-bs-toggle="modal"
                            data-bs-target="#addInventoryModal" onclick="resetForm()">+</button>
                    </div>

                    {{-- Table Card --}}
                    <div class="section-card mt-3 p-3">

                        <div class="table-responsive">
                            <table id="consumableTable" class="table table-bordered table-hover w-100">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Calendar</th>
                                        <th>Leader</th>
                                        <th>Micro</th>
                                        <th>Disp<br>Micro</th>
                                        <th>Halo</th>
                                        <th>Opti</th>
                                        <th>D2</th>
                                        <th>Oxi</th>
                                        <th>Shld</th>
                                        <th>Sterl</th>
                                        <th>ATP</th>
                                        <th>Gloves</th>
                                        <th>Water</th>
                                        <th>Rinse</th>
                                        <th>Wash</th>
                                        <th>Rust</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->company->name ?? 'Unknown' }}</td>
                                        <td>{{ $report->reported_at ? $report->reported_at->format('y-m-d H:i') : '' }}</td>
                                        <td>{{ $report->leader->name ?? 'Unknown' }}</td>
                                        <td>{{ floatval($report->micro_pre) }}, {{ floatval($report->micro_post) }}</td>
                                        <td>{{ floatval($report->disp_micro_pre) }}, {{ floatval($report->disp_micro_post) }}</td>
                                        <td>{{ floatval($report->halo_pre) }}, {{ floatval($report->halo_post) }}</td>
                                        <td>{{ floatval($report->opti_pre) }}, {{ floatval($report->opti_post) }}</td>
                                        <td>{{ floatval($report->d2_pre) }}, {{ floatval($report->d2_post) }}</td>
                                        <td>{{ floatval($report->oxi_pre) }}, {{ floatval($report->oxi_post) }}</td>
                                        <td>{{ floatval($report->shld_pre) }}, {{ floatval($report->shld_post) }}</td>
                                        <td>{{ floatval($report->sterl_pre) }}, {{ floatval($report->sterl_post) }}</td>
                                        <td>{{ floatval($report->atp_pre) }}, {{ floatval($report->atp_post) }}</td>
                                        <td>{{ floatval($report->gloves_pre) }}, {{ floatval($report->gloves_post) }}</td>
                                        <td>{{ floatval($report->water_pre) }}, {{ floatval($report->water_post) }}</td>
                                        <td>{{ floatval($report->rinse_pre) }}, {{ floatval($report->rinse_post) }}</td>
                                        <td>{{ floatval($report->wash_pre) }}, {{ floatval($report->wash_post) }}</td>
                                        <td>{{ floatval($report->rust_pre) }}, {{ floatval($report->rust_post) }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm py-0 px-2 edit-btn" 
                                                data-id="{{ $report->id }}"
                                                data-company_id="{{ $report->company_id }}"
                                                data-micro_pre="{{ $report->micro_pre }}" data-micro_post="{{ $report->micro_post }}"
                                                data-disp_micro_pre="{{ $report->disp_micro_pre }}" data-disp_micro_post="{{ $report->disp_micro_post }}"
                                                data-halo_pre="{{ $report->halo_pre }}" data-halo_post="{{ $report->halo_post }}"
                                                data-opti_pre="{{ $report->opti_pre }}" data-opti_post="{{ $report->opti_post }}"
                                                data-d2_pre="{{ $report->d2_pre }}" data-d2_post="{{ $report->d2_post }}"
                                                data-oxi_pre="{{ $report->oxi_pre }}" data-oxi_post="{{ $report->oxi_post }}"
                                                data-shld_pre="{{ $report->shld_pre }}" data-shld_post="{{ $report->shld_post }}"
                                                data-sterl_pre="{{ $report->sterl_pre }}" data-sterl_post="{{ $report->sterl_post }}"
                                                data-atp_pre="{{ $report->atp_pre }}" data-atp_post="{{ $report->atp_post }}"
                                                data-gloves_pre="{{ $report->gloves_pre }}" data-gloves_post="{{ $report->gloves_post }}"
                                                data-water_pre="{{ $report->water_pre }}" data-water_post="{{ $report->water_post }}"
                                                data-rinse_pre="{{ $report->rinse_pre }}" data-rinse_post="{{ $report->rinse_post }}"
                                                data-wash_pre="{{ $report->wash_pre }}" data-wash_post="{{ $report->wash_post }}"
                                                data-rust_pre="{{ $report->rust_pre }}" data-rust_post="{{ $report->rust_post }}"
                                            >Edit</button>
                                            <form action="{{ url('admin/consumable-reports/delete', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                @csrf 
                                                <button type="submit" class="btn btn-danger btn-sm py-0 px-2 ms-1">Del</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Overall Compliance Summary --}}
                        <div class="compliance-wrapper">
                            <h6>Overall Compliance</h6>
                            <table class="table table-bordered compliance-table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Good</th>
                                        <th>Bad</th>
                                        <th>Total</th>
                                        <th>Percent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $goodReports }}</td>
                                        <td class="{{ $badReports > 0 ? 'val-bad' : '' }}">{{ $badReports }}</td>
                                        <td>{{ $totalReports }}</td>
                                        <td>{{ $compliancePercentage }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- ADD / EDIT INVENTORY NUMBERS MODAL --}}
{{-- ============================================================ --}}
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h1 class="modal-title" id="addInventoryModalLabel">Add Inventory Numbers</h1>
                <div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <form id="inventoryForm" method="POST" action="{{ url('admin/consumable-reports/store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="row mx-0">

                        {{-- Company Selection --}}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Company</label>
                                <span class="text-danger">*</span>
                                <select name="company_id" id="company_id" class="form-control" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Inventory Items Table --}}
                        <div class="col-lg-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Pre Service</th>
                                            <th>Post Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Microfiber Bins</td>
                                            <td><input type="number" step="any" min="0" name="micro_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="micro_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Disposable Microfiber Packs</td>
                                            <td><input type="number" step="any" min="0" name="disp_micro_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="disp_micro_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Halomist Gallons</td>
                                            <td><input type="number" step="any" min="0" name="halo_pre" class="form-control" value="0.0"></td>
                                            <td><input type="number" step="any" min="0" name="halo_post" class="form-control" value="0.0"></td>
                                        </tr>
                                        <tr>
                                            <td>Opticide Gallons</td>
                                            <td><input type="number" step="any" min="0" name="opti_pre" class="form-control" value="0.0"></td>
                                            <td><input type="number" step="any" min="0" name="opti_post" class="form-control" value="0.0"></td>
                                        </tr>
                                        <tr>
                                            <td>D2 Gallons</td>
                                            <td><input type="number" step="any" min="0" name="d2_pre" class="form-control" value="0.0"></td>
                                            <td><input type="number" step="any" min="0" name="d2_post" class="form-control" value="0.0"></td>
                                        </tr>
                                        <tr>
                                            <td>Oxivir Bottles</td>
                                            <td><input type="number" step="any" min="0" name="oxi_pre" class="form-control" value="0.0"></td>
                                            <td><input type="number" step="any" min="0" name="oxi_post" class="form-control" value="0.0"></td>
                                        </tr>
                                        <tr>
                                            <td>Shield Bottles</td>
                                            <td><input type="number" step="any" min="0" name="shld_pre" class="form-control" value="0.0"></td>
                                            <td><input type="number" step="any" min="0" name="shld_post" class="form-control" value="0.0"></td>
                                        </tr>
                                        <tr>
                                            <td>Sterifab Gallons</td>
                                            <td><input type="number" step="any" min="0" name="sterl_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="sterl_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>ATP Swabs</td>
                                            <td><input type="number" step="any" min="0" name="atp_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="atp_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Gloves (Boxes)</td>
                                            <td><input type="number" step="any" min="0" name="gloves_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="gloves_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Water Gallons</td>
                                            <td><input type="number" step="any" min="0" name="water_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="water_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Rinse Aid</td>
                                            <td><input type="number" step="any" min="0" name="rinse_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="rinse_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash Cleaner</td>
                                            <td><input type="number" step="any" min="0" name="wash_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="wash_post" class="form-control" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td>Rust Inhibitor</td>
                                            <td><input type="number" step="any" min="0" name="rust_pre" class="form-control" value="0"></td>
                                            <td><input type="number" step="any" min="0" name="rust_post" class="form-control" value="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#consumableTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: false,
        responsive: false,
        columnDefs: [
            { orderable: false, targets: -1 },
            { searchable: false, targets: [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17] }
        ],
        language: {
            search: 'Search:',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: {
                previous: 'Previous',
                next: 'Next' 
            }
        }
    });

    // jQuery Validate for the inventory form
    $("#inventoryForm").validate({
        ignore: [],
        rules: {
            company_id: { required: true }
        },
        messages: {
            company_id: { required: "Please select a Company." }
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
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent()); // Inserts after the .input-group
            } else {
                error.insertAfter(element); // Default
            }
        }
    });

    // AJAX Submission
    $('#inventoryForm').submit(function(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');

        if (!$form.valid()) return;

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),

            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
            },

            success: function(response) {
                toastr.success(response.message || 'Report saved successfully!');
                $form[0].reset();
                $('#addInventoryModal').modal('hide');

                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },

            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Something went wrong while saving the report.');
                $submitBtn.prop('disabled', false).text('Save');
            }
        });
    });
    $('.edit-btn').on('click', function() {
        let btn = $(this);
        let id = btn.data('id');
        
        $('#inventoryForm').attr('action', '{{ url('admin/consumable-reports/update') }}/' + id);
        $('#formMethod').val('PUT');
        $('#addInventoryModalLabel').text('Edit Inventory Numbers');

        $('#company_id').val(btn.data('company_id'));
        
        const fields = ['micro', 'disp_micro', 'halo', 'opti', 'd2', 'oxi', 'shld', 'sterl', 'atp', 'gloves', 'water', 'rinse', 'wash', 'rust'];
        
        fields.forEach(field => {
            $('input[name="'+field+'_pre"]').val(btn.data(field+'_pre'));
            $('input[name="'+field+'_post"]').val(btn.data(field+'_post'));
        });

        $('#addInventoryModal').modal('show');
    });
});

function resetForm() {
    $('#inventoryForm').attr('action', '{{ url('admin/consumable-reports/store') }}');
    $('#formMethod').val('POST');
    $('#addInventoryModalLabel').text('Add Inventory Numbers');
    $('#inventoryForm')[0].reset();
}
</script>
@endpush
