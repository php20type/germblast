<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SurveyFacility;
use App\Models\SurveyFacilityAtp;
use App\Models\SurveyFacilityMap;
use App\Models\SurveyProposal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SurveyProposalController extends Controller
{
    public function survey_proposal($leadId)
    {

        $lead = Lead::findOrFail($leadId);
        $surveyProposal = SurveyProposal::where('lead_id', $leadId)->first();

        return view('admin.leads.survey-proposal', compact('lead', 'surveyProposal'));
    }

    public function survey_proposal_store(Request $request, $leadId)
    {
        // All fields are required now (as per your updated form)
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

        // ⭐ ALWAYS calculate estimate (your simplified formula)
        $estimate =
            ($validated['enrollment']) +
            ($validated['wada']) +
            ($validated['aba']) +
            ($validated['service_technicians']) +
            ($validated['distance']) +
            ($validated['man_hours']);

        // Required fields we add manually
        $validated['lead_id'] = $leadId;
        $validated['user_id'] = auth()->id();  // ⭐ Correct way
        $validated['estimate'] = $estimate;

        // Store or update the survey proposal
        $proposal = SurveyProposal::updateOrCreate(
            ['lead_id' => $leadId],
            $validated
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Survey proposal updated successfully.',
            'estimate' => number_format($estimate, 2),
        ]);
    }

    public function survey_facility($leadId)
    {
        $lead = Lead::findOrFail($leadId);

        return view('admin.leads.survey-facility', compact('lead'));
    }

   public function survey_facility_store(Request $request, $leadId)
{
    // Validate inputs
    $request->validate([
        'facility_name'        => 'required|string|max:255',
        'address'              => 'required|string|max:255',
        'city'                 => 'required|string|max:255',
        'state'                => 'required|string|max:255',
        'zip'                  => 'required|string|max:20',
        'facility_type'        => 'required|string',

        'square_footage'       => 'required|numeric|min:0',
        'offices'              => 'required|numeric|min:0',
        'standard_bathrooms'   => 'required|numeric|min:0',
        'single_bathrooms'     => 'required|numeric|min:0',
        'man_hours'            => 'required|numeric|min:0',

        'map_name'             => 'required|string|max:255',
        'map_file'             => 'required|file|max:10240',

        'atp_location'         => 'required|string|max:255',
        'atp_value'            => 'required|numeric|min:0',
        'atp_file'             => 'required|file|max:10240',
    ]);

    try {
        // Get survey proposal
        $surveyProposal = SurveyProposal::where('lead_id', $leadId)->firstOrFail();

        // 1️⃣ Save Facility
        $facility = SurveyFacility::create([
            'user_id'            => auth()->id(),
            'survey_proposal_id' => $surveyProposal->id,

            'facility_name'      => $request->facility_name,
            'address'            => $request->address,
            'city'               => $request->city,
            'state'              => $request->state,
            'zip'                => $request->zip,
            'facility_type'      => $request->facility_type,

            'square_footage'     => $request->square_footage,
            'offices'            => $request->offices,
            'standard_bathrooms' => $request->standard_bathrooms,
            'single_bathrooms'   => $request->single_bathrooms,

            'man_hours'          => $request->man_hours,
            'man_hours_cost'     => $request->man_hours * 15,
        ]);

        // --------------------------------------------------------
        // SAVE MAP FILE (uses the same structure as your example)
        // --------------------------------------------------------
        if ($request->hasFile('map_file')) {

            $file      = $request->file('map_file');
            $original  = $file->getClientOriginalName();
            $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
            $ext       = $file->getClientOriginalExtension();
            $filename  = Str::random(10) . '_' . $cleanName . '.' . $ext;

            $path = $file->storeAs('facility/maps', $filename, 'public');

            SurveyFacilityMap::create([
                'survey_facility_id' => $facility->id,
                'name'               => $request->map_name,
                'file_name'          => $original,
                'file_path'          => $path,
                'file_type'          => $ext,
            ]);
        }

        // --------------------------------------------------------
        // SAVE ATP FILE
        // --------------------------------------------------------
        if ($request->hasFile('atp_file')) {

            $file      = $request->file('atp_file');
            $original  = $file->getClientOriginalName();
            $cleanName = Str::slug(pathinfo($original, PATHINFO_FILENAME));
            $ext       = $file->getClientOriginalExtension();
            $filename  = Str::random(10) . '_' . $cleanName . '.' . $ext;

            $path = $file->storeAs('facility/atp', $filename, 'public');

            SurveyFacilityAtp::create([
                'survey_facility_id' => $facility->id,
                'location'           => $request->atp_location,
                'value'              => $request->atp_value,
                'file_name'          => $original,
                'file_path'          => $path,
                'file_type'          => $ext,
            ]);
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Facility saved successfully!',
            'facility_id'  => $facility->id,
        ]);

    } catch (\Throwable $e) {

        Log::error("SurveyFacility upload failed for lead={$leadId}: ".$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Facility creation failed. Please try again later.',
        ], 500);
    }
}


    public function survey_equipment($leadId)
    {
        $lead = Lead::findOrFail($leadId);

        return view('admin.leads.survey-equipment', compact('lead'));
    }

    public function equipment_store(Request $request)
    {
        return 'Equipment information stored successfully';
    }
}
