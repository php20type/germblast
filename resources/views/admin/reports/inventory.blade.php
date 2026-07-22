@extends('admin.includes.layout')

@section('title', 'Inventory Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td {
            border-bottom: none !important;
        }

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
                                                            class="btn btn-outline-dark py-1 px-3 edit-btn me-2"
                                                            style="border-radius: 6px; font-size: 12px; font-weight: 500;"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-unit="{{ $unit ?: '' }}"
                                                            data-inv="{{ $item->inventory_val !== null ? floatval($item->inventory_val) : '' }}"
                                                            data-reorder="{{ $item->reorder_point_val !== null ? floatval($item->reorder_point_val) : '' }}"
                                                            data-office="{{ $item->office }}"
                                                            data-supplier="{{ $item->supplier ?: '' }}"
                                                            data-date="{{ $item->report_date ? $item->report_date->format('Y-m-d') : '' }}"
                                                            data-actions="{{ $item->actions ?: '' }}"
                                                            data-notes="{{ $item->notes ?: '' }}">Edit</button>
                                                        <form action="{{ route('admin.inventory-report.destroy', $item->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this inventory item?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger py-1 px-3"
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Card Modal (Serif style matching the image 2) -->
    <div class="modal fade" id="kanbanCardModal" tabindex="-1" aria-labelledby="kanbanCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 0; border: 2px solid #000; font-family: 'Times New Roman', Times, serif; color: #000; background-color: #fff;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"
                        style="filter: grayscale(1);"></button>
                </div>
                <div class="modal-body px-4 pb-4 pt-0">
                    <div class="border border-dark p-2 bg-white mt-3">
                        <h4 class="text-center fw-bold mb-4" style="font-size: 24px;">Kanban Card</h4>

                        <table class="table table-bordered border-dark mb-0 text-dark" style="font-size: 16px;">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" style="width: 45%; padding: 10px 12px; border-color: #000;">Office
                                    </td>
                                    <td id="kanban-office" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="padding: 10px 12px; border-color: #000;">Item</td>
                                    <td id="kanban-item" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="padding: 10px 12px; border-color: #000;">Supplier</td>
                                    <td id="kanban-supplier" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="padding: 10px 12px; border-color: #000;">Reorder Point</td>
                                    <td id="kanban-reorder-point" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="padding: 10px 12px; border-color: #000;">Reorder Quantity
                                    </td>
                                    <td id="kanban-reorder-qty" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center fw-bold py-3"
                                        style="font-size: 18px; border-color: #000;">Details</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center py-4" style="border-color: #000;">
                                        <div class="fw-bold mb-2" style="font-size: 18px;">Misc. Notes</div>
                                        <div id="kanban-notes" class="text-dark" style="font-size: 14px;">Write notes here
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Inventory Item Modal -->
    <div class="modal fade" id="inventoryItemModal" tabindex="-1" aria-labelledby="inventoryItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="inventoryItemModalLabel">Create Inventory Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="inventoryItemForm" method="POST" action="{{ route('admin.inventory-report.store') }}"
                        class="company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Item name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="item-name" placeholder="Name" class="form-control"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Office Location</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="office" id="item-office" value="Lubbock, TX"
                                        placeholder="Office location" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Report Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" name="report_date" id="item-report-date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Inventory Level</label>
                                    <input type="number" step="any" min="0" name="inventory_val" id="item-inventory-val"
                                        placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Reorder Point</label>
                                    <input type="number" step="any" min="0" name="reorder_point_val"
                                        id="item-reorder-point-val" placeholder="0.00" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Unit</label>
                                    <input type="text" name="unit" id="item-unit" placeholder="e.g. Eaches"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" name="supplier" id="item-supplier" placeholder="Supplier name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Actions Needed (Custom Alert Text)</label>
                                    <input type="text" name="actions" id="item-actions"
                                        placeholder="Leave blank for auto-generated warning message" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" id="item-notes" class="form-control" rows="3"
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
            $('#inventoryItemModalLabel').text('Create Inventory Item');
            $('#inventoryItemForm').attr('action', "{{ route('admin.inventory-report.store') }}");
            $('#inventoryItemForm')[0].reset();
            $('#item-report-date').val("{{ date('Y-m-d') }}");
            $('#item-office').val('Lubbock, TX');
            $('#inventoryItemModal').modal('show');
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

                // Show reorder point and quantity
                const pointText = activeItemData.reorder !== '' ? activeItemData.reorder : '0.00';
                const unitText = activeItemData.unit || 'Eaches';

                $('#kanban-reorder-point').text(pointText + ' ' + unitText);
                $('#kanban-reorder-qty').text(unitText);
                $('#kanban-notes').text(activeItemData.notes || 'Write notes here');

                // Update delete form action
                $('#delete-kanban-form').attr('action', `/admin/inventory-report/${activeItemData.id}/delete`);

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

                $('#inventoryItemModalLabel').text('Edit Inventory Item');
                $('#inventoryItemForm').attr('action', `/admin/inventory-report/${id}/update`);

                // Fill fields
                $('#item-name').val(name);
                $('#item-office').val(office);
                $('#item-report-date').val(date);
                $('#item-inventory-val').val(inv);
                $('#item-reorder-point-val').val(reorder);
                $('#item-unit').val(unit);
                $('#item-supplier').val(supplier);
                $('#item-actions').val(actions);
                $('#item-notes').val(notes);

                $('#inventoryItemModal').modal('show');
            });
        });
    </script>
@endpush