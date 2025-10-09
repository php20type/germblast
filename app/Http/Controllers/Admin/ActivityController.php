<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function login_activity(Request $request)
    {
        $user_id = auth()->id();
        // Validate request
        $validated = $request->validate([
            'note' => 'required|string',
            'description' => 'required|string',
            'activity_type' => 'required|exists:activity_types,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string',
            'mentioned_company_ids' => 'nullable|string',
            'mentioned_people_ids' => 'nullable|string',
            'mentioned_user_ids' => 'nullable|string',
            'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        // Create Activity using validated data
        $activity = Activity::create([
            'user_id' => $user_id,
            'activity_type_id' => $validated['activity_type'],
            'note' => $validated['note'],
            'description' => $validated['description'],
            'owner_type' => $validated['owner_type'],
            'owner_id' => $validated['owner_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'] ?? null,
            'status' => $validated['status'] ?? null,
        ]);

        $participants = json_decode($request->participants, true);

        if ($participants && is_array($participants)) {
            foreach ($participants as $p) {
                switch ($p['type']) {
                    case 'company':
                        $activity->companies()->attach($p['id']);
                        break;
                    case 'people':
                        $activity->peoples()->attach($p['id']);
                        break;
                    case 'user':
                        $activity->users()->attach($p['id']);
                        break;
                    case 'lead':
                        $activity->leads()->attach($p['id']);
                        break;
                }
            }
        }

        // Helper function to convert comma-separated string to array
        $convertToArray = fn ($value) => array_filter(is_array($value) ? $value : explode(',', $value));

        // Attach related companies
        if ($request->filled('mentioned_company_ids')) {
            $activity->mentionCompanies()->sync($convertToArray($request->mentioned_company_ids));
        }

        // Attach related peoples
        if ($request->filled('mentioned_people_ids')) {
            $activity->mentionPeoples()->sync($convertToArray($request->mentioned_people_ids));
        }

        // Attach related users
        if ($request->filled('mentioned_user_ids')) {
            $activity->mentionUsers()->sync($convertToArray($request->mentioned_user_ids));
        }

        //  Return JSON response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Activity logged successfully!',
            'data' => $activity->load('companies', 'peoples', 'users'),
        ]);
    }
}
