<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyTaskController;
use App\Http\Controllers\CompanyDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::prefix('company')->name('company.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Company Listing & Creating Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/', [CompanyController::class, 'index'])
            ->middleware('permission:company.list.all.view')
            ->name('index');

        Route::get('my_companies/{id}', [CompanyController::class, 'my_companies'])
            ->middleware('permission:company.list.my.view')
            ->name('my_companies');

        Route::post('store', [CompanyController::class, 'store'])
            ->middleware('permission:company.create')
            ->name('store');

        Route::post('delete', [CompanyController::class, 'delete'])
            ->middleware('permission:company.delete')
            ->name('delete');

        Route::middleware('permission:company.detail.view')->group(function () {

            Route::get('{company}', [CompanyController::class, 'show'])->name('show');
            Route::get('{id}/timeline', [CompanyController::class, 'show'])->name('timeline');

        });

        Route::middleware('permission:company.detail.edit')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Company Details Page Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{company}/location/add', [CompanyController::class, 'addLocation'])->name('location.add');
            Route::post('location/{location}/update', [CompanyController::class, 'updateLocation'])->name('location.update');
            Route::post('location/{location}/delete', [CompanyController::class, 'deleteLocation'])->name('location.delete');
            Route::post('{company}/update-detail', [CompanyController::class, 'updateDetail'])->name('updateDetail');
            Route::post('{company}/update-photo', [CompanyController::class, 'updatePhoto'])->name('updatePhoto');
            Route::post('{company}/people/add', [CompanyController::class, 'addPeople'])->name('people.add');
            Route::post('{company}/remove-person', [CompanyController::class, 'removePerson'])->name('people.remove');
            Route::post('{company}/tags/add', [CompanyController::class, 'addTag'])->name('tags.add');
            Route::post('{company}/tags/{tag}/remove', [CompanyController::class, 'removeTag'])->name('tags.remove');
            Route::post('{company}/update-field', [CompanyController::class, 'updateField'])->name('company.update.field');
            Route::post('delete-field', [CompanyController::class, 'deleteField'])->name('delete-field');
            Route::post('{company}/files/upload', [CompanyController::class, 'fileUpload'])->name('files.upload');
            Route::post('files/delete', [CompanyController::class, 'fileDelete'])->name('files.delete');

            /*
            |--------------------------------------------------------------------------
            | Company Task Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{company}/tasks', [CompanyTaskController::class, 'addTask'])->name('tasks.store');
            Route::put('tasks/{task}/update', [CompanyTaskController::class, 'updateTask'])->name('tasks.update');
            Route::post('tasks/{task}/complete', [CompanyTaskController::class, 'markCompleted'])->name('tasks.complete');
            Route::post('tasks/{task}/reopen', [CompanyTaskController::class, 'reopenTask'])->name('tasks.reopen');
            Route::post('tasks/delete/{task_id}', [CompanyTaskController::class, 'deleteTask'])->name('task.delete');

        });

        /*
        |--------------------------------------------------------------------------
        | Company Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('{company}/dashboard', [CompanyDashboardController::class, 'company_dashboard'])
            ->middleware('permission:company.dashboard.view')
            ->name('dashboard');

        Route::middleware('permission:company.dashboard.edit')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | IAQ Zone and Device Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{company}/iaq-zones', [CompanyDashboardController::class, 'storeIAQZone'])->name('iaq-zones.store');
            Route::get('{company}/iaq-zones/{zoneId}/edit', [CompanyDashboardController::class, 'editIAQZone'])->name('iaq-zones.edit');
            Route::post('{company}/iaq-zones/{zoneId}/update', [CompanyDashboardController::class, 'updateIAQZone'])->name('iaq-zones.update');
            Route::post('{company}/iaq-devices', [CompanyDashboardController::class, 'storeIAQDevice'])->name('iaq-devices.store');
            Route::get('{company}/iaq-devices/{deviceId}/edit', [CompanyDashboardController::class, 'editIAQDevice'])->name('iaq-devices.edit');
            Route::post('{company}/iaq-devices/{deviceId}/update', [CompanyDashboardController::class, 'updateIAQDevice'])->name('iaq-devices.update');

            /*
            |--------------------------------------------------------------------------
            | Biological Response and Readiness Routes
            |--------------------------------------------------------------------------
            */
            Route::get('{company}/biological-response', [CompanyDashboardController::class, 'biological_response'])->name('biological.response');
            Route::post('{company}/biological-response/store', [CompanyDashboardController::class, 'biological_response_store'])->name('biological.response.store');
            Route::get('{company}/biological-response/{intakeId}/edit', [CompanyDashboardController::class, 'biological_response_edit'])->name('biological.response.edit');
            Route::post('{company}/biological-response/{intakeId}/update', [CompanyDashboardController::class, 'biological_response_update'])->name('biological.response.update');
            Route::get('{company}/biological-readiness', [CompanyDashboardController::class, 'biological_readiness'])->name('biological.readiness');
            Route::post('{company}/biological-readiness/store', [CompanyDashboardController::class, 'biological_readiness_store'])->name('biological.readiness.store');
            Route::get('{company}/biological-readiness/{readinessId}/edit', [CompanyDashboardController::class, 'biological_readiness_edit'])->name('biological.readiness.edit');
            Route::post('{company}/biological-readiness/{readinessId}/update', [CompanyDashboardController::class, 'biological_readiness_update'])->name('biological.readiness.update');

            /*
            |--------------------------------------------------------------------------
            | IAQ Survey Routes
            |--------------------------------------------------------------------------
            */
            Route::get('{company}/iaq-survey', [CompanyDashboardController::class, 'iaq_survey'])->name('iaq.survey');
            Route::post('{company}/iaq-survey/store', [CompanyDashboardController::class, 'iaq_survey_store'])->name('iaq.survey.store');
            Route::get('{company}/iaq-survey/{surveyId}/edit', [CompanyDashboardController::class, 'iaq_survey_edit'])->name('iaq.survey.edit');
            Route::post('{company}/iaq-survey/{surveyId}/update', [CompanyDashboardController::class, 'iaq_survey_update'])->name('iaq.survey.update');

            /*
            |--------------------------------------------------------------------------
            | Water Management Routes
            |--------------------------------------------------------------------------
            */
            Route::get('{company}/water-management', [CompanyDashboardController::class, 'water_management'])->name('water.management');
            Route::post('{company}/water-management/store', [CompanyDashboardController::class, 'water_management_store'])->name('water.management.store');
            Route::get('{company}/water-management/{surveyId}/edit', [CompanyDashboardController::class, 'water_management_edit'])->name('water.management.edit');
            Route::post('{company}/water-management/{surveyId}/update', [CompanyDashboardController::class, 'water_management_update'])->name('water.management.update');

        });

    });

    Route::post('/update-company-field', [CompanyController::class, 'updateCompanyField'])
    ->middleware('permission:company.detail.edit')
    ->name('update.company.field');

});
