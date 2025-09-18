<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Competitor;
use App\Models\LeadStage;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadProduct;
use App\Models\LeadPeople;
use App\Models\LeadTag;
use App\Models\LeadSource;
use App\Models\LeadCompetitor;
use App\Models\LeadCompany;
use App\Models\People;
use App\Models\Activity;
use App\Models\User;
use App\Models\Tag;
use App\Models\Market;
use App\Models\Outcome;
use Carbon\Carbon;
use App\Models\Industry;
use App\Models\Company;
use App\Models\Source;
use App\Models\Product;


class LeadController extends Controller
{
    // public function getSidebarStats()
    // {
    //     $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors', 'stages')->get();
    //     $user = auth()->user();

    //     $myLeads = $leads->where('assignee_id', $user->id);
    //     $myLeadsCount = $myLeads->count();

    //     $now = Carbon::now();
    //     $startOfWeek = $now->copy()->startOfWeek();
    //     $endOfWeek = $now->copy()->endOfWeek();

    //     $addedThisWeekCount = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    //     $closingThisWeekCount = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->count();
    //     $myLeadStatusCount = Lead::where('lead_status', 'open')
    //         ->where('assignee_id', $user->id)
    //         ->count();
    //     $myWatchingLeadsCount = Lead::whereJsonContains('lead_flags', 'watching')
    //         ->where('assignee_id', $user->id)
    //         ->count();
    //     $hotLeadsCount = Lead::whereJsonContains('lead_flags', 'hot')->count();

    //     $totalLeads = $leads->count();
    //     $totalValue = $leads->flatMap->products->sum('pivot.price');
    //     $avgValue = $leads->flatMap->products->avg('pivot.price');
    //     $avgConfidence = $leads->avg('confidence');

    //     $formattedTotalLeads = number_format($totalLeads / 1000, 1);
    //     $formattedTotalValue = number_format($totalValue, 2);
    //     $formattedAvgValue = number_format($avgValue / 1000, 1);
    //     $formattedAvgConfidence = number_format($avgConfidence, 0);

    //     return compact(
    //         'totalLeads',
    //         'formattedTotalLeads',
    //         'formattedTotalValue',
    //         'formattedAvgValue',
    //         'myLeadsCount',
    //         'formattedAvgConfidence',
    //         'addedThisWeekCount',
    //         'closingThisWeekCount',
    //         'myWatchingLeadsCount',
    //         'hotLeadsCount',
    //         'myLeadStatusCount'
    //     );
    // }

    public function getSidebarStats()
    {
        $leads = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages'
        ])->get();

        $user = auth()->user();

        // My Leads
        $myLeads = $leads->where('assignee_id', $user->id);
        $myLeadsCount = $myLeads->count();

        // Weekly Ranges
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $addedThisWeekCount = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $closingThisWeekCount = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->count();

        // Lead Flags & Status
        $myLeadStatusCount = Lead::where('lead_status', 'open')
            ->where('assignee_id', $user->id)
            ->count();

        $myWatchingLeadsCount = Lead::whereJsonContains('lead_flags', 'watching')
            ->where('assignee_id', $user->id)
            ->count();

        $hotLeadsCount = Lead::whereJsonContains('lead_flags', 'hot')->count();

        // Totals & Averages
        $totalLeads = $leads->count();
        $totalValue = $leads->flatMap->products->sum(function ($product) {
            return $product->pivot->price * ($product->pivot->qty ?? 1);
        });
        $avgValue = $leads->flatMap->products->avg(function ($product) {
            return $product->pivot->price * ($product->pivot->qty ?? 1);
        });
        $avgConfidence = $leads->avg('confidence');

        // Formatting (optional: keep or remove the /1000 depending on how you want display)
        $formattedTotalLeads = number_format($totalLeads / 1000, 1);
        $formattedTotalValue = number_format($totalValue, 2);
        $formattedAvgValue = number_format($avgValue / 1000, 1);
        $formattedAvgConfidence = number_format($avgConfidence, 0);

        return compact(
            'totalLeads',
            'formattedTotalLeads',
            'formattedTotalValue',
            'formattedAvgValue',
            'myLeadsCount',
            'formattedAvgConfidence',
            'addedThisWeekCount',
            'closingThisWeekCount',
            'myWatchingLeadsCount',
            'hotLeadsCount',
            'myLeadStatusCount'
        );
    }


    // public function index(Request $request)
    // {
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors', 'stages');

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         // Search by lead name or people name
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }
    //     }

    //     $leads = $query->get();

    //     // Group leads by name and prepare aggregated data
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();

    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => $lead->peoples->first()->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => $lead->assignee->name ?? 'N/A',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => Carbon::parse($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.index', array_merge(
    //         compact('groupedLeads', 'peoples', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function index(Request $request)
    {
        $peoples = People::all();
        $activity_types = ActivityType::all();

        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages'
        ]);

        // AJAX filters
        if ($request->ajax()) {

            // Search by lead name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%$search%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot === 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and prepare aggregated data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => $lead->peoples->first()->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => $lead->assignee->name ?? 'N/A',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.index', array_merge(
            compact('groupedLeads', 'peoples', 'activity_types'),
            $sidebarStats
        ));
    }


    // public function my_leads(Request $request, $id)
    // {
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     // Base query: only leads assigned to current user
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors', 'stages')
    //         ->where('assignee_id', $id);

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         // Search by lead name or people name
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }

    //         // Optionally filter by assigned user (if admin is viewing)
    //         if ($request->filled('assignee_id')) {
    //             $query->where('assignee_id', $request->assignee_id);
    //         }
    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate data
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();

    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.my-leads', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function my_leads(Request $request, $id)
    {
        $peoples = People::all();
        $activity_types = ActivityType::all();

        // Base query: only leads assigned to this user
        $query = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
            'stages'
        ])->where('assignee_id', $id);

        // AJAX filters
        if ($request->ajax()) {

            // Search by lead name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%$search%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot === 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }

            // Optionally filter by assigned user (for admins)
            if ($request->filled('assignee_id')) {
                $query->where('assignee_id', $request->assignee_id);
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => $lead->peoples->first()->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => $lead->assignee->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.my-leads', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }

    // public function open_leads(Request $request)
    // {
    //     $user = auth()->user();
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     // Base query: only open leads assigned to current user
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
    //         ->where('lead_status', 'open')
    //         ->where('assignee_id', $user->id);

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         // Search by lead name only
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }

    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate data
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();
    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.open-leads', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function open_leads(Request $request)
    {
        $user = auth()->user();
        $peoples = People::all();
        $activity_types = ActivityType::all();

        // Base query: only open leads assigned to current user
        $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
            ->where('lead_status', 'open')
            ->where('assignee_id', $user->id);

        // AJAX filters
        if ($request->ajax()) {

            // Search by lead name only
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%$search%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot == 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.open-leads', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }

    // public function hot_leads(Request $request)
    // {
    //     $user = auth()->user();
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     // Base query: only hot leads
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
    //         ->whereJsonContains('lead_flags', 'hot');

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         // Search by lead name only
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }

    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();
    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.hot-leads', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function hot_leads(Request $request)
    {
        $user = auth()->user();
        $peoples = People::all();
        $activity_types = ActivityType::all();

        // Base query: only hot leads
        $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
            ->whereJsonContains('lead_flags', 'hot');

        // AJAX filters
        if ($request->ajax()) {

            // Search by lead name only
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%$search%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads (extra safety)
            if ($request->has('hot') && $request->hot == 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.hot-leads', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }

    // public function watching_leads(Request $request)
    // {
    //     $user = auth()->user(); // current user
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     // Base query: only leads assigned to current user and flagged as watching
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
    //         ->where('assignee_id', $user->id)
    //         ->whereJsonContains('lead_flags', 'watching');

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         // Search by lead name only
    //         if ($request->filled('search')) {
    //             $query->where('name', 'like', "%{$request->search}%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }
    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate data
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();
    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.watching-leads', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function watching_leads(Request $request)
    {
        $user = auth()->user(); // current user
        $peoples = People::all();
        $activity_types = ActivityType::all();

        // Base query: only leads assigned to current user and flagged as watching
        $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
            ->where('assignee_id', $user->id)
            ->whereJsonContains('lead_flags', 'watching');

        // AJAX filters
        if ($request->ajax()) {

            // Search by lead name only
            if ($request->filled('search')) {
                $query->where('name', 'like', "%{$request->search}%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot == 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate data
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.watching-leads', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }

    // public function added_this_week(Request $request)
    // {
    //     $user = auth()->user();
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     $now = Carbon::now();
    //     $startOfWeek = $now->copy()->startOfWeek();
    //     $endOfWeek = $now->copy()->endOfWeek();

    //     // Base query: leads added this week
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
    //         ->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         if ($request->filled('search')) {
    //             $query->where('name', 'like', "%{$request->search}%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }
    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();
    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.added-this-week', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }


    public function added_this_week(Request $request)
    {
        $user = auth()->user();
        $peoples = People::all();
        $activity_types = ActivityType::all();

        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Base query: leads added this week
        $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        // AJAX filters
        if ($request->ajax()) {

            if ($request->filled('search')) {
                $query->where('name', 'like', "%{$request->search}%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot == 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.added-this-week', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }


    // public function closing_this_week(Request $request)
    // {
    //     $user = auth()->user();
    //     $peoples = People::all();
    //     $activity_types = ActivityType::all();

    //     $now = Carbon::now();
    //     $startOfWeek = $now->copy()->startOfWeek();
    //     $endOfWeek = $now->copy()->endOfWeek();

    //     // Base query: leads closing this week
    //     $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
    //         ->whereBetween('close_date', [$startOfWeek, $endOfWeek]);

    //     // AJAX filters
    //     if ($request->ajax()) {

    //         if ($request->filled('search')) {
    //             $query->where('name', 'like', "%{$request->search}%");
    //         }

    //         // Filter by status
    //         if ($request->filled('status')) {
    //             $query->where('lead_status', $request->status);
    //         }

    //         // Only hot leads
    //         if ($request->has('hot') && $request->hot == 'hot') {
    //             $query->whereJsonContains('lead_flags', 'hot');
    //         }
    //     }

    //     $leads = $query->get();

    //     // Group leads by name and aggregate
    //     $groupedLeads = $leads->groupBy('name')->map(function ($group) {
    //         $lead = $group->first();
    //         return [
    //             'id' => $lead->id,
    //             'name' => $lead->name,
    //             'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
    //             'created_at' => $lead->created_at->diffForHumans(null, true),
    //             'total_price' => $group->flatMap->products->sum('pivot.price'),
    //             'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
    //             'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
    //             'confidence' => round($group->avg('confidence')),
    //             'close_date' => optional($lead->close_date)->format('j F Y'),
    //         ];
    //     });

    //     $leadCount = $leads->count();
    //     $sidebarStats = $this->getSidebarStats();

    //     // Return partial for AJAX
    //     if ($request->ajax()) {
    //         return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
    //     }

    //     // Normal page load
    //     return view('admin.leads.closing-this-week', array_merge(
    //         compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
    //         $sidebarStats
    //     ));
    // }

    public function closing_this_week(Request $request)
    {
        $user = auth()->user();
        $peoples = People::all();
        $activity_types = ActivityType::all();

        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Base query: leads closing this week
        $query = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')
            ->whereBetween('close_date', [$startOfWeek, $endOfWeek]);

        // AJAX filters
        if ($request->ajax()) {

            if ($request->filled('search')) {
                $query->where('name', 'like', "%{$request->search}%");
            }

            // Filter by status
            if ($request->filled('status')) {
                $query->where('lead_status', $request->status);
            }

            // Only hot leads
            if ($request->has('hot') && $request->hot == 'hot') {
                $query->whereJsonContains('lead_flags', 'hot');
            }
        }

        $leads = $query->get();

        // Group leads by name and aggregate
        $groupedLeads = $leads->groupBy('name')->map(function ($group) {
            $lead = $group->first();

            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'people_name' => optional($lead->peoples->first())->name ?? 'N/A',
                'created_at' => $lead->created_at->diffForHumans(null, true),
                'total_price' => $group->flatMap->products->sum(function ($product) {
                    return $product->pivot->price * ($product->pivot->qty ?? 1);
                }),
                'assignee' => optional($lead->assignee)->name ?? 'Unassigned',
                'sources' => $group->flatMap->sources->pluck('name')->unique()->join(', ') ?: 'N/A',
                'confidence' => round($group->avg('confidence')),
                'close_date' => $lead->close_date
                    ? Carbon::parse($lead->close_date)->format('j F Y')
                    : 'N/A',
            ];
        });

        $leadCount = $leads->count();
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.leads.partials.lead-table-rows', compact('groupedLeads'))->render();
        }

        // Normal page load
        return view('admin.leads.closing-this-week', array_merge(
            compact('groupedLeads', 'peoples', 'leadCount', 'activity_types'),
            $sidebarStats
        ));
    }


    // public function store(Request $request)
    // {
    //     // dd($request);
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'assignee_id' => 'nullable|exists:users,id',
    //         'close_date' => 'nullable|date',
    //         'confidence' => 'nullable|numeric',
    //         'product_id' => 'nullable|array',
    //         'product_id.*' => 'exists:products,id',
    //         'quantity' => 'nullable|array',
    //         'price' => 'nullable|array',
    //         'company_id' => 'nullable|array',
    //         'company_id.*' => 'exists:companies,id',
    //         'person_id' => 'nullable|array',
    //         'person_id.*' => 'nullable|exists:people,id',
    //         'source_id' => 'nullable|array',
    //         'source_id.*' => 'exists:sources,id',
    //         'competitors_id' => 'nullable|array',
    //         'competitors_id.*' => 'nullable|exists:competitors,id',
    //         // 'tag_id' => 'required',
    //     ]);

    //     // Create one lead only
    //     $lead = Lead::create([
    //         'name' => $request->name,
    //         'assignee_id' => $request->assignee_id,
    //         'close_date' => $request->close_date,
    //         'confidence' => $request->confidence,
    //         // 'tag_id' => $request->tag_id,
    //     ]);

    //     // Store company relations in lead_companies
    //     if ($request->filled('company_id')) {
    //         foreach ($request->company_id as $companyId) {
    //             LeadCompany::create([
    //                 'lead_id' => $lead->id,
    //                 'company_id' => $companyId,
    //             ]);
    //         }
    //     }

    //     // Store related people
    //     if ($request->filled('person_id')) {
    //         foreach ($request->person_id as $person_id) {
    //             LeadPeople::create([
    //                 'lead_id' => $lead->id,
    //                 'people_id' => $person_id,
    //             ]);
    //         }
    //     }

    //     // Store products with qty & price
    //     if ($request->filled('product_id')) {
    //         foreach ($request->product_id as $index => $productId) {
    //             LeadProduct::create([
    //                 'lead_id' => $lead->id,
    //                 'product_id' => $productId,
    //                 'qty' => $request->quantity[$index] ?? 1,
    //                 'price' => $request->price[$index] ?? 0,
    //             ]);
    //         }
    //     }

    //     // Store sources
    //     if ($request->filled('source_id')) {
    //         foreach ($request->source_id as $sourceId) {
    //             LeadSource::create([
    //                 'lead_id' => $lead->id,
    //                 'source_id' => $sourceId,
    //             ]);
    //         }
    //     }

    //     // Store competitors
    //     if ($request->filled('competitors_id')) {
    //         foreach ($request->competitors_id as $competitorId) {
    //             LeadCompetitor::create([
    //                 'lead_id' => $lead->id,
    //                 'competitor_id' => $competitorId,
    //             ]);
    //         }
    //     }

    //     // Store sources
    //     if ($request->filled('tag_id')) {
    //         foreach ($request->tag_id as $tagId) {
    //             LeadTag::create([
    //                 'lead_id' => $lead->id,
    //                 'tag_id' => $tagId,
    //             ]);
    //         }
    //     }

    //     // return redirect()->route('admin.leads.index')->with('success', 'Leads created successfully');
    //     return redirect()->back()->with('success', 'Leads created successfully');
    // }

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

    // public function show($id)
    // {
    //     $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors', 'stages')->findOrFail($id);
    //     $leadStages = LeadStage::all();
    //     $activity_types = ActivityType::all(); // fetch all activities
    //     $sources = Source::all();
    //     $competitors = Competitor::all();
    //     $users = User::all();
    //     $industries = Industry::all();
    //     $allpeoples = People::all();
    //     $products = Product::all();

    //     return view('admin.leads.edit', compact('leads', 'users', 'allpeoples', 'industries', 'activity_types', 'competitors', 'leadStages', 'sources', 'products'));
    // }

    // public function ajax_update(Request $request)
    // {
    //     $request->validate([
    //         'lead_id' => 'required|exists:leads,id',
    //         'lead_status' => 'nullable',
    //         'lead_flag' => 'nullable',
    //     ]);

    //     $lead = Lead::findOrFail($request->lead_id);

    //     if ($request->filled('lead_status')) {
    //         $lead->lead_status = $request->lead_status;
    //     }

    //     if ($request->has('lead_flags')) {
    //         $lead->lead_flags = $request->lead_flags;
    //     }

    //     $lead->save();

    //     return response()->json(['success' => true]);
    // }

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
        'leadTask'
    ])->findOrFail($id);

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

}
