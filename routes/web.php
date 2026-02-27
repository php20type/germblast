<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Dashboards
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('/sales/dashboard', 'sales.dashboard')->name('sales.dashboard');
    Route::view('/technician/dashboard', 'technician.dashboard')->name('technician.dashboard');
    Route::view('/client/dashboard', 'client.dashboard')->name('client.dashboard');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Core Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('profile/view', [ProfileController::class, 'view'])->name('profile.view');
    Route::post('profile/update', [ProfileController::class, 'adminUpdate'])->name('profile.admin.update');

    Route::post('/tasks/ajax', [TaskController::class, 'ajax_store'])->name('task.ajax.store');

    // Activities & Notes
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

    // Roles
    Route::get('roles/permissions', [RolePermissionController::class, 'index'])->name('roles.permissions');
    Route::post('roles/permissions/update', [RolePermissionController::class, 'update'])->name('roles.permissions.update');

    // Employees
    Route::get('employee/index', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');

});

Route::view('survey-proposal.pdf', 'survey-proposal.pdf')->name('survey.proposal');

Route::get('admin/lead/fulfill-order', [LeadController::class, 'fulfillOrder'])->name('admin.lead.fulfill_order');

/*
|--------------------------------------------------------------------------
| Modular Route Files (REQUIRES)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
require __DIR__ . '/company.php';
require __DIR__ . '/people.php';
require __DIR__ . '/lead.php';
require __DIR__ . '/sale.php';
require __DIR__ . '/survey.php';
require __DIR__ . '/settings.php';
