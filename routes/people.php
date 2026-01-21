<?php

use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\PeopleTaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::prefix('people')->name('people.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | People Listing & Creating Routes
        |--------------------------------------------------------------------------
        */
        Route::get('index', [PeopleController::class, 'index'])
            ->middleware('permission:people.list.all.view')
            ->name('index');

        Route::post('store', [PeopleController::class, 'store'])
            ->middleware('permission:people.create')
            ->name('store');

        Route::post('delete', [PeopleController::class, 'delete'])
            ->middleware('permission:people.delete')
            ->name('delete');

        Route::get('my-peoples/{id}', [PeopleController::class, 'my_peoples'])
            ->middleware('permission:people.list.my.view')
            ->name('my_peoples');

        Route::get('animal-care', [PeopleController::class, 'animal_care'])
            ->middleware('permission:people.list.animal_care.view')
            ->name('animal_care');

        Route::get('marketing-contacts', [PeopleController::class, 'marketing_contacts'])
            ->middleware('permission:people.list.marketing_contacts.view')
            ->name('marketing_contacts');

        Route::get('sequence-healthcare', [PeopleController::class, 'sequence_healthcare'])
            ->middleware('permission:people.list.sequence_healthcare.view')
            ->name('sequence_healthcare');

        Route::middleware('permission:people.detail.view')->group(function () {

            Route::get('{people}', [PeopleController::class, 'show'])->name('show');
            Route::get('{id}/timeline', [PeopleController::class, 'show'])->name('timeline');

        });

        Route::middleware('permission:people.detail.edit')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | People Details Page Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{people}/update-detail', [PeopleController::class, 'updateDetail'])->name('updateDetail');
            Route::post('{people}/company/add', [PeopleController::class, 'addCompany'])->name('companies.add');
            Route::post('{people}/remove-company', [PeopleController::class, 'removeCompany'])->name('company.remove');
            Route::post('{people}/tags/add', [PeopleController::class, 'addTag'])->name('tags.add');
            Route::post('{people}/tags/{tag}/remove', [PeopleController::class, 'removeTag'])->name('tags.remove');
            Route::post('{people}/update-field', [PeopleController::class, 'updateField'])->name('update.field');
            Route::post('delete-field', [PeopleController::class, 'deleteField'])->name('delete-field');

            /*
            |--------------------------------------------------------------------------
            | People Task Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{people}/tasks', [PeopleTaskController::class, 'addTask'])->name('tasks.store');
            Route::put('tasks/{task}/update', [PeopleTaskController::class, 'updateTask'])->name('tasks.update');
            Route::post('tasks/{task}/complete', [PeopleTaskController::class, 'markCompleted'])->name('tasks.complete');
            Route::post('tasks/{task}/reopen', [PeopleTaskController::class, 'reopenTask'])->name('tasks.reopen');
            Route::post('tasks/delete/{task_id}', [PeopleTaskController::class, 'deleteTask'])->name('task.delete');

            /*
            |--------------------------------------------------------------------------
            | People Files Routes
            |--------------------------------------------------------------------------
            */
            Route::post('{people}/files/upload', [PeopleController::class, 'fileUpload'])->name('files.upload');
            Route::post('files/delete', [PeopleController::class, 'fileDelete'])->name('files.delete');

        });

    });

    Route::post('/update-people-field', [PeopleController::class, 'updatePeopleField'])
        ->middleware('permission:people.detail.edit')
        ->name('update.people.field');

});
