<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ZoomController;
use App\Models\ActivityType;
use App\Models\Lead;
use App\Models\Meeting;
use App\Models\People;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Calculate percent difference
    private function calculatePercentChange($current, $previous)
    {
        if ($previous == 0) {
            return 0;
        }

        return (int) round(abs(($current - $previous) / $previous * 100));
    }

    // Format sentence for change
    private function formatChangeSentence($current, $previous)
    {
        $diff = $current - $previous;
        $percent = $this->calculatePercentChange($current, $previous);
        if ($diff >= 0) {
            return "Up {$percent}% From {$previous} This Time Last Month";
        } else {
            return "Down {$percent}% From {$previous} This Time Last Month";
        }
    }

    private function calculateLeadData()
    {
        $today = Carbon::now();
        $startOfThisMonth = $today->copy()->startOfMonth();
        $endOfToday = $today->copy()->endOfDay();
        $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();

        // New Leads
        $newLeadsThisMonth = Lead::whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $newLeadsLastMonth = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $newLeadsDiff = $newLeadsThisMonth - $newLeadsLastMonth;
        $newLeadsPercent = $this->calculatePercentChange($newLeadsThisMonth, $newLeadsLastMonth);
        $newLeadsChange = $this->formatChangeSentence($newLeadsThisMonth, $newLeadsLastMonth);

        // Open Leads
        $openLeadsThisMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $openLeadsLastMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $openLeadsDiff = $openLeadsThisMonth - $openLeadsLastMonth;
        $openLeadsPercent = $this->calculatePercentChange($openLeadsThisMonth, $openLeadsLastMonth);
        $openLeadsChange = $this->formatChangeSentence($openLeadsThisMonth, $openLeadsLastMonth);

        // Sales (Won Leads)
        $salesLeadsThisMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfThisMonth, $endOfToday])->count();
        $salesLeadsLastMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfLastMonth, $endOfLastMonth])->count();
        $salesLeadsDiff = $salesLeadsThisMonth - $salesLeadsLastMonth;
        $salesLeadsPercent = $this->calculatePercentChange($salesLeadsThisMonth, $salesLeadsLastMonth);
        $salesLeadsChange = $this->formatChangeSentence($salesLeadsThisMonth, $salesLeadsLastMonth);

        // Section 2: Lead Summary
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $allLeads = Lead::all();
        $allLeadsCount = $allLeads->count();
        $allLeadsValue = Helper::calculateTotalValue($allLeads);
        $allLeadsValueFormatted = Helper::formatValue($allLeadsValue);

        $myLeads = Lead::where('assignee_id', auth()->id())->get();
        $myLeadsCount = $myLeads->count();
        $myLeadsValue = Helper::calculateTotalValue($myLeads);
        $myLeadsValueFormatted = Helper::formatValue($myLeadsValue);

        $addedThisWeek = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $addedThisWeekCount = $addedThisWeek->count();
        $addedThisWeekValue = Helper::calculateTotalValue($addedThisWeek);
        $addedThisWeekValueFormatted = Helper::formatValue($addedThisWeekValue);

        $closingThisWeek = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->get();
        $closingThisWeekCount = $closingThisWeek->count();
        $closingThisWeekValue = Helper::calculateTotalValue($closingThisWeek);
        $closingThisWeekValueFormatted = Helper::formatValue($closingThisWeekValue);

        $hotLeads = Lead::where('is_hot', 1)->get();
        $hotLeadsCount = $hotLeads->count();
        $hotLeadsValue = Helper::calculateTotalValue($hotLeads);
        $hotLeadsValueFormatted = Helper::formatValue($hotLeadsValue);

        // Section 3: Pipeline
        $gbPresentation = Lead::where('stage_id', 1)->get();
        $gbPresentationCount = $gbPresentation->count();
        $gbPresentationCountValue = Helper::calculateTotalValue($gbPresentation);
        $gbPresentationCountValueFormatted = Helper::formatValue($gbPresentationCountValue);

        $siteSurvey = Lead::where('stage_id', 2)->get();
        $siteSurveyCount = $siteSurvey->count();
        $siteSurveyCountValue = Helper::calculateTotalValue($siteSurvey);
        $siteSurveyCountValueFormatted = Helper::formatValue($siteSurveyCountValue);

        $proposalApproval = Lead::where('stage_id', 3)->get();
        $proposalApprovalCount = $proposalApproval->count();
        $proposalApprovalCountValue = Helper::calculateTotalValue($proposalApproval);
        $proposalApprovalCountValueFormatted = Helper::formatValue($proposalApprovalCountValue);

        $proposalPresentation = Lead::where('stage_id', 4)->get();
        $proposalPresentationCount = $proposalPresentation->count();
        $proposalPresentationCountValue = Helper::calculateTotalValue($proposalPresentation);
        $proposalPresentationCountValueFormatted = Helper::formatValue($proposalPresentationCountValue);

        $signedProposal = Lead::where('stage_id', 5)->get();
        $signedProposalCount = $signedProposal->count();
        $signedProposalCountValue = Helper::calculateTotalValue($signedProposal);
        $signedProposalCountValueFormatted = Helper::formatValue($signedProposalCountValue);

        return compact(
            'newLeadsThisMonth', 'newLeadsLastMonth', 'newLeadsDiff', 'newLeadsPercent',
            'openLeadsThisMonth', 'openLeadsLastMonth', 'openLeadsDiff', 'openLeadsPercent',
            'salesLeadsThisMonth', 'salesLeadsLastMonth', 'salesLeadsDiff', 'salesLeadsPercent',
            'newLeadsChange', 'openLeadsChange', 'salesLeadsChange',
            'allLeadsCount', 'myLeadsCount', 'addedThisWeekCount', 'closingThisWeekCount', 'hotLeadsCount',
            'allLeadsValue', 'myLeadsValue', 'addedThisWeekValue', 'closingThisWeekValue', 'hotLeadsValue',
            'allLeadsValueFormatted', 'myLeadsValueFormatted', 'addedThisWeekValueFormatted', 'closingThisWeekValueFormatted', 'hotLeadsValueFormatted',
            'gbPresentationCount', 'siteSurveyCount', 'proposalApprovalCount', 'proposalPresentationCount', 'signedProposalCount',
            'gbPresentationCountValueFormatted', 'siteSurveyCountValueFormatted', 'proposalApprovalCountValueFormatted', 'proposalPresentationCountValueFormatted', 'signedProposalCountValueFormatted'
        );
    }

    public function index(Request $request)
    {
        $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();
        $peoples = People::with('peopleEmail', 'peoplePhone', 'peopleAddress', 'peopleUrl', 'peopleCompany')->get();

        // Call separated calculation function
        $data = $this->calculateLeadData();

        $users = User::all();
        $activitytypes = ActivityType::all();

        // ==============
        // TIMELINE
        // ==============
        $user = auth()->user();
        $userId = $user->id;

        // --- Fetch Activities directly ---
        $activities = $user->activity()->with('comments.creator', 'peoples', 'companies', 'leads')->get();

        $activities->transform(function ($activity) {
            $participants = collect();
            $participants = $participants->merge($activity->peoples->pluck('name'));
            $participants = $participants->merge($activity->companies->pluck('name'));
            $participants = $participants->merge($activity->leads->pluck('name'));

            $activity->participant_names = $participants->join(', ');
            $activity->type = 'activity';
            $activity->timestamp = $activity->date;

            return $activity;
        });

        // --- Fetch Notes directly ---
        $notes = $user->note()->with('comments.creator', 'peoples', 'companies', 'users')->get();

        $notes->transform(function ($note) {
            $mentions = collect();
            $mentions = $mentions->merge($note->peoples->pluck('name'));
            $mentions = $mentions->merge($note->companies->pluck('name'));
            $mentions = $mentions->merge($note->users->pluck('name'));

            $note->mentioned_names = $mentions->join(', ');
            $note->type = 'note';
            $note->timestamp = $note->created_at;

            return $note;
        });

        // --- Fetch Timeline directly ---
        $timelineEntries = $user->timeline()->get();

        $timelineEntries->transform(function ($item) {
            $item->type = 'timeline';
            $item->timestamp = $item->created_at;

            return $item;
        });

        $activityFilters = [
            'filter_range' => $request->input('filter_range', 'all'),
            'activity_type_id' => $request->input('activity_type_id', 'all'),
            'user_id' => $userId,
            'status' => $request->input('status', 'all'),
        ];

        $timelineFilters = [
            'filter_range' => $request->input('filter_range', 'all'),
            'activity_type_id' => $request->input('activity_type_id', 'all'),
            'user_id' => $userId,
            'status' => $request->input('status', 'all'),
            'type' => $request->input('type', 'all'),
        ];

        $logged_activities = $activities->filter(fn ($a) => $a->status === 'Logged');
        $allactivities = $activities->filter(fn ($a) => in_array($a->status, ['Logged', 'Scheduled']));

        $activityFiltered = Helper::applySaleActivityFilters($allactivities, $activityFilters);
        $allactivities = $activityFiltered['allactivities'];

        // --- Milestones (based on user created_at) ---
        $milestones = collect();
        if ($user->created_at) {
            $createdAt = $user->created_at->copy();
            $now = now();
            $totalMonths = $createdAt->diffInMonths($now);

            for ($i = 1; $i <= $totalMonths; $i++) {
                $milestoneDate = $createdAt->copy()->addMonths($i);

                if ($i === 1) {
                    $label = '1 month since joining';
                } elseif ($i === 6) {
                    $label = '6 months since joining';
                } elseif ($i % 12 === 0) {
                    $years = $i / 12;
                    $label = $years === 1 ? '1 year since joining' : "{$years} years since joining";
                } else {
                    continue;
                }

                $milestones->push((object) [
                    'type' => 'milestone',
                    'title' => $label,
                    'timestamp' => $milestoneDate,
                ]);
            }
        }

        $timelineFiltered = Helper::applySaleTimelineFilters(
            $logged_activities,
            $notes,
            $timelineEntries,
            $milestones,
            $timelineFilters
        );

        $logged_activities = $timelineFiltered['logged_activities'];
        $notes = $timelineFiltered['notes'];
        $timelineEntries = $timelineFiltered['timelineEntries'];
        $milestones = $timelineFiltered['milestones'];

        // FINAL TIMELINE MERGE
        $timeline = $logged_activities
            ->concat($notes)
            ->concat($timelineEntries)
            ->concat($milestones)
            ->sortByDesc('timestamp')
            ->values();

        $alltasks = $user->taskAssignee()->get();

        // --- Apply Task Filters first ---
        $taskFilters = [
            'filter_range' => $request->input('filter_range', 'all'),
            'status' => $request->input('status', 'all'),
        ];

        $taskFiltered = Helper::applySaleTaskFilters($alltasks, $taskFilters);
        $filteredTasks = $taskFiltered['alltasks'];

        // --- Split after filtering ---
        $pendingTasks = $filteredTasks->filter(fn ($task) => is_null($task->completed_time));
        $completedTasks = $filteredTasks->filter(fn ($task) => ! is_null($task->completed_time));

        // Handle AJAX requests
        if ($request->ajax()) {
            if ($request->input('section') === 'timeline') {
                $timeline_html = view('admin.sales.sales-timeline-partial', compact('timeline'))->render();

                return response()->json(['timeline_html' => $timeline_html]);
            }

            if ($request->input('section') === 'logged_activities') {
                $activity_html = view('admin.sales.sales-activity-partial', compact('allactivities'))->render();

                return response()->json(['activity_html' => $activity_html]);
            }

            if ($request->ajax() && $request->input('section') === 'task') {
                $task_html = view('admin.sales.sales-task-partial', compact('pendingTasks', 'completedTasks'))->render();

                return response()->json(['task_html' => $task_html]);
            }

        }

        return view('admin.sales.index', array_merge(compact(
            'leads', 'peoples', 'users', 'activitytypes',
            'activities', 'logged_activities', 'allactivities',
            'notes', 'timeline', 'timelineEntries', 'alltasks', 'pendingTasks', 'completedTasks'
        ), $data));
    }

    public function schedule_meeting(Request $request)
    {
        $query = Meeting::with(['user', 'zoom', 'activityType'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc');

        // Search by meeting name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter by meeting type
        if ($request->filled('meeting_type')) {
            $query->where('meeting_type', $request->meeting_type);
        }

        $meetings = $query->get();
        $meetingsCount = $meetings->count();
        $activity_types = ActivityType::all();

        // AJAX response (same pattern as companies)
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.sales.meeting-table-rows', compact('meetings'))->render(),
                'count' => $meetingsCount,
            ]);
        }

        return view('admin.sales.meetings', compact('meetings', 'meetingsCount', 'activity_types'));
    }

    public function isMeetingSlotAvailable(int $userId, string $date, string $start, string $end): bool
    {
        return ! Meeting::where('user_id', $userId)
            ->where('date', $date)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();
    }

    public function store_meeting(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'meeting_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'meeting_type' => 'required|in:zoom,live',
            'location' => 'nullable|string|max:255',
            'activity_type_id' => 'required|exists:activity_types,id',
            'description' => 'required|string',
        ]);

        $start = Carbon::parse($validated['meeting_date'].' '.$validated['start_time']);
        $end = Carbon::parse($validated['meeting_date'].' '.$validated['end_time']);

        $isAvailable = $this->isMeetingSlotAvailable(
            auth()->id(),
            $validated['meeting_date'],
            $start->format('H:i:s'),
            $end->format('H:i:s')
        );

        if (! $isAvailable) {
            return response()->json([
                'success' => false,
                'message' => 'Selected time slot is already booked.',
            ], 422);
        }

        $meeting = Meeting::create([
            'user_id' => auth()->id(),
            'activity_type_id' => $validated['activity_type_id'],
            'name' => $validated['name'],
            'meeting_type' => $validated['meeting_type'],
            'duration' => $validated['duration'],
            'date' => $validated['meeting_date'],
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'location' => $validated['location'] ?? null,
            'status' => 'Pending',
            'description' => $validated['description'],
        ]);

        // Create Zoom meeting if needed (S2S OAuth flow already handled)
        if ($meeting->meeting_type === 'zoom') {
            app(ZoomController::class)->createMeeting(new Request, $meeting->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Meeting scheduled successfully!',
        ]);
    }

    public function show_meeting($id)
    {
        $meeting = Meeting::with('activityType')->findOrFail($id);

        return response()->json($meeting);
    }

    public function isMeetingSlotAvailableForUpdate(int $userId, string $date, string $start, string $end, int $ignoreMeetingId): bool
    {
        return ! Meeting::where('user_id', $userId)
            ->where('date', $date)
            ->where('id', '!=', $ignoreMeetingId) // ⬅ ignore self
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();
    }

    public function update_meeting(Request $request, $id)
    {
        $meeting = Meeting::with('zoom')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'meeting_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'meeting_type' => 'required|in:zoom,live',
            'location' => 'nullable|string|max:255',
            'activity_type_id' => 'required|exists:activity_types,id',
            'description' => 'required|string',
        ]);

        $start = Carbon::parse($validated['meeting_date'].' '.$validated['start_time']);
        $end = Carbon::parse($validated['meeting_date'].' '.$validated['end_time']);

        $isAvailable = $this->isMeetingSlotAvailableForUpdate(
            $meeting->user_id,
            $validated['meeting_date'],
            $start->format('H:i:s'),
            $end->format('H:i:s'),
            $meeting->id
        );

        if (! $isAvailable) {
            return response()->json([
                'success' => false,
                'message' => 'Selected time slot is already booked.',
            ], 422);
        }

        // keep old type for comparison
        $oldType = $meeting->meeting_type;
        $newType = $validated['meeting_type'];

        $meeting->update([
            'activity_type_id' => $validated['activity_type_id'],
            'name' => $validated['name'],
            'meeting_type' => $newType,
            'duration' => $validated['duration'],
            'date' => $validated['meeting_date'],
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'],
        ]);

        // Zoom → Zoom (update or create)
        if ($oldType === 'zoom' && $newType === 'zoom') {
            if ($meeting->zoom) {
                app(ZoomController::class)->updateMeeting($meeting);
            } else {
                app(ZoomController::class)->createMeeting(new Request, $meeting->id);
            }
        }

        // Live → Zoom (create)
        if ($oldType === 'live' && $newType === 'zoom') {
            app(ZoomController::class)->createMeeting(new Request, $meeting->id);
        }

        // Zoom → Live (delete)
        if ($oldType === 'zoom' && $newType === 'live' && $meeting->zoom) {
            app(ZoomController::class)->deleteMeeting($meeting);
        }

        return response()->json([
            'success' => true,
            'message' => 'Meeting updated successfully!',
        ]);
    }

    public function delete_meetings(Request $request)
    {
        $ids = (array) $request->ids;

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No meetings selected for deletion.',
            ], 400);
        }

        $meetings = Meeting::with('zoom')->whereIn('id', $ids)->get();

        foreach ($meetings as $meeting) {
            // Delete Zoom meeting if exists
            if ($meeting->meeting_type === 'zoom' && $meeting->zoom) {
                try {
                    app(\App\Services\ZoomService::class)
                        ->deleteMeeting($meeting->zoom->zoom_meeting_id);

                    $meeting->zoom->delete();
                } catch (\Throwable $e) {
                    // Ignore Zoom failure, continue deletion
                }
            }

            $meeting->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($ids) > 1
                ? 'Selected meetings deleted successfully.'
                : 'Meeting deleted successfully.',
        ]);
    }
}
