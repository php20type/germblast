<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Lead;
use App\Models\Meeting;
use App\Models\People;
use App\Models\User;
use App\Models\ZoomMeeting;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function schedule_meeting()
    {
        $meetings = Meeting::with(['user', 'zoom'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.sales.meetings', compact('meetings'));
    }

    public function store(Request $request, ZoomService $zoomService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'day' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'meeting_type' => 'required|in:zoom,live',
            'activity_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            // STEP 1 — Create base meeting
            $meeting = Meeting::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'duration' => $request->duration,
                'date' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'meeting_type' => $request->meeting_type,
                'status' => 'Pending',
                'description' => $request->description,
                'activity_type_id' => null,
            ]);

            // If LIVE → done
            if ($request->meeting_type === 'live') {
                return response()->json([
                    'success' => true,
                    'message' => 'Live meeting scheduled successfully!',
                    'meeting' => $meeting,
                ]);
            }

            // STEP 2 — Prepare Zoom payload
            $zoomStartTime = Carbon::parse(
                $request->day.' '.$request->start_time
            )->toIso8601String();

            $zoomPayload = [
                'topic' => $request->name,
                'type' => 2,
                'start_time' => $zoomStartTime,
                'duration' => (int) $request->duration,
                'agenda' => $request->description ?? 'Scheduled Zoom Meeting',
                'settings' => [
                    'join_before_host' => false,
                    'waiting_room' => true,
                    'mute_upon_entry' => true,
                    'approval_type' => 0,
                    'auto_recording' => 'none',
                ],
            ];

            // THIS WAS THE PROBLEM EARLIER:
            // You must pass BOTH user + meetingData
            $zoomResponse = $zoomService->createMeeting(Auth::user(), $zoomPayload);

            // STEP 3 — Store Zoom meeting details
            ZoomMeeting::create([
                'meeting_id' => $meeting->id,
                'zoom_meeting_id' => $zoomResponse['id'] ?? null,
                'uuid' => $zoomResponse['uuid'] ?? null,
                'host_id' => $zoomResponse['host_id'] ?? null,
                'host_email' => $zoomResponse['host_email'] ?? null,
                'topic' => $zoomResponse['topic'] ?? null,
                'status' => $zoomResponse['status'] ?? null,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration' => $request->duration,
                'date' => $request->day,
                'timezone' => $zoomResponse['timezone'] ?? 'UTC',
                'agenda' => $zoomResponse['agenda'] ?? ($request->description ?? ''),
                'password' => $zoomResponse['password'] ?? null,
                'start_url' => $zoomResponse['start_url'] ?? null,
                'join_url' => $zoomResponse['join_url'] ?? null,
                'response' => json_encode($zoomResponse),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Zoom meeting created successfully!',
                'meeting' => $meeting,
                'zoom' => $zoomResponse,
            ]);

        } catch (\Throwable $e) {
            Log::error('Meeting store failed', [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule meeting.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
