<?php

namespace App\Http\Controllers;

use App\Models\EquipmentEvaluation;
use App\Models\EquipmentType;
use App\Models\FacilityRoomType;
use App\Models\Lead;
use App\Models\PricingProposal;
use App\Models\PricingService;
use App\Models\SurveyEquipmentImage;
use App\Models\SurveyFacility;
use App\Models\SurveyFacilityAtp;
use App\Models\SurveyFacilityMap;
use App\Models\SurveyProposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

        $totalSquareFootage = $facilities->sum('square_footage');
        $totalFacilityManHours = $facilities->sum('man_hours');
        $totalFacilityCost = $facilities->sum('man_hours_cost');

        $totalWashHours = $equipments->sum('wash_man_hours');
        $totalWashCost = $equipments->sum('wash_man_hours_cost');

        $totalCleanHours = $equipments->sum('cleaning_man_hours');
        $totalCleanCost = $equipments->sum('cleaning_man_hours_cost');

        $pricingProposals = PricingProposal::with(['facilities', 'equipment'])
            ->where('survey_proposal_id', $surveyProposal->id)
            ->get();

        return view('admin.leads.survey.survey-proposal', compact(
            'lead',
            'surveyProposal',
            'facilities',
            'equipments',
            'totalFacilityManHours',
            'totalFacilityCost',
            'totalSquareFootage',
            'totalWashHours',
            'totalWashCost',
            'totalCleanHours',
            'totalCleanCost',
            'pricingProposals'
        ));
    }

    public function survey_proposal_store(Request $request, $leadId)
    {
        $rules = [
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
        $facilityRoomTypes = FacilityRoomType::all();

        return view('admin.leads.survey.survey-facility', compact(
            'surveyProposal',
            'facilities',
            'facilityRoomTypes'
        ));
    }

    public function survey_facility_store(Request $request, $surveyProposalId)
    {
        // Validate only fixed fields (dynamic fields are validated in jQuery).
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'facility_type' => 'required|string',

            'map_name' => 'required|string|max:255',
            'map_file' => 'required|file|max:10240',

            'atp_location' => 'required|string|max:255',
            'atp_value' => 'required|numeric|min:0',
            'atp_file' => 'required|file|max:10240',
        ]);

        try {

            $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

            // -----------------------------------------
            // BUILD FACILITY DATA (fixed + dynamic)
            // -----------------------------------------
            $facilityData = [
                'user_id' => auth()->id(),
                'survey_proposal_id' => $surveyProposal->id,

                'facility_name' => $request->facility_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'facility_type' => $request->facility_type,
            ];

            // -----------------------------------------
            // ADD ALL DYNAMIC FIELDS FROM facility_room_types TABLE
            // -----------------------------------------
            $totalCount = 0;

            foreach (FacilityRoomType::all() as $type) {
                $value = intval($request->{$type->input_name} ?? 0);

                // Add field to data array
                $facilityData[$type->input_name] = $value;

                // Count for Man-Hours (all fields included)
                $totalCount += $value;
            }

            // -----------------------------------------
            // MAN-HOURS CALCULATION
            // -----------------------------------------
            // $manHours = $totalCount > 0 ? $totalCount * 0.5 : 0;
            $manHours = 0;

            foreach (FacilityRoomType::all() as $type) {

                $value = intval($request->{$type->input_name} ?? 0);

                // Save field dynamically
                $facilityData[$type->input_name] = $value;

                // Calculate man hours using DB value
                $manHours += $value * floatval($type->hours_required);
            }
            $manHoursCost = $manHours * 28.75;

            $facilityData['man_hours'] = $manHours;
            $facilityData['man_hours_cost'] = $manHoursCost;

            $facilityData['total_cost'] = round($manHoursCost, 2);

            // -----------------------------------------
            // CREATE FACILITY RECORD
            // -----------------------------------------
            $facility = SurveyFacility::create($facilityData);

            // -----------------------------------------
            // SAVE MAP FILE
            // -----------------------------------------
            if ($request->hasFile('map_file')) {

                $file = $request->file('map_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
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

            // -----------------------------------------
            // SAVE ATP FILE
            // -----------------------------------------
            if ($request->hasFile('atp_file')) {

                $file = $request->file('atp_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$clean.'.'.$ext;

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

            Log::error("SurveyFacility upload failed (proposal={$surveyProposalId}): ".$e->getMessage());

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
        $facilityRoomTypes = FacilityRoomType::all();
        $facilityMaps = SurveyFacilityMap::where('survey_facility_id', $facility->id)->get();
        $facilityAtps = SurveyFacilityAtp::where('survey_facility_id', $facility->id)->get();

        return view('admin.leads.survey.facility-edit', compact(
            'facility',
            'surveyProposalId',
            'facilityRoomTypes',
            'facilityMaps',
            'facilityAtps'
        ));
    }

    public function survey_facility_update(Request $request, $facilityId)
    {
        // Validate only fixed fields
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'facility_type' => 'required|string',

            'map_name' => 'nullable|string|max:255',
            'map_file' => 'nullable|file|max:10240',

            'atp_location' => 'nullable|string|max:255',
            'atp_value' => 'nullable|numeric|min:0',
            'atp_file' => 'nullable|file|max:10240',
        ]);

        try {

            $facility = SurveyFacility::findOrFail($facilityId);

            // -----------------------------------------
            // BUILD FACILITY DATA (fixed + dynamic)
            // -----------------------------------------
            $facilityData = [
                'facility_name' => $request->facility_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'facility_type' => $request->facility_type,
            ];

            // -----------------------------------------
            // DYNAMIC FIELDS FROM facility_room_types TABLE
            // -----------------------------------------
            $totalCount = 0;

            foreach (FacilityRoomType::all() as $type) {

                $value = intval($request->{$type->input_name} ?? 0);

                // Add dynamic fields to update array
                $facilityData[$type->input_name] = $value;

                $totalCount += $value;
            }

            // -----------------------------------------
            // MAN-HOURS CALCULATION
            // -----------------------------------------
            // $manHours = $totalCount > 0 ? $totalCount * 0.5 : 0;
            $manHours = 0;

            foreach (FacilityRoomType::all() as $type) {

                $value = intval($request->{$type->input_name} ?? 0);

                // Save field dynamically
                $facilityData[$type->input_name] = $value;

                // Calculate man hours using DB value
                $manHours += $value * floatval($type->hours_required);
            }
            $manHoursCost = $manHours * 28.75;

            $facilityData['man_hours'] = $manHours;
            $facilityData['man_hours_cost'] = $manHoursCost;

            // -----------------------------------------
            // UPDATE FACILITY RECORD
            // -----------------------------------------
            $facility->update($facilityData);

            // -----------------------------------------
            // UPDATE MAP FILE
            // -----------------------------------------
            if ($request->hasFile('map_file')) {

                $file = $request->file('map_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
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

            // -----------------------------------------
            // UPDATE ATP FILE
            // -----------------------------------------
            if ($request->hasFile('atp_file')) {

                $file = $request->file('atp_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$clean.'.'.$ext;
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
                'message' => 'Facility updated successfully!',
                'facility_id' => $facility->id,
            ]);

        } catch (\Throwable $e) {

            Log::error("Facility update failed (facility={$facilityId}): ".$e->getMessage());

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
        $washingTypes = EquipmentType::where('type', 'washing')->get();
        $cleaningTypes = EquipmentType::where('type', 'cleaning')->get();
        $equipmentTypes = EquipmentType::all();

        // Return the equipment page with proposal & equipment list
        return view('admin.leads.survey.survey-equipment', compact(
            'surveyProposal',
            'equipments',
            'equipmentTypes',
            'washingTypes',
            'cleaningTypes'
        ));
    }

    public function survey_equipment_edit($equipmentId)
    {
        $equipment = EquipmentEvaluation::findOrFail($equipmentId);
        $surveyProposalId = $equipment->survey_proposal_id;
        $equipmentImages = SurveyEquipmentImage::where('survey_equipment_id', $equipment->id)->get();
        $washingTypes = EquipmentType::where('type', 'washing')->get();
        $cleaningTypes = EquipmentType::where('type', 'cleaning')->get();
        $equipmentTypes = EquipmentType::all(); // optional, but useful if needed

        return view('admin.leads.survey.equipment-edit', compact(
            'equipment',
            'surveyProposalId',
            'equipmentImages',
            'washingTypes',
            'cleaningTypes',
            'equipmentTypes'
        ));
    }

    public function survey_equipment_store(Request $request, $surveyProposalId)
    {
        // Validate fixed fields only
        $request->validate([
            'name' => 'required|string|max:255',
            'utility_file' => 'required|file|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        try {

            $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

            // ------------------------------------------
            // BASE EQUIPMENT RECORD
            // ------------------------------------------
            $equipmentData = [
                'user_id' => auth()->id(),
                'survey_proposal_id' => $surveyProposal->id,
                'name' => $request->name,
            ];

            // ------------------------------------------
            // FETCH ALL EQUIPMENT TYPES
            // ------------------------------------------
            $washingTypes = EquipmentType::where('type', 'washing')->get();
            $cleaningTypes = EquipmentType::where('type', 'cleaning')->get();

            $washHours = 0;
            $cleanHours = 0;

            // ------------------------------------------
            // PROCESS WASHING FIELDS
            // ------------------------------------------
            foreach ($washingTypes as $type) {

                $count = intval($request->{$type->input_name} ?? 0);

                // Store dynamic value
                $equipmentData[$type->input_name] = $count;

                // Man-hours = count × hours_required
                $washHours += $count * floatval($type->hours_required);
            }

            // ------------------------------------------
            // PROCESS CLEANING FIELDS
            // ------------------------------------------
            foreach ($cleaningTypes as $type) {

                $count = intval($request->{$type->input_name} ?? 0);

                // Store dynamic value
                $equipmentData[$type->input_name] = $count;

                // Man-hours = count × hours_required
                $cleanHours += $count * floatval($type->hours_required);
            }

            // ------------------------------------------
            // COST CALCULATION
            // ------------------------------------------
            $washCost = $washHours * 28.75;
            $cleanCost = $cleanHours * 28.75;

            $equipmentData['wash_man_hours'] = $washHours;
            $equipmentData['wash_man_hours_cost'] = $washCost;
            $equipmentData['cleaning_man_hours'] = $cleanHours;
            $equipmentData['cleaning_man_hours_cost'] = $cleanCost;

            $equipmentData['total_cost'] = round($washCost + $cleanCost, 2);

            // ------------------------------------------
            // CREATE EQUIPMENT RECORD
            // ------------------------------------------
            $equipment = EquipmentEvaluation::create($equipmentData);

            // ------------------------------------------
            // SAVE IMAGE
            // ------------------------------------------
            if ($request->hasFile('utility_file')) {

                $file = $request->file('utility_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$clean.'.'.$ext;

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

            Log::error("EquipmentEvaluation store failed (proposal={$surveyProposalId}): ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Equipment creation failed. Please try again later.',
            ], 500);
        }
    }

    public function survey_equipment_update(Request $request, $equipmentId)
    {
        // Validate only fixed fields
        $request->validate([
            'name' => 'required|string|max:255',
            'utility_file' => 'nullable|file|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        try {

            $equipment = EquipmentEvaluation::findOrFail($equipmentId);

            // ------------------------------------------
            // BASE UPDATE DATA (fixed fields)
            // ------------------------------------------
            $equipmentData = [
                'name' => $request->name,
            ];

            // ------------------------------------------
            // FETCH ALL EQUIPMENT TYPES
            // ------------------------------------------
            $washingTypes = EquipmentType::where('type', 'washing')->get();
            $cleaningTypes = EquipmentType::where('type', 'cleaning')->get();

            $washHours = 0;
            $cleanHours = 0;

            // ------------------------------------------
            // UPDATE WASHING FIELDS
            // ------------------------------------------
            foreach ($washingTypes as $type) {

                $count = intval($request->{$type->input_name} ?? 0);

                // Store dynamic value
                $equipmentData[$type->input_name] = $count;

                // Man-hours = count × hours_required
                $washHours += $count * floatval($type->hours_required);
            }

            // ------------------------------------------
            // UPDATE CLEANING FIELDS
            // ------------------------------------------
            foreach ($cleaningTypes as $type) {

                $count = intval($request->{$type->input_name} ?? 0);

                $equipmentData[$type->input_name] = $count;

                // Man-hours = count × hours_required
                $cleanHours += $count * floatval($type->hours_required);
            }

            // ------------------------------------------
            // COST CALCULATION
            // ------------------------------------------
            $washCost = $washHours * 28.75;
            $cleanCost = $cleanHours * 28.75;

            $equipmentData['wash_man_hours'] = $washHours;
            $equipmentData['wash_man_hours_cost'] = $washCost;
            $equipmentData['cleaning_man_hours'] = $cleanHours;
            $equipmentData['cleaning_man_hours_cost'] = $cleanCost;

            // ------------------------------------------
            // UPDATE EQUIPMENT RECORD
            // ------------------------------------------
            $equipment->update($equipmentData);

            // ------------------------------------------
            // SAVE NEW IMAGE (optional)
            // ------------------------------------------
            if ($request->hasFile('utility_file')) {

                $file = $request->file('utility_file');
                $original = $file->getClientOriginalName();
                $clean = Str::slug(pathinfo($original, PATHINFO_FILENAME));
                $ext = $file->getClientOriginalExtension();
                $filename = Str::random(10).'_'.$clean.'.'.$ext;

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

            Log::error("EquipmentEvaluation update failed (id={$equipmentId}): ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Equipment update failed. Please try again later.',
            ], 500);
        }
    }

    public function pricing_proposal($surveyProposalId)
    {
        $surveyProposal = SurveyProposal::findOrFail($surveyProposalId);

        $facilities = SurveyFacility::where('survey_proposal_id', $surveyProposalId)->get();
        $equipments = EquipmentEvaluation::where('survey_proposal_id', $surveyProposalId)->get();

        return view('admin.leads.survey.add-pricing-proposal', compact(
            'surveyProposal',
            'facilities',
            'equipments'
        ));
    }

    public function pricing_store(Request $request, SurveyProposal $survey_proposal)
    {
        $validated = $request->validate([
            // Pricing values
            'pricing_total' => 'required|numeric|min:0',
            'partial_cost_service' => 'required|numeric|min:0',
            'awareness' => 'nullable|numeric|min:0',
            'education' => 'nullable|numeric|min:0',
            'technology' => 'nullable|numeric|min:0',
            'response' => 'nullable|numeric|min:0',
            'logistics_expense' => 'nullable|numeric|min:0',

            // Facility & Equipment
            'facility_ids' => 'nullable|array',
            'facility_ids.*' => 'integer|exists:survey_facilities,id',

            'equipment_ids' => 'nullable|array',
            'equipment_ids.*' => 'integer|exists:equipment_evaluations,id',

            // Proposal settings
            'proposal_name' => 'required|string|max:255',
            'proposal_order' => 'required|integer',
            'override_pricing' => 'required|numeric',
            'discounts' => 'nullable|numeric',
            'descriptions' => 'required|string',
            'services' => 'required|string',

            // Contract details
            'services_per_year' => 'required|integer',
            'contract_terms' => 'required|integer',
            'prepayment_discount' => 'required|boolean',
        ]);

        try {
            /** --------------------------------
             * STEP 1 — Create Pricing Proposal (NO UPDATE)
             * -------------------------------- */
            $pricing = PricingProposal::create([
                'survey_proposal_id' => $survey_proposal->id,

                'pricing_total' => $validated['pricing_total'],
                'partial_cost_service' => $validated['partial_cost_service'],
                'awareness' => $validated['awareness'] ?? 0,
                'education' => $validated['education'] ?? 0,
                'technology' => $validated['technology'] ?? 0,
                'response' => $validated['response'] ?? 0,
                'logistics_expense' => $validated['logistics_expense'] ?? 0,

                'proposal_name' => $validated['proposal_name'],
                'proposal_order' => $validated['proposal_order'],
                'override_pricing' => $validated['override_pricing'],
                'discounts' => $validated['discounts'] ?? 0,
                'descriptions' => $validated['descriptions'],

                'services_per_year' => $validated['services_per_year'],
                'contract_terms' => $validated['contract_terms'],
                'prepayment_discount' => $validated['prepayment_discount'],
            ]);

            /** --------------------------------
             * STEP 2 — Attach Facilities & Equipment
             * -------------------------------- */
            if (! empty($validated['facility_ids'])) {
                $pricing->facilities()->attach($validated['facility_ids']);
            }

            if (! empty($validated['equipment_ids'])) {
                $pricing->equipment()->attach($validated['equipment_ids']);
            }

            /** --------------------------------
             * STEP 3 — Save Services (CREATE ONLY)
             * -------------------------------- */
            $services = json_decode($validated['services'], true);

            if (! is_array($services)) {
                throw new \Exception('Invalid services payload');
            }

            foreach ($services as $service) {
                if (! empty($service['value'])) {
                    PricingService::create([
                        'pricing_id' => $pricing->id,
                        'service_name' => $service['value'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pricing Proposal Created Successfully!',
                'pricing_id' => $pricing->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('Pricing proposal creation failed', [
                'survey_proposal_id' => $survey_proposal->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create pricing proposal.',
            ], 500);
        }
    }

    public function pricing_proposal_edit(PricingProposal $pricing)
    {
        $pricing->load(['facilities', 'equipment']);

        $allFacilities = SurveyFacility::where(
            'survey_proposal_id',
            $pricing->survey_proposal_id
        )->get();

        $allEquipments = EquipmentEvaluation::where(
            'survey_proposal_id',
            $pricing->survey_proposal_id
        )->get();

        return view('admin.leads.survey.edit-pricing-proposal', [
            'pricingProposal' => $pricing,          // proposal being edited
            'allFacilities' => $allFacilities,      // dropdown options
            'allEquipments' => $allEquipments,      // dropdown options
            'facilities' => $pricing->facilities,   // selected
            'equipments' => $pricing->equipment,    // selected
        ]);
    }

    public function updateExistingPricing(Request $request, PricingProposal $pricing)
    {
        $validated = $request->validate([
            // Pricing values (already calculated in JS)
            'pricing_total' => 'required|numeric|min:0',
            'partial_cost_service' => 'required|numeric|min:0',
            'awareness' => 'nullable|numeric|min:0',
            'education' => 'nullable|numeric|min:0',
            'technology' => 'nullable|numeric|min:0',
            'response' => 'nullable|numeric|min:0',
            'logistics_expense' => 'nullable|numeric|min:0',

            // Facility & Equipment
            'facility_ids' => 'nullable|array',
            'facility_ids.*' => 'integer|exists:survey_facilities,id',

            'equipment_ids' => 'nullable|array',
            'equipment_ids.*' => 'integer|exists:equipment_evaluations,id',

            // Proposal settings
            'proposal_name' => 'required|string|max:255',
            'proposal_order' => 'required|integer',
            'override_pricing' => 'required|numeric',
            'discounts' => 'nullable|numeric',
            'descriptions' => 'required|string',
            'services' => 'required|string',

            // Contract details
            'services_per_year' => 'required|integer',
            'contract_terms' => 'required|integer',
            'prepayment_discount' => 'required|boolean',
        ]);

        try {
            /** --------------------------------
             * STEP 1 — Update Pricing Proposal
             * -------------------------------- */
            $pricing->update([
                'pricing_total' => $validated['pricing_total'],
                'partial_cost_service' => $validated['partial_cost_service'],
                'awareness' => $validated['awareness'] ?? 0,
                'education' => $validated['education'] ?? 0,
                'technology' => $validated['technology'] ?? 0,
                'response' => $validated['response'] ?? 0,
                'logistics_expense' => $validated['logistics_expense'] ?? 0,

                'proposal_name' => $validated['proposal_name'],
                'proposal_order' => $validated['proposal_order'],
                'override_pricing' => $validated['override_pricing'],
                'discounts' => $validated['discounts'] ?? 0,
                'descriptions' => $validated['descriptions'],

                'services_per_year' => $validated['services_per_year'],
                'contract_terms' => $validated['contract_terms'],
                'prepayment_discount' => $validated['prepayment_discount'],
            ]);

            /** --------------------------------
             * STEP 2 — Sync Facilities & Equipment
             * -------------------------------- */
            $pricing->facilities()->sync($validated['facility_ids'] ?? []);
            $pricing->equipment()->sync($validated['equipment_ids'] ?? []);

            /** --------------------------------
             * STEP 3 — Save Services
             * -------------------------------- */
            $services = json_decode($validated['services'], true);

            if (! is_array($services)) {
                throw new \Exception('Invalid services payload');
            }

            $pricing->pricingServices()->delete();

            foreach ($services as $service) {
                if (! empty($service['value'])) {
                    PricingService::create([
                        'pricing_id' => $pricing->id,
                        'service_name' => $service['value'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Pricing Proposal Updated Successfully!',
            ]);

        } catch (\Throwable $e) {
            Log::error('Pricing proposal update failed', [
                'pricing_id' => $pricing->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update pricing proposal.',
            ], 500);
        }
    }

    public function deletePricing(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:pricing_proposals,id',
        ]);

        try {
            $pricing = PricingProposal::findOrFail($request->id);

            // delete pivot relations
            $pricing->facilities()->detach();
            $pricing->equipment()->detach();

            // delete main entry
            $pricing->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pricing proposal deleted successfully.',
            ]);

        } catch (\Throwable $e) {
            Log::error('Delete pricing failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Deletion failed.',
            ], 500);
        }
    }

    public function survey_view(Request $request, $id)
    {
        $survey = SurveyProposal::with([
            'lead', 'company', 'user',
            'facilities',
            'equipmentEvaluations',
            'pricingProposal.pricingServices',
            'pricingProposal.facilities',
            'pricingProposal.equipment',
        ])->findOrFail($id);

        $date = Carbon::now();

        $selectedIds = collect(explode(',', $request->get('pricing_ids')))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values();

        $pricingDetails = PricingProposal::with([
            'facilities',
            'equipment',
            'pricingServices',
        ])
            ->when($selectedIds->isNotEmpty(), function ($q) use ($selectedIds) {
                $q->whereIn('id', $selectedIds);
            })
            ->where('survey_proposal_id', $survey->id)
            ->get();

        return view('survey-proposal.view', compact('survey', 'pricingDetails', 'date'));
    }

    public function survey_download(Request $request, $id)
    {
        $survey = SurveyProposal::with([
            'lead', 'company', 'user',
            'facilities',
            'equipmentEvaluations',
            'pricingProposal.pricingServices',
            'pricingProposal.facilities',
            'pricingProposal.equipment',
        ])->findOrFail($id);

        $selectedIds = explode(',', $request->get('pricing_ids'));

        $pricingDetails = PricingProposal::with(['facilities', 'equipment'])
            ->whereIn('id', $selectedIds)
            ->get();

        $pdf = Pdf::loadView('survey-proposal.final-pdf', compact('survey', 'pricingDetails'));

        return $pdf->download("survey_proposal_{$survey->id}.pdf");
    }
}
