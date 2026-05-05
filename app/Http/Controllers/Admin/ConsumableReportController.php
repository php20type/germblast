<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsumableReport;
use App\Models\Company;
use Illuminate\Http\Request;

class ConsumableReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = ConsumableReport::with(['company', 'leader'])->get();
        $companies = Company::all();

        return view('admin.consumable-reports.index', compact('reports', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['reported_at'] = now();

        ConsumableReport::create($data);

        return redirect()->back()->with('success', 'Consumable report created successfully.');
    }

    public function update(Request $request, $id)
    {
        $report = ConsumableReport::findOrFail($id);

        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $report->update($request->all());

        return redirect()->back()->with('success', 'Consumable report updated successfully.');
    }

    public function destroy($id)
    {
        $report = ConsumableReport::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Consumable report deleted successfully.');
    }
}
