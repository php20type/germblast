<?php

namespace App\Http\Controllers\Admin;

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
        // $totalValue = $leads->flatMap->products->sum(function ($product) {
        //     return $product->pivot->price * ($product->pivot->qty ?? 1);
        // });
        // $avgValue = $leads->flatMap->products->avg(function ($product) {
        //     return $product->pivot->price * ($product->pivot->qty ?? 1);
        // });
        // $avgConfidence = $leads->avg('confidence');
        $totalValue = $leads->sum('total_value');  //  use accessor
        $avgValue = $leads->avg('total_value');   //  use accessor
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
            'stages',
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

            if ($request->filled('people_id')) {
                $query->whereHas('peoples', function ($q) use ($request) {
                    $q->where('people_id', $request->people_id);
                });
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
            'stages',
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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
                // 'total_price' => $group->flatMap->products->sum(function ($product) {
                //     return $product->pivot->price * ($product->pivot->qty ?? 1);
                // }),
                'total_price' => $group->sum->total_value,
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

        $pending_tasks = $leads->leadTask->whereNull('completed_user_id');
        $completed_tasks = $leads->leadTask->whereNotNull('completed_user_id');

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
            'lead_id' => 'required|integer',
            'related_id' => 'required|integer',
            'type' => 'required|string|in:company,people,product,competitor,source',
        ]);

        $leadId = $request->lead_id;
        $relatedId = $request->related_id;
        $type = $request->type;

        try {
            switch ($type) {
                case 'company':
                    $deleted = LeadCompany::where('lead_id', $leadId)
                        ->where('company_id', $relatedId)
                        ->delete();
                    break;

                case 'people':
                    $deleted = LeadPeople::where('lead_id', $leadId)
                        ->where('people_id', $relatedId)
                        ->delete();
                    break;

                case 'product':
                    $deleted = LeadProduct::where('lead_id', $leadId)
                        ->where('product_id', $relatedId)
                        ->delete();
                    break;

                case 'competitor':
                    $deleted = LeadCompetitor::where('lead_id', $leadId)
                        ->where('competitor_id', $relatedId)
                        ->delete();
                    break;

                case 'source':
                    $deleted = LeadSource::where('lead_id', $leadId)
                        ->where('source_id', $relatedId)
                        ->delete();
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Invalid type provided.'], 422);
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
