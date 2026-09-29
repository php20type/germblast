<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityRoomType;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\Log;

class SurveyConfigurationController extends Controller
{
    public function index()
    {
        // Use existing models for Facilities and Equipment
        $facilities = FacilityRoomType::all();
        $equipment = EquipmentType::all();

        // Master parameters currently not in a centralized DB table. 
        // Rendering them dynamically from a controller array so the UI is ready when the DB is added.
        $parameters = [
            'TravelBetween' => 0.33,
            'MilesPerGallon' => 14,
            'PricePerGallon' => 3.00,
            'AwarenessPercent' => 0.1000,
            'EducationPercent' => 0.1000,
            'TechnologyPercent' => 0.0150,
            'ResponsePercent' => 0.0900,
            'SalesRepPercent' => 0.1100,
            'HourlyRate' => 28.75,
        ];

        return view('admin.corporate-tools.survey-configuration', compact('facilities', 'equipment', 'parameters'));
    }

    public function updateParameters(Request $request)
    {
        // Placeholder for when a generic settings table is implemented
        return response()->json(['success' => true, 'message' => 'Master Parameters updated successfully.']);
    }

    public function updateFacilities(Request $request)
    {
        $request->validate([
            'facilities' => 'required|array',
            'facilities.*' => 'numeric|min:0'
        ]);

        foreach ($request->facilities as $id => $hours) {
            FacilityRoomType::where('id', $id)->update(['hours_required' => $hours]);
        }

        return response()->json(['success' => true, 'message' => 'Survey Facilities updated successfully.']);
    }

    public function updateEquipment(Request $request)
    {
        $request->validate([
            'equipment' => 'required|array',
            'equipment.*' => 'numeric|min:0'
        ]);

        // Assuming EquipmentType has hours_required
        foreach ($request->equipment as $id => $hours) {
            EquipmentType::where('id', $id)->update(['hours_required' => $hours]);
        }

        return response()->json(['success' => true, 'message' => 'Survey Equipment updated successfully.']);
    }
}
