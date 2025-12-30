<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyRepositoryInterface;
use App\Models\ActivityType;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CompanyEmail;
use App\Models\CompanyFile;
use App\Models\CompanyLocation;
use App\Models\CompanyPeople;
use App\Models\CompanyPhone;
use App\Models\CompanyTag;
use App\Models\CompanyType;
use App\Models\CompanyUrl;
use App\Models\Competitor;
use App\Models\Country;
use App\Models\Industry;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\State;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Territory;
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

class CompanyController extends Controller
{
    protected $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function getSidebarStats()
    {
        $currentUser = auth()->user();
        $totalCompanies = $this->companyRepo->countAll();
        $myCompaniesCount = $this->companyRepo->countByUser($currentUser->id);

        $formattedTotalCompanies = $totalCompanies >= 1000
            ? number_format($totalCompanies / 1000, 1).'k'
            : $totalCompanies;

        $formattedMyCompanies = $myCompaniesCount >= 1000
            ? number_format($myCompaniesCount / 1000, 1).'k'
            : $myCompaniesCount;

        return compact('formattedTotalCompanies', 'formattedMyCompanies');
    }

    private function applyCompanyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('company_type_id')) {
            $query->where('company_type_id', $request->company_type_id);
        }

        if ($request->filled('user_id')) {
            $query->whereHas('user', fn ($q) => $q->where('user_id', $request->user_id));
        }

        if ($request->filled('people_id')) {
            $query->whereHas('peoples', fn ($q) => $q->where('people_id', $request->people_id));
        }

        if (! empty($request->company_tags_filter_id)) {
            $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $request->company_tags_filter_id));
        }

        if (! empty($request->industry_filter_id)) {
            $query->whereIn('industry_id', $request->industry_filter_id);
        }

        if (! empty($request->territory_filter_id)) {
            $query->whereIn('territory_id', $request->territory_filter_id);
        }

        if (! empty($request->activity_type_filter_id)) {
            $query->whereHas('activity', fn ($q) => $q->whereIn('activity_type_id', $request->activity_type_filter_id));
        }

        if (! empty($request->leads_status)) {
            $query->whereHas('leads', fn ($q) => $q->whereIn('lead_status', $request->leads_status));
        }

        return $query;
    }

    private function getCompanySharedData()
    {
        return [
            'peoples' => People::all(),
            'users' => User::all(),
            'products' => Product::all(),
            'allCompanies' => Company::all(),
            'sources' => Source::all(),
            'activity_types' => ActivityType::all(),
            'industries' => Industry::all(),
            'territories' => Territory::all(),
            'competitors' => Competitor::all(),
            'companytags' => Tag::where('tag_id', 2)->get(),
            'company_types' => CompanyType::all(),
        ];
    }

    public function index(Request $request)
    {
        $query = $this->applyCompanyFilters(
            $this->companyRepo->getAllWithRelations(),
            $request
        );

        $companies = $query->get();
        $companiesCount = $companies->count();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.company.partials.company-table-rows', compact('companies'))->render(),
                'count' => $companiesCount,
            ]);
        }

        return view('admin.company.index', array_merge(
            compact('companies', 'companiesCount'),
            $this->getCompanySharedData(),
            $this->getSidebarStats()
        ));
    }

    public function my_companies(Request $request, $id)
    {
        $query = $this->applyCompanyFilters(
            $this->companyRepo->getByUserWithRelations($id),
            $request
        );

        $companies = $query->get();
        $totalMyCompanies = $companies->count();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.company.partials.company-table-rows', compact('companies'))->render(),
                'count' => $totalMyCompanies,
            ]);
        }

        return view('admin.company.my-companies', array_merge(
            compact('companies', 'totalMyCompanies'),
            $this->getCompanySharedData(),
            $this->getSidebarStats()
        ));
    }

    public function store(Request $request, NotificationService $notify)
    {
        $company = null;

        DB::transaction(function () use ($request, &$company) {

            // Step 1: Create company
            $company = Company::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'description' => $request->description,
                'company_type_id' => $request->company_type_id,
                'industry_id' => $request->industry_id,
                'territory_id' => $request->territory_id,
            ]);

            // Step 2: Store emails
            if ($request->email) {
                CompanyEmail::create([
                    'company_id' => $company->id,
                    'email' => $request->email,
                ]);
            }

            // Step 3: Store phones
            if ($request->phone) {
                CompanyPhone::create([
                    'company_id' => $company->id,
                    'phone' => $request->phone,
                ]);
            }

            // Step 4: Store addresses
            if ($request->address) {
                CompanyAddress::create([
                    'company_id' => $company->id,
                    'address' => $request->address,
                ]);
            }

            // Step 5: Store URLs
            if ($request->url) {
                CompanyUrl::create([
                    'company_id' => $company->id,
                    'url' => $request->url,
                ]);
            }

            // Step 6: Store people
            if ($request->people_id) {
                CompanyPeople::create([
                    'company_id' => $company->id,
                    'people_id' => $request->people_id,
                ]);
            }

            // Step 7: Store tags
            if ($request->tag_id) {
                CompanyTag::create([
                    'company_id' => $company->id,
                    'tag_id' => $request->tag_id,
                ]);
            }
        });

        // SEND EMAIL NOTIFICATION
        $notify->companyCreated($company);

        return redirect()->back()->with('success', 'Company created successfully!');
    }

    // ======================
    // This is for approval workflow
    // ======================
    // public function store(Request $request)
    // {
    //     ApprovalService::request(
    //         'febev88675@bablace.com',
    //         'company_create',
    //         [
    //             'request_data' => $request->all(),
    //             'creator_id' => auth()->id(),
    //         ],
    //          url()->previous()
    //     );

    //     return redirect()->back()->with('success', 'Company creation request submitted for approval.');
    // }

    public function ajax_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'url' => 'nullable|url',
            'people_id' => 'nullable|exists:people,id',
            'company_type_id' => 'nullable|exists:company_types,id',
            'tag_id' => 'nullable|exists:tags,id',
            'industry_id' => 'nullable|exists:industries,id',
            'territory_id' => 'nullable|exists:territories,id',
        ]);

        DB::transaction(function () use ($request, &$company) {
            // Create base company
            $company = Company::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'company_type_id' => $request->company_type_id,
                'industry_id' => $request->industry_id,
                'territory_id' => $request->territory_id,
            ]);

            // Store email
            if ($request->filled('email')) {
                CompanyEmail::create([
                    'company_id' => $company->id,
                    'email' => $request->email,
                ]);
            }

            // Store tag
            if ($request->filled('tag_id')) {
                CompanyTag::create([
                    'company_id' => $company->id,
                    'tag_id' => $request->tag_id,
                ]);
            }

            // Store phone
            if ($request->filled('phone')) {
                CompanyPhone::create([
                    'company_id' => $company->id,
                    'phone' => $request->phone,
                ]);
            }

            // Store address
            if ($request->filled('address')) {
                CompanyAddress::create([
                    'company_id' => $company->id,
                    'address' => $request->address,
                ]);
            }

            // Store URL
            if ($request->filled('url')) {
                CompanyUrl::create([
                    'company_id' => $company->id,
                    'url' => $request->url,
                ]);
            }

            // Store related person (only one for now)
            if ($request->filled('people_id')) {
                CompanyPeople::create([
                    'company_id' => $company->id,
                    'people_id' => $request->people_id,
                ]);
            }
        });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Company added successfully.',
                'company' => $company->load([
                    'companyEmail',
                    'companyPhone',
                    'companyAddress',
                    'companyUrl',
                    'peoples',
                ]),
            ]);
        }

        return redirect()->back()->with('success', 'Company added successfully.');
    }

    public function show(Request $request, $id)
    {
        $activity_types = ActivityType::all();
        $products = Product::all();

        // Load company with all relations
        $company = Company::with([
            'user',
            'companyType',
            'industry',
            'tags',
            'companyEmail',
            'companyPeople',
            'companyPhone',
            'companyFile',
            'companyAddress',
            'companyUrl',
            'leads',
            'locations.country',
            'locations.state',
            'locations.city',
            'peoples', // <-- fetch related people via pivot
        ])->findOrFail($id);

        $companyFiles = $company->companyFile;

        $activities = Helper::getActivitiesForParticipant('company', $company->id);
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

        $notes = Helper::getNotesForParticipant('company', $company->id);
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
        $timelineEntries = Helper::getTimelineForEntity('company', $company->id);
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

        $milestones = collect();

        if ($company->created_at) {
            $createdAt = $company->created_at->copy();
            $now = now();

            // Calculate total months since creation
            $totalMonths = $createdAt->diffInMonths($now);

            // Generate milestones dynamically — only 1 month, 6 months, and yearly
            for ($i = 1; $i <= $totalMonths; $i++) {
                $milestoneDate = $createdAt->copy()->addMonths($i);

                // Only display for 1 monsth, 6 months, 1 year, 2 years, 3 years, etc.
                if ($i === 1) {
                    $label = '1 month as a client';
                } elseif ($i === 6) {
                    $label = '6 months as a client';
                } elseif ($i % 12 === 0) {
                    $years = $i / 12;
                    $label = $years === 1
                        ? '1 year as a client'
                        : "{$years} years as a client";
                } else {
                    continue; // skip other months like 18, 9, etc.
                }

                // Push milestone to collection
                $milestones->push((object) [
                    'type' => 'milestone',
                    'title' => $label,
                    'timestamp' => $milestoneDate,
                ]);
            }

        }

        $timeline = $logged_activities
            ->concat($notes)
            ->concat($timelineEntries)
            ->concat($milestones)
            ->sortByDesc('timestamp')
            ->values(); // reindex after sorting

        // ADD THIS SECTION — Handle AJAX requests
        if ($request->ajax()) {
            $timeline_html = view('admin.company.partials.company-timeline', compact('timeline'))->render();

            return response()->json([
                'timeline_html' => $timeline_html,
            ]);
        }

        // $related_leads = $company->leads;
        $related_leads = $company->leads()->with('products')->get();
        $relatedLeadsCount = Helper::calculateTotalValue($related_leads);
        $formattedLeadsCount = Helper::formatValue($relatedLeadsCount);

        $hotLeadsCount = $company->leads()->where('is_hot', 1)->count();
        $wonLeadsCount = $company->leads()->where('lead_status', 'won')->count();
        $lostLeadsCount = $company->leads()->where('lead_status', 'lost')->count();

        foreach ($related_leads as $lead) {
            $status = strtolower($lead->lead_status ?? 'open');
            $icon = '';

            if ($status === 'won') {
                $icon = asset('img/icons/won.svg');
            } elseif ($status === 'cancelled') {
                $icon = asset('img/icons/cancelled.svg');
            } elseif ($status === 'pending') {
                $icon = asset('img/icons/pending.svg');
            } elseif ($status === 'lost') {
                $icon = asset('img/icons/lost.svg');
            } else {
                $icon = asset('img/icons/level-5.svg'); // default
            }
            // Attach computed icon path to the lead model
            $lead->status_icon = $icon;
        }

        $companies = Company::all();
        $pending_tasks = $company->task->whereNull('completed_user_id');
        $completed_tasks = $company->task->whereNotNull('completed_user_id');

        $users = User::all();
        $companytags = Tag::where('tag_id', 2)->get();
        $competitors = Competitor::all();
        $sources = Source::all();
        $company_types = CompanyType::all();
        $industries = Industry::all();
        $territories = Territory::all();
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();
        $companyLocations = $company->locations;
        // Already coming from pivot relation, so no need for where('company_id', $id)
        $peoples = $company->peoples;
        $allpeoples = People::all();

        $assignedPeopleIds = $company->peoples->pluck('id');
        $availablePeoples = People::whereNotIn('id', $assignedPeopleIds)->get();

        $emails = [];

        $emailTypes = [
            'email' => 'Email',
            'personal_email' => 'Personal Email',
            'support_email' => 'Support Email',
            'work_email' => 'Work Email',
        ];

        if ($company->companyEmail) {
            foreach ($emailTypes as $field => $label) {
                if (! empty($company->companyEmail->$field)) {
                    $emails[] = [
                        'selected' => $field,
                        'value' => $company->companyEmail->$field,
                    ];
                }
            }
        }

        $addressTypes = [
            'address' => 'Address',
            'main_address' => 'Main Address',
            'work_address' => 'Work Address',
            'home_address' => 'Home Address',
            'billing_address' => 'Billing Address',
            'mailing_address' => 'Mailing Address',
        ];

        $addresses = [];

        // Check if record exists
        $addressRecord = $company->companyAddress;
        if ($addressRecord) {
            foreach ($addressTypes as $field => $label) {
                if (! empty($addressRecord->$field)) {
                    $addresses[] = [
                        'selected' => $field, // which option should be selected
                        'value' => $addressRecord->$field,
                    ];
                }
            }
        }

        $phoneTypes = [
            'phone' => 'Phone',
            'home_phones' => 'Home Phone',
            'mobile_phones' => 'Mobile Phone',
            'work_phones' => 'Work Phone',
            'fax_phones' => 'Fax Phone',
        ];

        $phones = [];

        $phoneRecord = $company->companyPhone;
        if ($phoneRecord) {
            foreach ($phoneTypes as $field => $label) {
                if (! empty($phoneRecord->$field)) {
                    $phones[] = [
                        'selected' => $field,   // which option should be selected
                        'value' => $phoneRecord->$field,
                    ];
                }
            }
        }

        $urlTypes = [
            'url' => 'URL',
            'blog_url' => 'Blog URL',
            'twitter_url' => 'Twitter URL',
        ];

        $urls = [];

        $urlRecord = $company->companyUrl;
        if ($urlRecord) {
            foreach ($urlTypes as $field => $label) {
                if (! empty($urlRecord->$field)) {
                    $urls[] = [
                        'selected' => $field, // which option should be selected
                        'value' => $urlRecord->$field,
                    ];
                }
            }
        }

        return view('admin.company.edit', compact(
            'company',
            'companyFiles',
            'activities',
            'logged_activities',
            'scheduled_activities',
            'notes',
            'timeline',
            'timelineEntries',
            'related_leads',
            'formattedLeadsCount',
            'hotLeadsCount',
            'wonLeadsCount',
            'lostLeadsCount',
            'pending_tasks',
            'completed_tasks',
            'users',
            'company_types',
            'companytags',
            'activity_types',
            'competitors',
            'sources',
            'companies',
            'countries',
            'states',
            'cities',
            'products',
            'peoples',
            'companyLocations',
            'allpeoples',
            'availablePeoples',
            'industries',
            'territories',
            'emails',
            'emailTypes',
            'addresses',
            'addressTypes',
            'phones',
            'phoneTypes',
            'urls',
            'urlTypes'
        ));
    }


    public function addLocation(Request $request, Company $company)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'required|string|max:255',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'zip' => 'required|string|max:20',
        ]);

        $location = CompanyLocation::create([
            'company_id' => $company->id,
            'location_name' => $validated['location_name'],
            'address_1' => $validated['address_1'],
            'address_2' => $validated['address_2'],
            'country_id' => $validated['country_id'],
            'state_id' => $validated['state_id'],
            'city_id' => $validated['city_id'],
            'zip' => $validated['zip'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Company location added successfully.',
            'data' => $location,
        ], 201);
    }

    public function addPeople(Request $request, $companyId)
    {

        $request->validate([
            'people_id' => 'required|exists:people,id',
        ]);

        // Prevent duplicates
        $exists = CompanyPeople::where('company_id', $companyId)
            ->where('people_id', $request->people_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This person is already linked to the company.',
            ], 422);
        }

        // Create new record
        CompanyPeople::create([
            'company_id' => $companyId,
            'people_id' => $request->people_id,
        ]);

        $personName = People::find($request->people_id)->name;
        $companyName = Company::find($companyId)->name;

        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'company',
            'owner_id' => $companyId,
            'action_type' => 'added_person',
            'description' => "added {$personName} to {$companyName}",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Person added to company successfully!',
        ]);
    }

    public function removePerson(Request $request, $companyId)
    {
        $request->validate([
            'people_id' => 'required|exists:people,id',
        ]);

        // Find the pivot record
        $companyPeople = CompanyPeople::where('company_id', $companyId)
            ->where('people_id', $request->people_id)
            ->first();

        if (! $companyPeople) {
            return response()->json([
                'status' => 'error',
                'message' => 'This person is not linked to the company.',
            ], 404);
        }

        // Delete the pivot record
        $companyPeople->delete();

        // Prepare names for readable timeline entry
        $personName = People::find($request->people_id)->name;
        $companyName = Company::find($companyId)->name;

        // Log to timeline with proper action type and message
        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'company',
            'owner_id' => $companyId,
            'action_type' => 'removed_person',
            'description' => "removed {$personName} from {$companyName}",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Person removed from company successfully!',
        ]);
    }

    public function updateDetail(Request $request, $companyId)
    {
        $request->validate([
            'field' => 'required|string|in:name,description',
            'value' => 'nullable|string',
        ]);

        $company = Company::findOrFail($companyId);
        $company->{$request->field} = $request->value;
        $company->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->field).' updated successfully!',
        ]);
    }

    public function addTag(Request $request, $companyId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        // Prevent duplicates
        $exists = CompanyTag::where('company_id', $companyId)
            ->where('tag_id', $request->tag_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This tag is already linked to the company.',
            ], 422);
        }

        // Create new record
        CompanyTag::create([
            'company_id' => $companyId,
            'tag_id' => $request->tag_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tag added to company successfully!',
        ]);
    }

    public function removeTag(Request $request, $companyId, $tagId)
    {
        // Find the pivot record
        $companyTag = CompanyTag::where('company_id', $companyId)
            ->where('tag_id', $tagId)
            ->first();

        if (! $companyTag) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tag not found for this company.',
            ], 404);
        }

        $companyTag->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag removed from company successfully!',
        ]);
    }

    public function updateField(Request $request, Company $company)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $allowed = ['company_type_id', 'industry_id', 'territory_id', 'user_id', 'annual_revenue', 'employees_count'];

        if (! in_array($request->field, $allowed)) {
            return response()->json(['error' => 'Invalid field'], 422);
        }

        $company->update([
            $request->field => $request->value,
        ]);

        $companyName = $company->name ?? 'Unknown Company';
        $description = null;
        $actionType = null;

        // Add timeline entries for key updates
        if ($request->field === 'company_type_id') {
            $newType = CompanyType::find($request->value)->type;
            $description = "changed the company type of {$companyName} to {$newType}";
            $actionType = 'updated_company_type';
        } elseif ($request->field === 'user_id') {
            $newAssignee = User::find($request->value)->name;
            $description = "reassigned {$companyName} to {$newAssignee}";
            $actionType = 'updated_assignee';
        }

        if ($description) {
            Timeline::create([
                'user_id' => auth()->id(),
                'owner_type' => 'company',
                'owner_id' => $company->id,
                'action_type' => $actionType,
                'description' => $description,
            ]);
        }

        return response()->json(['success' => true, 'field' => $request->field, 'value' => $request->value]);
    }

    public function deleteField(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type' => 'required|string',
            'field_name' => 'required|string', // email, address, phone, url
        ]);

        // Map field_name to model and allowed types
        $models = [
            'email' => [CompanyEmail::class, ['email', 'personal_email', 'support_email', 'work_email']],
            'address' => [CompanyAddress::class, ['address', 'main_address', 'work_address', 'home_address', 'billing_address', 'mailing_address']],
            'phone' => [CompanyPhone::class, ['phone', 'home_phones', 'mobile_phones', 'work_phones', 'fax_phones']],
            'url' => [CompanyUrl::class, ['url', 'blog_url', 'twitter_url']],
        ];

        if (! isset($models[$request->field_name])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid field name'], 400);
        }

        [$modelClass, $allowedTypes] = $models[$request->field_name];

        if (! in_array($request->type, $allowedTypes)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid type'], 400);
        }

        $record = $modelClass::where('company_id', $request->company_id)->first();

        if (! $record) {
            return response()->json(['status' => 'error', 'message' => ucfirst($request->field_name).' record not found'], 404);
        }

        $record->{$request->type} = null;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' deleted successfully',
            'data' => $record,
        ]);
    }

    public function updateCompanyField(Request $request)
    {
        // Define config for each category
        $config = [
            'email' => [
                'model' => CompanyEmail::class,
                'valid_types' => ['email', 'personal_email', 'support_email', 'work_email'],
                'validation' => 'email',
            ],
            'address' => [
                'model' => CompanyAddress::class,
                'valid_types' => ['address', 'main_address', 'work_address', 'home_address', 'billing_address', 'mailing_address'],
                'validation' => 'string',
            ],
            'phone' => [
                'model' => CompanyPhone::class,
                'valid_types' => ['phone', 'home_phones', 'mobile_phones', 'work_phones', 'fax_phones'],
                'validation' => 'string',
            ],
            'url' => [
                'model' => CompanyUrl::class,
                'valid_types' => ['url', 'blog_url', 'twitter_url'],
                'validation' => 'url',
            ],
        ];

        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'category' => 'required|in:'.implode(',', array_keys($config)),
            'type' => 'required|string',
            'value' => 'required',
        ]);

        $category = $request->category;

        if (! in_array($request->type, $config[$category]['valid_types'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid type for category '.$category,
            ], 422);
        }

        // Validate value based on category-specific validation
        $validator = \Validator::make($request->all(), [
            'value' => $config[$category]['validation'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first('value'),
            ], 422);
        }

        $modelClass = $config[$category]['model'];
        $record = $modelClass::firstOrNew(['company_id' => $request->company_id]);
        $record->{$request->type} = $request->value;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $record,
        ]);
    }

    public function addTask(Request $request, $companyId)
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

        // Create the task in the unified tasks table
        $task = Task::create([
            'owner_type' => 'Company',
            'owner_id' => $companyId,
            'title' => $request->title,
            'description' => $request->description,
            'created_time' => now(),
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
            'subject_type' => 'company',
            'subject_legacy_id' => $companyId,
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

        // Fetch from unified tasks table
        $task = Task::findOrFail($taskId);
        $assignee = User::findOrFail($request->user_id);

        // Convert due date properly
        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        // Update fields
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_time' => $dueTime,
            'assignee_id' => $assignee->id,
            'assignee_name' => $assignee->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }

    public function markCompleted($taskId)
    {
        // Fetch from unified tasks table
        $task = Task::findOrFail($taskId);

        // Get the logged-in user
        $user = auth()->user();

        // Update completion fields
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
        // Fetch the task from the unified tasks table
        $task = Task::findOrFail($taskId);

        // Reset completion fields
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
        // Find the task in the unified tasks table
        $task = Task::find($task_id);

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

    public function fileUpload(Request $request, Company $company)
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

            $path = $file->storeAs('company_files', $filename, 'public');

            $companyFile = CompanyFile::create([
                'company_id' => $company->id,
                'user_id' => auth()->id(),
                'file_name' => $originalName,
                'file_path' => $path,
                'file_type' => $extension,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file' => $companyFile,
            ]);
        } catch (\Throwable $e) {
            Log::error("Company file upload failed for company ID {$company->id}: ".$e->getMessage());

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
            'company_id' => 'required|integer',
        ]);

        try {
            $file = CompanyFile::where('id', $request->file_id)
                ->where('company_id', $request->company_id)
                ->firstOrFail();

            // Delete file from storage
            Storage::disk('public')->delete($file->file_path);

            // Delete record from DB
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully!',
            ]);

        } catch (\Throwable $e) {
            Log::error("File delete failed for company {$request->company_id}: ".$e->getMessage());

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
                'message' => 'No company selected for deletion.',
            ], 400);
        }

        try {
            Company::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) > 1
                    ? 'Selected companies deleted successfully.'
                    : 'Company deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete company(s): '.$e->getMessage(),
            ], 500);
        }
    }
}
