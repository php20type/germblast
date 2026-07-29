<?php

use App\Http\Controllers\Admin\SaleController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Sales Dashboard & Meeting Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/executive', [SaleController::class, 'executive'])->name('sales.executive');
    Route::get('/schedule/meeting', [SaleController::class, 'schedule_meeting'])->name('sales.schedule.meeting');
    Route::post('/store/meeting', [SaleController::class, 'store_meeting'])->name('sales.store.meeting');
    Route::get('meeting/{id}', [SaleController::class, 'show_meeting'])->name('sales.meetings.show');
    Route::post('meeting/{meeting}/update', [SaleController::class, 'update_meeting'])->name('sales.meetings.update');
    Route::post('meetings/delete', [SaleController::class, 'delete_meetings'])->name('sales.meetings.delete');
    Route::post('meeting/{id}/complete', [SaleController::class, 'complete_meeting'])->name('sales.meeting.complete');

    Route::get('/sales/invoices', [SaleController::class, 'invoices'])->name('sales.invoices');
    Route::get('/sales/contract-exception-report', [SaleController::class, 'contractExceptionReport'])->name('sales.contract_exception_report');
    Route::get('/sales/purchasing-information', [SaleController::class, 'purchasingInformation'])->name('sales.purchasing_information');
});
