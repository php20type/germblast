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
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        
                        <!-- Header matching GermBlast standard layout -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">INVENTORY <span style="font-size: 24px;">📦</span></h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">Track stock levels, reorder points, and required actions.</p>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            @php
                                                $invVal = $item['inventory_val'];
                                                $reVal = $item['reorder_point_val'];
                                                $unit = $item['unit'];
                                                
                                                // Format point text
                                                $pointText = $invVal . '/' . $reVal;
                                                if ($unit) {
                                                    $pointText .= ' ' . $unit;
                                                }
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a class="item-link" 
                                                       data-name="{{ $item['name'] }}"
                                                       data-unit="{{ $unit ?: 'Eaches' }}"
                                                       data-inv="{{ $invVal !== '' ? $invVal : '0.00' }}"
                                                       data-reorder="{{ $reVal !== '' ? $reVal : 'Eaches' }}"
                                                       data-office="{{ $item['office'] }}"
                                                       data-supplier="{{ $item['supplier'] ?: '' }}">
                                                       {{ $item['name'] }}
                                                    </a>
                                                </td>
                                                <td class="col-report-date text-center">{{ $item['report_date'] }}</td>
                                                <td>{{ $pointText }}</td>
                                                <td class="{{ $item['warning'] ? 'col-actions-warning' : '' }}">
                                                    {{ $item['actions'] }}
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
            <div class="modal-content" style="border-radius: 0; border: 2px solid #000; font-family: 'Times New Roman', Times, serif; color: #000; background-color: #fff;">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close" style="filter: grayscale(1);"></button>
                </div>
                <div class="modal-body px-4 pb-4 pt-0">
                    <div class="border border-dark p-2 bg-white">
                        <h4 class="text-center fw-bold mb-4" style="font-size: 24px;">Kanban Card</h4>
                        
                        <table class="table table-bordered border-dark mb-0 text-dark" style="font-size: 16px;">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" style="width: 45%; padding: 10px 12px; border-color: #000;">Office</td>
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
                                    <td class="fw-bold" style="padding: 10px 12px; border-color: #000;">Reorder Quantity</td>
                                    <td id="kanban-reorder-qty" style="padding: 10px 12px; border-color: #000;"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center fw-bold py-3" style="font-size: 18px; border-color: #000;">Details</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center py-4" style="border-color: #000;">
                                        <div class="fw-bold mb-2" style="font-size: 18px;">Misc. Notes</div>
                                        <div class="text-dark" style="font-size: 14px;">Write notes here</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                const name = $(this).data('name');
                const unit = $(this).data('unit');
                const inv = $(this).data('inv');
                const reorder = $(this).data('reorder');
                const office = $(this).data('office');
                const supplier = $(this).data('supplier');

                $('#kanban-office').text(office);
                $('#kanban-item').text(name);
                $('#kanban-supplier').text(supplier);
                $('#kanban-reorder-point').text(unit);
                $('#kanban-reorder-qty').text(unit);

                $('#kanbanCardModal').modal('show');
            });
        });
    </script>
@endpush
