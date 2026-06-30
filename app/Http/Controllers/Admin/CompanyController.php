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
use App\Models\Territory;
use App\Models\Timeline;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
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
            ? number_format($totalCompanies / 1000, 1) . 'k'
            : $totalCompanies;

        $formattedMyCompanies = $myCompaniesCount >= 1000
            ? number_format($myCompaniesCount / 1000, 1) . 'k'
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

        if ($request->filled('assignee_id')) {
            $query->whereHas('assignee', fn($q) => $q->where('assignee_id', $request->assignee_id));
        }

        if ($request->filled('people_id')) {
            $query->whereHas('peoples', fn($q) => $q->where('people_id', $request->people_id));
        }

        if (!empty($request->company_tags_filter_id)) {
            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $request->company_tags_filter_id));
        }

        if (!empty($request->industry_filter_id)) {
            $query->whereIn('industry_id', $request->industry_filter_id);
        }

        if (!empty($request->territory_filter_id)) {
            $query->whereIn('territory_id', $request->territory_filter_id);
        }

        if (!empty($request->activity_type_filter_id)) {
            $query->whereHas('activity', fn($q) => $q->whereIn('activity_type_id', $request->activity_type_filter_id));
        }

        if (!empty($request->leads_status)) {
            $query->whereHas('leads', fn($q) => $q->whereIn('lead_status', $request->leads_status));
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

        $companies = $query->paginate(10)->appends($request->query());
        $companiesCount = $companies->total();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.company.partials.company-table-rows', compact('companies'))->render(),
                'count' => $companiesCount,
                'pagination' => (string) $companies->links(),
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

        $companies = $query->paginate(10)->appends($request->query());
        $totalMyCompanies = $companies->total();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.company.partials.company-table-rows', compact('companies'))->render(),
                'count' => $totalMyCompanies,
                'pagination' => (string) $companies->links(),
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
        if ($request->filled('tax_rate') && !array_key_exists($request->tax_rate, config('mapping.tax_rates'))) {
            return redirect()->back()->with('error', 'Invalid tax rate selected.');
        }

        try {
            // Step 1: Create company
            $company = Company::create([
                'user_id' => auth()->id(),
                'assignee_id' => $request->assignee_id,
                'name' => $request->name,
                'description' => $request->description,
                'company_type_id' => $request->company_type_id,
                'industry_id' => $request->industry_id,
                'territory_id' => $request->territory_id,
                'tax_rate' => $request->tax_rate,
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

            // SEND EMAIL NOTIFICATION
            $notify->companyCreated($company);

            return redirect()->back()->with('success', 'Company created successfully!');

        } catch (\Exception $e) {
            Log::error('Company Creation Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
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
        // $related_leads = $company->leads()->with('products')->get();
        $related_leads = $company->leadCompany()->with('products')->get();
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
        // $cities = City::all();
        // $states = State::all();
        $states = [];
        $cities = [];
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
                if (!empty($company->companyEmail->$field)) {
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
                if (!empty($addressRecord->$field)) {
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
                if (!empty($phoneRecord->$field)) {
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
                if (!empty($urlRecord->$field)) {
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
            'address_2' => 'nullable|string|max:255',
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

    public function updateLocation(Request $request, $locationId)
    {
        $location = CompanyLocation::findOrFail($locationId);
        
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'zip' => 'required|string|max:20',
        ]);

        $location->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Company location updated successfully.',
            'data' => $location,
        ], 200);
    }

    public function deleteLocation($locationId)
    {
        $location = CompanyLocation::findOrFail($locationId);
        $location->delete();

        return response()->json([
            'status' => true,
            'message' => 'Company location deleted successfully.',
        ], 200);
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

        if (!$companyPeople) {
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
            'message' => ucfirst($request->field) . ' updated successfully!',
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

        if (!$companyTag) {
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

        $companyName = $company->name ?? 'Unknown Company';

        switch ($request->field) {

            case 'company_type_id':
                $company->update([
                    'company_type_id' => $request->value,
                ]);

                $newType = CompanyType::find($request->value)->type ?? 'Unknown';

                Timeline::create([
                    'user_id' => auth()->id(),
                    'owner_type' => 'company',
                    'owner_id' => $company->id,
                    'action_type' => 'updated_company_type',
                    'description' => "changed the company type of {$companyName} to {$newType}",
                ]);
                break;

            case 'assignee_id':
                $company->update([
                    'assignee_id' => $request->value,
                ]);

                $newAssignee = User::find($request->value)->name ?? 'Unassigned';

                Timeline::create([
                    'user_id' => auth()->id(),
                    'owner_type' => 'company',
                    'owner_id' => $company->id,
                    'action_type' => 'updated_assignee',
                    'description' => "reassigned {$companyName} to {$newAssignee}",
                ]);
                break;

            case 'industry_id':
                $company->update([
                    'industry_id' => $request->value,
                ]);
                break;

            case 'territory_id':
                $company->update([
                    'territory_id' => $request->value,
                ]);
                break;

            case 'annual_revenue':
                $company->update([
                    'annual_revenue' => $request->value,
                ]);
                break;

            case 'employees_count':
                $company->update([
                    'employees_count' => $request->value,
                ]);
                break;

            case 'tax_rate':
                if ($request->filled('value') && !array_key_exists($request->value, config('mapping.tax_rates'))) {
                    return response()->json([
                        'error' => 'Invalid tax rate value',
                    ], 422);
                }
                $company->update([
                    'tax_rate' => $request->value,
                ]);
                break;

            default:
                return response()->json([
                    'error' => 'Invalid field',
                ], 422);
        }

        return response()->json([
            'success' => true,
            'field' => $request->field,
            'value' => $request->value,
        ]);
    }

    public function updateCompanyField(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'category' => 'required|in:email,address,phone,url',
            'type' => 'required|string',
            'value' => 'required',
        ]);

        switch ($request->category) {

            case 'email':
                $request->validate([
                    'type' => 'in:email,personal_email,support_email,work_email',
                    'value' => 'email',
                ]);

                $record = CompanyEmail::firstOrNew([
                    'company_id' => $request->company_id,
                ]);
                break;

            case 'address':
                $request->validate([
                    'type' => 'in:address,main_address,work_address,home_address,billing_address,mailing_address',
                    'value' => 'string',
                ]);

                $record = CompanyAddress::firstOrNew([
                    'company_id' => $request->company_id,
                ]);
                break;

            case 'phone':
                $request->validate([
                    'type' => 'in:phone,home_phones,mobile_phones,work_phones,fax_phones',
                    'value' => 'string',
                ]);

                $record = CompanyPhone::firstOrNew([
                    'company_id' => $request->company_id,
                ]);
                break;

            case 'url':
                $request->validate([
                    'type' => 'in:url,blog_url,twitter_url',
                    'value' => 'url',
                ]);

                $record = CompanyUrl::firstOrNew([
                    'company_id' => $request->company_id,
                ]);
                break;
        }

        $record->{$request->type} = $request->value;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' updated successfully',
            'data' => $record,
        ]);
    }

    public function deleteField(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'category' => 'required|in:email,address,phone,url',
            'type' => 'required|string',
        ]);

        switch ($request->category) {

            case 'email':
                $allowed = ['email', 'personal_email', 'support_email', 'work_email'];
                $model = CompanyEmail::where('company_id', $request->company_id)->first();
                break;

            case 'address':
                $allowed = [
                    'address',
                    'main_address',
                    'work_address',
                    'home_address',
                    'billing_address',
                    'mailing_address',
                ];
                $model = CompanyAddress::where('company_id', $request->company_id)->first();
                break;

            case 'phone':
                $allowed = [
                    'phone',
                    'home_phones',
                    'mobile_phones',
                    'work_phones',
                    'fax_phones',
                ];
                $model = CompanyPhone::where('company_id', $request->company_id)->first();
                break;

            case 'url':
                $allowed = ['url', 'blog_url', 'twitter_url'];
                $model = CompanyUrl::where('company_id', $request->company_id)->first();
                break;

            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid category',
                ], 400);
        }

        if (!in_array($request->type, $allowed)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field type',
            ], 422);
        }

        if (!$model) {
            return response()->json([
                'status' => 'error',
                'message' => ucfirst($request->category) . ' record not found',
            ], 404);
        }

        $model->{$request->type} = null;
        $model->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' deleted successfully',
            'data' => $model,
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
            $filename = Str::random(10) . '_' . $cleanName . '.' . $extension;

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
            Log::error("Company file upload failed for company ID {$company->id}: " . $e->getMessage());

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

            Storage::disk('public')->delete($file->file_path);
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully!',
            ]);

        } catch (\Throwable $e) {
            Log::error("File delete failed for company {$request->company_id}: " . $e->getMessage());

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
                'message' => 'Failed to delete company(s): ' . $e->getMessage(),
            ], 500);
        }
    }
}
