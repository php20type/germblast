<?php

use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::prefix('lead')->name('lead.')->group(function () {

        Route::get('service/details/{lead}', [ServiceController::class, 'getServiceDetails'])->name('service.details');

        Route::post('service/store/{lead}', [ServiceController::class, 'storeService'])->name('service.store');
        Route::post('service/add-date', [ServiceController::class, 'addIntendedDate'])->name('service.add_date');

        Route::post('service/slot/{slotId}/confirm', [ServiceController::class, 'confirmSlot'])->name('service.slot.confirm');
        Route::post('service/slot/{slotId}/update', [ServiceController::class, 'updateSlot'])->name('service.slot.update');

        Route::post('service/slot/{slotId}/facility/add', [ServiceController::class, 'addFacility'])->name('service.slot.facility.add');
        Route::post('service/slot/facility/{facilityId}/remove', [ServiceController::class, 'removeFacility'])->name('service.slot.facility.remove');

        Route::post('service/clock-in',  [ServiceController::class, 'clockIn'])->name('service.clock_in');
        Route::post('service/clock-out', [ServiceController::class, 'clockOut'])->name('service.clock_out');

        Route::get('service/fulfill-order/{orderId}', [ServiceController::class, 'fulfillOrder'])->name('service.fulfill_order');
        Route::post('service/fulfill-order/{orderId}/book', [ServiceController::class, 'fulfillOrder_book'])->name('service.fulfill_order.book');

    });

    Route::get('calendar', [ServiceController::class, 'calendar'])->name('calendar.index');
    Route::get('calendar/orders', [ServiceController::class, 'calendarOrders'])->name('calendar.orders');
});
