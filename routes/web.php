<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentManagementController;
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
    $user = auth()->user();
    if ($user->isCustomer()) {
        return view('dashboard'); // customer dashboard
    }
    return redirect()->route('admin.dashboard'); // others
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
    Route::post('employee/{id}/mask-fit-test/store', [EmployeeController::class, 'storeMaskFitTest'])->name('employee.mask-fit-test.store');
    Route::post('employee/{id}/driver-log/store',[EmployeeController::class, 'storeDriverLog'])->name('employee.driver-log.store');
    Route::post('employee/{id}/driver-suspension/store',[EmployeeController::class, 'storeDriverSuspension'])->name('employee.driver-suspension.store');

    // Expense Reports
    Route::get('expense-report/index', [ExpenseReportController::class, 'index'])->name('expense-report.index');
    Route::get('expense-report/personal/create', [ExpenseReportController::class, 'personal_create'])->name('expense-report.personal.create');
    Route::get('expense-report/corporate/create', [ExpenseReportController::class, 'corporate_create'])->name('expense-report.corporate.create');
    Route::get('expense-report/edit/{id}', [ExpenseReportController::class, 'edit'])->name('expense-report.edit');
    Route::post('expense-report/update/{id}', [ExpenseReportController::class, 'update'])->name('expense-report.update');
    Route::post('expense-report/submit/{id}', [ExpenseReportController::class, 'submit'])->name('expense-report.submit');
    Route::post('expense-report/{id}/approve-item',[ExpenseReportController::class, 'approveItem'])->name('expense-report.approve-item');
    Route::post('expense-report/{id}/unsubmit',       [ExpenseReportController::class, 'unsubmit'])->name('expense-report.unsubmit');
    Route::post('expense-report/{id}/accept-and-fill', [ExpenseReportController::class, 'acceptAndFill'])->name('expense-report.accept-and-fill');

    Route::get('equipment-management/index', [EquipmentManagementController::class, 'index'])->name('equipment-management.index');
    Route::post('equipment-management/store', [EquipmentManagementController::class, 'store'])->name('equipment-management.store');
    Route::post('equipment-management/update-status/{id}', [EquipmentManagementController::class, 'updateStatus'])->name('equipment-management.update-status');
    Route::get('equipment-management/{id}/history', [EquipmentManagementController::class, 'history'])->name('equipment-management.history');
});

Route::view('survey-proposal.pdf', 'survey-proposal.pdf')->name('survey.proposal');

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
require __DIR__ . '/service.php';
require __DIR__ . '/settings.php';
