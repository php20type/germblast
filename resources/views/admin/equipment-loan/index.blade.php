@extends('admin.includes.layout')

@section('title', 'Equipment Loan/Rental')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Equipment Report Table Boxed Styling from EQ */
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

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px !important;
        }

        /* Status Badge from Reference */
        .status-pill {
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .status-pill-available {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pill-checkedout {
            background: #fce8e6;
            color: #c53030;
        }

        .status-pill-sold {
            background: #f3f4f6;
            color: #374151;
        }

        .status-pill-lost {
            background: #eef0f2;
            color: #4b5563;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        


                        <!-- Header Area -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">EQUIPMENT LOAN/RENTAL <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">Track and manage equipment checkout, returns, and sales.</p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddEquipmentModal">
                                    + CREATE EQUIPMENT
                                </button>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="equipmentLoanTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Equipment</th>
                                            <th>Serial Number</th>
                                            <th>Status</th>
                                            <th>Location / Rental Info</th>
                                            <th class="text-center" style="width: 150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipments as $eq)
                                            <tr>
                                                <td class="fw-semibold text-dark">{{ $eq->name }}</td>
                                                <td class="text-secondary">{{ $eq->serial_number }}</td>
                                                <td>
                                                    @if ($eq->status === 'available')
                                                        <span class="status-pill status-pill-available">Available for Checkout</span>
                                                    @elseif ($eq->status === 'processed')
                                                        <span class="status-pill status-pill-checkedout">Checked Out / In Process</span>
                                                    @elseif ($eq->status === 'sold')
                                                        <span class="status-pill status-pill-sold">Sold to Client</span>
                                                    @elseif ($eq->status === 'lost')
                                                        <span class="status-pill status-pill-lost">Lost</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($eq->status === 'available')
                                                        <span class="text-success small fw-semibold"><i class="fa-solid fa-circle-check"></i> Ready for loaning</span>
                                                    @elseif ($eq->status === 'processed')
                                                        <div class="fw-bold text-dark mb-1">{{ $eq->company->name ?? '—' }}</div>
                                                        <div class="text-muted small mb-1">Checked out by: {{ $eq->checkedOutBy->name ?? '—' }}</div>
                                                        <div class="text-danger small fw-semibold">Due back: {{ $eq->due_date ? $eq->due_date->format('m/d/y') : '—' }}</div>
                                                    @elseif ($eq->status === 'sold')
                                                        <div class="text-secondary fw-bold mb-1">Sold to Client</div>
                                                        <div class="text-muted small">Purchased by: {{ $eq->company->name ?? '—' }}</div>
                                                    @elseif ($eq->status === 'lost')
                                                        <div class="text-danger fw-bold mb-1">Lost</div>
                                                        <div class="text-muted small">Status updated: {{ $eq->updated_at->format('m/d/y') }}</div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($eq->status === 'available')
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-process-checkout" 
                                                                style="border-radius: 6px; padding: 6px 14px;"
                                                                data-id="{{ $eq->id }}" 
                                                                data-name="{{ $eq->name }}" 
                                                                data-serial="{{ $eq->serial_number }}">
                                                            Process
                                                        </button>
                                                    @elseif ($eq->status === 'processed')
                                                        <button class="btn btn-sm btn-outline-dark me-2 btn-process-disposition"
                                                                style="border-radius: 6px; padding: 6px 14px;"
                                                                data-id="{{ $eq->id }}"
                                                                data-name="{{ $eq->name }}"
                                                                data-serial="{{ $eq->serial_number }}"
                                                                data-company="{{ $eq->company->name ?? '—' }}"
                                                                data-user="{{ $eq->checkedOutBy->name ?? '—' }}"
                                                                data-due="{{ $eq->due_date ? $eq->due_date->format('m/d/y') : '—' }}">
                                                            Process
                                                        </button>
                                                    @else
                                                        <span class="text-muted small">—</span>
                                                    @endif
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

    <!-- Modal: Add Equipment -->
    <div class="modal fade" id="AddEquipmentModal" tabindex="-1" aria-labelledby="AddEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="AddEquipmentModalLabel">Create New Equipment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.equipment-loan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Equipment Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. 5000Pro, Air Oasis" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Serial Number</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="serial_number" class="form-control" placeholder="e.g. 21918004" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Checkout Equipment -->
    <div class="modal fade" id="CheckoutEquipmentModal" tabindex="-1" aria-labelledby="CheckoutEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="CheckoutEquipmentModalLabel">Process Checkout</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="checkout-form" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="p-3 bg-light rounded border mb-3">
                                    <div class="mb-1"><span class="fw-semibold text-muted">Equipment:</span> <span class="eq-name fw-bold text-dark"></span></div>
                                    <div><span class="fw-semibold text-muted">Serial:</span> <span class="eq-serial fw-bold text-dark"></span></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Company</label>
                                    <span class="text-danger">*</span>
                                    <select id="checkout-company" name="company_id" class="form-select" required>
                                        <option value="">-- Select Company --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Complete Checkout</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Disposition Equipment -->
    <div class="modal fade" id="DispositionEquipmentModal" tabindex="-1" aria-labelledby="DispositionEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="DispositionEquipmentModalLabel">Process Equipment Disposition</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="disposition-form" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="p-3 bg-light rounded border mb-3" style="font-size: 13px;">
                                    <div class="mb-1"><span class="fw-semibold text-muted">Equipment:</span> <span class="eq-name fw-bold text-dark"></span></div>
                                    <div class="mb-1"><span class="fw-semibold text-muted">Serial:</span> <span class="eq-serial fw-bold text-dark"></span></div>
                                    <div class="mb-1"><span class="fw-semibold text-muted">Company:</span> <span class="eq-company fw-bold text-dark"></span></div>
                                    <div class="mb-1"><span class="fw-semibold text-muted">Checked Out By:</span> <span class="eq-user fw-bold text-dark"></span></div>
                                    <div><span class="fw-semibold text-muted">Due Back Date:</span> <span class="eq-due fw-bold text-danger"></span></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Disposition Action</label>
                                    <span class="text-danger">*</span>
                                    <select name="action" class="form-select" required>
                                        <option value="">-- Select Disposition Action --</option>
                                        <option value="check_in">Check In (Returns to Available)</option>
                                        <option value="sell">Sell to Client (Updates to Sold)</option>
                                        <option value="lost">Mark as Lost (Updates to Lost)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Disposition</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
            // Initialize DataTable
            $('#equipmentLoanTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                responsive: false,
                columnDefs: [
                    { orderable: false, targets: -1 }
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

            // Trigger checkout modal values
            $('.btn-process-checkout').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const serial = $(this).data('serial');

                const modal = $('#CheckoutEquipmentModal');
                modal.find('.eq-name').text(name);
                modal.find('.eq-serial').text(serial);
                modal.find('#checkout-company').val('');
                
                // Set action
                modal.find('form').attr('action', `/admin/equipment-loan/${id}/checkout`);
                modal.modal('show');
            });

            // Trigger disposition modal values
            $('.btn-process-disposition').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const serial = $(this).data('serial');
                const company = $(this).data('company');
                const user = $(this).data('user');
                const due = $(this).data('due');

                const modal = $('#DispositionEquipmentModal');
                modal.find('.eq-name').text(name);
                modal.find('.eq-serial').text(serial);
                modal.find('.eq-company').text(company);
                modal.find('.eq-user').text(user);
                modal.find('.eq-due').text(due);

                // Set action
                modal.find('form').attr('action', `/admin/equipment-loan/${id}/disposition`);
                modal.modal('show');
            });
        });
    </script>
@endpush
