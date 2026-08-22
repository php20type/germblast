<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::prefix('settings')->name('settings.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Index Page Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/', [SettingController::class, 'index'])->name('index');

        /*
        |--------------------------------------------------------------------------
        | Activity Type Routes
        |--------------------------------------------------------------------------
        */
        Route::get('activity_type', [SettingController::class, 'activity_type'])->name('activity_type');
        Route::post('activity_type', [SettingController::class, 'activity_type_store'])->name('activity_type.store');
        Route::post('activity_type/update/{id}', [SettingController::class, 'activity_type_update'])->name('activity_type.update');

        /*
        |--------------------------------------------------------------------------
        | Competitor Routes
        |--------------------------------------------------------------------------
        */
        Route::get('competitor', [SettingController::class, 'competitor'])->name('competitor');
        Route::post('competitor', [SettingController::class, 'competitor_store'])->name('competitor.store');
        Route::post('competitor/update/{id}', [SettingController::class, 'competitor_update'])->name('competitor.update');

        /*
        |--------------------------------------------------------------------------
        | Industry Routes
        |--------------------------------------------------------------------------
        */
        Route::get('industry', [SettingController::class, 'industry'])->name('industry');
        Route::post('industry', [SettingController::class, 'industry_store'])->name('industry.store');
        Route::post('industry/update/{id}', [SettingController::class, 'industry_update'])->name('industry.update');

        /*
        |--------------------------------------------------------------------------
        | Channel Source Routes
        |--------------------------------------------------------------------------
        */
        Route::get('channel_source', [SettingController::class, 'channel_source'])->name('channel_source');
        Route::post('channel_source', [SettingController::class, 'source_store'])->name('source.store');
        Route::post('channel_source/update/{id}', [SettingController::class, 'source_update'])->name('source.update');

        /*
        |--------------------------------------------------------------------------
        | Company Type Routes
        |--------------------------------------------------------------------------
        */
        Route::get('company_type', [SettingController::class, 'company_type'])->name('company_type');
        Route::post('company_type', [SettingController::class, 'company_type_store'])->name('company_type.store');
        Route::post('company_type/update/{id}', [SettingController::class, 'company_type_update'])->name('company_type.update');

        /*
        |--------------------------------------------------------------------------
        | Market Routes
        |--------------------------------------------------------------------------
        */
        Route::get('market', [SettingController::class, 'market'])->name('market');
        Route::post('market', [SettingController::class, 'market_store'])->name('market.store');
        Route::post('market/update/{id}', [SettingController::class, 'market_update'])->name('market.update');

        /*
        |--------------------------------------------------------------------------
        | Tag Routes
        |--------------------------------------------------------------------------
        */
        Route::get('tag', [SettingController::class, 'tag'])->name('tag');
        Route::post('tag', [SettingController::class, 'tag_store'])->name('tag.store');
        Route::post('tag/update/{id}', [SettingController::class, 'tag_update'])->name('tag.update');

        /*
        |--------------------------------------------------------------------------
        | Product Routes
        |--------------------------------------------------------------------------
        */
        Route::get('product', [SettingController::class, 'product'])->name('product');
        Route::post('product', [SettingController::class, 'product_store'])->name('product.store');
        Route::post('product/update/{id}', [SettingController::class, 'product_update'])->name('product.update');

        /*
        |--------------------------------------------------------------------------
        | Territory Routes
        |--------------------------------------------------------------------------
        */
        Route::get('territory', [SettingController::class, 'territory'])->name('territory');
        Route::post('territory', [SettingController::class, 'territory_store'])->name('territory.store');
        Route::post('territory/update/{id}', [SettingController::class, 'territory_update'])->name('territory.update');
        Route::post('territory/update-locations/{id}', [SettingController::class, 'territory_update_locations'])->name('territory.update_locations');

    });


});

Route::get('/states/{countryId}', [SettingController::class, 'getStatesByCountry'])->name('get.states');
Route::get('/cities/{stateId}', [SettingController::class, 'getCitiesByState'])->name('get.cities');
