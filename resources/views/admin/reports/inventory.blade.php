@extends('admin.includes.layout')

@section('title', 'Inventory Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>


        /* Report Date Column (light-red/pink background as in image) */
        .col-report-date {
            background-color: #fce8e6 !important;
            color: #c0392b !important;
            font-weight: 500;
        }

        /* Actions Needed Warning Cell */
        .col-actions-warning {
            background-color: #fce8e6 !important;
            color: #c0392b !important;
            font-weight: 500;
        }

        .item-link {
            color: #2563eb !important;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
        }

        .item-link:hover {
            text-decoration: underline;
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

                        <!-- Header matching GermBlast standard layout -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">INVENTORY <span
                                        style="font-size: 24px;">📦</span></h3>
                                <p class="text-muted mb-0">Track stock levels, reorder points, and
                                    required actions.</p>
                            </div>
                            @can('inventory_reporting.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" onclick="openCreateModal()">
                                    + CREATE ITEM
                                </button>
                            </div>
                            @endcan
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Table Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="inventoryTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Report Date</th>
                                            <th>Inventory/Reorder Point</th>
                                            <th>Actions Needed</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            @php
                                                $invVal = $item->inventory_val !== null ? number_format($item->inventory_val, 2) : '';
                                                $reVal = $item->reorder_point_val !== null ? number_format($item->reorder_point_val, 2) : '';
                                                $unit = $item->unit;

                                                // Format point text
                                                $pointText = $invVal . '/' . $reVal;
                                                if ($unit) {
                                                    $pointText .= ' ' . $unit;
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a class="item-link" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        data-unit="{{ $unit ?: '' }}"
                                                        data-inv="{{ $item->inventory_val !== null ? floatval($item->inventory_val) : '' }}"
                                                        data-reorder="{{ $item->reorder_point_val !== null ? floatval($item->reorder_point_val) : '' }}"
                                                        data-office="{{ $item->office }}"
                                                        data-supplier="{{ $item->supplier ?: '' }}"
                                                        data-date="{{ $item->report_date ? $item->report_date->format('Y-m-d') : '' }}"
                                                        data-actions="{{ $item->actions ?: '' }}"
                                                        data-notes="{{ $item->notes ?: '' }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </td>
                                                <td class="col-report-date text-center">
                                                    {{ $item->report_date ? $item->report_date->format('m/d/y') : '' }}
                                                </td>
                                                <td>{{ $pointText }}</td>
                                                <td class="{{ $item->warning ? 'col-actions-warning' : '' }}">
                                                    {{ $item->actions }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @can('inventory_reporting.edit')
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-dark edit-btn me-2"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-unit="{{ $unit ?: '' }}"
                                                            data-inv="{{ $item->inventory_val !== null ? floatval($item->inventory_val) : '' }}"
                                                            data-reorder="{{ $item->reorder_point_val !== null ? floatval($item->reorder_point_val) : '' }}"
                                                            data-office="{{ $item->office }}"
                                                            data-supplier="{{ $item->supplier ?: '' }}"
                                                            data-date="{{ $item->report_date ? $item->report_date->format('Y-m-d') : '' }}"
                                                            data-actions="{{ $item->actions ?: '' }}"
                                                            data-notes="{{ $item->notes ?: '' }}">Edit</button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-item-btn"
                                                            data-url="{{ route('admin.inventory-report.destroy', $item->id) }}">Del</button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Card Modal -->
    <div class="modal fade" id="kanbanCardModal" tabindex="-1" aria-labelledby="kanbanCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="kanbanCardModalLabel">Kanban Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <table class="table table-bordered table-striped mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 40%; background-color: #f8f9fa;">Office</th>
                                <td id="kanban-office"></td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Item</th>
                                <td id="kanban-item"></td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Supplier</th>
                                <td id="kanban-supplier"></td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Reorder Point</th>
                                <td id="kanban-reorder-point"></td>
                            </tr>
                            <tr>
                                <th style="background-color: #f8f9fa;">Reorder Quantity</th>
                                <td id="kanban-reorder-qty"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-2">Misc. Notes</h6>
                        <p id="kanban-notes" class="text-muted mb-0" style="white-space: pre-wrap; font-size: 14px;"></p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Inventory Item Modal -->
    <div class="modal fade" id="addInventoryItemModal" tabindex="-1" aria-labelledby="addInventoryItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="addInventoryItemModalLabel">Create Inventory Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addInventoryItemForm" method="POST" action="{{ route('admin.inventory-report.store') }}"
                        class="company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Item name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="add-item-name" placeholder="Name" class="form-control"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Office Location</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="office" id="add-item-office" value="Lubbock, TX"
                                        placeholder="Office location" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Report Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" name="report_date" id="add-item-report-date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Inventory Level</label>
                                    <input type="number" step="any" min="0" name="inventory_val" id="add-item-inventory-val"
                                        placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Reorder Point</label>
                                    <input type="number" step="any" min="0" name="reorder_point_val"
                                        id="add-item-reorder-point-val" placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Unit</label>
                                    <input type="text" name="unit" id="add-item-unit" placeholder="e.g. Eaches"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" name="supplier" id="add-item-supplier" placeholder="Supplier name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Actions Needed (Custom Alert Text)</label>
                                    <input type="text" name="actions" id="add-item-actions"
                                        placeholder="Leave blank for auto-generated warning message" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" id="add-item-notes" class="form-control" rows="3"
                                        placeholder="Write any notes here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Inventory Item Modal -->
    <div class="modal fade" id="editInventoryItemModal" tabindex="-1" aria-labelledby="editInventoryItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editInventoryItemModalLabel">Edit Inventory Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editInventoryItemForm" method="POST" action="" class="company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Item name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="edit-item-name" placeholder="Name" class="form-control"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Office Location</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="office" id="edit-item-office" value="Lubbock, TX"
                                        placeholder="Office location" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Report Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" name="report_date" id="edit-item-report-date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Inventory Level</label>
                                    <input type="number" step="any" min="0" name="inventory_val" id="edit-item-inventory-val"
                                        placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Reorder Point</label>
                                    <input type="number" step="any" min="0" name="reorder_point_val"
                                        id="edit-item-reorder-point-val" placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Unit</label>
                                    <input type="text" name="unit" id="edit-item-unit" placeholder="e.g. Eaches"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" name="supplier" id="edit-item-supplier" placeholder="Supplier name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Actions Needed (Custom Alert Text)</label>
                                    <input type="text" name="actions" id="edit-item-actions"
                                        placeholder="Leave blank for auto-generated warning message" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" id="edit-item-notes" class="form-control" rows="3"
                                        placeholder="Write any notes here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
        // Store the active item data globally to transfer to edit modal
        let activeItemData = {};

        function openCreateModal() {
            $('#addInventoryItemForm')[0].reset();
            $('#add-item-report-date').val("{{ date('Y-m-d') }}");
            $('#add-item-office').val('Lubbock, TX');
            $('#addInventoryItemModal').modal('show');
        }

        $(document).ready(function () {
            // Initialize DataTable
            $('#inventoryTable').DataTable({
                pageLength: 25,
                ordering: false,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            });

            // Handle Item click to display Kanban Card modal
            $('.item-link').on('click', function () {
                activeItemData = {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    unit: $(this).data('unit'),
                    inv: $(this).data('inv'),
                    reorder: $(this).data('reorder'),
                    office: $(this).data('office'),
                    supplier: $(this).data('supplier'),
                    date: $(this).data('date'),
                    actions: $(this).data('actions'),
                    notes: $(this).data('notes')
                };

                $('#kanban-office').text(activeItemData.office || '');
                $('#kanban-item').text(activeItemData.name || '');
                $('#kanban-supplier').text(activeItemData.supplier || 'N/A');

                const pointText = activeItemData.reorder !== '' ? activeItemData.reorder : '0.00';
                const unitText = activeItemData.unit || 'Eaches';

                $('#kanban-reorder-point').text(pointText + ' ' + unitText);
                $('#kanban-reorder-qty').text(unitText);
                $('#kanban-notes').text(activeItemData.notes || 'Write notes here');

                $('#kanbanCardModal').modal('show');
            });

            // Handle clicking Edit button from the listing table
            $('.edit-btn').on('click', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const unit = $(this).data('unit');
                const inv = $(this).data('inv');
                const reorder = $(this).data('reorder');
                const office = $(this).data('office');
                const supplier = $(this).data('supplier');
                const date = $(this).data('date');
                const actions = $(this).data('actions');
                const notes = $(this).data('notes');

                $('#editInventoryItemForm').attr('action', `/admin/inventory-report/${id}/update`);

                // Fill fields
                $('#edit-item-name').val(name);
                $('#edit-item-office').val(office);
                $('#edit-item-report-date').val(date);
                $('#edit-item-inventory-val').val(inv);
                $('#edit-item-reorder-point-val').val(reorder);
                $('#edit-item-unit').val(unit);
                $('#edit-item-supplier').val(supplier);
                $('#edit-item-actions').val(actions);
                $('#edit-item-notes').val(notes);

                $('#editInventoryItemModal').modal('show');
            });

            // ==========================================
            // Validation & Form Submission (AJAX)
            // ==========================================
            let validationConfig = {
                rules: {
                    name: { required: true },
                    office: { required: true },
                    report_date: { required: true }
                },
                messages: {
                    name: { required: "Please enter item name." },
                    office: { required: "Please enter office location." },
                    report_date: { required: "Please enter report date." }
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
            };

            $("#addInventoryItemForm").validate(validationConfig);
            $("#editInventoryItemForm").validate(validationConfig);

            $('#addInventoryItemForm, #editInventoryItemForm').submit(function(e) {
                e.preventDefault();

                if (!$(this).valid()) {
                    return;
                }

                const modalId = $(this).closest('.modal').attr('id');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#' + modalId).modal('hide');
                        toastr.success(response.message || 'Saved successfully!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong while saving.');
                    }
                });
            });

            // ==========================================
            // AJAX Delete with SweetAlert
            // ==========================================
            $(document).on('click', '.delete-item-btn', function() {
                let url = $(this).data('url');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will permanently delete this inventory item.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                toastr.success(response.message || 'Item deleted successfully.');
                                setTimeout(() => location.reload(), 1000);
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message || 'Something went wrong while deleting.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush