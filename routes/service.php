<?php

use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::prefix('lead')->name('lead.')->group(function () {

        Route::get('service/details/{lead}', [ServiceController::class, 'getServiceDetails'])->name('service.details');
        Route::get('service/pricing-proposal/{pricingProposal}', [ServiceController::class, 'getPricingProposalDetails'])->name('service.pricing_proposal_details');

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

        Route::post('order/{orderId}/invoice/generate', [ServiceController::class, 'generateInvoice'])->name('service.order.invoice.generate');
        Route::post('invoice/{invoiceId}/update', [ServiceController::class, 'updateInvoice'])->name('service.order.invoice.update');
        Route::post('invoice/{invoiceId}/share', [ServiceController::class, 'shareInvoice'])->name('service.order.invoice.share');
        Route::get('invoice/{invoiceId}/download/pdf', [ServiceController::class, 'downloadInvoicePdf'])->name('service.order.invoice.download.pdf');
        Route::get('invoice/{invoiceId}/download/csv', [ServiceController::class, 'downloadInvoiceCsv'])->name('service.order.invoice.download.csv');
        
        Route::post('outline/{outlineId}/update', [ServiceController::class, 'updateOutlineRange'])->name('service.outline.update');
        Route::post('service/{serviceId}/outline/add', [ServiceController::class, 'addServiceOutline'])->name('service.outline.add');

        Route::post('service/clock-in',  [ServiceController::class, 'clockIn'])->name('service.clock_in');
        Route::post('service/clock-out', [ServiceController::class, 'clockOut'])->name('service.clock_out');
        Route::post('service/clock/{clockId}/update', [ServiceController::class, 'updateClock'])->name('service.clock.update');
        Route::delete('service/clock/{clockId}/delete', [ServiceController::class, 'deleteClock'])->name('service.clock.delete');

        Route::get('service/fulfill-order/{orderId}', [ServiceController::class, 'fulfillOrder'])->name('service.fulfill_order')->middleware('permission:service.fulfill_order.view');
        Route::post('service/fulfill-order/{orderId}/book', [ServiceController::class, 'fulfillOrder_book'])->name('service.fulfill_order.book');
        Route::post('order/{orderId}/update-checklist', [ServiceController::class, 'updateChecklist'])->name('service.order.update_checklist');
        Route::post('order/{orderId}/update-consumables', [ServiceController::class, 'updateConsumables'])->name('service.order.update_consumables');
        Route::post('order/{orderId}/employee-performance/store', [ServiceController::class, 'storeEmployeePerformance'])->name('service.order.employee_performance.store');

        Route::get('order/{orderId}/audit', [ServiceController::class, 'serviceAudit'])->name('service.order.audit');
        Route::get('service/service-dashboard/{orderId}', [ServiceController::class, 'service_dashboard'])->name('service.service_dashboard');
        Route::post('service/slot/{slotId}/equipment/assign', [ServiceController::class, 'assignEquipment'])->name('service.slot.assign_equipment');
        Route::post('service/slot/{slotId}/equipment/{equipmentId}/remove', [ServiceController::class, 'removeEquipment'])->name('service.slot.remove_equipment');
        Route::post('order/{orderId}/hotel/save', [ServiceController::class, 'saveHotelDetails'])->name('service.order.hotel.save');
        Route::post('order/{orderId}/hotel/delete', [ServiceController::class, 'deleteHotelDetail'])->name('service.order.hotel.delete');
        Route::post('order/{orderId}/atp/save', [ServiceController::class, 'saveAtpDetails'])->name('service.order.atp.save');
        Route::post('order/{orderId}/atp/delete', [ServiceController::class, 'deleteAtpDetail'])->name('service.order.atp.delete');

        Route::post('order/{orderId}/room-record/save', [ServiceController::class, 'saveRoomRecord'])->name('service.order.room_record.save');
        Route::post('room-record/{recordId}/delete', [ServiceController::class, 'deleteRoomRecord'])->name('service.order.room_record.delete');

        Route::post('order/{orderId}/equipment-record/save', [ServiceController::class, 'saveEquipmentRecord'])->name('service.order.equipment_record.save');
        Route::post('equipment-record/{recordId}/delete', [ServiceController::class, 'deleteEquipmentRecord'])->name('service.order.equipment_record.delete');

        Route::post('order/{orderId}/clean-patch/save', [ServiceController::class, 'saveCleanPatch'])->name('service.order.clean_patch.save');
        Route::post('clean-patch/{patchId}/delete', [ServiceController::class, 'deleteCleanPatch'])->name('service.order.clean_patch.delete');

        Route::post('order/{orderId}/cancel', [ServiceController::class, 'cancelOrder'])->name('service.order.cancel');
        Route::post('order/{orderId}/reopen', [ServiceController::class, 'reopenOrder'])->name('service.order.reopen');
        // Route::post('order/{orderId}/status', [ServiceController::class, 'updateOrderStatus'])->name('service.order.update_status');
        // Route::post('service/slot/{slotId}/status', [ServiceController::class, 'updateSlotStatus'])->name('service.slot.update_status');
    });

    Route::get('calendar', [ServiceController::class, 'calendar'])->name('calendar.index');
    Route::get('calendar/orders', [ServiceController::class, 'calendarOrders'])->name('calendar.orders');

    Route::get('/scheduling-calendar', [ServiceController::class, 'schedulingCalendar'])->name('scheduling_calendar.index');
    Route::get('/scheduling-calendar/orders', [ServiceController::class, 'schedulingCalendarOrders'])->name('scheduling_calendar.orders');

    Route::get('/vehicle-planning', [ServiceController::class, 'vehiclePlanning'])->name('vehicle.planning');
    Route::get('/team-availability', [ServiceController::class, 'teamAvailability'])->name('team.availability');

    Route::get('/all-schedules', [ServiceController::class, 'all_schedules'])->name('all_schedules.index');
    Route::get('/my-jobs', [ServiceController::class, 'myJobs'])->name('my-jobs.index');

    Route::get('/labor-analysis', [ServiceController::class, 'labor_analysis'])->name('service.labor_analysis');
});
