<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CompanyEmail;
use App\Models\CompanyPeople;
use App\Models\CompanyPhone;
use App\Models\CompanyTag;
use App\Models\CompanyTask;
use App\Models\CompanyType;
use App\Models\CompanyUrl;
use App\Models\Competitor;
use App\Models\Industry;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Territory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $formattedTotalCompanies = number_format($totalCompanies / 1000, 1);
        $formattedMyCompanies = number_format($myCompaniesCount / 1000, 1);

        return compact('formattedTotalCompanies', 'formattedMyCompanies');
    }

    public function index(Request $request)
    {
        $query = $this->companyRepo->getAllWithRelations();

        // Apply filters here in Controller
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        if ($request->filled('company_type_id')) {
            $query->where('company_type_id', $request->company_type_id);
        }
        if ($request->filled('people_id')) {
            $query->whereHas('peoples', function ($q) use ($request) {
                $q->where('people_id', $request->people_id);
            });
        }


        $companies = $query->get();
        $companiesCount = $companies->count();

        $peoples = People::all();
        $company_types = CompanyType::all();
        $sidebarStats = $this->getSidebarStats();

        if ($request->ajax()) {
            return view('admin.company.partials.company-table-rows', compact('companies'))->render();
        }

        return view('admin.company.index', array_merge(
            compact('companies', 'peoples', 'company_types', 'companiesCount'),
            $sidebarStats
        ));
    }

    public function my_companies(Request $request, $id)
    {
        $query = $this->companyRepo->getByUserWithRelations($id);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        if ($request->filled('people_id')) {
            $query->whereHas('peoples', function ($q) use ($request) {
                $q->where('people.id', $request->people_id);
            });
        }
        if ($request->filled('company_type_id')) {
            $query->where('company_type_id', $request->company_type_id);
        }

        $companies = $query->get();
        $totalMyCompanies = $query->count();

        $peoples = People::all();
        $company_types = CompanyType::all();
        $sidebarStats = $this->getSidebarStats();

        if ($request->ajax()) {
            return view('admin.company.partials.company-table-rows', compact('companies'))->render();
        }

        return view('admin.company.my-companies', array_merge(
            compact('companies', 'peoples', 'company_types', 'totalMyCompanies'),
            $sidebarStats
        ));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

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

        return redirect()->back()->with('success', 'Company created successfully!');
    }

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
                'tag_id' => $request->tag_id,
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

    public function show($id)
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
            'companyAddress',
            'companyTask',
            'companyUrl',
            'peoples', // <-- fetch related people via pivot
        ])->findOrFail($id);

        $companies = Company::all();
        $pending_tasks = $company->companyTask->whereNull('completed_user_id');
        $completed_tasks = $company->companyTask->whereNotNull('completed_user_id');

        $users = User::all();
        $companytags = Tag::where('tag_id', 2)->get();
        $competitors = Competitor::all();
        $sources = Source::all();
        $company_types = CompanyType::all();
        $industries = Industry::all();
        $territories = Territory::all();
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
            'pending_tasks',
            'completed_tasks',
            'users',
            'company_types',
            'companytags',
            'activity_types',
            'competitors',
            'sources',
            'companies',
            'products',
            'peoples',
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

    public function activity_store(Request $request)
    {

        $data = [
            'title' => $request->title,
            'activity_type_id' => $request->activity_type_id,
            'date' => $request->date,
            'start_time' => Carbon::parse($request->start_time)->format('H:i:s'),
            'end_time' => Carbon::parse($request->end_time)->format('H:i:s'),
            'all_day' => $request->all_day ?? 0,
            'location' => $request->location,
            'agenda' => $request->agenda,
        ];

        $inserted = [];

        foreach ($request->participant_id as $participantId) {
            $newData = $data;
            $newData['participant_id'] = $participantId;
            $activity = Activity::create($newData);
            $inserted[] = $activity;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Activities added successfully.',
                'activities' => $inserted,
            ]);
        }

        return redirect()->back()->with('success', 'Activities added successfully.');
    }

    public function login_activity(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'activity_type' => 'required|exists:activity_types,id',
            'participant_id' => 'required',
        ]);

        Activity::create([
            'title' => $validated['title'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'activity_type_id' => $validated['activity_type'],
            'date' => Carbon::today(), // adds current date
            'participant_id' => $validated['participant_id'],
        ]);

        return redirect()->back()->with('success', 'Login Activity Added Successfully.');

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

        return response()->json(['success' => true, 'field' => $request->field, 'value' => $request->value]);
    }

    // public function deleteEmail(Request $request)
    // {
    //     $request->validate([
    //         'company_id' => 'required|exists:companies,id',
    //         'type' => 'required|in:email,personal_email,support_email,work_email'
    //     ]);

    //     $emailRecord = CompanyEmail::where('company_id', $request->company_id)->first();

    //     if (!$emailRecord) {
    //         return response()->json(['status' => 'error', 'message' => 'Email record not found'], 404);
    //     }

    //     // Clear the selected email type column
    //     $emailRecord->{$request->type} = null;
    //     $emailRecord->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' deleted successfully',
    //         'data' => $emailRecord
    //     ]);
    // }

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

    public function updateCompanyEmail(Request $request)
    {
        // Validate request
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type' => 'required|in:email,personal_email,support_email,work_email',
            'value' => 'required|email',
        ]);

        // Find the company_emails row for this person
        $emailRecord = CompanyEmail::where('company_id', $request->company_id)->first();

        if (! $emailRecord) {
            // If row doesn't exist, create new
            $emailRecord = new CompanyEmail;
            $emailRecord->company_id = $request->company_id;
        }

        // Update only the selected type column
        $emailRecord->{$request->type} = $request->value;
        $emailRecord->save();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $emailRecord,
        ]);
    }

    public function updateCompanyAddress(Request $request)
    {
        // Validate request
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type' => 'required|in:address,main_address,work_address,home_address,billing_address,mailing_address',
            'value' => 'required|string',
        ]);

        // Find the company_addresses row for this person
        $addressRecord = CompanyAddress::where('company_id', $request->company_id)->first();

        if (! $addressRecord) {
            // If row doesn't exist, create new
            $addressRecord = new CompanyAddress;
            $addressRecord->company_id = $request->company_id;
        }

        // Update only the selected type column
        $addressRecord->{$request->type} = $request->value;
        $addressRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $addressRecord,
        ]);
    }

    public function updateCompanyPhone(Request $request)
    {
        // Validate request
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type' => 'required|in:phone,home_phones,mobile_phones,work_phones,fax_phones',
            'value' => 'required|string',
        ]);

        // Find the company_phones row for this person
        $phoneRecord = CompanyPhone::where('company_id', $request->company_id)->first();

        if (! $phoneRecord) {
            // If row doesn't exist, create new
            $phoneRecord = new CompanyPhone;
            $phoneRecord->company_id = $request->company_id;
        }

        // Update only the selected type column
        $phoneRecord->{$request->type} = $request->value;
        $phoneRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $phoneRecord,
        ]);
    }

    public function updateCompanyUrl(Request $request)
    {
        // Validate request
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type' => 'required|in:url,blog_url,twitter_url',
            'value' => 'required|url',
        ]);

        // Find the company_urls row for this person
        $urlRecord = CompanyUrl::where('company_id', $request->company_id)->first();

        if (! $urlRecord) {
            // If row doesn't exist, create new
            $urlRecord = new CompanyUrl;
            $urlRecord->company_id = $request->company_id;
        }

        // Update only the selected type column
        $urlRecord->{$request->type} = $request->value;
        $urlRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)).' updated successfully',
            'data' => $urlRecord,
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

        // Create the task
        $task = CompanyTask::create([
            'company_id' => $companyId,
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

        $task = CompanyTask::findOrFail($taskId);
        $assignee = User::findOrFail($request->user_id);

        // Convert the due_date from "2025-09-24 6:30 PM" → "2025-09-24 18:30:00"
        $dueTime = Carbon::parse($request->due_date)->format('Y-m-d H:i:s');

        // Update the task
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
        $task = CompanyTask::findOrFail($taskId);

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
        $task = CompanyTask::findOrFail($taskId);

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
        $task = CompanyTask::find($task_id);

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
