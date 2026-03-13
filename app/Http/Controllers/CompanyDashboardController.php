<?php

namespace App\Http\Controllers;

use App\Models\BiologicalReadiness;
use App\Models\BiologicalReadinessInclude;
use App\Models\BiologicalResponseIntake;
use App\Models\BiologicalResponseTreatedArea;
use App\Models\Company;
use App\Models\IAQDevice;
use App\Models\IAQSurvey;
use App\Models\IAQZone;
use App\Models\ServiceOrder;
use App\Models\WaterManagementPhase;
use App\Models\WaterManagementTeam;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function company_dashboard(Company $company)
    {
        $company = Company::with(['locations', 'biologicalResponseIntakes', 'biologicalReadiness', 'iaqSurveys', 'waterManagementPhase'])->findOrFail($company->id);
        $companyLocations = $company->locations;

        // Collect all zones
        $iaqZones = $companyLocations
            ->pluck('iaqZones')
            ->flatten();

        // Collect all devices
        $iaqDevices = $iaqZones
            ->pluck('iaqDevices')
            ->flatten();

        $biologicalResponseIntakes = $company->biologicalResponseIntakes
            ->sortByDesc('created_at');

        $biologicalReadiness = $company->biologicalReadiness
            ->sortByDesc('created_at');

        $iaqSurveys = $company->iaqSurveys
            ->sortByDesc('created_at');

        $waterManagement = $company->waterManagementPhase->sortByDesc('created_at');

        $serviceOrders = ServiceOrder::whereHas('service.lead', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with(['service.lead'])->get();

        return view('admin.company.company-dashboard', [
            'company' => $company,
            'companyLocations' => $companyLocations,
            'iaqZones' => $iaqZones,
            'iaqDevices' => $iaqDevices,
            'biologicalResponseIntakes' => $biologicalResponseIntakes,
            'biologicalReadiness' => $biologicalReadiness,
            'iaqSurveys' => $iaqSurveys,
            'waterManagement' => $waterManagement,
            'serviceOrders'=> $serviceOrders
        ]);
    }

    public function storeIAQZone(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_location_id' => 'required|exists:company_locations,id',
        ]);

        IAQZone::create([
            'name' => $validated['name'],
            'company_location_id' => $validated['company_location_id'],
        ]);

        return response()->json([
            'message' => 'IAQ Zone added successfully.',
        ]);
    }

    public function editIAQZone(Company $company, $zoneId)
    {
        $zone = IAQZone::with('companyLocation')
            ->whereHas('companyLocation', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })
            ->findOrFail($zoneId);

        return response()->json([
            'data' => $zone,
        ]);
    }

    public function updateIAQZone(Request $request, Company $company, $zoneId)
    {
        $zone = IAQZone::whereHas('companyLocation', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })
            ->findOrFail($zoneId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_location_id' => 'required|exists:company_locations,id',
        ]);

        $zone->update($validated);

        return response()->json([
            'message' => 'IAQ Zone updated successfully.',
        ]);
    }

    public function storeIAQDevice(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'iaq_zone_id' => 'required|exists:iaq_zones,id',
            'node_id' => 'required|string|max:255',
        ]);

        IAQDevice::create([
            'name' => $validated['name'],
            'iaq_zone_id' => $validated['iaq_zone_id'],
            'node_id' => $validated['node_id'],
        ]);

        return response()->json([
            'message' => 'IAQ Device added successfully.',
        ]);
    }

    public function editIAQDevice(Company $company, $deviceId)
    {
        $device = IAQDevice::with('iaqZone.companyLocation')
            ->whereHas('iaqZone.companyLocation', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })
            ->findOrFail($deviceId);

        return response()->json([
            'data' => $device,
        ]);
    }

    public function updateIAQDevice(Request $request, Company $company, $deviceId)
    {
        $device = IAQDevice::whereHas('iaqZone.companyLocation', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })
            ->findOrFail($deviceId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'iaq_zone_id' => 'required|exists:iaq_zones,id',
            'node_id' => 'required|string|max:255',
        ]);

        $device->update($validated);

        return response()->json([
            'message' => 'IAQ Device updated successfully.',
        ]);
    }

    public function biological_response(Company $company)
    {
        $company->load('locations');
        $companyLocations = $company->locations;

        return view('admin.company.biological-response', [
            'company' => $company,
            'company_locations' => $companyLocations,
        ]);
    }

    public function biological_response_store(Request $request, Company $company)
    {
        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'project_name' => 'required|string|max:255',
            'project_address' => 'required|string|max:255',
            'project_city' => 'required|string|max:255',
            'project_state' => 'required|string|max:255',
            'project_zip' => 'required|string|max:50',
            'project_leader' => 'required|string|max:255',
            'comments' => 'required|string',

            /* ====================
               FRONTEND MANAGEMENT
            ==================== */
            'facility_type' => 'required|string|max:255',
            'casualties_or_illnesses' => 'required|string|max:255',
            'estimated_man_hours' => 'required|integer',
            'estimated_people' => 'required|integer',
            'type_of_loss' => 'required|string|max:255',
            'treated_areas' => 'required',

            /* ====================
               ADDITIONAL CONTACT
            ==================== */
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:50',

            /* ====================
               INSURANCE
            ==================== */
            'insurance_notified' => 'required|boolean',
            'insurance_company_name' => 'required|string|max:255',
            'insurance_phone' => 'required|string|max:50',
            'coverage_determination' => 'required|boolean',
            'coverage_amount' => 'required|numeric',
            'deductible' => 'required|numeric',
            'claim_number' => 'required|string|max:255',
            'adjuster_phone' => 'required|string|max:50',
            'insurance_email' => 'required|email|max:255',
            'limit_or_cap' => 'required|numeric',

            /* ====================
           ILLNESS / DEATH (OPTIONAL)
        ==================== */
            'person_travelled_outside' => 'nullable|boolean',
            'diagnosis' => 'nullable|boolean',
            'number_of_diagnosis' => 'nullable|integer',

            'cause_of_death' => 'nullable|string|max:255',
            'number_of_deaths' => 'nullable|integer',
            'body_unattended' => 'nullable|boolean',
            'unattended_days' => 'nullable|integer',

            /* ====================
           POLICE
        ==================== */
            'police_cleanup' => 'nullable|boolean',
            'police_number' => 'nullable|string|max:50',
            'overdose' => 'nullable|boolean',
            'gunshot' => 'nullable|boolean',
        ]);

        $type = $validated['casualties_or_illnesses'];

        /* ======================
           DEATH VALIDATION
        ====================== */
        if ($type === 'Death') {

            $request->validate([
                'cause_of_death' => 'required|string|max:255',
                'number_of_deaths' => 'required|integer|min:1',
                'body_unattended' => 'required|boolean',
                'death_more_than_2_rooms' => 'required|boolean',
                'death_high_consequence_infectious_disease' => 'required|boolean',
            ]);

            // unattended_days only required if body_unattended = 1
            if ($request->body_unattended == 1) {
                $request->validate([
                    'unattended_days' => 'required|integer|min:1',
                ]);
            }
        }

        /* ======================
           ILLNESS VALIDATION
        ====================== */
        if ($type === 'Illness') {

            $request->validate([
                'person_travelled_outside' => 'required|boolean',
                'diagnosis' => 'required|boolean',
                'number_of_diagnosis' => 'required|integer|min:1',
                'illness_more_than_2_rooms' => 'required|boolean',
                'illness_high_consequence_infectious_disease' => 'required|boolean',
            ]);
        }

        /* ======================
           POLICE (COMMON)
        ====================== */
        if (in_array($type, ['Death', 'Illness'])) {

            $request->validate([
                'police_cleanup' => 'required|boolean',
                'police_number' => 'required|string|max:50',
                'overdose' => 'required|boolean',
                'gunshot' => 'required|boolean',
            ]);
        }

        try {

            $moreThan2Rooms = 0;
            $highConsequence = 0;

            if ($type === 'Death') {
                $moreThan2Rooms = $request->death_more_than_2_rooms ?? 0;
                $highConsequence = $request->death_high_consequence_infectious_disease ?? 0;
            }

            if ($type === 'Illness') {
                $moreThan2Rooms = $request->illness_more_than_2_rooms ?? 0;
                $highConsequence = $request->illness_high_consequence_infectious_disease ?? 0;
            }

            $environmentHourlyRate = 250;
            $suppliesHourlyRate = 119;
            $wasteDisposal = 25;

            $environmentResponseTotal = $environmentHourlyRate * $validated['estimated_man_hours'];
            $responseSuppliesTotal = $suppliesHourlyRate * $validated['estimated_people'];

            $subTotal = $environmentResponseTotal + $responseSuppliesTotal;
            $total = $subTotal + $wasteDisposal;

            /* =========================
               CREATE INTAKE
            ========================= */
            $intake = BiologicalResponseIntake::create([
                'company_id' => $company->id,

                'project_name' => $validated['project_name'],
                'project_address' => $validated['project_address'],
                'project_city' => $validated['project_city'],
                'project_state' => $validated['project_state'],
                'project_zip' => $validated['project_zip'],
                'project_leader' => $validated['project_leader'],
                'comments' => $validated['comments'],

                'facility_type' => $validated['facility_type'],
                'casualties_or_illnesses' => $validated['casualties_or_illnesses'],
                'estimated_man_hours' => $validated['estimated_man_hours'],
                'estimated_people' => $validated['estimated_people'],
                'type_of_loss' => $validated['type_of_loss'],

                'contact_name' => $validated['contact_name'],
                'contact_title' => $validated['contact_title'],
                'contact_phone' => $validated['contact_phone'],

                'insurance_notified' => $validated['insurance_notified'],
                'insurance_company_name' => $validated['insurance_company_name'],
                'insurance_phone' => $validated['insurance_phone'],
                'coverage_determination' => $validated['coverage_determination'],
                'coverage_amount' => $validated['coverage_amount'],
                'deductible' => $validated['deductible'],
                'claim_number' => $validated['claim_number'],
                'adjuster_phone' => $validated['adjuster_phone'],
                'insurance_email' => $validated['insurance_email'],
                'limit_or_cap' => $validated['limit_or_cap'],

                /* ILLNESS / DEATH */
                'person_travelled_outside' => $validated['person_travelled_outside'] ?? 0,
                'diagnosis' => $validated['diagnosis'] ?? 0,
                'number_of_diagnosis' => $validated['number_of_diagnosis'] ?? null,

                'cause_of_death' => $validated['cause_of_death'] ?? null,
                'number_of_deaths' => $validated['number_of_deaths'] ?? null,
                'body_unattended' => $validated['body_unattended'] ?? 0,
                'unattended_days' => $validated['unattended_days'] ?? null,

                'more_than_2_rooms' => $moreThan2Rooms,
                'high_consequence_infectious_disease' => $highConsequence,

                /* POLICE */
                'police_cleanup' => $validated['police_cleanup'] ?? 0,
                'police_number' => $validated['police_number'] ?? null,
                'overdose' => $validated['overdose'] ?? 0,
                'gunshot' => $validated['gunshot'] ?? 0,

                //    COST CALCULATIONS
                'environment_hourly_rate' => $environmentHourlyRate,
                'environment_response_total' => $environmentResponseTotal,

                'supplies_hourly_rate' => $suppliesHourlyRate,
                'response_supplies_total' => $responseSuppliesTotal,

                'sub_total' => $subTotal,
                'waste_disposal' => $wasteDisposal,
                'total' => $total,
            ]);

            /* =========================
               STORE TREATED AREAS
            ========================= */

            $areas = json_decode($validated['treated_areas'], true);

            if (is_array($areas)) {
                foreach ($areas as $area) {
                    if (! empty($area['value'])) {
                        BiologicalResponseTreatedArea::create([
                            'biological_response_intake_id' => $intake->id,
                            'area_name' => $area['value'],
                        ]);
                    }
                }
            }

            return response()->json([
                'message' => 'Biological response intake created successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create biological response intake.',
            ], 500);
        }
    }

    public function biological_response_edit(Company $company, $intakeId)
    {
        $company->load('locations');

        $companyLocations = $company->locations;

        // Fetch intake that belongs to this company
        $intake = BiologicalResponseIntake::with('treatedAreas')
            ->where('company_id', $company->id)
            ->findOrFail($intakeId);

        return view('admin.company.biological-response-edit', [
            'company' => $company,
            'company_locations' => $companyLocations,
            'intake' => $intake,
        ]);
    }

    public function biological_response_update(Request $request, Company $company, $intakeId)
    {
        $intake = BiologicalResponseIntake::where('company_id', $company->id)
            ->findOrFail($intakeId);

        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'project_name' => 'required|string|max:255',
            'project_address' => 'required|string|max:255',
            'project_city' => 'required|string|max:255',
            'project_state' => 'required|string|max:255',
            'project_zip' => 'required|string|max:50',
            'project_leader' => 'required|string|max:255',
            'comments' => 'required|string',

            /* ====================
               FRONTEND MANAGEMENT
            ==================== */
            'facility_type' => 'required|string|max:255',
            'casualties_or_illnesses' => 'required|string|max:255',
            'estimated_man_hours' => 'required|integer',
            'estimated_people' => 'required|integer',
            'type_of_loss' => 'required|string|max:255',
            'treated_areas' => 'required',

            /* ====================
               ADDITIONAL CONTACT
            ==================== */
            'contact_name' => 'required|string|max:255',
            'contact_title' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:50',

            /* ====================
               INSURANCE
            ==================== */
            'insurance_notified' => 'required|boolean',
            'insurance_company_name' => 'required|string|max:255',
            'insurance_phone' => 'required|string|max:50',
            'coverage_determination' => 'required|boolean',
            'coverage_amount' => 'required|numeric',
            'deductible' => 'required|numeric',
            'claim_number' => 'required|string|max:255',
            'adjuster_phone' => 'required|string|max:50',
            'insurance_email' => 'required|email|max:255',
            'limit_or_cap' => 'required|numeric',

            /* ====================
               ILLNESS / DEATH (OPTIONAL)
            ==================== */
            'person_travelled_outside' => 'nullable|boolean',
            'diagnosis' => 'nullable|boolean',
            'number_of_diagnosis' => 'nullable|integer',

            'cause_of_death' => 'nullable|string|max:255',
            'number_of_deaths' => 'nullable|integer',
            'body_unattended' => 'nullable|boolean',
            'unattended_days' => 'nullable|integer',

            /* ====================
               POLICE
            ==================== */
            'police_cleanup' => 'nullable|boolean',
            'police_number' => 'nullable|string|max:50',
            'overdose' => 'nullable|boolean',
            'gunshot' => 'nullable|boolean',
        ]);

        $type = $validated['casualties_or_illnesses'];

        /* ======================
           DEATH VALIDATION
        ====================== */
        if ($type === 'Death') {

            $request->validate([
                'cause_of_death' => 'required|string|max:255',
                'number_of_deaths' => 'required|integer|min:1',
                'body_unattended' => 'required|boolean',
                'death_more_than_2_rooms' => 'required|boolean',
                'death_high_consequence_infectious_disease' => 'required|boolean',
            ]);

            if ($request->body_unattended == 1) {
                $request->validate([
                    'unattended_days' => 'required|integer|min:1',
                ]);
            }
        }

        /* ======================
           ILLNESS VALIDATION
        ====================== */
        if ($type === 'Illness') {

            $request->validate([
                'person_travelled_outside' => 'required|boolean',
                'diagnosis' => 'required|boolean',
                'number_of_diagnosis' => 'required|integer|min:1',
                'illness_more_than_2_rooms' => 'required|boolean',
                'illness_high_consequence_infectious_disease' => 'required|boolean',
            ]);
        }

        /* ======================
           POLICE (COMMON)
        ====================== */
        if (in_array($type, ['Death', 'Illness'])) {

            $request->validate([
                'police_cleanup' => 'required|boolean',
                'police_number' => 'required|string|max:50',
                'overdose' => 'required|boolean',
                'gunshot' => 'required|boolean',
            ]);
        }

        try {

            /* ======================
               NORMALIZE FLAGS
            ====================== */
            $moreThan2Rooms = 0;
            $highConsequence = 0;

            if ($type === 'Death') {
                $moreThan2Rooms = $request->death_more_than_2_rooms ?? 0;
                $highConsequence = $request->death_high_consequence_infectious_disease ?? 0;
            }

            if ($type === 'Illness') {
                $moreThan2Rooms = $request->illness_more_than_2_rooms ?? 0;
                $highConsequence = $request->illness_high_consequence_infectious_disease ?? 0;
            }

            /* ======================
               COST CALCULATION
            ====================== */
            $environmentHourlyRate = 250;
            $suppliesHourlyRate = 119;
            $wasteDisposal = 25;

            $environmentResponseTotal = $environmentHourlyRate * $validated['estimated_man_hours'];
            $responseSuppliesTotal = $suppliesHourlyRate * $validated['estimated_people'];

            $subTotal = $environmentResponseTotal + $responseSuppliesTotal;
            $total = $subTotal + $wasteDisposal;

            /* =========================
               UPDATE INTAKE
            ========================= */
            $intake->update([

                'project_name' => $validated['project_name'],
                'project_address' => $validated['project_address'],
                'project_city' => $validated['project_city'],
                'project_state' => $validated['project_state'],
                'project_zip' => $validated['project_zip'],
                'project_leader' => $validated['project_leader'],
                'comments' => $validated['comments'],

                'facility_type' => $validated['facility_type'],
                'casualties_or_illnesses' => $validated['casualties_or_illnesses'],
                'estimated_man_hours' => $validated['estimated_man_hours'],
                'estimated_people' => $validated['estimated_people'],
                'type_of_loss' => $validated['type_of_loss'],

                'contact_name' => $validated['contact_name'],
                'contact_title' => $validated['contact_title'],
                'contact_phone' => $validated['contact_phone'],

                'insurance_notified' => $validated['insurance_notified'],
                'insurance_company_name' => $validated['insurance_company_name'],
                'insurance_phone' => $validated['insurance_phone'],
                'coverage_determination' => $validated['coverage_determination'],
                'coverage_amount' => $validated['coverage_amount'],
                'deductible' => $validated['deductible'],
                'claim_number' => $validated['claim_number'],
                'adjuster_phone' => $validated['adjuster_phone'],
                'insurance_email' => $validated['insurance_email'],
                'limit_or_cap' => $validated['limit_or_cap'],

                /* ILLNESS / DEATH */
                'person_travelled_outside' => $validated['person_travelled_outside'] ?? 0,
                'diagnosis' => $validated['diagnosis'] ?? 0,
                'number_of_diagnosis' => $validated['number_of_diagnosis'] ?? null,

                'cause_of_death' => $validated['cause_of_death'] ?? null,
                'number_of_deaths' => $validated['number_of_deaths'] ?? null,
                'body_unattended' => $validated['body_unattended'] ?? 0,
                'unattended_days' => $validated['unattended_days'] ?? null,

                'more_than_2_rooms' => $moreThan2Rooms,
                'high_consequence_infectious_disease' => $highConsequence,

                /* POLICE */
                'police_cleanup' => $validated['police_cleanup'] ?? 0,
                'police_number' => $validated['police_number'] ?? null,
                'overdose' => $validated['overdose'] ?? 0,
                'gunshot' => $validated['gunshot'] ?? 0,

                /* COST */
                'environment_hourly_rate' => $environmentHourlyRate,
                'environment_response_total' => $environmentResponseTotal,
                'supplies_hourly_rate' => $suppliesHourlyRate,
                'response_supplies_total' => $responseSuppliesTotal,
                'sub_total' => $subTotal,
                'waste_disposal' => $wasteDisposal,
                'total' => $total,
            ]);

            /* =========================
               UPDATE TREATED AREAS
            ========================= */
            $intake->treatedAreas()->delete();

            $areas = json_decode($validated['treated_areas'], true);

            if (is_array($areas)) {
                foreach ($areas as $area) {
                    if (! empty($area['value'])) {
                        BiologicalResponseTreatedArea::create([
                            'biological_response_intake_id' => $intake->id,
                            'area_name' => $area['value'],
                        ]);
                    }
                }
            }

            return response()->json([
                'message' => 'Biological response intake updated successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to update biological response intake.',
            ], 500);
        }
    }

    public function biological_readiness(Company $company)
    {
        $company->load('locations');
        $companyLocations = $company->locations;

        return view('admin.company.biological-readiness', [
            'company' => $company,
            'company_locations' => $companyLocations,
        ]);
    }

    public function biological_readiness_store(Request $request, Company $company)
    {
        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'project_name' => 'required|string|max:255',
            'status' => 'required|string|max:50',

            'per_hour_reduction_amount' => 'nullable|numeric',
            'length' => 'required|integer|min:1',
            'monthly_rate' => 'required|numeric',

            /* ====================
               READINESS DETAILS
            ==================== */
            'default_readiness_includes_1' => 'required|string',
            'default_readiness_includes_2' => 'required|string',
            'additional_includes' => 'nullable',
        ]);

        try {

            /* ======================
               COST CALCULATION
            ====================== */
            $lineTotal = $validated['length'] * $validated['monthly_rate'];

            /* =========================
               CREATE READINESS
            ========================= */
            $readiness = BiologicalReadiness::create([
                'company_id' => $company->id,

                'status' => $validated['status'],
                'project_name' => $validated['project_name'],

                'per_hour_reduction_amount' => $validated['per_hour_reduction_amount'] ?? null,
                'length' => $validated['length'],
                'monthly_rate' => $validated['monthly_rate'],

                'default_readiness_includes_1' => $validated['default_readiness_includes_1'],
                'default_readiness_includes_2' => $validated['default_readiness_includes_2'],

                // fixed description as per requirement
                'service_description' => 'Monthly Readiness Program',

                'line_total' => $lineTotal,
            ]);

            /* =========================
               STORE ADDITIONAL INCLUDES
            ========================= */
            if (! empty($validated['additional_includes'])) {

                $includes = json_decode($validated['additional_includes'], true);

                if (is_array($includes)) {
                    foreach ($includes as $item) {
                        if (! empty($item['value'])) {
                            BiologicalReadinessInclude::create([
                                'biological_readiness_id' => $readiness->id,
                                'includes' => $item['value'],
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'Biological readiness created successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create biological readiness.',
            ], 500);
        }
    }

    public function biological_readiness_edit(Company $company, $readinessId)
    {
        $company->load('locations');

        $companyLocations = $company->locations;

        // Fetch readiness that belongs to this company
        $readiness = BiologicalReadiness::with('includes')
            ->where('company_id', $company->id)
            ->findOrFail($readinessId);

        return view('admin.company.biological-readiness-edit', [
            'company' => $company,
            'company_locations' => $companyLocations,
            'readiness' => $readiness,
        ]);
    }

    public function biological_readiness_update(Request $request, Company $company, $readinessId)
    {
        $readiness = BiologicalReadiness::where('company_id', $company->id)
            ->findOrFail($readinessId);

        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'project_name' => 'required|string|max:255',
            'status' => 'required|string|max:50',

            'per_hour_reduction_amount' => 'nullable|numeric',
            'length' => 'required|integer|min:1',
            'monthly_rate' => 'required|numeric',

            /* ====================
               READINESS DETAILS
            ==================== */
            'default_readiness_includes_1' => 'required|string',
            'default_readiness_includes_2' => 'required|string',
            'additional_includes' => 'nullable',
        ]);

        try {

            /* ======================
               COST CALCULATION
            ====================== */
            $lineTotal = $validated['length'] * $validated['monthly_rate'];

            /* =========================
               UPDATE READINESS
            ========================= */
            $readiness->update([

                'status' => $validated['status'],
                'project_name' => $validated['project_name'],

                'per_hour_reduction_amount' => $validated['per_hour_reduction_amount'] ?? null,
                'length' => $validated['length'],
                'monthly_rate' => $validated['monthly_rate'],

                'default_readiness_includes_1' => $validated['default_readiness_includes_1'],
                'default_readiness_includes_2' => $validated['default_readiness_includes_2'],

                // fixed description as per requirement
                'service_description' => 'Monthly Readiness Program',

                'line_total' => $lineTotal,
            ]);

            /* =========================
               UPDATE ADDITIONAL INCLUDES
            ========================= */
            $readiness->includes()->delete();

            if (! empty($validated['additional_includes'])) {

                $includes = json_decode($validated['additional_includes'], true);

                if (is_array($includes)) {
                    foreach ($includes as $item) {
                        if (! empty($item['value'])) {
                            BiologicalReadinessInclude::create([
                                'biological_readiness_id' => $readiness->id,
                                'includes' => $item['value'],
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'message' => 'Biological readiness updated successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to update biological readiness.',
            ], 500);
        }
    }

    public function iaq_survey(Company $company)
    {
        $company->load('locations');
        $companyLocations = $company->locations;

        return view('admin.company.iaq-survey', [
            'company' => $company,
            'company_locations' => $companyLocations,
        ]);
    }

    public function iaq_survey_store(Request $request, Company $company)
    {
        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'survey_name' => 'required|string',
            'building_description' => 'required|string',
            'reported_issues' => 'required|string',

            /* ====================
               GENERAL WALKTHROUGH
            ==================== */
            'odor' => 'required|boolean',
            'dirty_unsanitary' => 'required|boolean',
            'visible_microbial' => 'required|boolean',
            'material_staining' => 'required|boolean',
            'adequate_ventilation' => 'required|boolean',
            'hvac_duct_blocked' => 'required|boolean',
            'filter_adequate' => 'required|boolean',
            'chemical_storage' => 'required|boolean',
            'temp_within_ashre' => 'required|boolean',
            'overcrowding' => 'required|boolean',
            'poor_iaq_activities' => 'required|boolean',
            'water_intrusion' => 'required|boolean',
            'carpet_present' => 'required|boolean',
            'pest_management' => 'required|boolean',
            'dirty_air_diffusers' => 'required|boolean',
            'mhvac_equipment' => 'required|boolean',

            /* ====================
               SAMPLING DETAILS
            ==================== */
            'location' => 'required|string|max:255',
            'parameter' => 'required|string|max:100',
            'volume' => 'required|string|max:100',
            'sampler' => 'required|string|max:255',

            /* optional text fields */
            'result' => 'nullable|string',
        ]);

        try {

            IAQSurvey::create(array_merge(
                ['company_id' => $company->id],
                $request->all()
            ));

            return response()->json([
                'message' => 'IAQ survey created successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to create IAQ survey.',
            ], 500);
        }
    }

    public function iaq_survey_edit(Company $company, $surveyId)
    {
        $company->load('locations');

        $survey = IaqSurvey::where('company_id', $company->id)
            ->findOrFail($surveyId);

        return view('admin.company.iaq-survey-edit', [
            'company' => $company,
            'company_locations' => $company->locations,
            'survey' => $survey,
        ]);
    }

    public function iaq_survey_update(Request $request, Company $company, $surveyId)
    {
        $survey = IaqSurvey::where('company_id', $company->id)
            ->findOrFail($surveyId);

        $validated = $request->validate([

            /* ====================
               BASIC INFORMATION
            ==================== */
            'survey_name' => 'required|string',
            'building_description' => 'required|string',
            'reported_issues' => 'required|string',

            /* ====================
               GENERAL WALKTHROUGH
            ==================== */
            'odor' => 'required|boolean',
            'dirty_unsanitary' => 'required|boolean',
            'visible_microbial' => 'required|boolean',
            'material_staining' => 'required|boolean',
            'adequate_ventilation' => 'required|boolean',
            'hvac_duct_blocked' => 'required|boolean',
            'filter_adequate' => 'required|boolean',
            'chemical_storage' => 'required|boolean',
            'temp_within_ashre' => 'required|boolean',
            'overcrowding' => 'required|boolean',
            'poor_iaq_activities' => 'required|boolean',
            'water_intrusion' => 'required|boolean',
            'carpet_present' => 'required|boolean',
            'pest_management' => 'required|boolean',
            'dirty_air_diffusers' => 'required|boolean',
            'mhvac_equipment' => 'required|boolean',

            /* ====================
               SAMPLING DETAILS
            ==================== */
            'location' => 'required|string|max:255',
            'parameter' => 'required|string|max:100',
            'volume' => 'required|string|max:100',
            'sampler' => 'required|string|max:255',

            'result' => 'nullable|string',
        ]);

        try {

            $survey->update($request->all());

            return response()->json([
                'message' => 'IAQ survey updated successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to update IAQ survey.',
            ], 500);
        }
    }

    public function water_management(Company $company)
    {
        $company->load('locations');

        return view('admin.company.water-management', [
            'company' => $company,
            'company_locations' => $company->locations,
        ]);
    }

    public function water_management_store(Request $request, Company $company)
    {
        $validated = $request->validate([

            /* =====================
               BASIC DETAILS
            ===================== */
            'survey_name' => 'required|string|max:255',
            'municipal_water_supplier' => 'required|string|max:255',

            /* =====================
               WMP TEAM DETAILS (ARRAY)
            ===================== */
            'wmp_team_name' => 'required|array|min:1',
            'wmp_team_name.*' => 'required|string|max:255',

            'wmp_team_role' => 'required|array|min:1',
            'wmp_team_role.*' => 'required|string|max:255',

            'wmp_team_email' => 'required|array|min:1',
            'wmp_team_email.*' => 'required|email|max:255',

            /* =====================
               FACILITY RISK FACTORS
            ===================== */
            'is_healthcare_facility' => 'required|boolean',
            'houses_elderly_patients' => 'required|boolean',
            'has_multiple_housing_units' => 'required|boolean',
            'has_more_than_two_floors' => 'required|boolean',
            'has_cooling_tower' => 'required|boolean',
            'has_hot_tub_or_spa' => 'required|boolean',
            'has_indoor_fountain' => 'required|boolean',
            'has_central_mister_or_humidifier' => 'required|boolean',
            'conducts_organ_transplant' => 'required|boolean',
            'history_of_legionella' => 'required|boolean',

            /* =====================
               MONITORING DETAILS
            ===================== */
            'current_monitoring_activities' => 'nullable|string',
        ]);

        try {

            /* =====================
               CREATE WATER MANAGEMENT PHASE
            ===================== */
            $phase = WaterManagementPhase::create([
                'company_id' => $company->id,
                'survey_name' => $validated['survey_name'],
                'municipal_water_supplier' => $validated['municipal_water_supplier'],

                'is_healthcare_facility' => $validated['is_healthcare_facility'],
                'houses_elderly_patients' => $validated['houses_elderly_patients'],
                'has_multiple_housing_units' => $validated['has_multiple_housing_units'],
                'has_more_than_two_floors' => $validated['has_more_than_two_floors'],
                'has_cooling_tower' => $validated['has_cooling_tower'],
                'has_hot_tub_or_spa' => $validated['has_hot_tub_or_spa'],
                'has_indoor_fountain' => $validated['has_indoor_fountain'],
                'has_central_mister_or_humidifier' => $validated['has_central_mister_or_humidifier'],
                'conducts_organ_transplant' => $validated['conducts_organ_transplant'],
                'history_of_legionella' => $validated['history_of_legionella'],

                'current_monitoring_activities' => $validated['current_monitoring_activities'] ?? null,
            ]);

            /* =====================
               STORE WMP TEAM MEMBERS
            ===================== */
            foreach ($validated['wmp_team_name'] as $index => $name) {

                WaterManagementTeam::create([
                    'water_management_phase_id' => $phase->id,
                    'name' => $name,
                    'role' => $validated['wmp_team_role'][$index] ?? null,
                    'email' => $validated['wmp_team_email'][$index] ?? null,
                ]);
            }

            return response()->json([
                'message' => 'Water management details saved successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to save water management details.',
            ], 500);
        }
    }

    public function water_management_edit(Company $company, $surveyId)
    {
        $waterManagement = WaterManagementPhase::with('waterManagementTeams')
            ->where('company_id', $company->id)
            ->findOrFail($surveyId);

        return view('admin.company.water-management-edit', [
            'company' => $company,
            'waterManagement' => $waterManagement,
        ]);
    }

    public function water_management_update(Request $request, Company $company, $surveyId)
    {
        $waterManagement = WaterManagementPhase::where('company_id', $company->id)
            ->findOrFail($surveyId);

        $validated = $request->validate([
            'survey_name' => 'required|string|max:255',
            'municipal_water_supplier' => 'required|string|max:255',

            'wmp_team_name' => 'required|array|min:1',
            'wmp_team_name.*' => 'required|string|max:255',

            'wmp_team_role' => 'required|array|min:1',
            'wmp_team_role.*' => 'required|string|max:255',

            'wmp_team_email' => 'required|array|min:1',
            'wmp_team_email.*' => 'required|email|max:255',

            'is_healthcare_facility' => 'required|boolean',
            'houses_elderly_patients' => 'required|boolean',
            'has_multiple_housing_units' => 'required|boolean',
            'has_more_than_two_floors' => 'required|boolean',
            'has_cooling_tower' => 'required|boolean',
            'has_hot_tub_or_spa' => 'required|boolean',
            'has_indoor_fountain' => 'required|boolean',
            'has_central_mister_or_humidifier' => 'required|boolean',
            'conducts_organ_transplant' => 'required|boolean',
            'history_of_legionella' => 'required|boolean',

            'current_monitoring_activities' => 'nullable|string',
        ]);

        try {

            $waterManagement->update([
                'survey_name' => $validated['survey_name'],
                'municipal_water_supplier' => $validated['municipal_water_supplier'],
                'is_healthcare_facility' => $validated['is_healthcare_facility'],
                'houses_elderly_patients' => $validated['houses_elderly_patients'],
                'has_multiple_housing_units' => $validated['has_multiple_housing_units'],
                'has_more_than_two_floors' => $validated['has_more_than_two_floors'],
                'has_cooling_tower' => $validated['has_cooling_tower'],
                'has_hot_tub_or_spa' => $validated['has_hot_tub_or_spa'],
                'has_indoor_fountain' => $validated['has_indoor_fountain'],
                'has_central_mister_or_humidifier' => $validated['has_central_mister_or_humidifier'],
                'conducts_organ_transplant' => $validated['conducts_organ_transplant'],
                'history_of_legionella' => $validated['history_of_legionella'],
                'current_monitoring_activities' => $validated['current_monitoring_activities'] ?? null,
            ]);

            $waterManagement->waterManagementTeams()->delete();
            /* =====================
            STORE WMP TEAM MEMBERS
            ===================== */
            foreach ($validated['wmp_team_name'] as $index => $name) {

                WaterManagementTeam::create([
                    'water_management_phase_id' => $waterManagement->id,
                    'name' => $name,
                    'role' => $validated['wmp_team_role'][$index] ?? null,
                    'email' => $validated['wmp_team_email'][$index] ?? null,
                ]);
            }

            return response()->json([
                'message' => 'Water management details saved successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update water management details.',
            ], 500);
        }
    }
}
