<?php

use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\LeadTaskController;
use App\Http\Controllers\LeadStageController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::prefix('lead')->name('lead.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Lead Creating & Listing Routes
        |--------------------------------------------------------------------------
        */
        Route::get('index', [LeadController::class, 'index'])
            ->middleware('permission:lead.list.all.view')
            ->name('index');

        Route::get('hot-leads', [LeadController::class, 'hot_leads'])
            ->middleware('permission:lead.list.hot.view')
            ->name('hot_leads');

        Route::get('added-this-week', [LeadController::class, 'added_this_week'])
            ->middleware('permission:lead.list.added_this_week.view')
            ->name('added_this_week');

        Route::get('closing-this-week', [LeadController::class, 'closing_this_week'])
            ->middleware('permission:lead.list.closing_this_week.view')
            ->name('closing_this_week');

        Route::get('my-leads/{id}', [LeadController::class, 'my_leads'])
            ->middleware('permission:lead.list.my.view')
            ->name('my_leads');

        Route::get('open-leads/{id}', [LeadController::class, 'open_leads'])
            ->middleware('permission:lead.list.open.view')
            ->name('open_leads');

        Route::get('watching-leads/{id}', [LeadController::class, 'watching_leads'])
            ->middleware('permission:lead.list.watching.view')
            ->name('watching_leads');

        Route::post('store', [LeadController::class, 'store'])
            ->middleware('permission:lead.create')
            ->name('store');

        Route::post('delete', [LeadController::class, 'delete'])
            ->middleware('permission:lead.delete')
            ->name('delete');

        Route::middleware('permission:lead.detail.view')->group(function () {

            Route::get('{lead}', [LeadController::class, 'show'])->name('show');
            Route::get('{id}/timeline', [LeadController::class, 'show'])->name('timeline');

        });

        Route::middleware('permission:lead.detail.edit')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Lead Details Page Routes
            |--------------------------------------------------------------------------
            */
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

            /*
            |--------------------------------------------------------------------------
            | Lead Task Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{lead}/tasks', [LeadTaskController::class, 'addTask'])->name('tasks.store');
            Route::put('tasks/{task}/update', [LeadTaskController::class, 'updateTask'])->name('tasks.update');
            Route::post('tasks/{task}/complete', [LeadTaskController::class, 'markCompleted'])->name('tasks.complete');
            Route::post('tasks/{task}/reopen', [LeadTaskController::class, 'reopenTask'])->name('tasks.reopen');
            Route::post('tasks/delete/{task_id}', [LeadTaskController::class, 'deleteTask'])->name('task.delete');

            /*
            |--------------------------------------------------------------------------
            | Lead Stage Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{lead}/initial-meeting/schedule', [LeadStageController::class, 'scheduleInitialMeeting'])->name('initial.schedule');
            Route::post('{lead}/initial-meeting/complete', [LeadStageController::class, 'completeInitialMeeting'])->name('initial.complete');
            Route::post('{lead}/initial-meeting/reopen', [LeadStageController::class, 'reopenInitialMeeting'])->name('initial.reopen');
            Route::post('{lead}/initial-meeting/reset', [LeadStageController::class, 'resetInitialMeeting'])->name('initial.reset');

            Route::post('{lead}/site-survey/schedule', [LeadStageController::class, 'scheduleSiteSurvey'])->name('site_survey.schedule');
            Route::post('{lead}/site-survey/complete', [LeadStageController::class, 'completeSiteSurvey'])->name('site_survey.complete');
            Route::post('{lead}/site-survey/reopen', [LeadStageController::class, 'reopenSiteSurvey'])->name('site_survey.reopen');
            Route::post('{lead}/site-survey/reset', [LeadStageController::class, 'resetSiteSurvey'])->name('site_survey.reset');

        });

    });

});
