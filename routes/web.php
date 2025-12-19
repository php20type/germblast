<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\IcimatrixController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\LeadStageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyProposalController;
use App\Models\ActivityType;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Competitor;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Territory;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
        $leads = Lead::all();
        $sources = Source::all();
        $products = Product::all();
        $company_types = CompanyType::all();
        $territories = Territory::all();
        $competitors = Competitor::all();
        $leadtags = Tag::where('tag_id', 1)->get();
        $companytags = Tag::where('tag_id', 2)->get();
        $persontags = Tag::where('tag_id', 3)->get();

        $activity_types = ActivityType::all();

        return view('admin.dashboard', compact('users', 'company_types', 'leads', 'industries', 'leadtags', 'companytags', 'persontags', 'activity_types', 'peoples', 'companies', 'sources', 'territories', 'products', 'competitors'));
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

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // sales section
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/schedule/meeting', [SaleController::class, 'schedule_meeting'])->name('sales.schedule.meeting');
    Route::post('/store/meeting', [SaleController::class, 'store_meeting'])->name('sales.store.meeting');
    Route::get('meeting/{id}', [SaleController::class, 'show_meeting'])->name('sales.meetings.show');
    Route::post('meeting/{meeting}/update', [SaleController::class, 'update_meeting'])->name('sales.meetings.update');
    Route::post('meetings/delete', [SaleController::class, 'delete_meetings'])->name('sales.meetings.delete');
    Route::post('meeting/{id}/complete', [SaleController::class, 'complete_meeting'])->name('sales.meeting.complete');

    // Company Section
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/company/my_companies/{id}', [CompanyController::class, 'my_companies'])->name('company.my_companies');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::post('/companies/delete', [CompanyController::class, 'delete'])->name('companies.delete');

    // Company - Task Section
    Route::post('/companies/{company}/tasks', [CompanyController::class, 'addTask'])->name('companies.tasks.store');
    Route::put('companies/tasks/{task}/update', [CompanyController::class, 'updateTask'])->name('companies.tasks.update');
    Route::post('companies/tasks/{task}/complete', [CompanyController::class, 'markCompleted'])->name('companies.tasks.complete');
    Route::post('companies/tasks/{task}/reopen', [CompanyController::class, 'reopenTask'])->name('companies.tasks.reopen');
    Route::post('/companies/tasks/delete/{task_id}', [CompanyController::class, 'deleteTask'])->name('companies.task.delete');

    // Company - Detail Section
    Route::get('companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::get('companies/{id}/timeline', [CompanyController::class, 'show'])->name('companies.timeline');
    Route::post('/company/ajax', [CompanyController::class, 'ajax_store'])->name('company.ajax.store');
    Route::post('companies/{company}/update-detail', [CompanyController::class, 'updateDetail'])->name('companies.updateDetail');
    Route::post('companies/{company}/people/add', [CompanyController::class, 'addPeople'])->name('companies.people.add');
    Route::post('companies/{company}/remove-person', [CompanyController::class, 'removePerson'])->name('companies.people.remove');
    Route::post('companies/{company}/tags/add', [CompanyController::class, 'addTag'])->name('companies.tags.add');
    Route::post('companies/{company}/tags/{tag}/remove', [CompanyController::class, 'removeTag'])->name('companies.tags.remove');
    Route::post('/companies/{company}/update-field', [CompanyController::class, 'updateField'])->name('company.update.field');
    Route::post('companies/delete-field', [CompanyController::class, 'deleteField'])->name('companies.delete-field');
    Route::post('/update-company-field', [CompanyController::class, 'updateCompanyField'])->name('update.company.field');
    Route::post('/companies/{company}/files/upload', [CompanyController::class, 'fileUpload'])->name('companies.files.upload');
    Route::post('/companies/files/delete', [CompanyController::class, 'fileDelete'])->name('companies.files.delete');

    // People Section
    Route::get('/people/index', [PeopleController::class, 'index'])->name('peoples.index');
    Route::get('/people/my-peoples/{id}', [PeopleController::class, 'my_peoples'])->name('peoples.my_peoples');
    Route::post('/people/store', [PeopleController::class, 'store'])->name('people.store');
    Route::post('/people/delete', [PeopleController::class, 'delete'])->name('people.delete');
    Route::get('peoples/{people}', [PeopleController::class, 'show'])->name('peoples.show');
    Route::get('peoples/{id}/timeline', [PeopleController::class, 'show'])->name('peoples.timeline');

    // People - Task Section
    Route::post('/people/{people}/tasks', [PeopleController::class, 'addTask'])->name('people.tasks.store');
    Route::put('people/tasks/{task}/update', [PeopleController::class, 'updateTask'])->name('people.tasks.update');
    Route::post('people/tasks/{task}/complete', [PeopleController::class, 'markCompleted'])->name('people.tasks.complete');
    Route::post('people/tasks/{task}/reopen', [PeopleController::class, 'reopenTask'])->name('people.tasks.reopen');
    Route::post('people/tasks/delete/{task_id}', [PeopleController::class, 'deleteTask'])->name('people.task.delete');

    // People - Detail Section
    Route::post('/people/ajax', [PeopleController::class, 'ajax_store'])->name('people.ajax.store');
    Route::post('people/{people}/update-detail', [PeopleController::class, 'updateDetail'])->name('people.updateDetail');
    Route::post('people/{people}/company/add', [PeopleController::class, 'addCompany'])->name('people.companies.add');
    Route::post('people/{people}/remove-company', [PeopleController::class, 'removeCompany'])->name('people.company.remove');
    Route::post('people/{people}/tags/add', [PeopleController::class, 'addTag'])->name('people.tags.add');
    Route::post('people/{people}/tags/{tag}/remove', [PeopleController::class, 'removeTag'])->name('people.tags.remove');

    Route::get('/people/animal-care', [PeopleController::class, 'animal_care'])->name('peoples.animal_care');
    Route::get('/people/marketing-contacts', [PeopleController::class, 'marketing_contacts'])->name('peoples.marketing_contacts');
    Route::get('/people/sequence-healthcare', [PeopleController::class, 'sequence_healthcare'])->name('peoples.sequence_healthcare');
    Route::post('peoples/{people}/update-field', [PeopleController::class, 'updateField'])->name('people.update.field');
    Route::post('peoples/delete-field', [PeopleController::class, 'deleteField'])->name('peoples.delete-field');
    Route::post('/update-people-field', [PeopleController::class, 'updatePeopleField'])->name('update.people.field');
    Route::post('/peoples/{people}/files/upload', [PeopleController::class, 'fileUpload'])->name('people.files.upload');
    Route::post('/peoples/files/delete', [PeopleController::class, 'fileDelete'])->name('people.files.delete');

    // Task Section
    Route::post('/tasks/ajax', [TaskController::class, 'ajax_store'])->name('task.ajax.store');

    // Lead Section
    Route::get('/leads/index', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/hot-leads', [LeadController::class, 'hot_leads'])->name('leads.hot_leads');
    Route::get('/leads/added-this-week', [LeadController::class, 'added_this_week'])->name('leads.added_this_week');
    Route::get('/leads/closing-this-week', [LeadController::class, 'closing_this_week'])->name('leads.closing_this_week');
    Route::get('/leads/my-leads/{id}', [LeadController::class, 'my_leads'])->name('leads.my_leads');
    Route::get('/leads/open-leads/{id}', [LeadController::class, 'open_leads'])->name('leads.open_leads');
    Route::get('/leads/watching-leads/{id}', [LeadController::class, 'watching_leads'])->name('leads.watching_leads');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store');
    Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('leads/{id}/timeline', [LeadController::class, 'show'])->name('leads.timeline');
    Route::post('/leads/delete', [LeadController::class, 'delete'])->name('leads.delete');

    // Lead - Task Section
    Route::post('/leads/{lead}/tasks', [LeadController::class, 'addTask'])->name('leads.tasks.store');
    Route::put('leads/tasks/{task}/update', [LeadController::class, 'updateTask'])->name('leads.tasks.update');
    Route::post('leads/tasks/{task}/complete', [LeadController::class, 'markCompleted'])->name('leads.tasks.complete');
    Route::post('leads/tasks/{task}/reopen', [LeadController::class, 'reopenTask'])->name('leads.tasks.reopen');
    Route::post('leads/tasks/delete/{task_id}', [LeadController::class, 'deleteTask'])->name('leads.task.delete');

    // Lead - Detail Section
    Route::post('/leads/ajax-update', [LeadController::class, 'ajax_update'])->name('leads.ajax_update');
    Route::post('leads/forecasting/store', [LeadController::class, 'storeForecasting'])->name('leads.forecasting.store');
    Route::post('/leads/check-stage-condition/{id}', [LeadController::class, 'checkStageCondition'])->name('leads.check.stage.condition');
    Route::post('/leads/change-stage/{id}', [LeadController::class, 'changeStage'])->name('leads.change.stage');
    Route::post('leads/{lead}/update-detail', [LeadController::class, 'updateDetail'])->name('lead.updateDetail');
    Route::post('leads/{lead}/tags/add', [LeadController::class, 'addTag'])->name('leads.tags.add');
    Route::post('leads/{lead}/tags/{tag}/remove', [LeadController::class, 'removeTag'])->name('leads.tags.remove');
    Route::post('/leads/{lead}/files/upload', [LeadController::class, 'fileUpload'])->name('leads.files.upload');
    Route::post('/leads/files/delete', [LeadController::class, 'fileDelete'])->name('leads.files.delete');

    Route::post('leads/delete-field', [LeadController::class, 'deleteField'])->name('leads.delete-field');
    Route::post('leads/update-field', [LeadController::class, 'updateField'])->name('leads.update-field');
    Route::post('/leads/add-product', [LeadController::class, 'addProduct'])->name('leads.add-product');

    // Lead Stage Process
    Route::post('/lead/{lead}/initial-meeting/schedule', [LeadStageController::class, 'scheduleInitialMeeting'])->name('lead.initial.schedule');
    Route::post('/lead/{lead}/initial-meeting/complete', [LeadStageController::class, 'completeInitialMeeting'])->name('lead.initial.complete');
    Route::post('/lead/{lead}/initial-meeting/reopen', [LeadStageController::class, 'reopenInitialMeeting'])->name('lead.initial.reopen');
    Route::post('/leads/{lead}/initial-meeting/reset', [LeadStageController::class, 'resetInitialMeeting'])->name('lead.initial.reset');

    Route::post('/lead/{lead}/site-survey/schedule', [LeadStageController::class, 'scheduleSiteSurvey'])->name('lead.site_survey.schedule');
    Route::post('/lead/{lead}/site-survey/complete', [LeadStageController::class, 'completeSiteSurvey'])->name('lead.site_survey.complete');
    Route::post('/lead/{lead}/site-survey/reopen', [LeadStageController::class, 'reopenSiteSurvey'])->name('lead.site_survey.reopen');
    Route::post('/lead/{lead}/site-survey/reset', [LeadStageController::class, 'resetSiteSurvey'])->name('lead.site_survey.reset');

    // Lead - Survey Proposal Section
    Route::get('/leads/{lead}/survey/proposal', [SurveyProposalController::class, 'survey_proposal'])->name('leads.survey.proposal');
    Route::post('/leads/{lead}/survey/proposal/store', [SurveyProposalController::class, 'survey_proposal_store'])
        ->name('leads.survey.proposal.store');

    Route::get('/survey/proposal/{survey_proposal}/facility', [SurveyProposalController::class, 'survey_facility'])
        ->name('survey.proposal.facility');
    Route::post('/survey/proposal/{survey_proposal}/facility/store', [SurveyProposalController::class, 'survey_facility_store'])
        ->name('survey.proposal.facility.store');
    Route::get('/survey/proposal/facility/{facility}/edit', [SurveyProposalController::class, 'survey_facility_edit'])
        ->name('survey.facility.edit');
    Route::post('/survey/proposal/{facility}/facility/update', [SurveyProposalController::class, 'survey_facility_update'])
        ->name('survey.proposal.facility.update');

    Route::get('/survey/proposal/{survey_proposal}/equipment', [SurveyProposalController::class, 'survey_equipment'])
        ->name('survey.proposal.equipment');
    Route::post('/survey/proposal/{survey_proposal}/equipment/store', [SurveyProposalController::class, 'survey_equipment_store'])
        ->name('survey.proposal.equipment.store');
    Route::get('/survey/proposal/equipment/{equipment}/edit', [SurveyProposalController::class, 'survey_equipment_edit'])
        ->name('survey.equipment.edit');
    Route::post('/survey/proposal/{equipment}/equipment/update', [SurveyProposalController::class, 'survey_equipment_update'])
        ->name('survey.proposal.equipment.update');

    Route::get('/survey/proposal/{survey_proposal}/pricing', [SurveyProposalController::class, 'pricing_proposal'])
        ->name('survey.proposal.pricing.proposal');
    Route::get('/survey/proposal/pricing/{pricing}/edit', [SurveyProposalController::class, 'pricing_proposal_edit'])
        ->name('pricing_proposal.edit');
    Route::post('/pricing-proposal/store', [SurveyProposalController::class, 'pricing_store'])->name('pricing_proposal.store');

    Route::post('/pricing-proposal/update', [SurveyProposalController::class, 'updateExistingPricing'])->name('pricing-proposal.update');
    Route::post('/pricing-proposal/delete', [SurveyProposalController::class, 'deletePricing'])->name('pricing-proposal.delete');

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
    Route::post('/settings/product', action: [SettingController::class, 'product_store'])->name('settings.product.store');
    Route::get('/settings/territory', [SettingController::class, 'territory'])->name('settings.territory');
    Route::post('/settings/territory', [SettingController::class, 'territory_store'])->name('settings.territory.store');

    // activities section
    Route::post('/schedule_activity', [ActivityController::class, 'schedule_activity'])->name('schedule.activity');
    Route::post('/login_activity', [ActivityController::class, 'login_activity'])->name('login.activity');
    Route::post('/log_activity/{id}', [ActivityController::class, 'log_activity'])->name('log.activity');
    Route::post('/delete_activity/{id}', [ActivityController::class, 'delete_activity'])->name('delete.activity');
    Route::post('activity/add_comment/{id}', [ActivityController::class, 'add_comment'])->name('add.activity.comment');
    Route::post('activity/delete_comment/{id}', [ActivityController::class, 'delete_comment'])->name('delete.activity.comment');
    Route::post('/add_note', [NoteController::class, 'add_note'])->name('add.note');
    Route::post('/delete_note/{id}', [NoteController::class, 'delete_note'])->name('delete.note');
    Route::post('note/add_comment/{id}', [NoteController::class, 'add_comment'])->name('add.note.comment');
    Route::post('note/delete_comment/{id}', [NoteController::class, 'delete_comment'])->name('delete.note.comment');

    // ICIMatrix sections
    Route::get('/icimatrix', [IcimatrixController::class, 'index'])->name('icimatrix.index');

    Route::get('/survey/proposal/view/{id}', [SurveyProposalController::class, 'survey_view'])->name('survey.proposal.view');
    Route::get('/survey/proposal/download/{id}', [SurveyProposalController::class, 'survey_download'])->name('survey.proposal.download');
});

Route::get('/states/{countryId}', [SettingController::class, 'getStatesByCountry'])->name('get.states');
Route::get('/cities/{stateId}', [SettingController::class, 'getCitiesByState'])->name('get.cities');
Route::get('/approval/approve/{token}', [ApprovalController::class, 'approve'])->name('approval.approve');
Route::get('/approval/reject/{token}', [ApprovalController::class, 'reject'])->name('approval.reject');
Route::view('survey-proposal.pdf', 'survey-proposal.pdf')->name('survey.proposal');
