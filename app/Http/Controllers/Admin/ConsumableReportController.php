<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsumableReport;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ConsumableReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:consumable_report.view', only: ['index']),
            new Middleware('permission:consumable_report.add', only: ['store']),
            new Middleware('permission:consumable_report.edit', only: ['update', 'destroy']),
        ];
    }
    public function index(Request $request)
    {
        $reports = ConsumableReport::with(['company', 'leader'])->get();
        $companies = Company::all();

        $totalReports = $reports->count();
        $goodReports = $reports->where('status', 1)->count();
        $badReports = $reports->where('status', 0)->count();
        $compliancePercentage = $totalReports > 0 ? round(($goodReports / $totalReports) * 100, 2) : 0;

        return view('admin.consumable-reports.index', compact('reports', 'companies', 'totalReports', 'goodReports', 'badReports', 'compliancePercentage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            $data = $request->all();
            $data['user_id'] = auth()->id();
            $data['reported_at'] = now();
            $data['status'] = $this->calculateStatus($data);

            ConsumableReport::create($data);

            if ($request->ajax()) {
                return response()->json(['message' => 'Consumable report created successfully.']);
            }
            return redirect()->back()->with('success', 'Consumable report created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $report = ConsumableReport::findOrFail($id);

            $request->validate([
                'company_id' => 'required|exists:companies,id',
            ]);

            $data = $request->all();
            $data['status'] = $this->calculateStatus($data);

            $report->update($data);

            if ($request->ajax()) {
                return response()->json(['message' => 'Consumable report updated successfully.']);
            }
            return redirect()->back()->with('success', 'Consumable report updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Something went wrong!'], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroy($id)
    {
        $report = ConsumableReport::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Consumable report deleted successfully.');
    }

    private function calculateStatus(array $data)
    {
        $fields = [
            'micro_pre', 'micro_post',
            'disp_micro_pre', 'disp_micro_post',
            'halo_pre', 'halo_post',
            'opti_pre', 'opti_post',
            'd2_pre', 'd2_post',
            'oxi_pre', 'oxi_post',
            'shld_pre', 'shld_post',
            'sterl_pre', 'sterl_post',
            'atp_pre', 'atp_post',
            'gloves_pre', 'gloves_post',
            'water_pre', 'water_post',
            'rinse_pre', 'rinse_post',
            'wash_pre', 'wash_post',
            'rust_pre', 'rust_post'
        ];

        foreach ($fields as $field) {
            if (isset($data[$field]) && (float)$data[$field] > 0) {
                return 1;
            }
        }

        return 0;
    }
}
