<?php

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use App\Models\Industry;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\LeadController;
use App\Models\User;
use App\Models\people;
use App\Models\Company;
use App\Models\Source;
use App\Models\Product;
use App\Models\Competitor;
use App\Models\CompanyType;
use App\Models\Tag;
use App\Models\ActivityType;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $users = User::all();
        $industries = Industry::all();
        $peoples = People::all();
        $companies = Company::all();
        $sources = Source::all();
        $products = Product::all();
        $company_types = CompanyType::all();
        $competitors = Competitor::all();
        $leadtags = Tag::where('tag_id', 1)->get();
        $companytags = Tag::where('tag_id', 2)->get();
        $persontags = Tag::where('tag_id', 3)->get();

        $activity_types = ActivityType::all();

        return view('admin.dashboard', compact('users', 'company_types', 'industries', 'leadtags', 'companytags', 'persontags', 'activity_types', 'peoples', 'companies', 'sources', 'products', 'competitors'));
        // return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/sales/dashboard', function () {
        return view('sales.dashboard');
    })->name('sales.dashboard');

    Route::get('/technician/dashboard', function () {
        return view('technician.dashboard');
    })->name('technician.dashboard');

    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {

    // sales section
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');

    // companies section
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/company/my_companies/{id}', [CompanyController::class, 'my_companies'])->name('company.my_companies');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::post('/company/ajax', [CompanyController::class, 'ajax_store'])->name('company.ajax.store');
    Route::post('/companies/{company}/update-field', [CompanyController::class, 'updateField'])->name('company.update.field');
    Route::post('companies/delete-field', [CompanyController::class, 'deleteField'])->name('companies.delete-field');
    // Route::post('companies/delete-email', [CompanyController::class, 'deleteEmail'])->name('companies.delete-email');
    // Route::post('companies/delete-address', [CompanyController::class, 'deleteAddress'])->name('companies.delete-address');
    // Route::post('companies/delete-phone', [CompanyController::class, 'deletePhone'])->name('companies.delete-phone');
    // Route::post('companies/delete-url', [CompanyController::class, 'deleteUrl'])->name('companies.delete-url');
    Route::post('/update-company-email', [CompanyController::class, 'updateCompanyEmail'])->name('update.company.email');
    Route::post('/update-company-address', [CompanyController::class, 'updateCompanyAddress'])->name('update.company.address');
    Route::post('/update-company-phone', [CompanyController::class, 'updateCompanyPhone'])->name('update.company.phone');
    Route::post('/update-company-url', [CompanyController::class, 'updateCompanyUrl'])->name('update.company.url');

    // peoples section
    Route::post('/people/store', [PeopleController::class, 'store'])->name('people.store');
    Route::get('/people/delete/{people_id}', [PeopleController::class, 'delete'])->name('people.delete');
    Route::post('/people/ajax', [PeopleController::class, 'ajax_store'])->name('people.ajax.store');
    Route::get('/people/index', [PeopleController::class, 'index'])->name('peoples.index');
    Route::get('/people/my-peoples/{id}', [PeopleController::class, 'my_peoples'])->name('peoples.my_peoples');
    Route::get('/people/animal-care', [PeopleController::class, 'animal_care'])->name('peoples.animal_care');
    Route::get('/people/marketing-contacts', [PeopleController::class, 'marketing_contacts'])->name('peoples.marketing_contacts');
    Route::get('/people/sequence-healthcare', [PeopleController::class, 'sequence_healthcare'])->name('peoples.sequence_healthcare');
    Route::get('peoples/{people}', [PeopleController::class, 'show'])->name('peoples.show');
    Route::post('peoples/{people}/update-field', [PeopleController::class, 'updateField'])->name('people.update.field');
    Route::post('peoples/delete-field', [PeopleController::class, 'deleteField'])->name('peoples.delete-field');
    Route::post('/update-person-email', [PeopleController::class, 'updatePersonEmail'])->name('update.person.email');
    Route::post('/update-person-address', [PeopleController::class, 'updatePersonAddress'])->name('update.person.address');
    Route::post('/update-person-phone', [PeopleController::class, 'updatePersonPhone'])->name('update.person.phone');
    Route::post('/update-person-url', [PeopleController::class, 'updatePersonUrl'])->name('update.person.url');

    // tasks sections
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/ajax', [TaskController::class, 'ajax_store'])->name('task.ajax.store');

    // leads section
    Route::get('/leads/index', [LeadController::class, 'index'])->name('leads.index');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::post('/leads/ajax-update', [LeadController::class, 'ajax_update'])->name('leads.ajax_update');
    Route::get('/leads/my-leads/{id}', [LeadController::class, 'my_leads'])->name('leads.my_leads');
    Route::get('/leads/added-this-week', [LeadController::class, 'added_this_week'])->name('leads.added_this_week');
    Route::get('/leads/closing-this-week', [LeadController::class, 'closing_this_week'])->name('leads.closing_this_week');
    Route::get('/leads/open-leads', [LeadController::class, 'open_leads'])->name('leads.open_leads');
    Route::get('/leads/hot-leads', [LeadController::class, 'hot_leads'])->name('leads.hot_leads');
    Route::get('/leads/watching-leads', [LeadController::class, 'watching_leads'])->name('leads.watching_leads');
    Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('leads/delete-field', [LeadController::class, 'deleteField'])->name('leads.delete-field');
    Route::post('leads/update-field', [LeadController::class, 'updateField'])->name('leads.update-field');

    // settings section
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/activity_type', [SettingController::class, 'activity_type'])->name('settings.activity_type');
    Route::post('/settings/activity_type', [SettingController::class, 'activity_type_store'])->name('settings.activity_type.store');
    Route::get('/settings/competitor', [SettingController::class, 'competitor'])->name('settings.competitor');
    Route::post('/settings/competitor', [SettingController::class, 'competitor_store'])->name('settings.competitor.store');
    Route::get('/settings/industry', [SettingController::class, 'industry'])->name('settings.industry');
    Route::post('/settings/industry', [SettingController::class, 'industry_store'])->name('settings.industry.store');
    Route::get('/settings/channel_source', [SettingController::class, 'channel_source'])->name('settings.channel_source');
    Route::post('/settings/channel_source', [SettingController::class, 'source_store'])->name('settings.source.store');
    Route::get('/settings/company_type', [SettingController::class, 'company_type'])->name('settings.company_type');
    Route::post('/settings/company_type', [SettingController::class, 'company_type_store'])->name('settings.company_type.store');
    Route::get('/settings/market', [SettingController::class, 'market'])->name('settings.market');
    Route::post('/settings/market', [SettingController::class, 'market_store'])->name('settings.market.store');
    Route::get('/settings/tag', [SettingController::class, 'tag'])->name('settings.tag');
    Route::post('/settings/tag', [SettingController::class, 'tag_store'])->name('settings.tag.store');
    Route::get('/settings/product', [SettingController::class, 'product'])->name('settings.product');
    Route::post('/settings/product', [SettingController::class, 'product_store'])->name('settings.product.store');
    Route::get('/settings/territory', [SettingController::class, 'territory'])->name('settings.territory');
    Route::post('/settings/territory', [SettingController::class, 'territory_store'])->name('settings.territory.store');


    // activities section
    Route::post('/activity/store', [CompanyController::class, 'activity_store'])->name('activity.store');
    Route::post('/login_activity', [CompanyController::class, 'login_activity'])->name('login.activity');

    // Route::post('/people/ajax', [PeopleController::class, 'ajax_store'])->name('people.store');

});

Route::get('/states/{countryId}', [SettingController::class, 'getStatesByCountry'])->name('get.states');
Route::get('/cities/{stateId}', [SettingController::class, 'getCitiesByState'])->name('get.cities');
