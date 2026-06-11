@extends('admin.includes.layout')

@section('title', 'Invoices')

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

        .status-pill-draft {
            background: #f3f4f6;
            color: #4b5563;
        }

        .status-pill-sent {
            background: #eef2ff;
            color: #4f46e5;
        }

        .status-pill-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pill-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Action Buttons */
        .action-btn {
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
        }

        .action-btn-pdf {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .action-btn-pdf:hover {
            background-color: #fca5a5;
            color: #b91c1c;
        }

        .action-btn-csv {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .action-btn-csv:hover {
            background-color: #a7f3d0;
            color: #047857;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">INVOICES REPORT <span style="font-size: 24px;">📄</span></h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">Track and view all generated invoices across your organization.</p>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        <!-- Table Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="invoicesTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Company</th>
                                            <th>Invoice Date</th>
                                            <th>Due Date</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 180px;">Downloads</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>
                                                    <strong>{{ $invoice->invoice_no ?? 'N/A' }}</strong>
                                                </td>
                                                <td>
                                                    @if (isset($invoice->serviceOrder->service->lead->company->id))
                                                        <a href="{{ route('admin.company.show', $invoice->serviceOrder->service->lead->company->id) }}" class="text-decoration-none text-dark">
                                                            {{ $invoice->serviceOrder->service->lead->company->name }}
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                    @if (isset($invoice->serviceOrder->order_no))
                                                        <div class="small text-muted mt-1" style="font-size: 12px;">
                                                            Order #{{ $invoice->serviceOrder->order_no }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $invoice->invoice_date ? $invoice->invoice_date->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $invoice->total_amount ? '$' . number_format($invoice->total_amount, 2) : '$0.00' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusLower = strtolower($invoice->status ?? 'draft');
                                                    @endphp
                                                    <span class="status-pill status-pill-{{ $statusLower }}">
                                                        {{ $invoice->status ?? 'Draft' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('admin.lead.service.order.invoice.download.pdf', $invoice->id) }}" 
                                                           class="action-btn action-btn-pdf" 
                                                           title="Download PDF">
                                                            <i class="fa fa-file-pdf"></i> PDF
                                                        </a>
                                                        <a href="{{ route('admin.lead.service.order.invoice.download.csv', $invoice->id) }}" 
                                                           class="action-btn action-btn-csv" 
                                                           title="Download CSV">
                                                            <i class="fa fa-file-csv"></i> CSV
                                                        </a>
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
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#invoicesTable').DataTable({
                pageLength: 10,
                ordering: false,
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: {
                        previous: '< Previous',
                        next: 'Next >'
                    }
                },
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
            });
        });
    </script>
@endpush
