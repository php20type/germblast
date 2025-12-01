<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStageProcess;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class LeadStageController extends Controller
{
    public function scheduleInitialMeeting(Request $request, Lead $lead, NotificationService $notify)
    {
        // 1. Validation
        $request->validate([
            'schedule_meeting_date' => 'required|date|after:now',
        ], [
            'schedule_meeting_date.after' => 'Meeting must be scheduled for a future time.',
        ]);

        // 2. Ensure stage process exists
        $stage = LeadStageProcess::firstOrCreate(
            ['lead_id' => $lead->id]
        );

        // 3. CONDITION: If meeting already completed, do not allow re-scheduling
        if ($stage->initial_meeting_completed_at) {
            return response()->json([
                'message' => 'Initial meeting is already completed. Cannot reschedule.',
            ], 422);
        }

        // 4. Save scheduled meeting
        $stage->update([
            'initial_meeting_scheduled_at' => $request->schedule_meeting_date,
        ]);

        $notify->initialMeetingScheduled($lead, $request->schedule_meeting_date);

        return response()->json([
            'message' => 'Initial meeting scheduled successfully.',
        ]);
    }

    public function completeInitialMeeting(Lead $lead, NotificationService $notify)
    {
        $stage = LeadStageProcess::firstOrCreate(['lead_id' => $lead->id]);

        if (! $stage->initial_meeting_scheduled_at) {
            return response()->json([
                'message' => 'You must schedule the meeting first.',
            ], 422);
        }

        if ($stage->initial_meeting_completed_at) {
            return response()->json([
                'message' => 'This stage is already completed.',
            ], 422);
        }

        $stage->update([
            'initial_meeting_completed_at' => now(),
            'initial_meeting_completed_by' => auth()->id(),
        ]);

        $notify->initialMeetingCompleted($lead);

        return response()->json([
            'message' => 'Initial meeting marked as completed.',
        ]);
    }

    public function reopenInitialMeeting(Lead $lead)
    {
        $stage = LeadStageProcess::where('lead_id', $lead->id)->first();

        if (! $stage) {
            return response()->json([
                'message' => 'Stage data not found.',
            ], 404);
        }

        // If nothing was completed, do not allow reopening
        if (! $stage->initial_meeting_completed_at && ! $stage->initial_meeting_scheduled_at) {
            return response()->json([
                'message' => 'Nothing to reopen for this stage.',
            ], 422);
        }

        // RESET the stage data
        $stage->update([
            'initial_meeting_scheduled_at' => null,
            'initial_meeting_completed_at' => null,
            'initial_meeting_completed_by' => null,
        ]);

        return response()->json([
            'message' => 'Initial meeting stage has been reopened successfully.',
        ]);
    }

    public function resetInitialMeeting(Lead $lead)
    {
        $stage = LeadStageProcess::where('lead_id', $lead->id)->first();

        if (! $stage) {
            return response()->json(['message' => 'Stage not found'], 404);
        }

        // Remove scheduled + completed data
        $stage->update([
            'initial_meeting_scheduled_at' => null,
            'initial_meeting_completed_at' => null,
            'initial_meeting_completed_by' => null,
        ]);

        return response()->json([
            'message' => 'Initial meeting reset. You can schedule again.',
        ]);
    }

    public function scheduleSiteSurvey(Request $request, Lead $lead, NotificationService $notify)
    {
        $request->validate([
            'site_survey_date' => 'required|date|after:now',
        ], [
            'site_survey_date.after' => 'Survey must be scheduled for a future time.',
        ]);

        $stage = LeadStageProcess::firstOrCreate(['lead_id' => $lead->id]);

        if ($stage->site_survey_completed_at) {
            return response()->json([
                'message' => 'Site survey is already completed. Cannot reschedule.',
            ], 422);
        }

        $stage->update([
            'site_survey_scheduled_at' => $request->site_survey_date,
        ]);

        // NOTIFY (Email/SMS)
        $notify->siteSurveyScheduled($lead, $stage);

        return response()->json([
            'message' => 'Site survey scheduled successfully.',
        ]);
    }

    public function completeSiteSurvey(Lead $lead, NotificationService $notify)
    {
        $stage = LeadStageProcess::firstOrCreate(['lead_id' => $lead->id]);

        if (! $stage->site_survey_scheduled_at) {
            return response()->json([
                'message' => 'You must schedule the site survey first.',
            ], 422);
        }

        if ($stage->site_survey_completed_at) {
            return response()->json([
                'message' => 'Site survey already completed.',
            ], 422);
        }

        $stage->update([
            'site_survey_completed_at' => now(),
            'site_survey_completed_by' => auth()->id(),
        ]);

        $notify->siteSurveyCompleted($lead, $stage);

        return response()->json([
            'message' => 'Site survey marked as completed.',
        ]);
    }

    public function reopenSiteSurvey(Lead $lead)
    {
        $stage = LeadStageProcess::firstOrCreate(['lead_id' => $lead->id]);

        if (! $stage->site_survey_completed_at) {
            return response()->json([
                'message' => 'Site survey is not completed yet.',
            ], 422);
        }

        $stage->update([
            'site_survey_completed_at' => null,
            'site_survey_completed_by' => null,
        ]);

        return response()->json([
            'message' => 'Site survey reopened.',
        ]);
    }

    public function resetSiteSurvey(Lead $lead)
    {
        $stage = LeadStageProcess::firstOrCreate(['lead_id' => $lead->id]);

        if ($stage->site_survey_completed_at) {
            return response()->json([
                'message' => 'Cannot edit. Site survey already completed.',
            ], 422);
        }

        $stage->update([
            'site_survey_scheduled_at' => null,
        ]);

        return response()->json([
            'message' => 'Site survey schedule removed. You can schedule again.',
        ]);
    }
}
