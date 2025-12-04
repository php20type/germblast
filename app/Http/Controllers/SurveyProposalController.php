<?php

namespace App\Http\Controllers;

use App\Models\EquipmentEvaluation;
use App\Models\EquipmentType;
use App\Models\FacilityRoomType;
use App\Models\Lead;
use App\Models\PricingProposal;
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

    public function pricing_store(Request $request)
    {
        $request->validate([
            'pricing_proposal_id' => 'required|integer|exists:pricing_proposals,id',

            // Facility & Equipment
            'facility_ids' => 'nullable|array',
            'facility_ids.*' => 'integer|exists:survey_facilities,id',

            'equipment_ids' => 'nullable|array',
            'equipment_ids.*' => 'integer|exists:equipment_evaluations,id',

            // Proposal settings
            'proposal_name' => 'nullable|string|max:255',
            'proposal_order' => 'nullable|integer',
            'override_pricing' => 'nullable|string|max:255',
            'discounts' => 'nullable|numeric',
            'descriptions' => 'nullable|string',

            // Contract details
            'services_per_year' => 'nullable|integer',
            'contract_terms' => 'nullable|integer',
            'prepayment_discount' => 'nullable',
        ]);

        try {
            $pricing = PricingProposal::findOrFail($request->pricing_proposal_id);

            /** STEP 1 — Sync facilities & equipment */
            $pricing->facilities()->sync($request->facility_ids ?? []);
            $pricing->equipment()->sync($request->equipment_ids ?? []);

            /** STEP 2 — Calculate totals */
            $totalFacilityCost = SurveyFacility::whereIn('id', $request->facility_ids ?? [])
                ->sum('man_hours_cost');

            $totalEquipmentCost = EquipmentEvaluation::whereIn('id', $request->equipment_ids ?? [])
                ->sum('wash_man_hours_cost');

            $partialCost = $totalFacilityCost + $totalEquipmentCost;
            $estimatedPricingTotal = $partialCost * 4.76;

            /** STEP 3 — Update database */
            $pricing->update([
                'partial_cost_service' => round($partialCost, 2),
                'pricing_total' => round($estimatedPricingTotal, 2),

                'proposal_name' => $request->proposal_name,
                'proposal_order' => $request->proposal_order,
                'override_pricing' => $request->override_pricing,
                'discounts' => $request->discounts,
                'descriptions' => $request->descriptions,

                'services_per_year' => $request->services_per_year,
                'contract_terms' => $request->contract_terms,
                'prepayment_discount' => $request->prepayment_discount,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pricing Proposal Saved Successfully!',
                'partial_cost_service' => round($partialCost, 2),
                'pricing_total' => round($estimatedPricingTotal, 2),
            ]);

        } catch (\Throwable $e) {
            Log::error('Save full proposal failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to save pricing proposal.',
            ], 500);
        }
    }

    public function updateExistingPricing(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:pricing_proposals,id',

            'facility_ids' => 'nullable|array',
            'facility_ids.*' => 'integer|exists:survey_facilities,id',

            'equipment_ids' => 'nullable|array',
            'equipment_ids.*' => 'integer|exists:equipment_evaluations,id',

            'proposal_name' => 'nullable|string|max:255',
            'proposal_order' => 'nullable|integer',
            'override_pricing' => 'nullable|string|max:255',
            'discounts' => 'nullable|numeric',
            'descriptions' => 'nullable|string',

            'services_per_year' => 'nullable|integer',
            'contract_terms' => 'nullable|integer',
            'prepayment_discount' => 'nullable|in:1,0',
        ]);

        try {

            $pricing = PricingProposal::findOrFail($request->id);

            // Sync facilities / equipment
            $pricing->facilities()->sync($request->facility_ids ?? []);
            $pricing->equipment()->sync($request->equipment_ids ?? []);

            // Recalculate totals
            $totalFacilityCost = SurveyFacility::whereIn('id', $request->facility_ids ?? [])->sum('man_hours_cost');
            $totalEquipmentCost = EquipmentEvaluation::whereIn('id', $request->equipment_ids ?? [])->sum('wash_man_hours_cost');

            $partialCost = $totalFacilityCost + $totalEquipmentCost;
            $estimatedPricingTotal = $partialCost * 4.76;

            // Update record
            $pricing->update([
                'partial_cost_service' => round($partialCost, 2),
                'pricing_total' => round($estimatedPricingTotal, 2),

                'proposal_name' => $request->proposal_name,
                'proposal_order' => $request->proposal_order,
                'override_pricing' => $request->override_pricing,
                'discounts' => $request->discounts,
                'descriptions' => $request->descriptions,

                'services_per_year' => $request->services_per_year,
                'contract_terms' => $request->contract_terms,
                'prepayment_discount' => $request->prepayment_discount,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pricing updated successfully!',
                'pricing_total' => round($estimatedPricingTotal, 2),
                'partial_cost_service' => round($partialCost, 2),
            ]);

        } catch (\Throwable $e) {
            Log::error('Update pricing failed: '.$e->getMessage());

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
}
