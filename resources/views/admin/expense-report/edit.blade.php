@extends('admin.includes.layout')

@section('title', 'Expense Report')

@push('styles')
<style>


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
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        <!-- HEADER -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Expense Report #{{ $report->id }}</h3>
                                <p class="text-muted mb-0">Employee: <strong>{{ $report->user->name }}</strong> | Type: <strong>{{ $report->report_type }}</strong></p>
                                @php
                                    $statusSlug = strtolower($report->status ?? 'open');
                                    $pillClass = 'status-pill-' . $statusSlug;
                                @endphp
                                <div class="status-pill {{ $pillClass }} fs-6 mt-2">
                                    {{ $report->status ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="right-part-sec d-flex align-items-center">
                                <a href="{{ route('admin.expense-report.index') }}" class="btn btn-outline-dark me-3">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                
                            </div>
                        </div>

                        <div class="px-4 pb-2">
                            <!-- SUMMARY & APPROVED ITEMS ROW -->
                            <div class="row">
                                <!-- LEFT COLUMN: SUMMARY -->
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="section-card h-100">
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
                                </div>

                                <!-- RIGHT COLUMN: APPROVED ITEMS -->
                                <div class="col-lg-6 col-12 mb-4">
                                    <div class="section-card h-100">
                                        <div class="section-header">
                                            <h3 class="section-title">Approved Items List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover w-100 equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Expense Type</th>
                                                        <th>Description</th>
                                                        <th>Approved Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $approvedItems = $report->items->filter(function($item) {
                                                            return $item->reason_code == 1;
                                                        });
                                                    @endphp

                                                    @forelse($approvedItems as $item)
                                                        <tr>
                                                            <td class="fw-semibold text-dark">{{ $item->expenseType->name ?? '-' }}</td>
                                                            <td class="text-wrap" style="max-width: 150px;">{{ $item->description }}</td>
                                                            <td><strong class="text-success">${{ number_format($item->approved_amount, 2) }}</strong></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted py-3">No items have been approved yet.</td>
                                                        </tr>
                                                    @endforelse

                                                    @if($approvedItems->isNotEmpty())
                                                        <tr style="background-color: rgba(6, 150, 151, 0.05);">
                                                            <td colspan="2"><strong class="text-dark text-end d-block pe-3">Total Approved</strong></td>
                                                            <td><strong class="text-success">${{ number_format($approvedItems->sum('approved_amount'), 2) }}</strong></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
                                            @canany(['expense_report.edit', 'expense_report.add'])
                                                <th>Action</th>
                                            @endcanany
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

                                                @canany(['expense_report.edit', 'expense_report.add'])
                                                <td>
                                                    @if($report->status === 'Open')
                                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-item-id="{{ $item->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @elseif($report->status === 'Submitted')
                                                        <div style="min-width: 200px;">
                                                            @can('expense_report.edit')
                                                            <form action="{{ route('admin.expense-report.approve-item', $report->id) }}" method="POST" class="approve-item-form" id="approve-form-{{ $item->id }}">
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
                                                            @else
                                                            <div class="text-start">
                                                                <div class="mb-2">
                                                                    <label class="form-label mb-1" style="font-size: 12px; font-weight: 600;">Approved Value</label>
                                                                    <input type="number" step="0.01" class="form-control bg-light"
                                                                        value="{{ ($item->approved_amount == 0 || is_null($item->approved_amount)) ? $item->amount_requested : $item->approved_amount }}" disabled>
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
                                                            @endcan
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
                                                @endcanany
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
                            @canany(['expense_report.add', 'expense_report.edit'])
                            <!-- ADD EXPENSE -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">Add Expense</h3>
                                </div>

                                <p class="text-muted mb-3">
                                    Enter in any expenses not related to a specific job here
                                </p>

                                <form action="{{ route('admin.expense-report.update', $report->id) }}" method="POST" enctype="multipart/form-data" id="add-expense-form">
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
                                            <input type="file" class="form-control bg-light" name="receipt_picture" accept="image/*" required>
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
                                <form action="{{ route('admin.expense-report.submit', $report->id) }}" method="POST" id="submit-report-form" data-item-count="{{ $report->items->count() }}">
                                    @csrf
                                    <button class="btn btn-success px-4">
                                        Submit for Reimbursement
                                    </button>
                                </form>
                            </div>
                            @endcanany
                        @endif

                        @if($report->status === 'Submitted')
                            @can('expense_report.edit')
                            <div class="section-card">
                                <h5 class="mb-3" style="font-weight: 500;">Admin Actions</h5>
                                <div class="d-flex align-items-center gap-3">

                                    <form action="{{ route('admin.expense-report.unsubmit', $report->id) }}" method="POST" class="mb-0" id="unsubmit-report-form">
                                        @csrf
                                        <button type="submit" class="btn btn-warning text-dark px-4">
                                            <i class="fas fa-undo me-1"></i> Unsubmit Report
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.expense-report.accept-and-fill', $report->id) }}" method="POST" class="mb-0" id="accept-fill-form">
                                        @csrf
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-check-double me-1"></i> Mark as Accepted and Filled
                                        </button>
                                    </form>

                                </div>
                            </div>
                            @endcan
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
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {

    // ==============================
    // Add Expense Validation and Submission
    // ==============================
    $("#add-expense-form").validate({
        ignore: [],
        rules: {
            description: { required: true },
            expense_type_id: { required: true },
            amount_requested: { required: true, number: true },
            receipt_picture: { required: true }
        },
        messages: {
            description: { required: "Please enter description." },
            expense_type_id: { required: "Please select an expense type." },
            amount_requested: { required: "Please enter the amount.", number: "Must be a valid number." },
            receipt_picture: { required: "Please upload a receipt picture." }
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
    });

    $('#add-expense-form').submit(function(e) {
        e.preventDefault();

        if (!$('#add-expense-form').valid()) {
            return;
        }

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.expense-report.update', $report->id) }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Expense added successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(xhr) {
                alert(xhr.responseText);
                toastr.error('Something went wrong while adding expense.');
            }
        });
    });

    // ==============================
    // Delete Expense Item
    // ==============================
    $(document).on('click', '.btn-delete', function() {
        let itemId = $(this).data('item-id');

        Swal.fire({
            title: "Are you sure?",
            text: "This action will permanently delete the selected item.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.expense-report.update', $report->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        action_type: "remove",
                        item_id: itemId
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

    // ==============================
    // Submit Report
    // ==============================
    $('#submit-report-form').submit(function(e) {
        e.preventDefault();

        let itemCount = parseInt($(this).data('item-count')) || 0;
        if (itemCount === 0) {
            toastr.error('You must add at least one expense item before submitting the report.');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to submit this report for reimbursement?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('Report submitted successfully!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong while submitting.');
                    }
                });
            }
        });
    });

    // ==============================
    // Unsubmit Report
    // ==============================
    $('#unsubmit-report-form').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "Unsubmit this report and return it to Open?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, unsubmit!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('Report unsubmitted successfully!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });

    // ==============================
    // Accept and Fill Report
    // ==============================
    $('#accept-fill-form').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "Mark this report as accepted and filled?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('Report accepted and filled!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong.');
                    }
                });
            }
        });
    });

    // ==============================
    // Approve Item
    // ==============================
    $('.approve-item-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                toastr.success('Updated successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(xhr) {
                toastr.error('Something went wrong.');
            }
        });
    });

});
</script>
@endpush

@endsection
