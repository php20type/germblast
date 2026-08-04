<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\ConsumableReportController;
use App\Http\Controllers\Admin\OfficeDutyController;
use App\Http\Controllers\Admin\InventoryReportController;
use App\Http\Controllers\Admin\JobProfitabilityController;
use App\Http\Controllers\Admin\ChangeControlController;
use App\Http\Controllers\Admin\BusinessFailureController;
use App\Http\Controllers\Admin\IsdAttendanceController;
use App\Http\Controllers\Admin\LoanEquipmentController;
use App\Http\Controllers\Admin\AnonymousFeedbackController;
use App\Http\Controllers\Admin\TimeOffRequestController;
use App\Http\Controllers\Admin\CoreValuePraiseController;
use App\Http\Controllers\Admin\EmployeeRewardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentManagementController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\Admin\TrainingCategoryController;
use App\Http\Controllers\Admin\TrainingTestController;
use App\Http\Controllers\Admin\TrainingQuestionController;
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
    Route::get('global-search', [AdminController::class, 'search'])->name('global-search');

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
    Route::post('employee/{id}/availability/store', [EmployeeController::class, 'storeAvailability'])->name('employee.availability.store');

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

    // Consumable Reports
    Route::get('consumable-reports/index', [ConsumableReportController::class, 'index'])->name('consumable-reports.index');
    Route::post('consumable-reports/store', [ConsumableReportController::class, 'store'])->name('consumable-reports.store');
    Route::put('consumable-reports/update/{id}', [ConsumableReportController::class, 'update'])->name('consumable-reports.update');
    Route::post('consumable-reports/delete/{id}', [ConsumableReportController::class, 'destroy'])->name('consumable-reports.destroy');

    // Office Duties
    Route::get('office-duties', [OfficeDutyController::class, 'index'])->name('office-duties.index');
    Route::post('office-duties/store', [OfficeDutyController::class, 'store'])->name('office-duties.store');
    Route::put('office-duties/update/{id}', [OfficeDutyController::class, 'update'])->name('office-duties.update');
    Route::post('office-duties/complete/{id}', [OfficeDutyController::class, 'complete'])->name('office-duties.complete');

    // Equipment Loan System
    Route::get('equipment-loan/index', [LoanEquipmentController::class, 'index'])->name('equipment-loan.index');
    Route::post('equipment-loan/store', [LoanEquipmentController::class, 'store'])->name('equipment-loan.store');
    Route::post('equipment-loan/{id}/checkout', [LoanEquipmentController::class, 'checkout'])->name('equipment-loan.checkout');
    Route::post('equipment-loan/{id}/disposition', [LoanEquipmentController::class, 'disposition'])->name('equipment-loan.disposition');

    // Warehouse 
    Route::get('/warehouse/maintenance-dashboard', [WarehouseController::class, 'maintenance'])->name('warehouse.maintenance');
    Route::post('/warehouse/tasks/store', [WarehouseController::class, 'store'])->name('warehouse.tasks.store');
    Route::post('/warehouse/tasks/update/{id}', [WarehouseController::class, 'update'])->name('warehouse.tasks.update');
    Route::post('/warehouse/tasks/complete/{id}', [WarehouseController::class, 'complete'])->name('warehouse.tasks.complete');
    Route::post('/warehouse/tasks/reset/{id}', [WarehouseController::class, 'reset'])->name('warehouse.tasks.reset');
    Route::post('/warehouse/tasks/delete/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.tasks.destroy');

    // System Notifications
    Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/mark-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('notifications/latest', [\App\Http\Controllers\Admin\NotificationController::class, 'getLatest'])->name('notifications.latest');

    // Training Categories
    Route::get('training-categories/index', [TrainingCategoryController::class, 'index'])->name('training-categories.index');
    Route::get('training-categories/create', [TrainingCategoryController::class, 'create'])->name('training-categories.create');
    Route::post('training-categories/store', [TrainingCategoryController::class, 'store'])->name('training-categories.store');
    Route::get('training-categories/edit/{id}', [TrainingCategoryController::class, 'edit'])->name('training-categories.edit');
    Route::post('training-categories/update/{id}', [TrainingCategoryController::class, 'update'])->name('training-categories.update');

    // Training Tests
    Route::get('training-tests/index', [TrainingTestController::class, 'index'])->name('training-tests.index');
    Route::get('training-tests/create', [TrainingTestController::class, 'create'])->name('training-tests.create');
    Route::post('training-tests/store', [TrainingTestController::class, 'store'])->name('training-tests.store');
    Route::get('training-tests/edit/{id}', [TrainingTestController::class, 'edit'])->name('training-tests.edit');
    Route::post('training-tests/update/{id}', [TrainingTestController::class, 'update'])->name('training-tests.update');

    // Training Questions
    Route::get('training-questions/index', [TrainingQuestionController::class, 'index'])->name('training-questions.index');
    Route::get('training-questions/show/{test_id}', [TrainingQuestionController::class, 'show'])->name('training-questions.show');
    Route::post('training-questions/store', [TrainingQuestionController::class, 'store'])->name('training-questions.store');
    Route::post('training-questions/update/{id}', [TrainingQuestionController::class, 'update'])->name('training-questions.update');

    // Training Report
    Route::get('training-report/index', [\App\Http\Controllers\Admin\TrainingReportController::class, 'index'])->name('training-report.index');

    // Employee Training Module
    Route::get('employee-training', [\App\Http\Controllers\Admin\EmployeeTrainingController::class, 'index'])->name('employee-training.index');
    Route::get('employee-training/{test_id}/quiz', [\App\Http\Controllers\Admin\EmployeeTrainingController::class, 'show'])->name('employee-training.show');
    Route::post('employee-training/{test_id}/submit', [\App\Http\Controllers\Admin\EmployeeTrainingController::class, 'submit'])->name('employee-training.submit');
    Route::get('employee-training/certificate/{attempt_id}', [\App\Http\Controllers\Admin\EmployeeTrainingController::class, 'certificate'])->name('employee-training.certificate');

    Route::get('/warehouse/calendar', [WarehouseController::class, 'calendar'])->name('warehouse.calendar');
    Route::post('/warehouse/calendar/store', [WarehouseController::class, 'storeSchedule'])->name('warehouse.calendar.store');
    Route::post('/warehouse/calendar/delete/{id}', [WarehouseController::class, 'destroySchedule'])->name('warehouse.calendar.destroy');
    // Anonymous Feedback
    Route::get('hr/feedback', [AnonymousFeedbackController::class, 'index'])->name('hr.feedback.index');
    Route::get('hr/feedback/create', [AnonymousFeedbackController::class, 'create'])->name('hr.feedback.create');
    Route::post('hr/feedback/store', [AnonymousFeedbackController::class, 'store'])->name('hr.feedback.store');

    // Time Off Requests
    Route::get('hr/time-off', [TimeOffRequestController::class, 'index'])->name('hr.time-off.index');
    Route::post('hr/time-off/store', [TimeOffRequestController::class, 'store'])->name('hr.time-off.store');
    Route::post('hr/time-off/{id}/approve', [TimeOffRequestController::class, 'approve'])->name('hr.time-off.approve');
    Route::post('hr/time-off/{id}/reject', [TimeOffRequestController::class, 'reject'])->name('hr.time-off.reject');

    // Core Value Praise
    Route::get('hr/praise', [CoreValuePraiseController::class, 'index'])->name('hr.praise.index');
    Route::get('hr/praise/create', [CoreValuePraiseController::class, 'create'])->name('hr.praise.create');
    Route::post('hr/praise/store', [CoreValuePraiseController::class, 'store'])->name('hr.praise.store');

    // GB Rewards
    Route::get('hr/rewards', [EmployeeRewardController::class, 'index'])->name('hr.rewards.index');
    Route::post('hr/rewards/store', [EmployeeRewardController::class, 'store'])->name('hr.rewards.store');
    Route::delete('hr/rewards/{id}/destroy', [EmployeeRewardController::class, 'destroy'])->name('hr.rewards.destroy');

    // Driver Reports
    Route::get('hr/driver-report', [EmployeeController::class, 'driverReport'])->name('hr.driver-report.index');
    Route::post('hr/driver-report/{userId}', [EmployeeController::class, 'updateDriverReport'])->name('hr.driver-report.update');

    // HR Timecards
    Route::get('hr/timecards', [EmployeeController::class, 'hr_timecards'])->name('hr.timecards.index');

    // Employee Work Report
    Route::get('work-report', [EmployeeController::class, 'workReport'])->name('work-report.index');

    // Timecards
    Route::get('timecards', [EmployeeController::class, 'timecard_index'])->name('timecards.index');
    Route::post('timecards', [EmployeeController::class, 'store_timecard'])->name('timecards.store');
    Route::get('timecards/{id}', [EmployeeController::class, 'timecard_details'])->name('timecards.details');
    Route::put('timecards/{id}', [EmployeeController::class, 'update_timecard'])->name('timecards.update');
    Route::get('my-timeclock', [EmployeeController::class, 'my_timeclock'])->name('my-timeclock');

    // Inventory Report
    Route::get('inventory-report', [InventoryReportController::class, 'index'])->name('inventory-report.index');
    Route::post('inventory-report', [InventoryReportController::class, 'store'])->name('inventory-report.store');
    Route::post('inventory-report/{id}/update', [InventoryReportController::class, 'update'])->name('inventory-report.update');
    Route::post('inventory-report/{id}/delete', [InventoryReportController::class, 'destroy'])->name('inventory-report.destroy');

    // Job Profitability
    Route::get('job-profitability', [JobProfitabilityController::class, 'index'])->name('job-profitability.index');
    Route::get('job-profitability/pdf', [JobProfitabilityController::class, 'downloadPdf'])->name('job-profitability.pdf');
    Route::get('job-profitability/csv', [JobProfitabilityController::class, 'downloadCsv'])->name('job-profitability.csv');

    // Change Control
    Route::get('change-control', [ChangeControlController::class, 'index'])->name('change-control.index');
    Route::post('change-control', [ChangeControlController::class, 'store'])->name('change-control.store');
    Route::get('change-control/{id}', [ChangeControlController::class, 'show'])->name('change-control.show');
    Route::post('change-control/{id}/update', [ChangeControlController::class, 'update'])->name('change-control.update');
    Route::post('change-control/{id}/status', [ChangeControlController::class, 'updateStatus'])->name('change-control.status.update');
    Route::post('change-control/{id}/task', [ChangeControlController::class, 'storeTask'])->name('change-control.task.store');
    Route::post('change-control/{id}/task/{taskId}/status', [ChangeControlController::class, 'updateTaskStatus'])->name('change-control.task.status.update');
    Route::post('change-control/{id}/documentation', [ChangeControlController::class, 'storeDocumentation'])->name('change-control.documentation.store');

    // Business Failures
    Route::get('business-failures', [BusinessFailureController::class, 'index'])->name('failures.index');
    Route::post('business-failures', [BusinessFailureController::class, 'store'])->name('failures.store');
    Route::post('business-failures/{id}/documentation', [BusinessFailureController::class, 'storeDocumentation'])->name('failures.documentation.store');

    // ISD Attendance Module
    Route::get('isd-attendance', [IsdAttendanceController::class, 'index'])->name('isd-attendance.index');
    Route::get('isd-attendance/campus/{campusId}', [IsdAttendanceController::class, 'attendance'])->name('isd-attendance.campus');
    Route::post('isd-attendance/store', [IsdAttendanceController::class, 'store'])->name('isd-attendance.store');
    Route::put('isd-attendance/{id}/update', [IsdAttendanceController::class, 'update'])->name('isd-attendance.update');
    Route::delete('isd-attendance/{id}/destroy', [IsdAttendanceController::class, 'destroy'])->name('isd-attendance.destroy');

    // ISD School Management
    Route::post('isd-attendance/school', [IsdAttendanceController::class, 'storeSchool'])->name('isd-attendance.school.store');
    Route::put('isd-attendance/school/{id}', [IsdAttendanceController::class, 'updateSchool'])->name('isd-attendance.school.update');
    Route::delete('isd-attendance/school/{id}', [IsdAttendanceController::class, 'destroySchool'])->name('isd-attendance.school.destroy');

    // ISD Campus Management
    Route::post('isd-attendance/campus', [IsdAttendanceController::class, 'storeCampus'])->name('isd-attendance.campus.store');
    Route::put('isd-attendance/campus/{id}', [IsdAttendanceController::class, 'updateCampus'])->name('isd-attendance.campus.update');
    Route::delete('isd-attendance/campus/{id}', [IsdAttendanceController::class, 'destroyCampus'])->name('isd-attendance.campus.destroy');
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
