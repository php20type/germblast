<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Territory;
use Illuminate\Http\Request;
use App\Models\People;
use App\Models\User;
use App\Models\ActivityType;
use App\Models\Source;
use App\Models\Competitor;
use App\Models\PeopleAddress;
use App\Models\PeopleEmail;
use App\Models\PeoplePhone;
use App\Models\PeopleCompany;
use App\Models\PeopleUrl;
use App\Models\Industry;
use App\Models\Product;
use App\Models\Company;
use App\Models\Lead;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PeopleController extends Controller
{
    // private function getSidebarStats()
    // {
    //     $user = auth()->user();

    //     $peoples = People::with('company', 'tag', 'user')->get();
    //     $myPeopleCount = $peoples->where('user_id', $user->id)->count(); // no need to query again
    //     $totalPeoples = $peoples->count();
    //     $formattedTotalPeoples = number_format($totalPeoples / 1000, 1);

    //     return compact('myPeopleCount', 'totalPeoples', 'formattedTotalPeoples');
    // }

    private function getSidebarStats()
    {
        $user = auth()->user();

        $peoples = People::with(['companies', 'tag', 'user'])->get();
        $myPeopleCount = $peoples->where('user_id', $user->id)->count();
        $totalPeoples = $peoples->count();
        $formattedTotalPeoples = number_format($totalPeoples / 1000, 1);

        return compact('myPeopleCount', 'totalPeoples', 'formattedTotalPeoples');
    }

    // public function index(Request $request)
    // {
    //     $user = auth()->user();
    //     $peoples = People::all();
    //     $query = People::with('company', 'tag', 'user');

    //     if ($request->ajax()) {
    //         // Search by lead name or people name
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by people id / assigneed to
    //         if ($request->filled('marketing_status')) {
    //             $query->where('marketing_status', $request->marketing_status);
    //         }
    //     }

    //     $peoples = $query->get();

    //     $getSidebarStats = $this->getSidebarStats();

    //     if ($request->ajax()) {
    //         return view('admin.peoples.partials.people-table-row', compact('peoples'))->render();
    //     }

    //     return view('admin.peoples.index', array_merge(
    //         compact('peoples', 'peoples'),
    //         $getSidebarStats
    //     ));
    // }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = People::with(['companies', 'tag', 'user']);

        // AJAX filters
        if ($request->ajax()) {

            // Search by people name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            // Filter by marketing_status
            if ($request->filled('marketing_status')) {
                $query->where('marketing_status', $request->marketing_status);
            }

            // Optionally filter by assigned user
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        }

        // Get filtered people
        $peoples = $query->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.peoples.partials.people-table-row', compact('peoples'))->render();
        }

        // Normal page load
        return view('admin.peoples.index', array_merge(
            compact('peoples'),
            $sidebarStats
        ));
    }

    // public function my_peoples(Request $request, $id)
    // {
    //     $user = auth()->user();
    //     $users = User::all();
    //     $query = People::with('company', 'tag', 'user')
    //         ->where('user_id', $id);

    //     if ($request->ajax()) {
    //         // Search by lead name or people name
    //         if ($request->filled('search')) {
    //             $search = $request->search;
    //             $query->where('name', 'like', "%$search%");
    //         }

    //         // Filter by people id / assigneed to
    //         if ($request->filled('marketing_status')) {
    //             $query->where('marketing_status', $request->marketing_status);
    //         }
    //     }

    //     $peoples = $query->get();

    //     $getSidebarStats = $this->getSidebarStats();

    //     if ($request->ajax()) {
    //         return view('admin.peoples.partials.people-table-row', compact('peoples'))->render();
    //     }

    //     return view('admin.peoples.my-peoples', array_merge(
    //         compact('users', 'peoples'),
    //         $getSidebarStats
    //     ));
    // }



    public function my_peoples(Request $request, $id)
    {
        $user = auth()->user();
        $users = User::all();

        // Base query: people assigned to the given user
        $query = People::with(['companies', 'tag', 'user'])
            ->where('user_id', $id);

        // AJAX filters
        if ($request->ajax()) {

            // Search by people name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            // Filter by marketing_status
            if ($request->filled('marketing_status')) {
                $query->where('marketing_status', $request->marketing_status);
            }
        }

        // Get filtered people
        $peoples = $query->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        // Return partial for AJAX
        if ($request->ajax()) {
            return view('admin.peoples.partials.people-table-row', compact('peoples'))->render();
        }

        // Normal page load
        return view('admin.peoples.my-peoples', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }

    // public function animal_care()
    // {
    //     $user = auth()->user();
    //     $users = User::all();
    //     $peoples = People::with('company', 'tag', 'user')
    //         ->where('user_id', auth()->id())
    //         ->get();

    //     $getSidebarStats = $this->getSidebarStats();


    //     return view('admin.peoples.animal-care', array_merge(
    //         compact('users', 'peoples'),
    //         $getSidebarStats
    //     ));

    // }

    public function animal_care()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tag', 'user'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.animal-care', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }


    // public function marketing_contacts()
    // {
    //     $user = auth()->user();
    //     $users = User::all();
    //     $peoples = People::with('company', 'tag', 'user')
    //         ->where('user_id', auth()->id())
    //         ->get();

    //     $getSidebarStats = $this->getSidebarStats();


    //     return view('admin.peoples.marketing-contacts', array_merge(
    //         compact('users', 'peoples'),
    //         $getSidebarStats
    //     ));

    // }

    public function marketing_contacts()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tag', 'user'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.marketing-contacts', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }

    // public function sequence_healthcare()
    // {
    //     $user = auth()->user();
    //     $users = User::all();
    //     $peoples = People::with('company', 'tag', 'user')
    //         ->where('user_id', auth()->id())
    //         ->get();

    //     $getSidebarStats = $this->getSidebarStats();


    //     return view('admin.peoples.sequence-healthcare', array_merge(
    //         compact('users', 'peoples'),
    //         $getSidebarStats
    //     ));
    // }

    public function sequence_healthcare()
    {
        $user = auth()->user();
        $users = User::all();

        // Fetch people assigned to current user with updated relationships
        $peoples = People::with(['companies', 'tag', 'user'])
            ->where('user_id', $user->id)
            ->get();

        // Sidebar stats
        $sidebarStats = $this->getSidebarStats();

        return view('admin.peoples.sequence-healthcare', array_merge(
            compact('users', 'peoples'),
            $sidebarStats
        ));
    }


    // public function show($id)
    // {
    //     $peoples = People::with('company', 'user')->findOrFail($id);

    //     $activity_types = ActivityType::all(); // fetch all activities
    //     $sources = Source::all();
    //     $competitors = Competitor::all();
    //     $users = User::all();
    //     $industries = Industry::all();
    //     $persontags = Tag::where('tag_id', 3)->get();
    //     $allpeoples = People::all();
    //     $products = Product::all();
    //     $companies = Company::all();
    //     $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();

    //     return view('admin.peoples.edit', compact('peoples', 'leads', 'persontags', 'activity_types', 'sources', 'competitors', 'users', 'industries', 'allpeoples', 'products', 'companies'));
    // }

    public function show($id)
    {
        // Fetch a single person with ALL its relations
        $peoples = People::with([
            'companies',
            'tag',
            'user',
            'country',
            'state',
            'city',
            'territory',
            'peopleEmail',
            'peopleAddress',
            'peoplePhone',
            'peopleUrl',
            'peopleTask',
            'peopleCompany',
            'companiesAlt',
            'activities',
            'leadPeople',
            'leads',
            'companyPeople',
            'companies'
        ])->findOrFail($id);

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

        // Fetch all leads with their relations
        $leads = Lead::with([
            'assignee',
            'companies',
            'products',
            'peoples',
            'sources',
            'competitors'
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
                if (!empty($emailRecord->$field)) {
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
                if (!empty($addressRecord->$field)) {
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
                if (!empty($phoneRecord->$field)) {
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
                if (!empty($urlRecord->$field)) {
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
            'leads',
            'persontags',
            'activity_types',
            'sources',
            'competitors',
            'users',
            'industries',
            'territories',
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

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'company_id' => 'required|exists:companies,id',
    //         'name' => 'required|string|max:255',
    //         'phone' => 'nullable|string',
    //         'email' => 'nullable|email',
    //         'job_title' => 'nullable|string',
    //         'description' => 'nullable|string',
    //     ]);

    //     // $people = People::create(
    //     //     $validated
    //     // );
    //     $people = People::create(array_merge($validated, [
    //         'user_id' => auth()->id()
    //     ]));


    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'People added successfully.',
    //             'people' => $people
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'People added successfully.');

    // }

    // public function ajax_store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'phone' => 'required|string',
    //         'code' => 'required|string',
    //         // 'bio' => 'nullable|string',
    //         // 'tag_id' => 'required',
    //         // 'territory_id' => 'required',
    //         // 'company_id' => 'required',
    //     ]);

    //     $data = [
    //         'user_id' => $validated['user_id'],
    //         'name' => $validated['name'],
    //         'email' => $validated['email'] ?? null,
    //         'phone' => $validated['phone'] ?? null,
    //         // 'company_id' => $validated['company_id'],
    //         // 'tag_id' => $validated['tag_id'],
    //         // 'territory_id' => $validated['territory_id'],
    //     ];

    //     // Conditionally add bio and url and address if they exist
    //     // doing this as are submitting add person inline form through this function as well
    //     if (!empty($validated['bio'])) {
    //         $data['bio'] = $validated['bio'];
    //     }

    //     if (!empty($validated['url'])) {
    //         $data['url'] = $validated['url'];
    //     }

    //     if (!empty($validated['address'])) {
    //         $data['address'] = $validated['address'];
    //     }

    //     $people = People::create($data);

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'People added successfully.',
    //             'people' => $people
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'People added successfully.');
    // }


    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Step 1: Create People record
            $people = People::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'bio' => $request->bio,
                'territory_id' => $request->territory_id,
                'tag_id' => $request->tag_id,
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
        if (!empty($validated['email'])) {
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

    public function delete(Request $request)
    {
        People::where('id', $request->people_id)->delete();
        return redirect()->back();
    }

    public function deleteField(Request $request)
    {
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|string',
            'field_name' => 'required|string' // email, address, phone, url
        ]);

        // Map field_name to model and allowed types
        $models = [
            'email' => [PeopleEmail::class, ['email', 'personal_email', 'support_email']],
            'address' => [PeopleAddress::class, ['address', 'main_address', 'work_address', 'home_address', 'billing_address', 'mailing_address']],
            'phone' => [PeoplePhone::class, ['phone', 'home_phones', 'mobile_phones', 'work_phones', 'fax_phones']],
            'url' => [PeopleUrl::class, ['url', 'blog_url', 'twitter_url']],
        ];

        if (!isset($models[$request->field_name])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid field name'], 400);
        }

        [$modelClass, $allowedTypes] = $models[$request->field_name];

        if (!in_array($request->type, $allowedTypes)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid type'], 400);
        }

        $record = $modelClass::where('people_id', $request->people_id)->first();

        if (!$record) {
            return response()->json(['status' => 'error', 'message' => ucfirst($request->field_name) . ' record not found'], 404);
        }

        $record->{$request->type} = null;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' deleted successfully',
            'data' => $record
        ]);
    }

     public function updateField(Request $request, Company $company)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $allowed = ['territory_id', 'user_id'];

        if (!in_array($request->field, $allowed)) {
            return response()->json(['error' => 'Invalid field'], 422);
        }

        $company->update([
            $request->field => $request->value
        ]);

        return response()->json(['success' => true, 'field' => $request->field, 'value' => $request->value]);
    }

    public function updatePersonEmail(Request $request)
    {
        // Validate request
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|in:email,personal_email,support_email,work_email',
            'value' => 'required|email'
        ]);

        // Find the people_emails row for this person
        $emailRecord = PeopleEmail::where('people_id', $request->people_id)->first();

        if (!$emailRecord) {
            // If row doesn't exist, create new
            $emailRecord = new PeopleEmail();
            $emailRecord->people_id = $request->people_id;
        }

        // Update only the selected type column
        $emailRecord->{$request->type} = $request->value;
        $emailRecord->save();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' updated successfully',
            'data' => $emailRecord
        ]);
    }

    public function updatePersonAddress(Request $request)
    {
        // Validate request
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|in:address,main_address,work_address,home_address,billing_address,mailing_address',
            'value' => 'required|string'
        ]);

        // Find the people_addresses row for this person
        $addressRecord = PeopleAddress::where('people_id', $request->people_id)->first();

        if (!$addressRecord) {
            // If row doesn't exist, create new
            $addressRecord = new PeopleAddress();
            $addressRecord->people_id = $request->people_id;
        }

        // Update only the selected type column
        $addressRecord->{$request->type} = $request->value;
        $addressRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' updated successfully',
            'data' => $addressRecord
        ]);
    }

    public function updatePersonPhone(Request $request)
    {
        // Validate request
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|in:phone,home_phones,mobile_phones,work_phones,fax_phones',
            'value' => 'required|string'
        ]);

        // Find the people_phones row for this person
        $phoneRecord = PeoplePhone::where('people_id', $request->people_id)->first();

        if (!$phoneRecord) {
            // If row doesn't exist, create new
            $phoneRecord = new PeoplePhone();
            $phoneRecord->people_id = $request->people_id;
        }

        // Update only the selected type column
        $phoneRecord->{$request->type} = $request->value;
        $phoneRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' updated successfully',
            'data' => $phoneRecord
        ]);
    }


    public function updatePersonUrl(Request $request)
    {
        // Validate request
        $request->validate([
            'people_id' => 'required|exists:people,id',
            'type' => 'required|in:url,blog_url,twitter_url',
            'value' => 'required|url'
        ]);

        // Find the people_urls row for this person
        $urlRecord = PeopleUrl::where('people_id', $request->people_id)->first();

        if (!$urlRecord) {
            // If row doesn't exist, create new
            $urlRecord = new PeopleUrl();
            $urlRecord->people_id = $request->people_id;
        }

        // Update only the selected type column
        $urlRecord->{$request->type} = $request->value;
        $urlRecord->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' updated successfully',
            'data' => $urlRecord
        ]);
    }



}
