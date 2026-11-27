<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityRoomType;
use App\Models\EquipmentType;
use App\Models\SurveyParameter;
use Illuminate\Support\Str;

class SurveyConfigurationController extends Controller
{
    public function index()
    {
        // Master parameters, Facilities and Equipment all come from the database
        $parameters = SurveyParameter::orderBy('sort_order')->get();
        $facilities = FacilityRoomType::all();
        $equipment = EquipmentType::all();

        return view('admin.corporate-tools.survey-configuration', compact('facilities', 'equipment', 'parameters'));
    }

    public function updateParameters(Request $request)
    {
        $labels = SurveyParameter::pluck('label', 'key');
        $keys = $labels->keys();

        $rules = ['parameters' => 'required|array'];
        $attributes = [];

        foreach ($keys as $key) {
            // Percentages are fractions (0.10 = 10%)
            $rules["parameters.$key"] = Str::endsWith($key, '_percent') ? 'required|numeric|min:0|max:1' : 'required|numeric|min:0|max:99999999';
            $attributes["parameters.$key"] = $labels[$key];
        }

        $request->validate($rules, [], $attributes);

        foreach ($keys as $key) {
            SurveyParameter::where('key', $key)->update(['value' => $request->parameters[$key]]);
        }

        return response()->json(['success' => true, 'message' => 'Master Parameters updated successfully.']);
    }

    public function updateFacilities(Request $request)
    {
        $this->updateHours($request, 'facilities', FacilityRoomType::class, 'Survey Facilities');

        return response()->json(['success' => true, 'message' => 'Survey Facilities updated successfully.']);
    }

    public function updateEquipment(Request $request)
    {
        $this->updateHours($request, 'equipment', EquipmentType::class, 'Survey Equipment');

        return response()->json(['success' => true, 'message' => 'Survey Equipment updated successfully.']);
    }

    /**
     * Saves the manhours of every row of a table (facilities or equipment).
     * Every row must come with a value: not empty, a number, not negative.
     */
    private function updateHours(Request $request, string $field, string $model, string $label): void
    {
        $names = $model::pluck('name', 'id');

        $rules = [$field => 'required|array'];
        $attributes = [];

        foreach ($names as $id => $name) {
            $rules["$field.$id"] = 'required|numeric|min:0|max:99999';
            $attributes["$field.$id"] = $name ?: "$label #$id";
        }

        $request->validate($rules, [], $attributes);

        foreach ($names->keys() as $id) {
            $model::where('id', $id)->update(['hours_required' => $request->input("$field.$id")]);
        }
    }
}
