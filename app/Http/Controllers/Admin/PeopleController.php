<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Company;
use App\Models\Competitor;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\People;
use App\Models\PeopleAddress;
use App\Models\PeopleCompany;
use App\Models\PeopleEmail;
use App\Models\PeopleFile;
use App\Models\PeoplePhone;
use App\Models\PeopleTag;
use App\Models\PeopleUrl;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Territory;
use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PeopleController extends Controller
{
    public function getSidebarStats()
    {
        $user = auth()->user();

        $peoples = People::with(['companies', 'tags', 'user'])->get();
        $myPeopleCount = $peoples->where('user_id', $user->id)->count();
        $totalPeoples = $peoples->count();

        // Conditional formatting
        $formattedTotalPeoples = $totalPeoples >= 1000
            ? number_format($totalPeoples / 1000, 1).'K'
            : $totalPeoples;

        $formattedMyPeopleCount = $myPeopleCount >= 1000
            ? number_format($myPeopleCount / 1000, 1).'K'
            : $myPeopleCount;

        return compact('myPeopleCount', 'formattedMyPeopleCount', 'totalPeoples', 'formattedTotalPeoples');
    }

    private function applyPeopleFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('user_id')) {
            $query->whereHas('user', fn ($q) => $q->where('user_id', $request->user_id)
            );
        }

        if ($request->filled('company_id')) {
            $query->whereHas('companiesAlt', fn ($q) => $q->where('company_id', $request->company_id)
            );
        }

        if (! empty($request->people_tags_filter_id)) {
            $query->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $request->people_tags_filter_id)
            );
        }

        if (! empty($request->territory_filter_id)) {
            $query->whereIn('territory_id', $request->territory_filter_id);
        }

        if (! empty($request->activity_type_filter_id)) {
            $query->whereHas('activity', fn ($q) => $q->whereIn('activity_type_id', $request->activity_type_filter_id)
            );
        }

        if (! empty($request->leads_status)) {
            $query->whereHas('leads', fn ($q) => $q->whereIn('lead_status', $request->leads_status)
            );
        }

        return $query;
    }

    private function getPeopleSharedData()
    {
        return [
            'companies' => Company::all(),
            'users' => User::all(),
            'products' => Product::all(),
            'allPeoples' => People::all(),
            'sources' => Source::all(),
            'activity_types' => ActivityType::all(),
            'territories' => Territory::all(),
            'competitors' => Competitor::all(),
            'peopletags' => Tag::where('tag_id', 3)->get(),
        ];
    }

    public function index(Request $request)
    {
        $query = People::with([
            'companies', 'tags', 'user',
            'peopleEmail', 'peoplePhone', 'peopleAddress',
            'peopleUrl', 'peopleCompany',
        ]);

        // Apply shared filters
        $this->applyPeopleFilters($query, $request);

        $peoples = $query->get();
        $peoplesCount = $peoples->count();

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.peoples.partials.people-table-row', compact('peoples'))->render(),
                'count' => $peoplesCount,
            ]);
        }

        // Full page load
        return view('admin.peoples.index', array_merge(
            compact('peoples', 'peoplesCount'),
            $this->getPeopleSharedData(),
            $this->getSidebarStats()
        ));
    }

    public function my_peoples(Request $request, $id)
    {
        $query = People::with([
            'companies', 'tags', 'user',
            'peopleEmail', 'peoplePhone', 'peopleAddress',
            'peopleUrl', 'peopleCompany',
        ])->where('user_id', $id);

        // Apply shared filters
        $this->applyPeopleFilters($query, $request);

        $peoples = $query->get();
        $myPeoplesCount = $peoples->count();

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.peoples.partials.people-table-row', compact('peoples'))->render(),
                'count' => $myPeoplesCount,
            ]);
        }

        // Full page load
        return view('admin.peoples.my-peoples', array_merge(
            compact('peoples', 'myPeoplesCount'),
            $this->getPeopleSharedData(),
            $this->getSidebarStats()
        ));
    }

    public function animal_care()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tags', 'user', 'peopleEmail', 'peoplePhone', 'peopleAddress', 'peopleUrl',  'peopleCompany'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.animal-care', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }

    public function marketing_contacts()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tags', 'user'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.marketing-contacts', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }

    public function sequence_healthcare()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tags', 'user'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.sequence-healthcare', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }

    public function show(Request $request, $id)
    {
        // Fetch a single person with ALL its relations
        $peoples = People::with([
            'companies',
            'tags',
            'user',
            'country',
            'state',
            'city',
            'territory',
            'peopleEmail',
            'peopleFile',
            'peopleAddress',
            'peoplePhone',
            'peopleUrl',
            'peopleCompany',
            'companiesAlt',
            'leadPeople',
            'leads',
            'companyPeople',
            'companies',
        ])->findOrFail($id);

        $peopleFiles = $peoples->peopleFile;

        $pending_tasks = $peoples->task->whereNull('completed_user_id');
        $completed_tasks = $peoples->task->whereNotNull('completed_user_id');

        $activities = Helper::getActivitiesForParticipant('people', $peoples->id);
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

        $notes = Helper::getNotesForParticipant('people', $peoples->id);
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

        // // Separate logged and scheduled activities
        // $logged_activities = $activities->filter(function ($activity) {
        //     return $activity->status === 'Logged';
        // });

        // $scheduled_activities = $activities->filter(function ($activity) {
        //     return $activity->status === 'Scheduled';
        // });

        // $timelineEntries = Helper::getTimelineForEntity('people', $peoples->id);
        // $timelineEntries->transform(function ($item) {
        //     $item->type = 'timeline';
        //     $item->timestamp = $item->created_at;

        //     return $item;
        // });

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
        $timelineEntries = Helper::getTimelineForEntity('people', $peoples->id);
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

        if ($peoples->created_at) {
            $createdAt = $peoples->created_at->copy();
            $now = now();

            // Calculate total months since creation
            $totalMonths = $createdAt->diffInMonths($now);

            // Generate milestones dynamically — only 1 month, 6 months, and yearly
            for ($i = 1; $i <= $totalMonths; $i++) {
                $milestoneDate = $createdAt->copy()->addMonths($i);

                // Only display for 1 month, 6 months, 1 year, 2 years, 3 years, etc.
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

        // $timeline = $logged_activities
        //     ->concat($notes)
        //     ->concat($timelineEntries)
        //     ->concat($milestones)
        //     ->sortByDesc('timestamp')
        //     ->values(); // reindex after sorting

        $timeline = $logged_activities
            ->concat($notes)
            ->concat($timelineEntries)
            ->concat($milestones)
            ->sortByDesc('timestamp')
            ->values(); // reindex after sorting

        // 👉 ADD THIS SECTION — Handle AJAX requests
        if ($request->ajax()) {
            $timeline_html = view('admin.peoples.partials.people-timeline', compact('timeline'))->render();

            return response()->json([
                'timeline_html' => $timeline_html,
            ]);
        }

        $related_leads = $peoples->leads()->with('products')->get();
        $relatedLeadsCount = Helper::calculateTotalValue($related_leads);
        $formattedLeadsCount = Helper::formatValue($relatedLeadsCount);

        $hotLeadsCount = $peoples->leads()->where('is_hot', 1)->count();
        $wonLeadsCount = $peoples->leads()->where('lead_status', 'won')->count();
        $lostLeadsCount = $peoples->leads()->where('lead_status', 'lost')->count();

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

        // Fetch related data
        $activity_types = ActivityType::all();
        $sources = Source::all();
        $competitors = Competitor::all();
        $users = User::all();
        $industries = Industry::all();
        $territories = Territory::all();
        $persontags = Tag::where('tag_id', 3)->get();
        $allpeoples = People::all();
        $products = Product::all();
        $companies = Company::all();

        $assignedCompanyIds = $peoples->companiesAlt->pluck('id'); // already linked company IDs
        $availableCompanies = Company::whereNotIn('id', $assignedCompanyIds)->get();

        // Fetch all leads with their relations
        $leads = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors',
        ])->get();

        $emailTypes = [
            'email' => 'Email',
            'personal_email' => 'Personal Email',
            'support_email' => 'Support Email',
        ];

        $emails = [];

        $emailRecord = $peoples->peopleEmail; // hasOne → single record
        if ($emailRecord) {
            foreach ($emailTypes as $field => $label) {
                if (! empty($emailRecord->$field)) {
                    $emails[] = [
                        'id' => $emailRecord->id,
                        'selected' => $field,   // which option should be selected
                        'value' => $emailRecord->$field,
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

        $addressRecord = $peoples->peopleAddress; // hasOne → single record
        if ($addressRecord) {
            foreach ($addressTypes as $field => $label) {
                if (! empty($addressRecord->$field)) {
                    $addresses[] = [
                        'id' => $addressRecord->id,
                        'selected' => $field,   // which option should be selected
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

        $phoneRecord = $peoples->peoplePhone; // hasOne → single record
        if ($phoneRecord) {
            foreach ($phoneTypes as $field => $label) {
                if (! empty($phoneRecord->$field)) {
                    $phones[] = [
                        'id' => $phoneRecord->id,
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

        $urlRecord = $peoples->peopleUrl; // hasOne → single record
        if ($urlRecord) {
            foreach ($urlTypes as $field => $label) {
                if (! empty($urlRecord->$field)) {
                    $urls[] = [
                        'id' => $urlRecord->id,
                        'selected' => $field, // which option should be selected
                        'value' => $urlRecord->$field,
                    ];
                }
            }
        }

        return view('admin.peoples.edit', compact(
            'peoples',
            'peopleFiles',
            'leads',
            'activities',
            'logged_activities',
            'scheduled_activities',
            'notes',
            'timelineEntries',
            'timeline',
            'persontags',
            'related_leads',
            'formattedLeadsCount',
            'hotLeadsCount',
            'wonLeadsCount',
            'lostLeadsCount',
            'pending_tasks',
            'completed_tasks',
            'activity_types',
            'sources',
            'competitors',
            'users',
            'industries',
            'territories',
            'availableCompanies',
            'allpeoples',
            'products',
            'companies',
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

    public function addCompany(Request $request, $peopleId)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        // Prevent duplicates
        $exists = PeopleCompany::where('people_id', $peopleId)
            ->where('company_id', $request->company_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This company is already linked to the person.',
            ], 422);
        }

        // Create new record
        PeopleCompany::create([
            'people_id' => $peopleId,
            'company_id' => $request->company_id,
        ]);

        // Timeline entry
        $personName = People::find($peopleId)->name;
        $companyName = Company::find($request->company_id)->name;

        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'people',
            'owner_id' => $peopleId,
            'action_type' => 'added_company',
            'description' => "added {$companyName} to {$personName}",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Company added to people successfully!',
        ]);
    }

    public function removeCompany(Request $request, $peopleId)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        // Find the pivot record
        $companyPeople = PeopleCompany::where('people_id', $peopleId)
            ->where('company_id', $request->company_id)
            ->first();

        if (! $companyPeople) {
            return response()->json([
                'status' => 'error',
                'message' => 'This company is not linked to the person.',
            ], 404);
        }

        // Delete the pivot record
        $companyPeople->delete();

        // Timeline entry
        $personName = People::find($peopleId)->name;
        $companyName = Company::find($request->company_id)->name;

        Timeline::create([
            'user_id' => auth()->id(),
            'owner_type' => 'people',
            'owner_id' => $peopleId,
            'action_type' => 'removed_company',
            'description' => "removed {$companyName} from {$personName}",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Company removed from person successfully!',
        ]);
    }

    public function addTag(Request $request, $peopleId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        // Prevent duplicates
        $exists = PeopleTag::where('people_id', $peopleId)
            ->where('tag_id', $request->tag_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This tag is already linked to the people.',
            ], 422);
        }

        // Create new record
        PeopleTag::create([
            'people_id' => $peopleId,
            'tag_id' => $request->tag_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tag added to people successfully!',
        ]);
    }

    public function removeTag(Request $request, $peopleId, $tagId)
    {
        // Find the pivot record
        $peopleTag = PeopleTag::where('people_id', $peopleId)
            ->where('tag_id', $tagId)
            ->first();

        if (! $peopleTag) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tag not found for this person.',
            ], 404);
        }

        $peopleTag->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tag removed from people successfully!',
        ]);
    }

    public function updatePeopleField(Request $request)
    {
        // Define config for each category
        $config = [
            'email' => [
                'model' => PeopleEmail::class,
                'valid_types' => ['email', 'personal_email', 'support_email'],
                'validation' => 'email',
            ],
            'address' => [
                'model' => PeopleAddress::class,
                'valid_types' => ['address', 'main_address', 'work_address', 'home_address', 'billing_address', 'mailing_address'],
                'validation' => 'string',
            ],
            'phone' => [
                'model' => PeoplePhone::class,
                'valid_types' => ['phone', 'home_phones', 'mobile_phones', 'work_phones', 'fax_phones'],
                'validation' => 'string',
            ],
            'url' => [
                'model' => PeopleUrl::class,
                'valid_types' => ['url', 'blog_url', 'twitter_url'],
                'validation' => 'url',
            ],
        ];

        $request->validate([
            'people_id' => 'required|exists:people,id',
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
        $record = $modelClass::firstOrNew(['people_id' => $request->people_id]);
        $record->{$request->type} = $request->value;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $record,
        ]);
    }

    public function updateDetail(Request $request, $peopleId)
    {
        $request->validate([
            'field' => 'required|string|in:name,bio',
            'value' => 'nullable|string',
        ]);

        $people = People::findOrFail($peopleId);
        $people->{$request->field} = $request->value;
        $people->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->field).' updated successfully!',
        ]);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Step 1: Create People record
            $people = People::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'bio' => $request->bio,
                'territory_id' => $request->territory_id,
            ]);

            // Step 2: Store Emails
            if ($request->email) {
                PeopleEmail::create([
                    'people_id' => $people->id,
                    'email' => $request->email,
                ]);
            }

            // Step 3: Store Phones
            if ($request->phone) {
                PeoplePhone::create([
                    'people_id' => $people->id,
                    'phone' => $request->phone,
                ]);
            }

            // Step 4: Store Addresses
            if ($request->address) {
                PeopleAddress::create([
                    'people_id' => $people->id,
                    'address' => $request->address,
                ]);
            }

            // Step 5: Store URLs
            if ($request->url) {
                PeopleUrl::create([
                    'people_id' => $people->id,
                    'url' => $request->url,
                ]);
            }

            // Step 6: Store Pivot (People Company)
            if ($request->company_id) {
                PeopleCompany::create([
                    'people_id' => $people->id,
                    'company_id' => $request->company_id,
                ]);
            }

            // Step 7: Store Tags
            if ($request->tag_id) {
                PeopleTag::create([
                    'people_id' => $people->id,
                    'tag_id' => $request->tag_id,
                ]);
            }

        });

        return redirect()->back()->with('success', 'Person created successfully!');
    }

    public function ajax_store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'code' => 'nullable|string|max:50',
        ]);

        // Step 1: Create Person
        $people = People::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'postalCode' => $validated['code'] ?? null,
            'user_id' => auth()->id(),
        ]);

        // Step 2: Store Email in people_emails table
        if (! empty($validated['email'])) {
            DB::table('people_emails')->insert([
                'people_id' => $people->id,
                'email' => $validated['email'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Person added successfully!',
            'people' => $people,
        ]);
    }

    public function deleteField(Request $request)
    {
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|string',
            'field_name' => 'required|string', // email, address, phone, url
        ]);

        // Map field_name to model and allowed types
        $models = [
            'email' => [PeopleEmail::class, ['email', 'personal_email', 'support_email']],
            'address' => [PeopleAddress::class, ['address', 'main_address', 'work_address', 'home_address', 'billing_address', 'mailing_address']],
            'phone' => [PeoplePhone::class, ['phone', 'home_phones', 'mobile_phones', 'work_phones', 'fax_phones']],
            'url' => [PeopleUrl::class, ['url', 'blog_url', 'twitter_url']],
        ];

        if (! isset($models[$request->field_name])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid field name'], 400);
        }

        [$modelClass, $allowedTypes] = $models[$request->field_name];

        if (! in_array($request->type, $allowedTypes)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid type'], 400);
        }

        $record = $modelClass::where('people_id', $request->people_id)->first();

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

    public function updateField(Request $request, People $people)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $allowed = ['territory_id', 'user_id'];

        if (! in_array($request->field, $allowed)) {
            return response()->json(['error' => 'Invalid field'], 422);
        }

        $people->update([
            $request->field => $request->value,
        ]);

        $peopleName = $people->name ?? 'Unknown Person';
        $newAssignee = User::find($request->value)->name ?? 'Unassigned';
        $description = null;
        $actionType = null;

        // Add timeline entries for key updates
        if ($request->field === 'user_id') {
            $description = "reassigned {$peopleName} to {$newAssignee}";
            $actionType = 'updated_assignee';
        }

        if ($description) {
            Timeline::create([
                'user_id' => auth()->id(),
                'owner_type' => 'people',
                'owner_id' => $people->id,
                'action_type' => $actionType,
                'description' => $description,
            ]);
        }

        return response()->json(['success' => true, 'field' => $request->field, 'value' => $request->value]);
    }

   
    public function fileUpload(Request $request, People $people)
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

            $path = $file->storeAs('people_files', $filename, 'public');

            $peopleFile = PeopleFile::create([
                'people_id' => $people->id,
                'user_id' => auth()->id(),
                'file_name' => $originalName,
                'file_path' => $path,
                'file_type' => $extension,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file' => $peopleFile,
            ]);
        } catch (\Throwable $e) {
            Log::error("People file upload failed for people ID {$people->id}: ".$e->getMessage());

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
            'people_id' => 'required|integer',
        ]);

        try {
            $file = PeopleFile::where('id', $request->file_id)
                ->where('people_id', $request->people_id)
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
            Log::error("File delete failed for people {$request->people_id}: ".$e->getMessage());

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
                'message' => 'No people selected for deletion.',
            ], 400);
        }

        try {
            People::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) > 1
                    ? 'Selected peoples deleted successfully.'
                    : 'People deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete people: '.$e->getMessage(),
            ], 500);
        }
    }
}
