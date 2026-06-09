<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanEquipment;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanEquipmentController extends Controller
{
    /**
     * Display the equipment loan dashboard.
     */
    public function index()
    {
        $equipments = LoanEquipment::with(['company.companyAddress', 'checkedOutBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        $companies = Company::orderBy('name')->get();

        return view('admin.equipment-loan.index', compact('equipments', 'companies'));
    }

    /**
     * Store a new equipment record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:loan_equipments,serial_number',
        ]);

        LoanEquipment::create([
            'name' => $request->name,
            'serial_number' => $request->serial_number,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Equipment added successfully and is available for checkout.');
    }

    /**
     * Process checkout for available equipment.
     */
    public function checkout(Request $request, $id)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $equipment = LoanEquipment::findOrFail($id);

        if ($equipment->status !== 'available') {
            return redirect()->back()->with('error', 'This equipment is not available for checkout.');
        }

        $processedDate = Carbon::now();
        $dueDate = $processedDate->copy()->addDays(5);

        $equipment->update([
            'status' => 'processed',
            'company_id' => $request->company_id,
            'checked_out_by_id' => auth()->id(),
            'processed_date' => $processedDate->toDateString(),
            'due_date' => $dueDate->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Equipment successfully checked out.');
    }

    /**
     * Process disposition for checked-out equipment.
     */
    public function disposition(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:check_in,sell,lost',
        ]);

        $equipment = LoanEquipment::findOrFail($id);

        if ($equipment->status !== 'processed') {
            return redirect()->back()->with('error', 'This equipment is not currently checked out.');
        }

        switch ($request->action) {
            case 'check_in':
                $equipment->update([
                    'status' => 'available',
                    'company_id' => null,
                    'checked_out_by_id' => null,
                    'processed_date' => null,
                    'due_date' => null,
                ]);
                $message = 'Equipment checked in successfully and is now available for checkout.';
                break;

            case 'sell':
                $equipment->update([
                    'status' => 'sold',
                    'due_date' => null,
                ]);
                $message = 'Equipment status updated to Sold to Client.';
                break;

            case 'lost':
                $equipment->update([
                    'status' => 'lost',
                    'due_date' => null,
                ]);
                $message = 'Equipment status updated to Lost.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
