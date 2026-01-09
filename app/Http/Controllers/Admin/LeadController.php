<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Company;
use App\Models\Competitor;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\LeadCompany;
use App\Models\LeadCompetitor;
use App\Models\LeadFile;
use App\Models\LeadPeople;
use App\Models\LeadProduct;
use App\Models\LeadSource;
use App\Models\LeadStage;
use App\Models\LeadStageProcess;
use App\Models\LeadTag;
use App\Models\Market;
use App\Models\Outcome;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\SurveyProposal;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Timeline;
use App\Models\User;
use App\Services\ApprovalService;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function getSidebarStats()
    {
        $leads = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->get();

        $user = auth()->user();

        // Helper function to format counts
        $formatCount = function ($count) {
            return $count >= 1000
                ? number_format($count / 1000, 1).'k'
                : $count;
        };

        $myLeads = $leads->where('assignee_id', $user->id);
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Counts
        $totalLeads = $leads->count();
        $myLeadsCount = $myLeads->count();
        $addedThisWeekCount = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $closingThisWeekCount = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->count();
        $myLeadOpenStatusCount = Lead::where('lead_status', 'open')->where('assignee_id', $user->id)->count();
        $myWatchingLeadsCount = Lead::where('is_watching', 1)->where('assignee_id', $user->id)->count();
        $hotLeadsCount = Lead::where('is_hot', 1)->count();

        return [
            'totalLeads' => $formatCount($totalLeads),
            'myLeadsCount' => $formatCount($myLeadsCount),
            'addedThisWeekCount' => $formatCount($addedThisWeekCount),
            'closingThisWeekCount' => $formatCount($closingThisWeekCount),
            'myLeadOpenStatusCount' => $formatCount($myLeadOpenStatusCount),
            'myWatchingLeadsCount' => $formatCount($myWatchingLeadsCount),
            'hotLeadsCount' => $formatCount($hotLeadsCount),
        ];
    }

    private function baseLeadQuery()
    {
        return Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ]);
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->hot === 'hot') {
            $query->where('is_hot', 1);
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        if ($request->lead_tags_filter_id) {
            $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $request->lead_tags_filter_id)
            );
        }

        if ($request->lead_stage_filter_id) {
            $query->whereIn('stage_id', $request->lead_stage_filter_id);
        }

        if ($request->leads_status) {
            $query->whereIn('lead_status', $request->leads_status);
        }

        if ($request->activity_type_filter_id) {
            $query->whereHas('activity', fn ($q) => $q->whereIn('activity_type_id', $request->activity_type_filter_id)
            );
        }

        if ($request->month_to_date) {
            $query->whereBetween('created_at', [
                now()->startOfMonth(),
                now(),
            ]);
        }

        return $query;
    }

    private function groupLeads($leads)
    {
        return $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => $lead->peoples->first()->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => Helper::calculateTotalValue($group),
                'stage_name' => $lead->stages->name ?? 'N/A',
                'assignee' => $lead->assignee->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });
    }

    private function calculateStats($leads)
    {
        $format = fn ($count) => $count >= 1000 ? number_format($count / 1000, 1).'k' : $count;

        $totalValue = Helper::calculateTotalValue($leads);
        $count = $leads->count();

        return [
            'formattedTotalLeads' => $format($count),
            'formattedTotalValue' => $format(round($totalValue)),
            'formattedAvgValue' => $format(round($count ? $totalValue / $count : 0)),
            'avgConfidence' => number_format($leads->avg('confidence'), 2),
        ];
    }

    private function sharedViewData()
    {
        return [
            'peoples' => People::all(),
            'users' => User::all(),
            'activity_types' => ActivityType::all(),
            'lead_stages' => LeadStage::all(),
            'leadtags' => Tag::where('tag_id', 1)->get(),
        ];
    }

    public function index(Request $request)
    {
        $query = $this->applyFilters($this->baseLeadQuery(), $request);

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.index',
            array_merge(
                compact('groupedLeads'),
                $stats,
                $this->sharedViewData(),
                $this->getSidebarStats()
            )
        );
    }

    public function my_leads(Request $request, $id)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()->where('assignee_id', $id),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.my-leads',
            array_merge(
                compact('groupedLeads'),
                $stats,
                $this->sharedViewData(),
                $this->getSidebarStats()
            )
        );
    }

    public function open_leads(Request $request, $id)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()
                ->where('lead_status', 'open')
                ->where('assignee_id', $id),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.open-leads',
            array_merge(
                compact('groupedLeads'),
                $stats,
                $this->sharedViewData(),
                $this->getSidebarStats()
            )
        );
    }

    public function hot_leads(Request $request)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()->where('is_hot', 1),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.hot-leads', array_merge(
            compact('groupedLeads'),
            $stats,
            $this->sharedViewData(),
            $this->getSidebarStats()
        ));
    }

    public function watching_leads(Request $request, $id)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()
                ->where('assignee_id', $id)
                ->where('is_watching', 1),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.watching-leads', array_merge(
            compact('groupedLeads'),
            $stats,
            $this->sharedViewData(),
            $this->getSidebarStats()
        ));
    }

    public function added_this_week(Request $request)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()
                ->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.added-this-week', array_merge(
            compact('groupedLeads'),
            $stats,
            $this->sharedViewData(),
            $this->getSidebarStats()
        ));
    }

    public function closing_this_week(Request $request)
    {
        $query = $this->applyFilters(
            $this->baseLeadQuery()
                ->whereBetween('close_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]),
            $request
        );

        $leads = $query->get();
        $groupedLeads = $this->groupLeads($leads);
        $stats = $this->calculateStats($leads);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $stats['formattedTotalLeads'],
                'total_value' => $stats['formattedTotalValue'],
                'avg_value' => $stats['formattedAvgValue'],
                'avg_confidence' => $stats['avgConfidence'],
            ]);
        }

        return view('admin.leads.closing-this-week', array_merge(
            compact('groupedLeads'),
            $stats,
            $this->sharedViewData(),
            $this->getSidebarStats()
        ));
    }

    public function store(Request $request, NotificationService $notify)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'assignee_id' => 'nullable|exists:users,id',
            'close_date' => 'nullable|date',
            'confidence' => 'nullable|numeric',

            'product_id' => 'nullable|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'nullable|array',
            'price' => 'nullable|array',

            'company_id' => 'nullable|array',
            'company_id.*' => 'exists:companies,id',

            'person_id' => 'nullable|array',
            'person_id.*' => 'nullable|exists:people,id',

            'source_id' => 'nullable|array',
            'source_id.*' => 'exists:sources,id',

            'competitors_id' => 'nullable|array',
            'competitors_id.*' => 'nullable|exists:competitors,id',

            'tag_id' => 'required',
        ]);

        $lead = null;

        DB::transaction(function () use ($request, &$lead) {

            $lead = Lead::create([
                'name' => $request->name,
                'assignee_id' => $request->assignee_id,
                'close_date' => $request->close_date,
                'confidence' => $request->confidence,
                'creator_id' => auth()->id(),
            ]);

            LeadStageProcess::create([
                'lead_id' => $lead->id,
            ]);

            SurveyProposal::create([
                'user_id' => auth()->id(),
                'lead_id' => $lead->id,
            ]);

            if ($request->filled('company_id')) {
                $lead->companies()->attach($request->company_id);
            }

            if ($request->filled('person_id')) {
                $lead->peoples()->attach($request->person_id);
            }

            if ($request->filled('product_id')) {
                foreach ($request->product_id as $index => $productId) {
                    $lead->products()->attach($productId, [
                        'qty' => $request->quantity[$index] ?? 1,
                        'price' => $request->price[$index] ?? 0,
                    ]);
                }
            }

            if ($request->filled('source_id')) {
                $lead->sources()->attach($request->source_id);
            }

            if ($request->filled('competitors_id')) {
                $lead->competitors()->attach($request->competitors_id);
            }

            if ($request->filled('tag_id')) {
                $lead->tags()->attach($request->tag_id);
            }
        });

        // TRIGGER EMAIL 1: Lead Created
        $notify->leadCreated($lead);

        // TRIGGER EMAIL 2: Lead Assigned (Delayed 12 sec)
        $notify->leadAssigned($lead);

        return redirect()->back()->with('success', 'Lead created successfully!');
    }

    public function show(Request $request, $id)
    {
        // Fetch lead with all pivot relations
        $leads = Lead::with([
            'assignee',
            'creator',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'tags',
            'stages',
            'market',
            'outcome',
            'leadFile',
            'leadCompanies',
            'leadProducts',
            'leadPeople',
            'leadSources',
            'leadCompetitors',
            'leadTags',
        ])->findOrFail($id);

        $leadFiles = $leads->leadFile;

        $leadValue = Helper::calculateTotalValue($leads);
        $formattedLeadValue = Helper::formatValue($leadValue);

        $pending_tasks = $leads->task->whereNull('completed_user_id');
        $completed_tasks = $leads->task->whereNotNull('completed_user_id');

        $activities = Helper::getActivitiesForParticipant('lead', $leads->id);
        $activities->load(['comments.creator']);
        $activities->transform(function ($activity) {
            $participants = collect();
            $participants = $participants->merge($activity->peoples->pluck('name'));
            $participants = $participants->merge($activity->companies->pluck('name'));
            $participants = $participants->merge($activity->leads->pluck('name'));

            // Add a new attribute to the activity
            $activity->participant_names = $participants->join(', ');

            // Add unified structure fields
            $activity->type = 'activity';
            // $activity->timestamp = $activity->created_at;
            $activity->timestamp = $activity->date; // not created_at

            return $activity;
        });

        $notes = Helper::getNotesForParticipant('lead', $leads->id);
        $notes->load(['comments.creator']);
        $notes->transform(function ($note) {
            $mentions = collect();
            $mentions = $mentions->merge($note->peoples->pluck('name'));
            $mentions = $mentions->merge($note->companies->pluck('name'));
            $mentions = $mentions->merge($note->users->pluck('name'));

            // Add a new attribute for easy access in views
            $note->mentioned_names = $mentions->join(', ');

            // Add unified structure fields
            $note->type = 'note';
            $note->timestamp = $note->created_at;

            return $note;
        });

        $filters = [
            'filter_range' => $request->input('filter_range', 'all'),
            'activity_type_id' => $request->input('activity_type_id', 'all'),
            'user_id' => $request->input('user_id', 'all'),
        ];

        // Separate logged and scheduled activities
        $logged_activities = $activities->filter(function ($activity) {
            return $activity->status === 'Logged';
        });

        $scheduled_activities = $activities->filter(function ($activity) {
            return $activity->status === 'Scheduled';
        });

        // --- Fetch Timeline Entries ---
        $timelineEntries = Helper::getTimelineForEntity('lead', $leads->id);
        $timelineEntries->transform(function ($item) {
            $item->type = 'timeline';
            $item->timestamp = $item->created_at;

            return $item;
        });

        // Apply filtering via helper
        $filtered = Helper::applyTimelineFilters($logged_activities, $notes, $timelineEntries, $filters);

        $logged_activities = $filtered['logged_activities'];
        $notes = $filtered['notes'];
        $timelineEntries = $filtered['timelineEntries'];

        $timeline = $logged_activities
            ->concat($notes)
            ->concat($timelineEntries)
            ->sortByDesc('timestamp')
            ->values(); // reindex after sorting

        // ADD THIS SECTION — Handle AJAX requests
        if ($request->ajax()) {
            $timeline_html = view('admin.leads.partials.lead-timeline', compact('timeline'))->render();

            return response()->json([
                'timeline_html' => $timeline_html,
            ]);
        }

        $leadStatusIcon = '';

        $status = strtolower($leads->lead_status);
        $stage_id = $leads->stage_id;

        if ($status === 'won') {
            $leadStatusIcon = asset('img/icons/won.svg'); // star
        } elseif ($status === 'cancelled') {
            $leadStatusIcon = asset('img/icons/cancelled.svg'); // disabled
        } elseif ($status === 'pending') {
            $leadStatusIcon = asset('img/icons/pending.svg'); // plain circle
        } elseif ($status === 'lost') {
            $leadStatusIcon = asset('img/icons/lost.svg'); // cross inside circle
        } elseif ($status === 'open' && $stage_id == 1) {
            $leadStatusIcon = asset('img/icons/level-1.svg'); // open + stage 1
        } elseif ($status === 'open' && $stage_id == 2) {
            $leadStatusIcon = asset('img/icons/level-2.svg'); // open + stage 2
        } elseif ($status === 'open' && $stage_id == 3) {
            $leadStatusIcon = asset('img/icons/level-3.svg'); // open + stage 3
        } elseif ($status === 'open' && $stage_id == 4) {
            $leadStatusIcon = asset('img/icons/level-4.svg'); // open + stage 4
        } elseif ($status === 'open' && $stage_id == 5) {
            $leadStatusIcon = asset('img/icons/level-5.svg'); // open + stage 5
        } else {
            $leadStatusIcon = asset('img/icons/level-1.svg'); // unknown , so will keep it by default of stage_id = 1
        }

        // Fetch supporting data for dropdowns or edit form
        $leadStages = LeadStage::all();
        $activity_types = ActivityType::all();
        $sources = Source::all();
        $competitors = Competitor::all();
        $companies = Company::all();
        $users = User::all();
        $industries = Industry::all();
        $allpeoples = People::all();
        $products = Product::all();
        $tags = Tag::where('tag_id', 1)->get();
        $lost_outcomes = Outcome::where('type', 'Lost')->get();
        $cancelled_outcomes = Outcome::where('type', 'Cancelled')->get();
        $markets = Market::all();
        $stage = $leads->leadStageProcess;

        return view('admin.leads.edit', compact(
            'leads',
            'stage',
            'formattedLeadValue',
            'activities',
            'logged_activities',
            'scheduled_activities',
            'notes',
            'timelineEntries',
            'timeline',
            'leadStatusIcon',
            'pending_tasks',
            'completed_tasks',
            'users',
            'leadFiles',
            'allpeoples',
            'industries',
            'activity_types',
            'competitors',
            'companies',
            'leadStages',
            'sources',
            'products',
            'tags',
            'markets',
            'lost_outcomes',
            'cancelled_outcomes'
        ));
    }

    public function ajax_update(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'lead_status' => 'nullable|string',
            'outcome_id' => 'nullable|exists:outcomes,id',
            'flag_type' => 'nullable|string|in:is_hot,is_watching',
            'flag_value' => 'nullable|boolean',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $leadName = $lead->name ?? 'Unnamed Lead';
        $description = null;
        $actionType = null;

        if ($request->filled('lead_status')) {
            $lead->lead_status = $request->lead_status;

            // Store outcome_id if provided
            if ($request->filled('outcome_id')) {
                $lead->outcome_id = $request->outcome_id;
            } else {
                $lead->outcome_id = null;
            }

            $description = "changed the status of {$leadName} to {$request->lead_status}";
            $actionType = 'updated_status';
        }
        if ($request->filled('flag_type')) {
            $flagField = $request->flag_type; // 'is_hot' or 'is_watching'
            $flagValue = (int) $request->flag_value;

            $lead->$flagField = $flagValue;

            $flagLabel = $flagField === 'is_hot' ? 'Hot' : 'Watching';

            // Dynamic message
            if ($flagValue === 1) {
                $description = "marked {$leadName} as {$flagLabel}";
            } else {
                $description = "removed {$leadName} from {$flagLabel}";
            }

            $actionType = 'updated_flags';
        }

        $lead->save();

        // Save timeline entry if any change occurred
        if ($description && $actionType) {
            Timeline::create([
                'user_id' => auth()->id(),
                'owner_type' => 'lead',
                'owner_id' => $lead->id,
                'action_type' => $actionType,
                'description' => $description,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function checkStageCondition(Request $request, $leadId)
    {
        $lead = Lead::findOrFail($leadId);
        $newStageId = $request->stage_id;

        // Example stage-wise validation
        switch ($newStageId) {
            case 2: // Site Survey
                if (! $lead->activity()->where('status', 'Logged')->exists()) {
                    return response()->json([
                        'allowed' => false,
                        'message' => 'Please log an activity first.',
                        'current_stage_id' => $lead->stage_id,
                    ]);
                }
                break;

            case 4: // Present Proposal
                if (! $lead->products()->exists()) {
                    return response()->json([
                        'allowed' => false,
                        'message' => 'Attach a product before moving to this stage.',
                        'current_stage_id' => $lead->stage_id,
                    ]);
                }
                break;
        }

        return response()->json(['allowed' => true]);
    }

    public function changeStage(Request $request, $leadId)
    {
        $lead = Lead::findOrFail($leadId);
        $oldStage = $lead->stages->name ?? 'Unknown Stage';
        $newStage = LeadStage::find($request->stage_id)->name ?? 'Unknown Stage';

        $lead->stage_id = $request->stage_id;
        $lead->save();

        // Timeline logging
        $leadName = $lead->name ?? 'Unnamed Lead';

        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'lead',
            'owner_id' => $lead->id,
            'action_type' => 'updated_stage',
            'description' => "changed the stage of {$leadName} from {$oldStage} to {$newStage}",
        ]);

        return response()->json(['message' => 'Lead stage updated successfully.']);
    }

    public function updateDetail(Request $request, $leadId)
    {
        $request->validate([
            'field' => 'required|string|in:name',
            'value' => 'nullable|string',
        ]);

        $lead = Lead::findOrFail($leadId);
        $lead->{$request->field} = $request->value;
        $lead->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->field).' updated successfully!',
        ]);
    }

    public function addTag(Request $request, $leadId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        // Prevent duplicates
        $exists = LeadTag::where('lead_id', $leadId)
            ->where('tag_id', $request->tag_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This tag is already linked to the lead.',
            ], 422);
        }

        // Create new record
        LeadTag::create([
            'lead_id' => $leadId,
            'tag_id' => $request->tag_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tag added to lead successfully!',
        ]);
    }

    public function removeTag(Request $request, $leadId, $tagId)
    {
        // Find the pivot record
        $leadTag = LeadTag::where('lead_id', $leadId)
            ->where('tag_id', $tagId)
            ->first();

        if (! $leadTag) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tag not found for this lead.',
            ], 404);
        }

        $leadTag->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag removed from lead successfully!',
        ]);
    }

    public function deleteField(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'related_id' => 'required|integer',
            'type' => 'required|string|in:company,people,product,competitor,source',
        ]);

        $relatedId = $request->related_id;
        $type = $request->type;
        $lead = Lead::findOrFail($request->lead_id);
        $leadName = $lead->name ?? 'Unnamed Lead';

        try {
            $deleted = false;
            $itemName = 'Unknown';
            $actionType = null;

            switch ($type) {
                case 'company':
                    $company = Company::find($relatedId);
                    $itemName = $company->name ?? 'Unknown Company';
                    $deleted = LeadCompany::where('lead_id', $lead->id)
                        ->where('company_id', $relatedId)
                        ->delete();
                    $actionType = 'removed_company';
                    break;

                case 'people':
                    $person = People::find($relatedId);
                    $itemName = $person->name ?? 'Unknown Person';
                    $deleted = LeadPeople::where('lead_id', $lead->id)
                        ->where('people_id', $relatedId)
                        ->delete();
                    $actionType = 'removed_person';
                    break;

                case 'product':
                    $pivot = LeadProduct::find($relatedId);
                    $product = $pivot ? Product::find($pivot->product_id) : null;
                    $itemName = $product->name ?? 'Unknown Product';
                    $deleted = $pivot ? $pivot->delete() : false;
                    $actionType = 'removed_product';
                    break;

                case 'competitor':
                    $pivot = LeadCompetitor::find($relatedId);
                    $competitor = $pivot ? Competitor::find($pivot->competitor_id) : null;
                    $itemName = $competitor->name ?? 'Unknown Competitor';
                    $deleted = $pivot ? $pivot->delete() : false;
                    $actionType = 'null';
                    break;

                case 'source':
                    $pivot = LeadSource::find($relatedId);
                    $source = $pivot ? Source::find($pivot->source_id) : null;
                    $itemName = $source->name ?? 'Unknown Source';
                    $deleted = $pivot ? $pivot->delete() : false;
                    $actionType = 'null';
                    break;
            }

            if ($deleted) {
                if (! empty($actionType)) {
                    Timeline::create([
                        'user_id' => auth()->id(),
                        'owner_type' => 'lead',
                        'owner_id' => $lead->id,
                        'action_type' => $actionType,
                        'description' => "removed {$itemName} from {$leadName}",
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => ucfirst($type).' removed successfully from lead.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => ucfirst($type).' not found or already deleted.',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting '.$type,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateField(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'related_id' => 'required',
            'type' => 'required|string',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        switch ($request->type) {

            case 'assignee':
                $oldAssignee = $lead->assignee->name;
                $lead->assignee_id = $request->related_id;
                $lead->save();

                $newAssignee = User::find($request->related_id)->name ?? 'Unknown User';
                $leadName = $lead->name ?? 'Unnamed Lead';

                Timeline::create([
                    'user_id' => auth()->id(),
                    'owner_type' => 'lead',
                    'owner_id' => $lead->id,
                    'action_type' => 'updated_assignee',
                    'description' => "reassigned {$leadName} from {$oldAssignee} to {$newAssignee}",
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Assignee updated successfully.',
                ]);

            case 'company':
                $model = Company::class;
                $relation = 'companies';
                $pivotColumn = 'company_id';
                $actionType = 'added_company';
                break;

            case 'people':
                $model = People::class;
                $relation = 'peoples';
                $pivotColumn = 'people_id';
                $actionType = 'added_person';
                break;

            case 'competitor':
                $model = Competitor::class;
                $relation = 'competitors';
                $pivotColumn = 'competitor_id';
                $actionType = null;
                break;

            case 'source':
                $model = Source::class;
                $relation = 'sources';
                $pivotColumn = 'source_id';
                $actionType = null;
                break;

            case 'product':
                $model = Product::class;
                $relation = 'products';
                $pivotColumn = 'product_id';
                $actionType = 'added_product';
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid type.',
                ]);
        }

        $item = $model::findOrFail($request->related_id);

        // Check if the item already exists in the belongsToMany pivot table
        $exists = $lead->$relation()->wherePivot($pivotColumn, $item->id)->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => ucfirst($request->type).' is already attached to this lead.',
            ]);
        }

        // Attach the item without removing existing
        $lead->$relation()->attach($item->id);

        // Log timeline entry only if $actionType is defined
        if (! empty($actionType)) {
            $leadName = $lead->name ?? 'Unnamed Lead';
            $itemName = $item->name ?? ucfirst($request->type);

            Timeline::create([
                'user_id' => auth()->id(),
                'owner_type' => 'lead',
                'owner_id' => $lead->id,
                'action_type' => $actionType,
                'description' => "added {$itemName} to {$leadName}",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst($request->type).' added successfully.',
        ]);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $product = Product::findOrFail($request->product_id);

        $leadProduct = $lead->leadProducts()->create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        // Timeline logging
        $leadName = $lead->name ?? 'Unnamed Lead';
        $productName = $product->name ?? 'Unknown Product';

        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'lead',
            'owner_id' => $lead->id,
            'action_type' => 'added_product',
            'description' => "added {$productName} (Qty: {$request->qty}, Price: {$request->price}) to {$leadName}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
        ]);
    }

    public function storeForecasting(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'confidence' => 'required|string|max:255',
            'expected_services' => 'required|integer',
            'expected_months' => 'required|integer',
            'expected_price' => 'required|string|max:255',
            'expected_first_date' => 'required|string|max:255',
        ]);

        try {
            $lead = Lead::findOrFail($validated['lead_id']);

            // Store the forecasting details in leads table
            $lead->confidence = $validated['confidence'];
            $lead->expected_services = $validated['expected_services'];
            $lead->expected_months = $validated['expected_months'];
            $lead->expected_price = $validated['expected_price'];
            $lead->expected_first_date = $validated['expected_first_date'];

            $lead->save();

            return response()->json([
                'success' => true,
                'message' => 'Sales Forecasting details saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while saving forecasting details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function fileUpload(Request $request, Lead $lead)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $cleanName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $filename = Str::random(10).'_'.$cleanName.'.'.$extension;

            $path = $file->storeAs('lead_files', $filename, 'public');

            $leadFile = LeadFile::create([
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'file_name' => $originalName,
                'file_path' => $path,
                'file_type' => $extension,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file' => $leadFile,
            ]);
        } catch (\Throwable $e) {
            Log::error("Lead file upload failed for lead ID {$lead->id}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'File upload failed. Please try again later.',
            ], 500);
        }
    }

    public function fileDelete(Request $request)
    {
        $request->validate([
            'file_id' => 'required|integer',
            'lead_id' => 'required|integer',
        ]);

        try {
            $file = LeadFile::where('id', $request->file_id)
                ->where('lead_id', $request->lead_id)
                ->firstOrFail();

            Storage::disk('public')->delete($file->file_path);
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully!',
            ]);

        } catch (\Throwable $e) {
            Log::error("File delete failed for lead {$request->lead_id}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'File deletion failed. Please try again later.',
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $ids = (array) $request->ids; // handles both single and multiple

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No lead selected for deletion.',
            ], 400);
        }

        try {
            Lead::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) > 1
                    ? 'Selected leads deleted successfully.'
                    : 'Lead deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lead(s): '.$e->getMessage(),
            ], 500);
        }
    }
}
