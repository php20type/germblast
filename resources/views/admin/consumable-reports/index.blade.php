@extends('admin.includes.layout')

@section('title', 'Consumable Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        tr.row-flagged td {
            background-color: #ffe5e5 !important;
            color: #c0392b;
        }

        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: center;
            white-space: nowrap;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Column specific alignment matching original logic */
        .equipment-report-table thead th:nth-child(1),
        .equipment-report-table thead th:nth-child(2),
        .equipment-report-table thead th:nth-child(3),
        .equipment-report-table tbody td:nth-child(1):not(.dataTables_empty),
        .equipment-report-table tbody td:nth-child(2):not(.dataTables_empty),
        .equipment-report-table tbody td:nth-child(3):not(.dataTables_empty) {
            text-align: left !important;
        }

        .dataTables_empty {
            text-align: center !important;
            padding: 50px !important;
            color: #6b7280 !important;
            font-size: 15px !important;
        }

        .compliance-wrapper {
            max-width: 400px;
            margin-top: 30px;
        }

        .compliance-wrapper h6 {
            font-weight: 700;
            font-size: 0.95rem;
            color: #374151;
            margin-bottom: 15px;
            padding-left: 5px;
        }

        .compliance-table {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }

        .compliance-table th,
        .compliance-table td {
            text-align: center;
            font-size: 0.85rem;
            padding: 12px !important;
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
                <!-- Sidebar -->
                @include('admin.corporate-tools.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">

                    <div class="main-content">

                        <div class="sales-dashboard">
                            <!-- Header -->
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">CONSUMABLE REPORT <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Track and analyze consumable usage across your organization.</p>
                                </div>
                                @can('consumable_report.add')
                                <div class="right-part-sec">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                                        + CREATE REPORT
                                    </button>
                                </div>
                                @endcan
                            </div>

                            {{-- Table Card --}}
                            <div class="px-4 pb-4">
                                <table id="consumableTable" class="table table-hover w-100 equipment-report-table">
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
                                                <td>{{ $report->reported_at ? $report->reported_at->format('y-m-d H:i') : '' }}
                                                </td>
                                                <td>{{ $report->leader->name ?? 'Unknown' }}</td>
                                                <td>{{ floatval($report->micro_pre) }}, {{ floatval($report->micro_post) }}</td>
                                                <td>{{ floatval($report->disp_micro_pre) }},
                                                    {{ floatval($report->disp_micro_post) }}</td>
                                                <td>{{ floatval($report->halo_pre) }}, {{ floatval($report->halo_post) }}</td>
                                                <td>{{ floatval($report->opti_pre) }}, {{ floatval($report->opti_post) }}</td>
                                                <td>{{ floatval($report->d2_pre) }}, {{ floatval($report->d2_post) }}</td>
                                                <td>{{ floatval($report->oxi_pre) }}, {{ floatval($report->oxi_post) }}</td>
                                                <td>{{ floatval($report->shld_pre) }}, {{ floatval($report->shld_post) }}</td>
                                                <td>{{ floatval($report->sterl_pre) }}, {{ floatval($report->sterl_post) }}</td>
                                                <td>{{ floatval($report->atp_pre) }}, {{ floatval($report->atp_post) }}</td>
                                                <td>{{ floatval($report->gloves_pre) }}, {{ floatval($report->gloves_post) }}
                                                </td>
                                                <td>{{ floatval($report->water_pre) }}, {{ floatval($report->water_post) }}</td>
                                                <td>{{ floatval($report->rinse_pre) }}, {{ floatval($report->rinse_post) }}</td>
                                                <td>{{ floatval($report->wash_pre) }}, {{ floatval($report->wash_post) }}</td>
                                                <td>{{ floatval($report->rust_pre) }}, {{ floatval($report->rust_post) }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        @can('consumable_report.edit')
                                                        <button class="btn btn-sm btn-outline-dark py-1 px-3 edit-btn me-2"
                                                            style="border-radius: 6px; font-size: 12px; font-weight: 500;"
                                                            data-id="{{ $report->id }}"
                                                            data-company_id="{{ $report->company_id }}"
                                                            data-micro_pre="{{ $report->micro_pre }}"
                                                            data-micro_post="{{ $report->micro_post }}"
                                                            data-disp_micro_pre="{{ $report->disp_micro_pre }}"
                                                            data-disp_micro_post="{{ $report->disp_micro_post }}"
                                                            data-halo_pre="{{ $report->halo_pre }}"
                                                            data-halo_post="{{ $report->halo_post }}"
                                                            data-opti_pre="{{ $report->opti_pre }}"
                                                            data-opti_post="{{ $report->opti_post }}"
                                                            data-d2_pre="{{ $report->d2_pre }}"
                                                            data-d2_post="{{ $report->d2_post }}"
                                                            data-oxi_pre="{{ $report->oxi_pre }}"
                                                            data-oxi_post="{{ $report->oxi_post }}"
                                                            data-shld_pre="{{ $report->shld_pre }}"
                                                            data-shld_post="{{ $report->shld_post }}"
                                                            data-sterl_pre="{{ $report->sterl_pre }}"
                                                            data-sterl_post="{{ $report->sterl_post }}"
                                                            data-atp_pre="{{ $report->atp_pre }}"
                                                            data-atp_post="{{ $report->atp_post }}"
                                                            data-gloves_pre="{{ $report->gloves_pre }}"
                                                            data-gloves_post="{{ $report->gloves_post }}"
                                                            data-water_pre="{{ $report->water_pre }}"
                                                            data-water_post="{{ $report->water_post }}"
                                                            data-rinse_pre="{{ $report->rinse_pre }}"
                                                            data-rinse_post="{{ $report->rinse_post }}"
                                                            data-wash_pre="{{ $report->wash_pre }}"
                                                            data-wash_post="{{ $report->wash_post }}"
                                                            data-rust_pre="{{ $report->rust_pre }}"
                                                            data-rust_post="{{ $report->rust_post }}">Edit</button>
                                                        <form action="{{ url('admin/consumable-reports/delete', $report->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger py-1 px-3"
                                                                style="border-radius: 6px; font-size: 12px; font-weight: 500;">Del</button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Overall Compliance Summary --}}
                            <div class="compliance-wrapper m-4">
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
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
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
