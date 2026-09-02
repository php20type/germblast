<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin/reports')
    ->name('admin.reports.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/new-leads', [ReportController::class, 'newLeads'])->name('new_leads');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/losses/leads', [ReportController::class, 'lostLeads'])->name('losses.leads');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
    });
