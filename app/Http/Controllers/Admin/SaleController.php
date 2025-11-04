<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Lead;
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

    public function index(Request $request)
    {
        $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();
        $peoples = People::with('peopleEmail', 'peoplePhone', 'peopleAddress', 'peopleUrl', 'peopleTask', 'peopleCompany')->get();

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

        // --- Apply Filters (if any) ---
        $filters = [
            'filter_range' => $request->input('filter_range', 'all'),
            'activity_type_id' => $request->input('activity_type_id', 'all'),
            'user_id' => $userId,
        ];

        // Separate logged & scheduled
        $logged_activities = $activities->filter(fn ($a) => $a->status === 'Logged');
        $scheduled_activities = $activities->filter(fn ($a) => $a->status === 'Scheduled');

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

        // --- Merge everything into one timeline ---
        $timeline = $logged_activities
            ->concat($notes)
            ->concat($timelineEntries)
            ->concat($milestones)
            ->sortByDesc('timestamp')
            ->values();

        // Fetch all tasks assigned to the logged-in user
        $companyTasks = $user->companyTaskAssignee()->whereNull('completed_user_id')->get();
        $peopleTasks = $user->peopleTaskAssignee()->whereNull('completed_user_id')->get();
        $leadTasks = $user->leadTaskAssignee()->whereNull('completed_user_id')->get();

        // Combine all pending tasks
        $pending_tasks = $companyTasks
            ->concat($peopleTasks)
            ->concat($leadTasks)
            ->sortByDesc('created_at')
            ->values();

        return view('admin.sales', compact('leads', 'peoples',
            'newLeadsThisMonth', 'newLeadsLastMonth', 'newLeadsDiff', 'newLeadsPercent',
            'openLeadsThisMonth', 'openLeadsLastMonth', 'openLeadsDiff', 'openLeadsPercent',
            'salesLeadsThisMonth', 'salesLeadsLastMonth', 'salesLeadsDiff', 'salesLeadsPercent',
            'newLeadsChange', 'openLeadsChange', 'salesLeadsChange',
            'allLeadsCount', 'myLeadsCount', 'addedThisWeekCount', 'closingThisWeekCount', 'hotLeadsCount',
            'allLeadsValue', 'myLeadsValue', 'addedThisWeekValue', 'closingThisWeekValue', 'hotLeadsValue',
            'allLeadsValueFormatted', 'myLeadsValueFormatted', 'addedThisWeekValueFormatted', 'closingThisWeekValueFormatted', 'hotLeadsValueFormatted',
            'gbPresentationCount', 'siteSurveyCount', 'proposalApprovalCount', 'proposalPresentationCount', 'signedProposalCount',
            'gbPresentationCountValueFormatted', 'siteSurveyCountValueFormatted', 'proposalApprovalCountValueFormatted', 'proposalPresentationCountValueFormatted', 'signedProposalCountValueFormatted', 'users', 'activitytypes',
            'activities',
            'logged_activities',
            'scheduled_activities',
            'notes',
            'timeline',
            'timelineEntries',
            'pending_tasks'
        ));

    }
}
