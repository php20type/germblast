<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsdAttendanceRecord;
use App\Models\IsdCampus;
use App\Models\IsdSchool;
use Illuminate\Http\Request;

class IsdAttendanceController extends Controller
{
    /**
     * PAGE 1: School District & Campus Selection Page
     */
    public function index(Request $request)
    {
        $selectedSchoolId = $request->get('school_id');

        $schools = IsdSchool::orderBy('name')->get()->map(fn($s) => ['id' => $s->id, 'name' => $s->name]);
        $campuses = collect([]);
        $selectedSchool = null;

        if ($selectedSchoolId) {
            $schoolModel = IsdSchool::find($selectedSchoolId);
            if ($schoolModel) {
                $selectedSchool = ['id' => $schoolModel->id, 'name' => $schoolModel->name];
                $campuses = IsdCampus::where('isd_school_id', $selectedSchoolId)->orderBy('name')->get()->map(fn($c) => ['id' => $c->id, 'isd_school_id' => $c->isd_school_id, 'name' => $c->name]);
            }
        }

        return view('admin.operations.isd-attendance.index', compact(
            'schools',
            'campuses',
            'selectedSchoolId',
            'selectedSchool'
        ));
    }

    /**
     * PAGE 2: Attendance Listing Page for Selected Campus
     */
    public function attendance(Request $request, $campusId)
    {
        $campusModel = IsdCampus::with('school')->findOrFail($campusId);
        $selectedCampus = ['id' => $campusModel->id, 'isd_school_id' => $campusModel->isd_school_id, 'name' => $campusModel->name];
        $selectedSchool = ['id' => $campusModel->school->id, 'name' => $campusModel->school->name];

        $attendanceRecords = IsdAttendanceRecord::where('isd_campus_id', $campusId)->orderBy('school_year', 'desc')->orderBy('week', 'desc')->get()->map(fn($r) => [
            'id' => $r->id,
            'isd_campus_id' => $r->isd_campus_id,
            'school_year' => $r->school_year,
            'week' => $r->week,
            'ada' => $r->ada,
            'pia' => $r->pia,
        ]);

        return view('admin.operations.isd-attendance.attendance', compact(
            'selectedSchool',
            'selectedCampus',
            'attendanceRecords'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campus_id' => 'required|exists:isd_campuses,id',
            'school_year' => 'required|string',
            'week' => 'required|integer|min:1',
            'ada' => 'required|numeric|min:0|max:100',
            'pia' => 'required|numeric|min:0|max:100',
        ]);

        IsdAttendanceRecord::create([
            'isd_campus_id' => $request->campus_id,
            'school_year' => $request->school_year,
            'week' => $request->week,
            'ada' => $request->ada,
            'pia' => $request->pia,
        ]);

        return redirect()->route('admin.isd-attendance.campus', $request->campus_id)
            ->with('success', 'Attendance record added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ada' => 'required|numeric|min:0|max:100',
            'pia' => 'required|numeric|min:0|max:100',
        ]);

        $record = IsdAttendanceRecord::findOrFail($id);
        $record->update([
            'ada' => $request->ada,
            'pia' => $request->pia,
        ]);

        return redirect()->back()->with('success', 'Attendance record updated successfully.');
    }

    public function destroy($id)
    {
        $record = IsdAttendanceRecord::findOrFail($id);
        $record->delete();

        return redirect()->back()->with('success', 'Attendance record deleted successfully.');
    }

    // --- School Management ---

    public function storeSchool(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        IsdSchool::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'School District added successfully.');
    }

    public function updateSchool(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $school = IsdSchool::findOrFail($id);
        $school->update(['name' => $request->name]);
        
        return redirect()->back()->with('success', 'School District updated successfully.');
    }

    public function destroySchool($id)
    {
        $school = IsdSchool::findOrFail($id);
        $school->delete();
        
        return redirect()->route('admin.isd-attendance.index')->with('success', 'School District deleted successfully.');
    }

    // --- Campus Management ---

    public function storeCampus(Request $request)
    {
        $request->validate([
            'isd_school_id' => 'required|exists:isd_schools,id',
            'name' => 'required|string|max:255',
        ]);
        
        IsdCampus::create([
            'isd_school_id' => $request->isd_school_id,
            'name' => $request->name,
        ]);
        return redirect()->back()->with('success', 'Campus added successfully.');
    }

    public function updateCampus(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $campus = IsdCampus::findOrFail($id);
        $campus->update(['name' => $request->name]);
        
        return redirect()->back()->with('success', 'Campus updated successfully.');
    }

    public function destroyCampus($id)
    {
        $campus = IsdCampus::findOrFail($id);
        $campus->delete();
        
        return redirect()->back()->with('success', 'Campus deleted successfully.');
    }
}
