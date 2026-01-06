<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyTaskController;
use App\Http\Controllers\Admin\IcimatrixController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\LeadTaskController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\PeopleTaskController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\LeadStageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyProposalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    //     ->name('admin.dashboard');

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

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/schedule/meeting', [SaleController::class, 'schedule_meeting'])->name('sales.schedule.meeting');
    Route::post('/store/meeting', [SaleController::class, 'store_meeting'])->name('sales.store.meeting');
    Route::get('meeting/{id}', [SaleController::class, 'show_meeting'])->name('sales.meetings.show');
    Route::post('meeting/{meeting}/update', [SaleController::class, 'update_meeting'])->name('sales.meetings.update');
    Route::post('meetings/delete', [SaleController::class, 'delete_meetings'])->name('sales.meetings.delete');
    Route::post('meeting/{id}/complete', [SaleController::class, 'complete_meeting'])->name('sales.meeting.complete');

    // ========================
    // COMPANY ROUTES
    // ========================
    Route::prefix('company')->name('company.')->group(function () {

        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('my_companies/{id}', [CompanyController::class, 'my_companies'])->name('my_companies');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::post('delete', [CompanyController::class, 'delete'])->name('delete');
        Route::post('ajax', [CompanyController::class, 'ajax_store'])->name('ajax.store');

        // Task Section
        Route::post('{company}/tasks', [CompanyTaskController::class, 'addTask'])->name('tasks.store');
        Route::put('tasks/{task}/update', [CompanyTaskController::class, 'updateTask'])->name('tasks.update');
        Route::post('tasks/{task}/complete', [CompanyTaskController::class, 'markCompleted'])->name('tasks.complete');
        Route::post('tasks/{task}/reopen', [CompanyTaskController::class, 'reopenTask'])->name('tasks.reopen');
        Route::post('tasks/delete/{task_id}', [CompanyTaskController::class, 'deleteTask'])->name('task.delete');

        // Detail Section
        Route::get('{company}', [CompanyController::class, 'show'])->name('show');
        Route::post('{company}/location/add', [CompanyController::class, 'addLocation'])->name('location.add');
        Route::get('{id}/timeline', [CompanyController::class, 'show'])->name('timeline');
        Route::post('{company}/update-detail', [CompanyController::class, 'updateDetail'])->name('updateDetail');
        Route::post('{company}/people/add', [CompanyController::class, 'addPeople'])->name('people.add');
        Route::post('{company}/remove-person', [CompanyController::class, 'removePerson'])->name('people.remove');
        Route::post('{company}/tags/add', [CompanyController::class, 'addTag'])->name('tags.add');
        Route::post('{company}/tags/{tag}/remove', [CompanyController::class, 'removeTag'])->name('tags.remove');
        Route::post('{company}/update-field', [CompanyController::class, 'updateField'])->name('company.update.field');
        Route::post('delete-field', [CompanyController::class, 'deleteField'])->name('delete-field');
        Route::post('{company}/files/upload', [CompanyController::class, 'fileUpload'])->name('files.upload');
        Route::post('files/delete', [CompanyController::class, 'fileDelete'])->name('files.delete');

        // Company Dashboard Section
        Route::get('{company}/dashboard', [CompanyDashboardController::class, 'company_dashboard'])->name('dashboard');
        Route::post('{company}/iaq-zones', [CompanyDashboardController::class, 'storeIAQZone'])->name('iaq-zones.store');
        Route::get('{company}/iaq-zones/{zoneId}/edit', [CompanyDashboardController::class, 'editIAQZone'])->name('iaq-zones.edit');
        Route::post('{company}/iaq-zones/{zoneId}/update', [CompanyDashboardController::class, 'updateIAQZone'])->name('iaq-zones.update');
        Route::post('{company}/iaq-devices', [CompanyDashboardController::class, 'storeIAQDevice'])->name('iaq-devices.store');
        Route::get('{company}/iaq-devices/{deviceId}/edit', [CompanyDashboardController::class, 'editIAQDevice'])->name('iaq-devices.edit');
        Route::post('{company}/iaq-devices/{deviceId}/update', [CompanyDashboardController::class, 'updateIAQDevice'])->name('iaq-devices.update');
        Route::get('{company}/biological-response', [CompanyDashboardController::class, 'biological_response'])->name('biological.response');
        Route::post('{company}/biological-response/store', [CompanyDashboardController::class, 'biological_response_store'])->name('biological.response.store');
        Route::get('{company}/biological-response/{intakeId}/edit', [CompanyDashboardController::class, 'biological_response_edit'])->name('biological.response.edit');
        Route::post('{company}/biological-response/{intakeId}/update', [CompanyDashboardController::class, 'biological_response_update'])->name('biological.response.update');
        Route::get('{company}/biological-readiness', [CompanyDashboardController::class, 'biological_readiness'])->name('biological.readiness');
        Route::post('{company}/biological-readiness/store', [CompanyDashboardController::class, 'biological_readiness_store'])->name('biological.readiness.store');
        Route::get('{company}/biological-readiness/{readinessId}/edit', [CompanyDashboardController::class, 'biological_readiness_edit'])->name('biological.readiness.edit');
        Route::post('{company}/biological-readiness/{readinessId}/update', [CompanyDashboardController::class, 'biological_readiness_update'])->name('biological.readiness.update');

        Route::get('{company}/iaq-survey', [CompanyDashboardController::class, 'iaq_survey'])->name('iaq.survey');
        Route::post('{company}/iaq-survey/store', [CompanyDashboardController::class, 'iaq_survey_store'])->name('iaq.survey.store');
        Route::get('{company}/iaq-survey/{surveyId}/edit', [CompanyDashboardController::class, 'iaq_survey_edit'])->name('iaq.survey.edit');
        Route::post('{company}/iaq-survey/{surveyId}/update', [CompanyDashboardController::class, 'iaq_survey_update'])->name('iaq.survey.update');

        Route::get('{company}/water-management', [CompanyDashboardController::class, 'water_management'])->name('water.management');
        Route::post('{company}/water-management/store', [CompanyDashboardController::class, 'water_management_store'])->name('water.management.store');
        Route::get('{company}/water-management/{surveyId}/edit', [CompanyDashboardController::class, 'water_management_edit'])->name('water.management.edit');
        Route::post('{company}/water-management/{surveyId}/update', [CompanyDashboardController::class, 'water_management_update'])->name('water.management.update');

    });

    Route::post('/update-company-field', [CompanyController::class, 'updateCompanyField'])->name('update.company.field');

    // ========================
    // PEOPLE ROUTES
    // ========================
    Route::prefix('people')->name('people.')->group(function () {

        Route::get('index', [PeopleController::class, 'index'])->name('index');
        Route::post('store', [PeopleController::class, 'store'])->name('store');
        Route::post('delete', [PeopleController::class, 'delete'])->name('delete');
        Route::get('my-peoples/{id}', [PeopleController::class, 'my_peoples'])->name('my_peoples');

        // Task Section
        Route::post('{people}/tasks', [PeopleTaskController::class, 'addTask'])->name('tasks.store');
        Route::put('tasks/{task}/update', [PeopleTaskController::class, 'updateTask'])->name('tasks.update');
        Route::post('tasks/{task}/complete', [PeopleTaskController::class, 'markCompleted'])->name('tasks.complete');
        Route::post('tasks/{task}/reopen', [PeopleTaskController::class, 'reopenTask'])->name('tasks.reopen');
        Route::post('tasks/delete/{task_id}', [PeopleTaskController::class, 'deleteTask'])->name('task.delete');

        // Detail Section
        Route::post('ajax', [PeopleController::class, 'ajax_store'])->name('ajax.store');
        Route::post('{people}/update-detail', [PeopleController::class, 'updateDetail'])->name('updateDetail');
        Route::post('{people}/company/add', [PeopleController::class, 'addCompany'])->name('companies.add');
        Route::post('{people}/remove-company', [PeopleController::class, 'removeCompany'])->name('company.remove');
        Route::post('{people}/tags/add', [PeopleController::class, 'addTag'])->name('tags.add');
        Route::post('{people}/tags/{tag}/remove', [PeopleController::class, 'removeTag'])->name('tags.remove');

        Route::get('{people}', [PeopleController::class, 'show'])->name('show');
        Route::get('{id}/timeline', [PeopleController::class, 'show'])->name('timeline');

        Route::get('animal-care', [PeopleController::class, 'animal_care'])->name('animal_care');
        Route::get('marketing-contacts', [PeopleController::class, 'marketing_contacts'])->name('marketing_contacts');
        Route::get('sequence-healthcare', [PeopleController::class, 'sequence_healthcare'])->name('sequence_healthcare');
        Route::post('{people}/update-field', [PeopleController::class, 'updateField'])->name('update.field');
        Route::post('delete-field', [PeopleController::class, 'deleteField'])->name('delete-field');

        Route::post('{people}/files/upload', [PeopleController::class, 'fileUpload'])->name('files.upload');
        Route::post('files/delete', [PeopleController::class, 'fileDelete'])->name('files.delete');

    });

    // People Section
    Route::post('/update-people-field', [PeopleController::class, 'updatePeopleField'])->name('update.people.field');
    // Task Section
    Route::post('/tasks/ajax', [TaskController::class, 'ajax_store'])->name('task.ajax.store');

    // ========================
    // LEAD ROUTES
    // ========================
    Route::prefix('lead')->name('lead.')->group(function () {

        // Lead Section
        Route::get('index', [LeadController::class, 'index'])->name('index');
        Route::get('hot-leads', [LeadController::class, 'hot_leads'])->name('hot_leads');
        Route::get('added-this-week', [LeadController::class, 'added_this_week'])->name('added_this_week');
        Route::get('closing-this-week', [LeadController::class, 'closing_this_week'])->name('closing_this_week');
        Route::get('my-leads/{id}', [LeadController::class, 'my_leads'])->name('my_leads');
        Route::get('open-leads/{id}', [LeadController::class, 'open_leads'])->name('open_leads');
        Route::get('watching-leads/{id}', [LeadController::class, 'watching_leads'])->name('watching_leads');
        Route::post('store', [LeadController::class, 'store'])->name('store');
        Route::get('{lead}', [LeadController::class, 'show'])->name('show');
        Route::get('{id}/timeline', [LeadController::class, 'show'])->name('timeline');
        Route::post('delete', [LeadController::class, 'delete'])->name('delete');

        // Task Section
        Route::post('{lead}/tasks', [LeadTaskController::class, 'addTask'])->name('tasks.store');
        Route::put('tasks/{task}/update', [LeadTaskController::class, 'updateTask'])->name('tasks.update');
        Route::post('tasks/{task}/complete', [LeadTaskController::class, 'markCompleted'])->name('tasks.complete');
        Route::post('tasks/{task}/reopen', [LeadTaskController::class, 'reopenTask'])->name('tasks.reopen');
        Route::post('tasks/delete/{task_id}', [LeadTaskController::class, 'deleteTask'])->name('task.delete');

        // Detail Section
        Route::post('ajax-update', [LeadController::class, 'ajax_update'])->name('ajax_update');
        Route::post('forecasting/store', [LeadController::class, 'storeForecasting'])->name('forecasting.store');
        Route::post('check-stage-condition/{id}', [LeadController::class, 'checkStageCondition'])->name('check.stage.condition');
        Route::post('change-stage/{id}', [LeadController::class, 'changeStage'])->name('change.stage');
        Route::post('{lead}/update-detail', [LeadController::class, 'updateDetail'])->name('lead.updateDetail');
        Route::post('{lead}/tags/add', [LeadController::class, 'addTag'])->name('tags.add');
        Route::post('{lead}/tags/{tag}/remove', [LeadController::class, 'removeTag'])->name('tags.remove');
        Route::post('{lead}/files/upload', [LeadController::class, 'fileUpload'])->name('files.upload');
        Route::post('files/delete', [LeadController::class, 'fileDelete'])->name('files.delete');

        Route::post('delete-field', [LeadController::class, 'deleteField'])->name('delete-field');
        Route::post('update-field', [LeadController::class, 'updateField'])->name('update-field');
        Route::post('add-product', [LeadController::class, 'addProduct'])->name('add-product');

        // Lead Stage Process
        Route::post('{lead}/initial-meeting/schedule', [LeadStageController::class, 'scheduleInitialMeeting'])->name('initial.schedule');
        Route::post('{lead}/initial-meeting/complete', [LeadStageController::class, 'completeInitialMeeting'])->name('initial.complete');
        Route::post('{lead}/initial-meeting/reopen', [LeadStageController::class, 'reopenInitialMeeting'])->name('initial.reopen');
        Route::post('{lead}/initial-meeting/reset', [LeadStageController::class, 'resetInitialMeeting'])->name('initial.reset');

        Route::post('{lead}/site-survey/schedule', [LeadStageController::class, 'scheduleSiteSurvey'])->name('site_survey.schedule');
        Route::post('{lead}/site-survey/complete', [LeadStageController::class, 'completeSiteSurvey'])->name('site_survey.complete');
        Route::post('{lead}/site-survey/reopen', [LeadStageController::class, 'reopenSiteSurvey'])->name('site_survey.reopen');
        Route::post('{lead}/site-survey/reset', [LeadStageController::class, 'resetSiteSurvey'])->name('site_survey.reset');

        // Survey Proposal Section
        Route::get('{lead}/survey/proposal', [SurveyProposalController::class, 'survey_proposal'])->name('survey.proposal');
        Route::post('{lead}/survey/proposal/store', [SurveyProposalController::class, 'survey_proposal_store'])->name('survey.proposal.store');
    });

    // ========================
    // SURVEY PROPOSAL ROUTES
    // ========================
    Route::prefix('survey/proposal')->name('survey.proposal.')->group(function () {

        Route::get('{survey_proposal}/facility', [SurveyProposalController::class, 'survey_facility'])->name('facility');
        Route::post('{survey_proposal}/facility/store', [SurveyProposalController::class, 'survey_facility_store'])->name('facility.store');
        Route::get('facility/{facility}/edit', [SurveyProposalController::class, 'survey_facility_edit'])->name('survey.facility.edit');
        Route::post('{facility}/facility/update', [SurveyProposalController::class, 'survey_facility_update'])->name('facility.update');

        Route::get('{survey_proposal}/equipment', [SurveyProposalController::class, 'survey_equipment'])->name('equipment');
        Route::post('{survey_proposal}/equipment/store', [SurveyProposalController::class, 'survey_equipment_store'])->name('equipment.store');
        Route::get('equipment/{equipment}/edit', [SurveyProposalController::class, 'survey_equipment_edit'])->name('survey.equipment.edit');
        Route::post('{equipment}/equipment/update', [SurveyProposalController::class, 'survey_equipment_update'])->name('equipment.update');

        Route::get('{survey_proposal}/pricing', [SurveyProposalController::class, 'pricing_proposal'])->name('pricing.proposal');

        Route::get('view/{id}', [SurveyProposalController::class, 'survey_view'])->name('view');
        Route::get('download/{id}', [SurveyProposalController::class, 'survey_download'])->name('download');

    });

    // ========================
    // PRICING PROPOSAL ROUTES
    // ========================
    Route::prefix('pricing-proposal')->name('pricing_proposal.')->group(function () {

        Route::post('{survey_proposal}/store', [SurveyProposalController::class, 'pricing_store'])->name('store');
        Route::get('{pricing}/edit', [SurveyProposalController::class, 'pricing_proposal_edit'])->name('edit');
        Route::post('{pricing}/update', [SurveyProposalController::class, 'updateExistingPricing'])->name('update');
        Route::post('delete', [SurveyProposalController::class, 'deletePricing'])->name('delete');

    });

    // ========================
    // SETTINGS ROUTES
    // ========================
    Route::prefix('settings')->name('settings.')->group(function () {

        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('activity_type', [SettingController::class, 'activity_type'])->name('activity_type');
        Route::post('activity_type', [SettingController::class, 'activity_type_store'])->name('activity_type.store');
        Route::get('competitor', [SettingController::class, 'competitor'])->name('competitor');
        Route::post('competitor', [SettingController::class, 'competitor_store'])->name('competitor.store');
        Route::get('industry', [SettingController::class, 'industry'])->name('industry');
        Route::post('industry', [SettingController::class, 'industry_store'])->name('industry.store');
        Route::get('channel_source', [SettingController::class, 'channel_source'])->name('channel_source');
        Route::post('channel_source', [SettingController::class, 'source_store'])->name('source.store');
        Route::get('company_type', [SettingController::class, 'company_type'])->name('company_type');
        Route::post('company_type', [SettingController::class, 'company_type_store'])->name('company_type.store');
        Route::get('market', [SettingController::class, 'market'])->name('market');
        Route::post('market', [SettingController::class, 'market_store'])->name('market.store');
        Route::get('tag', [SettingController::class, 'tag'])->name('tag');
        Route::post('tag', [SettingController::class, 'tag_store'])->name('tag.store');
        Route::get('product', [SettingController::class, 'product'])->name('product');
        Route::post('product', action: [SettingController::class, 'product_store'])->name('product.store');
        Route::get('territory', [SettingController::class, 'territory'])->name('territory');
        Route::post('territory', [SettingController::class, 'territory_store'])->name('territory.store');

    });

    // ========================
    // ACTIVITIES AND NOTES ROUTES
    // ========================
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

});

Route::get('/states/{countryId}', [SettingController::class, 'getStatesByCountry'])->name('get.states');
Route::get('/cities/{stateId}', [SettingController::class, 'getCitiesByState'])->name('get.cities');
Route::get('/approval/approve/{token}', [ApprovalController::class, 'approve'])->name('approval.approve');
Route::get('/approval/reject/{token}', [ApprovalController::class, 'reject'])->name('approval.reject');
Route::view('survey-proposal.pdf', 'survey-proposal.pdf')->name('survey.proposal');
