<?php

namespace App\Http\Controllers;

use App\Models\BiologicalResponseIntake;
use App\Models\BiologicalResponseTreatedArea;
use App\Models\Company;
use App\Models\IAQDevice;
use App\Models\IAQZone;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function company_dashboard(Company $company)
    {
        $company = Company::with(['locations'])->findOrFail($company->id);
        $companyLocations = $company->locations;

        // Collect all zones
        $iaqZones = $companyLocations
            ->pluck('iaqZones')
            ->flatten();

        // Collect all devices
        $iaqDevices = $iaqZones
            ->pluck('iaqDevices')
            ->flatten();

        return view('admin.company.company-dashboard', [
            'company' => $company,
            'companyLocations' => $companyLocations,
            'iaqZones' => $iaqZones,
            'iaqDevices' => $iaqDevices,
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

            'more_than_2_rooms' => 'nullable|boolean',
            'high_consequence_infectious_disease' => 'nullable|boolean',

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
                'more_than_2_rooms' => 'required|boolean',
                'high_consequence_infectious_disease' => 'required|boolean',
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
                'more_than_2_rooms' => 'required|boolean',
                'high_consequence_infectious_disease' => 'required|boolean',
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

                'more_than_2_rooms' => $validated['more_than_2_rooms'] ?? 0,
                'high_consequence_infectious_disease' => $validated['high_consequence_infectious_disease'] ?? 0,

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
}
