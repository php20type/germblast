<?php

use App\Http\Controllers\SurveyProposalController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Lead → Survey Proposal
    |--------------------------------------------------------------------------
    */
    Route::prefix('lead')->name('lead.')->group(function () {

        Route::get('{lead}/survey/proposal', [SurveyProposalController::class, 'survey_proposal'])->name('survey.proposal');
        Route::post('{lead}/survey/proposal/store', [SurveyProposalController::class, 'survey_proposal_store'])->name('survey.proposal.store');

    });

    /*
    |--------------------------------------------------------------------------
    | Survey Proposal (Facility, Equipment, Pricing, View)
    |--------------------------------------------------------------------------
    */
    Route::prefix('survey/proposal')->name('survey.proposal.')->group(function () {

        Route::get('{survey_proposal}/facility', [SurveyProposalController::class, 'survey_facility'])->name('facility');
        Route::post('{survey_proposal}/facility/store', [SurveyProposalController::class, 'survey_facility_store'])->name('facility.store');
        Route::get('facility/{facility}/edit', [SurveyProposalController::class, 'survey_facility_edit'])->name('facility.edit');
        Route::post('{facility}/facility/update', [SurveyProposalController::class, 'survey_facility_update'])->name('facility.update');

        Route::get('{survey_proposal}/equipment', [SurveyProposalController::class, 'survey_equipment'])->name('equipment');
        Route::post('{survey_proposal}/equipment/store', [SurveyProposalController::class, 'survey_equipment_store'])->name('equipment.store');
        Route::get('equipment/{equipment}/edit', [SurveyProposalController::class, 'survey_equipment_edit'])->name('equipment.edit');
        Route::post('{equipment}/equipment/update', [SurveyProposalController::class, 'survey_equipment_update'])->name('equipment.update');

        Route::get('{survey_proposal}/pricing', [SurveyProposalController::class, 'pricing_proposal'])->name('pricing.proposal');

        Route::get('view/{id}', [SurveyProposalController::class, 'survey_view'])->name('view');
        Route::get('download/{id}', [SurveyProposalController::class, 'survey_download'])->name('download');

    });

    /*
    |--------------------------------------------------------------------------
    | Pricing Proposal CRUD
    |--------------------------------------------------------------------------
    */
    Route::prefix('pricing-proposal')->name('pricing_proposal.')->group(function () {

        Route::post('{survey_proposal}/store', [SurveyProposalController::class, 'pricing_store'])->name('store');
        Route::get('{pricing}/edit', [SurveyProposalController::class, 'pricing_proposal_edit'])->name('edit');
        Route::post('{pricing}/update', [SurveyProposalController::class, 'updateExistingPricing'])->name('update');
        Route::post('delete', [SurveyProposalController::class, 'deletePricing'])->name('delete');

    });

});
