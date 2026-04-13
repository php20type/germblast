<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseReport;
use App\Models\ExpenseReportItem;
use App\Models\ExpenseType;
use App\Models\ExpenseItemReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ExpenseReportController extends Controller
{
    // public function index(Request $request)
    // {
    //     $baseQuery = ExpenseReport::with('user','items');

    //     // Search
    //     if ($request->filled('search')) {
    //         $baseQuery->where(function ($query) use ($request) {
    //             $query->whereHas('user', function ($q) use ($request) {
    //                 $q->where('name', 'like', "%{$request->search}%");
    //             })->orWhere('report_number', 'like', "%{$request->search}%");
    //         });
    //     }

    //     // Filters
    //     if ($request->filled('report_type')) {
    //         $baseQuery->where('report_type', $request->report_type);
    //     }

    //     // Clone queries
    //     $openReports = (clone $baseQuery)->where('status', 'Open')->latest()->get();
    //     $submittedReports = (clone $baseQuery)->where('status', 'Submitted')->latest()->get();
    //     $filledReports = (clone $baseQuery)->where('status', 'Filled')->latest()->get();

    //     $count = $openReports->count() + $submittedReports->count() + $filledReports->count();

    //     return view('admin.expense-report.index', compact(
    //         'openReports',
    //         'submittedReports',
    //         'filledReports',
    //         'count'
    //     ));
    // }

public function index(Request $request)
{
    $baseQuery = ExpenseReport::with('user', 'items');

   if ($request->filled('search')) {
        $baseQuery->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('report_type')) {
        $baseQuery->where('report_type', $request->report_type);
    }

    // If a specific status is requested (individual section search),
    // only fetch that section and return early
    if ($request->ajax() && $request->filled('status')) {
        $reports = (clone $baseQuery)->where('status', $request->status)->latest()->get();
        $key     = strtolower($request->status); // Open→open, Submitted→submitted, Filled→filled

        return response()->json([
            $key . '_table' => view('admin.expense-report.partials.expense-report-table-rows', ['reports' => $reports])->render(),
            $key . '_count' => $reports->count(),
        ]);
    }

    // Global search — fetch all 3
    $openReports      = (clone $baseQuery)->where('status', 'Open')->latest()->get();
    $submittedReports = (clone $baseQuery)->where('status', 'Submitted')->latest()->get();
    $filledReports    = (clone $baseQuery)->where('status', 'Filled')->latest()->get();

    $count = $openReports->count() + $submittedReports->count() + $filledReports->count();

    if ($request->ajax()) {
        return response()->json([
            'open_table'      => view('admin.expense-report.partials.expense-report-table-rows', ['reports' => $openReports])->render(),
            'submitted_table' => view('admin.expense-report.partials.expense-report-table-rows', ['reports' => $submittedReports])->render(),
            'filled_table'    => view('admin.expense-report.partials.expense-report-table-rows', ['reports' => $filledReports])->render(),
            'open_count'      => $openReports->count(),
            'submitted_count' => $submittedReports->count(),
            'filled_count'    => $filledReports->count(),
            'total_count'     => $count,
        ]);
    }

    return view('admin.expense-report.index', compact(
        'openReports',
        'submittedReports',
        'filledReports',
        'count'
    ));
}

   private function createReport($type)
    {
        return ExpenseReport::create([
            'user_id' => Auth::id(),
            'report_date' => now(),
            'report_type' => $type,
            'status' => 'Open',
            'total_amount' => 0,
        ]);
    }

    public function personal_create()
    {
        $report = $this->createReport('Personal');
        return redirect()->route('admin.expense-report.edit', $report->id);
    }

    public function corporate_create()
    {
        $report = $this->createReport('Corporate');
        return redirect()->route('admin.expense-report.edit', $report->id);
    }

    public function edit($id)
    {
        $report = ExpenseReport::with(['items.expenseType'])->findOrFail($id);
        $expenseTypes = ExpenseType::all();
        $itemReasons = ExpenseItemReason::all();

        // Summary (group by expense type)
        $summary = $report->items()
            ->select(
                'expense_type_id',
                DB::raw('COUNT(*) as receipt_count'),
                DB::raw('SUM(amount_requested) as total_amount')
            )
            ->groupBy('expense_type_id')
            ->with('expenseType')
            ->get();

        return view('admin.expense-report.edit', compact('report','expenseTypes', 'summary', 'itemReasons'));
    }

    public function update(Request $request, $id)
    {
        $report = ExpenseReport::findOrFail($id);

        if ($report->status !== 'Open') {
            return back()->with('error', 'Report is not editable');
        }
        switch ($request->action_type) {
            // ADD ITEM
            case 'add':
                $request->validate([
                    'description' => 'required|string',
                    'expense_type_id' => 'required',
                    'amount_requested' => 'required|numeric|min:0',
                    'receipt_picture' => 'required|image'
                ]);
                $path = null;
                if ($request->hasFile('receipt_picture')) {
                    $path = $request->file('receipt_picture')->store('receipts', 'public');
                }
                ExpenseReportItem::create([
                    'expense_report_id' => $report->id,
                    'expense_type_id' => $request->expense_type_id,
                    'description' => $request->description,
                    'amount_requested' => $request->amount_requested,
                    'receipt_picture' => $path,
                ]);
                break;

            // REMOVE ITEM
            case 'remove':
                $item = ExpenseReportItem::findOrFail($request->item_id);
                if ($item->receipt_picture) {
                    Storage::disk('public')->delete($item->receipt_picture);
                }
                $item->delete();
                break;
        }

        // UPDATE TOTAL AMOUNT
        $total = $report->items()->sum('amount_requested');
        $report->update([
            'total_amount' => $total
        ]);

        return redirect()->back()->with('success', 'Updated successfully');
    }

    public function submit($id)
    {
        $report = ExpenseReport::findOrFail($id);
        $report->update([
            'status' => 'Submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully');
    }

}
