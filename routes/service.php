<?php

use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::prefix('lead')->name('lead.')->group(function () {

        Route::get('service/details/{lead}', [ServiceController::class, 'getServiceDetails'])->name('service.details');

        Route::post('service/store/{lead}', [ServiceController::class, 'storeService'])->name('service.store');
        Route::post('service/add-date', [ServiceController::class, 'addIntendedDate'])->name('service.add_date');

        Route::post('service/clock-in',  [ServiceController::class, 'clockIn'])->name('service.clock_in');
        Route::post('service/clock-out', [ServiceController::class, 'clockOut'])->name('service.clock_out');

        Route::get('fulfill-order', [ServiceController::class, 'fulfillOrder'])->name('fulfill_order');

    });
});
