@extends('admin.includes.layout')

@section('title', 'Expense Report')

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <div class="sales-dashboard">

                    <!-- HEADER -->
                    <div class="dashboard-header section-card">
                        <h4 class="mb-2">Expense Report: {{ $report->id }}</h4>
                        <p class="mb-1">Employee: {{ $report->user->name }}</p>
                        <p class="mb-1">Expense Report Type: {{ $report->report_type }}</p>
                        <p class="text-muted">Report Status: {{ $report->status }}</p>
                    </div>

                    <!-- SUMMARY -->
                    <div class="section-card">
                        <div class="section-header">
                            <h3 class="section-title">Expense Report Summary</h3>
                        </div>

                        <table class="table table-bordered">
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
                                        <td>{{ $row->expenseType->name ?? '-' }}</td>
                                        <td>{{ $row->receipt_count }}</td>
                                        <td>{{ number_format($row->total_amount, 2) }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <th>Total</th>
                                    <th>{{ $summary->sum('receipt_count') }}</th>
                                    <th>{{ number_format($summary->sum('total_amount'), 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- ITEMS -->
                    <div class="section-card">
                        <div class="section-header">
                            <h3 class="section-title">Expense Items</h3>
                        </div>

                        <table class="table table-bordered">
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
                                        <td>{{ $item->expenseType->name ?? '-' }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ number_format($item->amount_requested, 2) }}</td>

                                        <td>
                                            @if($item->receipt_picture)
                                                <a href="{{ asset('storage/'.$item->receipt_picture) }}" target="_blank">
                                                    <img src="{{ asset('storage/'.$item->receipt_picture) }}"
                                                        width="auto" height="300px" alt="Receipt Picture"
                                                        style="image-orientation: from-image; border-radius:6px; border:1px solid #ddd;">
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if($report->status === 'Open')
                                                <form action="{{ route('admin.expense-report.update', $report->id) }}" method="POST">
                                                    @csrf

                                                    <input type="hidden" name="action_type" value="remove">
                                                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                                                    <button class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            @elseif($report->status === 'Submitted')
                                                <div>
                                                    <label class="form-label mb-1">Approved Value</label>
                                                    <input type="number" step="0.01" class="form-control mb-2"
                                                        name="approved_amount" value="{{ $item->amount_requested ?? '' }}">

                                                    <label class="form-label mb-1">Reason</label>
                                                    <select class="form-select mb-2" name="reason_code">
                                                        @foreach($itemReasons as $reason)
                                                            <option value="{{ $reason->id }}"
                                                                {{ $item->reason_code == $reason->id ? 'selected' : '' }}>
                                                                {{ $reason->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <button class="btn btn-light w-100 border">Update</button>

                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No expense items added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- <!-- UNASSIGNED -->
                    <div class="section-card">
                        <div class="section-header">
                            <h3 class="section-title">Expenses Not Currently Assigned</h3>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Expense Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Picture</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> --}}

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
                                        <input type="text" class="form-control" name="description" placeholder="Enter description" required>
                                    </div>

                                    <!-- Expense Type -->
                                    <div class="col-md-6">
                                        <label class="form-label">Expense Type</label>
                                        <select class="form-select" name="expense_type_id" required>
                                            <option value="">Select a type</option>
                                            @foreach($expenseTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Amount -->
                                    <div class="col-md-6">
                                        <label class="form-label">Amount (must match receipt)</label>
                                        <input type="number" step="0.01" class="form-control" name="amount_requested" placeholder="0.00" required>
                                    </div>

                                    <!-- Receipt -->
                                    <div class="col-md-6">
                                        <label class="form-label">Receipt Picture</label>
                                        <input type="file" class="form-control" name="receipt_picture" required>
                                    </div>

                                </div>


                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary">
                                            Add Expense
                                    </button>
                                </div>

                            </form>
                        </div>


                        <!-- SUBMIT -->
                        <div class="section-card">
                            <h5> If you have entered all of your expenses above, click the button below to submit your report</h5>
                            <form action="{{ route('admin.expense-report.submit', $report->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success mt-3">
                                    Submit for Reimbursement
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
