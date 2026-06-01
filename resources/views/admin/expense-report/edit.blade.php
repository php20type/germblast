@extends('admin.includes.layout')

@section('title', 'Expense Report')

@push('styles')
<style>
    /* Boxed Table System from Equipment Management */
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
        text-align: center;
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
        text-align: center;
        white-space: nowrap;
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

    /* Custom Premium Status Badges */
    .status-pill {
        font-size: 12px !important;
        font-weight: 600 !important;
        padding: 6px 14px !important;
        border-radius: 30px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border: 1px solid transparent !important;
    }

    .status-pill-open {
        background-color: rgba(13, 110, 253, 0.12) !important;
        color: #0d6efd !important;
        border-color: rgba(13, 110, 253, 0.2) !important;
    }

    .status-pill-submitted {
        background-color: rgba(255, 184, 28, 0.12) !important;
        color: #d39100 !important;
        border-color: rgba(255, 184, 28, 0.25) !important;
    }

    .status-pill-filled {
        background-color: rgba(6, 150, 151, 0.12) !important;
        color: #069697 !important;
        border-color: rgba(6, 150, 151, 0.25) !important;
    }

    .status-pill-approved {
        background-color: rgba(6, 150, 151, 0.12) !important;
        color: #069697 !important;
        border-color: rgba(6, 150, 151, 0.25) !important;
    }

    .status-pill-rejected {
        background-color: rgba(234, 61, 47, 0.12) !important;
        color: #ea3d2f !important;
        border-color: rgba(234, 61, 47, 0.2) !important;
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

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <div class="sales-dashboard">

                    <!-- HEADER -->
                    <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-2" style="font-weight: 500;">Expense Report #{{ $report->id }}</h3>
                            <p class="text-muted mb-0">Employee: <strong>{{ $report->user->name }}</strong> | Type: <strong>{{ $report->report_type }}</strong></p>
                        </div>
                        <div>
                            @php
                                $statusSlug = strtolower($report->status ?? 'open');
                                $pillClass = 'status-pill-' . $statusSlug;
                            @endphp
                            <span class="status-pill {{ $pillClass }} fs-6">
                                {{ $report->status ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <!-- SUMMARY -->
                    <div class="section-card">
                        <div class="section-header">
                            <h3 class="section-title">Expense Report Summary</h3>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover w-100 equipment-report-table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Receipt Count</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summary as $row)
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $row->expenseType->name ?? '-' }}</td>
                                            <td><span class="badge bg-secondary text-white rounded-pill px-2 py-1">{{ $row->receipt_count }}</span></td>
                                            <td><strong class="text-dark">${{ number_format($row->total_amount, 2) }}</strong></td>
                                        </tr>
                                    @endforeach

                                    <tr style="background-color: rgba(255, 184, 28, 0.05);">
                                        <td><strong class="text-dark">Total</strong></td>
                                        <td><span class="badge bg-dark text-white rounded-pill px-2 py-1">{{ $summary->sum('receipt_count') }}</span></td>
                                        <td><strong class="text-dark">${{ number_format($summary->sum('total_amount'), 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ITEMS -->
                    <div class="section-card">
                        <div class="section-header">
                            <h3 class="section-title">Expense Items</h3>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover w-100 equipment-report-table">
                                <thead>
                                    <tr>
                                        <th>Expense Type</th>
                                        <th>Description</th>
                                        <th>Amount Requested</th>
                                        <th>Picture</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($report->items as $item)
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $item->expenseType->name ?? '-' }}</td>
                                            <td class="text-wrap" style="max-width: 250px;">{{ $item->description }}</td>
                                            <td class="fw-bold text-dark">${{ number_format($item->amount_requested, 2) }}</td>

                                            <td>
                                                @if($item->receipt_picture)
                                                    <a href="{{ asset('storage/'.$item->receipt_picture) }}" target="_blank" class="d-inline-block">
                                                        <img src="{{ asset('storage/'.$item->receipt_picture) }}"
                                                            alt="Receipt Picture"
                                                            style="image-orientation: from-image; border-radius:8px; border:1px solid #e5e7eb; max-height:100px; width:auto; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s ease;"
                                                            onmouseover="this.style.transform='scale(1.05)'"
                                                            onmouseout="this.style.transform='scale(1)'">
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($report->status === 'Open')
                                                    <form action="{{ route('admin.expense-report.update', $report->id) }}" method="POST" class="d-inline">
                                                        @csrf

                                                        <input type="hidden" name="action_type" value="remove">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                                                        <button class="btn btn-sm btn-outline-danger" style="border-radius: 8px; font-weight: 600; padding: 6px 14px;">
                                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                                        </button>
                                                    </form>
                                                @elseif($report->status === 'Submitted')
                                                    <div style="min-width: 200px;">
                                                        <form action="{{ route('admin.expense-report.approve-item', $report->id) }}" method="POST">
                                                            @csrf

                                                            <input type="hidden" name="item_id" value="{{ $item->id }}">

                                                            <div class="mb-2 text-start">
                                                                <label class="form-label mb-1" style="font-size: 12px; font-weight: 600;">Approved Value</label>
                                                                <input type="number" step="0.01" class="form-control bg-light"
                                                                    name="approved_amount" value="{{ ($item->approved_amount == 0 || is_null($item->approved_amount)) ? $item->amount_requested : $item->approved_amount }}" required>
                                                            </div>

                                                            <div class="mb-2 text-start">
                                                                <label class="form-label mb-1" style="font-size: 12px; font-weight: 600;">Reason</label>
                                                                <select class="form-select bg-light" name="reason_code" required>
                                                                    <option value="">Select reason</option>
                                                                    @foreach($itemReasons as $reason)
                                                                        <option value="{{ $reason->id }}"
                                                                            {{ $item->reason_code == $reason->id ? 'selected' : '' }}>
                                                                            {{ $reason->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <button class="btn btn-export w-100 mt-2">
                                                                <i class="fas fa-check-circle me-1"></i> Update
                                                            </button>
                                                        </form>

                                                    </div>
                                                @elseif($report->status === 'Filled')
                                                    <div style="min-width: 200px;" class="text-start">
                                                        <div class="mb-2">
                                                            <label class="form-label mb-1" style="font-size: 12px; font-weight: 600;">Approved Value</label>
                                                            <input type="number" step="0.01" class="form-control bg-light"
                                                                value="{{ ($item->approved_amount == 0 || is_null($item->approved_amount)) ? $item->amount_requested : $item->approved_amount }}"
                                                                disabled>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label class="form-label mb-1" style="font-size: 12px; font-weight: 600;">Reason</label>
                                                            <select class="form-select bg-light" disabled>
                                                                <option value="">Select reason</option>
                                                                @foreach($itemReasons as $reason)
                                                                    <option value="{{ $reason->id }}"
                                                                        {{ $item->reason_code == $reason->id ? 'selected' : '' }}>
                                                                        {{ $reason->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No expense items added yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($report->status === 'Open')
                        <!-- ADD EXPENSE -->
                        <div class="section-card">
                            <div class="section-header">
                                <h3 class="section-title">Add Expense</h3>
                            </div>

                            <p class="text-muted mb-3">
                                Enter in any expenses not related to a specific job here
                            </p>

                            <form action="{{ route('admin.expense-report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="action_type" value="add">

                                <div class="row g-3">

                                    <!-- Description -->
                                    <div class="col-md-6">
                                        <label class="form-label">Purchase Description</label>
                                        <input type="text" class="form-control bg-light" name="description" placeholder="Enter description" required>
                                    </div>

                                    <!-- Expense Type -->
                                    <div class="col-md-6">
                                        <label class="form-label">Expense Type</label>
                                        <select class="form-select bg-light" name="expense_type_id" required>
                                            <option value="">Select a type</option>
                                            @foreach($expenseTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Amount -->
                                    <div class="col-md-6">
                                        <label class="form-label">Amount (must match receipt)</label>
                                        <input type="number" step="0.01" class="form-control bg-light" name="amount_requested" placeholder="0.00" required>
                                    </div>

                                    <!-- Receipt -->
                                    <div class="col-md-6">
                                        <label class="form-label">Receipt Picture</label>
                                        <input type="file" class="form-control bg-light" name="receipt_picture" required>
                                    </div>

                                </div>


                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-export px-4">
                                            + Add Expense
                                    </button>
                                </div>

                            </form>
                        </div>


                        <!-- SUBMIT -->
                        <div class="section-card">
                            <h5 class="mb-3" style="font-weight: 500;">Submit Report</h5>
                            <p class="text-muted mb-3">If you have entered all of your expenses above, click the button below to submit your report.</p>
                            <form action="{{ route('admin.expense-report.submit', $report->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success px-4" style="border-radius: 8px; font-weight: 600;">
                                    Submit for Reimbursement
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($report->status === 'Submitted')
                        <div class="section-card">
                            <h5 class="mb-3" style="font-weight: 500;">Admin Actions</h5>
                            <div class="d-flex align-items-center gap-3">

                                <form action="{{ route('admin.expense-report.unsubmit', $report->id) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-warning text-dark px-4" style="border-radius: 8px; font-weight: 600;"
                                        onclick="return confirm('Unsubmit this report and return it to Open?')">
                                        <i class="fas fa-undo me-1"></i> Unsubmit Report
                                    </button>
                                </form>

                                <form action="{{ route('admin.expense-report.accept-and-fill', $report->id) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; font-weight: 600;"
                                        onclick="return confirm('Mark this report as accepted and filled?')">
                                        <i class="fas fa-check-double me-1"></i> Mark as Accepted and Filled
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endif

                    @if($report->status === 'Filled')
                        <div class="section-card">
                            <div class="alert alert-success mb-0 d-flex align-items-center gap-3" style="border-radius: 12px;">
                                <i class="fas fa-check-circle fa-2x"></i>
                                <div>
                                    <h6 class="mb-1" style="font-weight: 600;">Report Accepted and Filled</h6>
                                    @if($report->filled_at)
                                        <div class="text-muted small">
                                            Completed on {{ \Carbon\Carbon::parse($report->filled_at)->format('jS F Y, g:i A') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
