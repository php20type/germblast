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
use App\Models\LeadPeople;
use App\Models\LeadProduct;
use App\Models\LeadSource;
use App\Models\LeadStage;
use App\Models\LeadTag;
use App\Models\LeadTask;
use App\Models\Market;
use App\Models\Outcome;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $myWatchingLeadsCount = Lead::whereJsonContains('lead_flags', 'watching')->where('assignee_id', $user->id)->count();
        $hotLeadsCount = Lead::whereJsonContains('lead_flags', 'hot')->count();

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

    public function index(Request $request)
    {
        //  Base query with all needed relations
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ]);

        // Apply Filters (same pattern as CompanyController)
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting (can move to a global helper later)
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations (use accessors where possible)
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Grouped data for table
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => $lead->peoples->first()->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => Helper::calculateTotalValue($group),
                'stage_name' => $lead->stages->name ?? 'N/A',
                'assignee' => $lead->assignee->name ?? 'N/A',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.index', array_merge(
            compact(
                'groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'
            ),
            $sidebarStats
        ));
    }

    public function my_leads(Request $request, $id)
    {
        // Base query: only leads assigned to this user
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->where('assignee_id', $id);

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Grouped data for table
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.my-leads', array_merge(
            compact(
                'groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'
            ),
            $sidebarStats
        ));
    }

    public function open_leads(Request $request, $id)
    {
        // Base query: only open leads assigned to current user
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->where('lead_status', 'open')
            ->where('assignee_id', $id);

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Group leads by name and aggregate data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.open-leads', array_merge(
            compact(
                'groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'
            ),
            $sidebarStats
        ));
    }

    public function hot_leads(Request $request)
    {
        // Base query: only hot leads
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->whereJsonContains('lead_flags', 'hot');

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.hot-leads', array_merge(
            compact('groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'),
            $sidebarStats
        ));
    }

    public function watching_leads(Request $request, $id)
    {
        // Base query: only leads assigned to current user and flagged as watching
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->where('assignee_id', $id)
            ->whereJsonContains('lead_flags', 'watching');

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Group leads by name and aggregate data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.watching-leads', array_merge(
            compact('groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'),
            $sidebarStats
        ));
    }

    public function added_this_week(Request $request)
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Base query: leads added this week
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.added-this-week', array_merge(
            compact('groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'),
            $sidebarStats
        ));
    }

    public function closing_this_week(Request $request)
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Base query: leads closing this week
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages',
        ])->whereBetween('close_date', [$startOfWeek, $endOfWeek]);

        // Apply Filters
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->has('hot') && $request->hot === 'hot') {
            $query->whereJsonContains('lead_flags', 'hot');
        }

        if ($request->filled('user_id')) {
            $query->where('assignee_id', $request->user_id);
        }

        // Get all leads
        $leads = $query->get();

        // Helper for count formatting
        $formatCount = fn ($count) => $count >= 1000
            ? number_format($count / 1000, 1).'k'
            : $count;

        // Calculations
        $totalValue = Helper::calculateTotalValue($leads);
        $avgValue = $leads->count() ? $totalValue / $leads->count() : 0;
        $avgConfidence = $leads->avg('confidence');
        $totalLeads = $leads->count();

        // Format counts
        $formattedTotalLeads = $formatCount($totalLeads);
        $formattedTotalValue = $formatCount(round($totalValue));
        $formattedAvgValue = $formatCount(round($avgValue));

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
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

        // Sidebar and related data
        $peoples = People::all();
        $users = User::all();
        $activity_types = ActivityType::all();
        $sidebarStats = $this->getSidebarStats();

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render(),
                'count' => $formattedTotalLeads,
                'total_value' => $formattedTotalValue,
                'avg_value' => $formattedAvgValue,
            ]);
        }

        // Normal page load
        return view('admin.leads.closing-this-week', array_merge(
            compact('groupedLeads',
                'peoples',
                'users',
                'activity_types',
                'formattedTotalLeads',
                'formattedTotalValue',
                'formattedAvgValue',
                'avgConfidence'),
            $sidebarStats
        ));
    }

    public function store(Request $request)
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

        // Create one lead only
        $lead = Lead::create([
            'name' => $request->name,
            'assignee_id' => $request->assignee_id,
            'close_date' => $request->close_date,
            'confidence' => $request->confidence,
            'creator_id' => auth()->id(),
        ]);

        // Companies
        if ($request->filled('company_id')) {
            $lead->companies()->attach($request->company_id);
        }

        // People
        if ($request->filled('person_id')) {
            $lead->peoples()->attach($request->person_id);
        }

        // Products with qty & price
        if ($request->filled('product_id')) {
            foreach ($request->product_id as $index => $productId) {
                $lead->products()->attach($productId, [
                    'qty' => $request->quantity[$index] ?? 1,
                    'price' => $request->price[$index] ?? 0,
                ]);
            }
        }

        // Sources
        if ($request->filled('source_id')) {
            $lead->sources()->attach($request->source_id);
        }

        // Competitors
        if ($request->filled('competitors_id')) {
            $lead->competitors()->attach($request->competitors_id);
        }

        // Tags
        if ($request->filled('tag_id')) {
            $lead->tags()->attach($request->tag_id);
        }

        // return redirect()->route('admin.leads.index')->with('success', 'Leads created successfully');
        return redirect()->back()->with('success', 'Leads created successfully');
    }

    public function show($id)
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
            'leadCompanies',
            'leadProducts',
            'leadPeople',
            'leadSources',
            'leadCompetitors',
            'leadTags',
            'leadTask',
        ])->findOrFail($id);

        $leadValue = Helper::calculateTotalValue($leads);
        $formattedLeadValue = Helper::formatValue($leadValue);

        $pending_tasks = $leads->leadTask->whereNull('completed_user_id');
        $completed_tasks = $leads->leadTask->whereNotNull('completed_user_id');

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

        // Separate logged and scheduled activities
        $logged_activities = $activities->filter(function ($activity) {
            return $activity->status === 'Logged';
        });

        $scheduled_activities = $activities->filter(function ($activity) {
            return $activity->status === 'Scheduled';
        });

        $timeline = $logged_activities->concat($notes)
            ->sortByDesc('timestamp')
            ->values(); // reindex after sorting

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
        $markets = Market::all();
        $outcomes = Outcome::all();

        return view('admin.leads.edit', compact(
            'leads',
            'formattedLeadValue',
            'activities',
            'logged_activities',
            'scheduled_activities',
            'notes',
            'timeline',
            'leadStatusIcon',
            'pending_tasks',
            'completed_tasks',
            'users',
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
            'outcomes'
        ));
    }

    public function ajax_update(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'lead_status' => 'nullable|string',
            'lead_flags' => 'nullable|array',
            'assignee_id' => 'nullable|exists:users,id',
            'stage_id' => 'nullable|exists:lead_stages,id',
            'close_date' => 'nullable|date',
            'confidence' => 'nullable|numeric',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        // Update core fields if provided
        if ($request->filled('lead_status')) {
            $lead->lead_status = $request->lead_status;
        }
        if ($request->has('lead_flags')) {
            $lead->lead_flags = $request->lead_flags;
        }
        if ($request->filled('assignee_id')) {
            $lead->assignee_id = $request->assignee_id;
        }
        if ($request->filled('stage_id')) {
            $lead->stage_id = $request->stage_id;
        }
        if ($request->filled('close_date')) {
            $lead->close_date = $request->close_date;
        }
        if ($request->filled('confidence')) {
            $lead->confidence = $request->confidence;
        }

        $lead->save();

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
        $lead->stage_id = $request->stage_id;
        $lead->save();

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
            'related_id' => 'required|integer', // pivot row id
            'type' => 'required|string|in:company,people,product,competitor,source',
        ]);

        $relatedId = $request->related_id;
        $type = $request->type;

        try {
            switch ($type) {
                case 'company':
                    $deleted = LeadCompany::where('lead_id', $request->lead_id)
                        ->where('company_id', $relatedId)
                        ->delete();
                    break;

                case 'people':
                    $deleted = LeadPeople::where('lead_id', $request->lead_id)
                        ->where('people_id', $relatedId)
                        ->delete();
                    break;

                case 'product':
                    $deleted = LeadProduct::where('id', $relatedId)->delete();
                    break;

                case 'competitor':
                    $deleted = LeadCompetitor::where('id', $relatedId)->delete();
                    break;

                case 'source':
                    $deleted = LeadSource::where('id', $relatedId)->delete();
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid type provided.',
                    ], 422);
            }

            if ($deleted) {
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

    // public function deleteField(Request $request)
    // {
    //     $request->validate([
    //         'lead_id' => 'required|exists:leads,id',
    //         'related_id' => 'required',
    //         'type' => 'required|string',
    //     ]);

    //     $lead = Lead::findOrFail($request->lead_id);

    //     switch ($request->type) {
    //         case 'company':
    //             $model = Company::class;
    //             $relation = 'companies';
    //             $pivotColumn = 'company_id';
    //             break;

    //         case 'people':
    //             $model = People::class;
    //             $relation = 'peoples';
    //             $pivotColumn = 'people_id';
    //             break;

    //         case 'competitor':
    //             $model = Competitor::class;
    //             $relation = 'competitors';
    //             $pivotColumn = 'competitor_id';
    //             break;

    //         case 'source':
    //             $model = Source::class;
    //             $relation = 'sources';
    //             $pivotColumn = 'source_id';
    //             break;

    //         case 'product':
    //             $model = Product::class;
    //             $relation = 'products';
    //             $pivotColumn = 'product_id';
    //             break;

    //         default:
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid type.',
    //             ], 422);
    //     }

    //     $item = $model::find($request->related_id);

    //     if (! $item) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => ucfirst($request->type).' not found.',
    //         ], 404);
    //     }

    //     // Check if the item exists in pivot
    //     $exists = $lead->$relation()->wherePivot($pivotColumn, $item->id)->exists();

    //     if (! $exists) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => ucfirst($request->type).' is not attached to this lead.',
    //         ], 404);
    //     }

    //     // Detach the item from pivot table
    //     $lead->$relation()->detach($item->id);

    //     return response()->json([
    //         'success' => true,
    //         'message' => ucfirst($request->type).' removed successfully from lead.',
    //     ]);
    // }

    public function updateField(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'related_id' => 'required',
            'type' => 'required|string',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        switch ($request->type) {
            case 'company':
                $model = Company::class;
                $relation = 'companies';
                $pivotColumn = 'company_id';
                break;

            case 'people':
                $model = People::class;
                $relation = 'peoples';
                $pivotColumn = 'people_id';
                break;

            case 'competitor':
                $model = Competitor::class;
                $relation = 'competitors';
                $pivotColumn = 'competitor_id';
                break;

            case 'source':
                $model = Source::class;
                $relation = 'sources';
                $pivotColumn = 'source_id';
                break;

            case 'product':
                $model = Product::class;
                $relation = 'products';
                $pivotColumn = 'product_id';
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

        $leadProduct = $lead->leadProducts()->create([
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully!',
        ]);
    }

    public function addTask(Request $request, $leadId)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|string', // will parse manually
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $assignee = User::findOrFail($request->user_id);

        // Convert the due_date from "2025-09-24 6:30 PM" → "2025-09-24 18:30:00"
        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        // Create the task
        $task = LeadTask::create([
            'lead_id' => $leadId,
            'title' => $request->title,
            'description' => $request->description,
            'created_time' => now(),
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
            'subject_type' => 'lead',
            'subject_legacy_id' => $leadId,
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Task added successfully',
            'task' => $task,
        ]);
    }

    public function updateTask(Request $request, $taskId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|string', // will parse manually
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $assignee = User::findOrFail($request->user_id);

        // Convert the due_date from "2025-09-24 6:30 PM" → "2025-09-24 18:30:00"
        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        // Find and update the task
        $task = LeadTask::findOrFail($taskId);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
        ]);

        // Return JSON response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    public function markCompleted($taskId)
    {
        $task = LeadTask::findOrFail($taskId);

        $user = auth()->user(); // logged-in user

        $task->update([
            'completed_time' => now(),
            'completed_user_id' => $user->id,
            'completed_user_name' => $user->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task marked as completed successfully!',
            'task' => $task,
        ]);
    }

    public function reopenTask($taskId)
    {
        $task = LeadTask::findOrFail($taskId);

        $task->update([
            'completed_time' => null,
            'completed_user_id' => null,
            'completed_user_name' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task reopened successfully',
            'task' => $task,
        ]);
    }

    public function deleteTask($task_id)
    {
        $task = LeadTask::find($task_id);

        if (! $task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found.',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully.',
        ]);
    }
}
