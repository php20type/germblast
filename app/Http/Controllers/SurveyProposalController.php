<?php

namespace App\Http\Controllers;

use App\Models\EquipmentEvaluation;
use App\Models\Lead;
use App\Models\SurveyEquipmentImage;
use App\Models\SurveyFacility;
use App\Models\SurveyFacilityAtp;
use App\Models\SurveyFacilityMap;
use App\Models\SurveyProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SurveyProposalController extends Controller
{
    public function survey_proposal($leadId)
    {
        $lead = Lead::findOrFail($leadId);
        $surveyProposal = SurveyProposal::where('lead_id', $leadId)->firstOrFail();
        $facilities = SurveyFacility::where('survey_proposal_id', $surveyProposal->id)->get();
        $equipments = EquipmentEvaluation::where('survey_proposal_id', $surveyProposal->id)->get();

        return view('admin.leads.survey-proposal', compact(
            'lead',
            'surveyProposal',
            'facilities',
            'equipments'
        ));
    }

    public function survey_proposal_store(Request $request, $leadId)
    {
        $rules = [
            'client_name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',

            'enrollment' => 'required|integer|min:0',
            'wada' => 'required|numeric|min:0',
            'aba' => 'required|numeric|min:0',
            'service_technicians' => 'required|integer|min:0',
            'distance' => 'required|numeric|min:0',
            'man_hours' => 'required|numeric|min:0',

            'specialist_narrative' => 'required|string',

            'supplemental_title' => 'required|string',
            'supplemental_body' => 'required|string',
        ];

        $validated = $request->validate($rules);

        // Calculate estimate
        $estimate =
            $validated['enrollment'] +
            $validated['wada'] +
            $validated['aba'] +
            $validated['service_technicians'] +
            $validated['distance'] +
            $validated['man_hours'];

        // Add system fields
        $validated['lead_id'] = $leadId;
        $validated['user_id'] = auth()->id();
        $validated['estimate'] = $estimate;

        // Store or update the proposal
        $proposal = SurveyProposal::updateOrCreate(
            ['lead_id' => $leadId],
            $validated
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Survey proposal updated successfully.',
            'estimate' => number_format($estimate, 2),
            'survey_proposal_id' => $proposal->id, // useful for next steps
        ]);
    }

    public function survey_facility($surveyProposalId)
    {
        $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

        // Load existing facilities for this proposal
        $facilities = SurveyFacility::where('survey_proposal_id', $surveyProposalId)->get();

        return view('admin.leads.survey-facility', compact(
            'surveyProposal',
            'facilities'
        ));
    }

    public function survey_facility_store(Request $request, $surveyProposalId)
    {
        // Validate inputs
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'facility_type' => 'required|string',

            'square_footage' => 'required|numeric|min:0',
            'offices' => 'required|numeric|min:0',
            'standard_bathrooms' => 'required|numeric|min:0',
            'single_bathrooms' => 'required|numeric|min:0',
            'man_hours' => 'required|numeric|min:0',

            'map_name' => 'required|string|max:255',
            'map_file' => 'required|file|max:10240',

            'atp_location' => 'required|string|max:255',
            'atp_value' => 'required|numeric|min:0',
            'atp_file' => 'required|file|max:10240',
        ]);

        try {
            // Get survey proposal
            $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

            // 1. Save Facility
            $facility = SurveyFacility::create([
                'user_id' => auth()->id(),
                'survey_proposal_id' => $surveyProposal->id,

                'facility_name' => $request->facility_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'facility_type' => $request->facility_type,

                'square_footage' => $request->square_footage,
                'offices' => $request->offices,
                'standard_bathrooms' => $request->standard_bathrooms,
                'single_bathrooms' => $request->single_bathrooms,

                'man_hours' => $request->man_hours,
                'man_hours_cost' => $request->man_hours * 15,
            ]);

            // 2. Save Map File
            if ($request->hasFile('map_file')) {

                $file = $request->file('map_file');
                $original = $file->getClientOriginalName();
                $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$cleanName.'.'.$ext;

                $path = $file->storeAs('facility/maps', $filename, 'public');

                SurveyFacilityMap::create([
                    'user_id' => auth()->id(),
                    'survey_facility_id' => $facility->id,
                    'map_name' => $request->map_name,
                    'file_name' => $original,
                    'file_path' => $path,
                    'file_type' => $ext,
                ]);
            }

            // 3. Save ATP File
            if ($request->hasFile('atp_file')) {

                $file = $request->file('atp_file');
                $original = $file->getClientOriginalName();
                $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$cleanName.'.'.$ext;

                $path = $file->storeAs('facility/atp', $filename, 'public');

                SurveyFacilityAtp::create([
                    'user_id' => auth()->id(),
                    'survey_facility_id' => $facility->id,
                    'location' => $request->atp_location,
                    'atp_value' => $request->atp_value,
                    'file_name' => $original,
                    'file_path' => $path,
                    'file_type' => $ext,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Facility saved successfully!',
                'facility_id' => $facility->id,
            ]);

        } catch (\Throwable $e) {

            Log::error("SurveyFacility upload failed for survey_proposal={$surveyProposalId}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Facility creation failed. Please try again later.',
            ], 500);
        }
    }

    public function survey_facility_edit($facilityId)
    {
        $facility = SurveyFacility::findOrFail($facilityId);
        $surveyProposalId = $facility->survey_proposal_id;

        $facilityMaps = SurveyFacilityMap::where('survey_facility_id', $facility->id)->get();
        $facilityAtps = SurveyFacilityAtp::where('survey_facility_id', $facility->id)->get();

        return view('admin.leads.facility-edit', compact('facility', 'surveyProposalId', 'facilityMaps', 'facilityAtps'));
    }

    public function survey_facility_update(Request $request, $facilityId)
    {
        // Validate inputs (NO file required on update)
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'facility_type' => 'required|string',

            'square_footage' => 'required|numeric|min:0',
            'offices' => 'required|numeric|min:0',
            'standard_bathrooms' => 'required|numeric|min:0',
            'single_bathrooms' => 'required|numeric|min:0',
            'man_hours' => 'required|numeric|min:0',

            'map_name' => 'nullable|string|max:255',
            'map_file' => 'nullable|file|max:10240',

            'atp_location' => 'nullable|string|max:255',
            'atp_value' => 'nullable|numeric|min:0',
            'atp_file' => 'nullable|file|max:10240',
        ]);

        try {

            // Find facility
            $facility = SurveyFacility::findOrFail($facilityId);

            // UPDATE facility details
            $facility->update([
                'facility_name' => $request->facility_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'facility_type' => $request->facility_type,

                'square_footage' => $request->square_footage,
                'offices' => $request->offices,
                'standard_bathrooms' => $request->standard_bathrooms,
                'single_bathrooms' => $request->single_bathrooms,

                'man_hours' => $request->man_hours,
                'man_hours_cost' => $request->man_hours * 15,
            ]);

            // UPDATE or CREATE MAP file if provided
            if ($request->hasFile('map_file')) {

                $file = $request->file('map_file');
                $original = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $filename = Str::random(10).'_'.$clean.'.'.$ext;

                $path = $file->storeAs('facility/maps', $filename, 'public');

                SurveyFacilityMap::create([
                    'user_id' => auth()->id(),
                    'survey_facility_id' => $facility->id,
                    'map_name' => $request->map_name,
                    'file_name' => $original,
                    'file_path' => $path,
                    'file_type' => $ext,
                ]);
            }

            // UPDATE or CREATE ATP file if provided
            if ($request->hasFile('atp_file')) {

                $file = $request->file('atp_file');
                $original = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $filename = Str::random(10).'_'.$clean.'.'.$ext;

                $path = $file->storeAs('facility/atp', $filename, 'public');

                SurveyFacilityAtp::create([
                    'user_id' => auth()->id(),
                    'survey_facility_id' => $facility->id,
                    'location' => $request->atp_location,
                    'value' => $request->atp_value,
                    'file_name' => $original,
                    'file_path' => $path,
                    'file_type' => $ext,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Facility updated successfully!',
                'facility_id' => $facility->id,
            ]);

        } catch (\Throwable $e) {

            Log::error("Facility update failed for facility={$facilityId}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Facility update failed. Please try again later.',
            ], 500);
        }
    }

    public function survey_equipment($surveyProposalId)
    {
        $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);
        $equipments = EquipmentEvaluation::where('survey_proposal_id', $surveyProposalId)->get();

        // Return the equipment page with proposal & equipment list
        return view('admin.leads.survey-equipment', compact(
            'surveyProposal',
            'equipments'
        ));
    }

    public function survey_equipment_edit($equipmentId)
    {
        // Get Equipment Evaluation
        $equipment = EquipmentEvaluation::findOrFail($equipmentId);
        $surveyProposalId = $equipment->survey_proposal_id;
        $equipmentImages = SurveyEquipmentImage::where('survey_equipment_id', $equipment->id)->get();

        return view('admin.leads.equipment-edit', compact(
            'equipment',
            'surveyProposalId',
            'equipmentImages'
        ));
    }

    public function survey_equipment_store(Request $request, $surveyProposalId)
    {
        // Minimal validation
        $request->validate([
            'utility_file' => 'required|file|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Get survey proposal
            $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

            // Save Equipment Evaluation
            $equipment = EquipmentEvaluation::create([
                'name'=> $request->name,
                'user_id' => auth()->id(),
                'survey_proposal_id' => $surveyProposal->id,
            ] + $request->except(['utility_file', 'description']));
            // Add all numeric fields except the file + description

            // Save Equipment Image
            if ($request->hasFile('utility_file')) {

                $file = $request->file('utility_file');
                $original = $file->getClientOriginalName();
                $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$cleanName.'.'.$ext;

                $path = $file->storeAs('equipment/images', $filename, 'public');

                SurveyEquipmentImage::create([
                    'user_id' => auth()->id(),
                    'survey_equipment_id' => $equipment->id,
                    'description' => $request->description,
                    'file_name' => $original,
                    'file_path' => $path,
                    'file_type' => $ext,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Equipment evaluation saved successfully!',
                'equipment_id' => $equipment->id,
            ]);

        } catch (\Throwable $e) {

            Log::error("EquipmentEvaluation upload failed for survey_proposal={$surveyProposalId}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Equipment creation failed. Please try again later.',
            ], 500);
        }
    }

    public function survey_equipment_update(Request $request, $equipmentId)
{
    // Minimal validation (same as store)
    $request->validate([
        'utility_file' => 'nullable|file|max:10240', // optional in update
        'description' => 'nullable|string|max:500',
    ]);

    try {
        // Fetch equipment record
        $equipment = EquipmentEvaluation::findOrFail($equipmentId);

        // Update Equipment (all numeric fields & name)
        $equipment->update([
            'name' => $request->name,
        ] + $request->except(['utility_file', 'description']));  // exclude file & description

        // -----------------------------
        //  ✅ Handle NEW image upload
        // -----------------------------
        if ($request->hasFile('utility_file')) {

            $file = $request->file('utility_file');
            $original = $file->getClientOriginalName();
            $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
            $ext = $file->getClientOriginalExtension();
            $filename = Str::random(10).'_'.$cleanName.'.'.$ext;

            $path = $file->storeAs('equipment/images', $filename, 'public');

            SurveyEquipmentImage::create([
                'user_id' => auth()->id(),
                'survey_equipment_id' => $equipment->id,
                'description' => $request->description,
                'file_name' => $original,
                'file_path' => $path,
                'file_type' => $ext,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Equipment evaluation updated successfully!',
        ]);

    } catch (\Throwable $e) {

        Log::error("EquipmentEvaluation update failed for equipment={$equipmentId}: ".$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Equipment update failed. Please try again later.',
        ], 500);
    }
}

}
