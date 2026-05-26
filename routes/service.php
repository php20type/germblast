<?php

use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::prefix('lead')->name('lead.')->group(function () {

        Route::get('service/details/{lead}', [ServiceController::class, 'getServiceDetails'])->name('service.details');

        Route::post('service/store/{lead}', [ServiceController::class, 'storeService'])->name('service.store');
        Route::post('service/add-date', [ServiceController::class, 'addIntendedDate'])->name('service.add_date');
        Route::post('service/add-recurrence', [ServiceController::class, 'addRecurrenceSchedule'])->name('service.add_recurrence');

        Route::post('service/slot/{slotId}/confirm', [ServiceController::class, 'confirmSlot'])->name('service.slot.confirm');
        Route::post('service/slot/{slotId}/update', [ServiceController::class, 'updateSlot'])->name('service.slot.update');

        Route::post('service/slot/{slotId}/facility/add', [ServiceController::class, 'addFacility'])->name('service.slot.facility.add');
        Route::post('service/slot/facility/{facilityId}/remove', [ServiceController::class, 'removeFacility'])->name('service.slot.facility.remove');

        Route::get('service/user-monthly-slots', [ServiceController::class, 'getUserMonthlySlots'])->name('service.user.monthly_slots');
        Route::post('service/slot/{slotId}/staff/assign', [ServiceController::class, 'assignStaff'])->name('service.slot.staff.assign');
        Route::post('service/slot/staff/{staffId}/remove', [ServiceController::class, 'removeStaff'])->name('service.slot.staff.remove');
        Route::post('service/slot/staff/{staffId}/toggle-leader', [ServiceController::class, 'toggleLeader'])->name('service.slot.staff.toggle_leader');

        Route::post('/slot/{slot}/vehicles', [ServiceController::class, 'assignVehicles'])->name('slot.vehicle.assign');
        Route::post('/slot/{slot}/vehicles/{vehicle}', [ServiceController::class, 'removeVehicle'])->name('slot.vehicle.remove');

        Route::post('order/{orderId}/notes/add', [ServiceController::class, 'addServiceNote'])->name('service.order.notes.add');
        Route::post('order/{orderId}/inventory/update', [ServiceController::class, 'updateInventory'])->name('service.order.inventory.update');
        Route::post('outline/{outlineId}/update', [ServiceController::class, 'updateOutlineRange'])->name('service.outline.update');

        Route::post('service/clock-in',  [ServiceController::class, 'clockIn'])->name('service.clock_in');
        Route::post('service/clock-out', [ServiceController::class, 'clockOut'])->name('service.clock_out');

        Route::get('service/fulfill-order/{orderId}', [ServiceController::class, 'fulfillOrder'])->name('service.fulfill_order');
        Route::post('service/fulfill-order/{orderId}/book', [ServiceController::class, 'fulfillOrder_book'])->name('service.fulfill_order.book');
        Route::post('order/{orderId}/update-checklist', [ServiceController::class, 'updateChecklist'])->name('service.order.update_checklist');
        Route::post('order/{orderId}/employee-performance/store', [ServiceController::class, 'storeEmployeePerformance'])->name('service.order.employee_performance.store');

    });

    Route::get('calendar', [ServiceController::class, 'calendar'])->name('calendar.index');
    Route::get('calendar/orders', [ServiceController::class, 'calendarOrders'])->name('calendar.orders');

    Route::get('/scheduling-calendar', [ServiceController::class, 'schedulingCalendar'])->name('scheduling_calendar.index');
    Route::get('/scheduling-calendar/orders', [ServiceController::class, 'schedulingCalendarOrders'])->name('scheduling_calendar.orders');

    Route::get('/vehicle-planning', [ServiceController::class, 'vehiclePlanning'])->name('vehicle.planning');

    Route::get('/all-schedules', [ServiceController::class, 'all_schedules'])->name('all_schedules.index');
});
