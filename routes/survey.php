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

        Route::get('{lead}/survey/proposal', [SurveyProposalController::class, 'survey_proposal'])
            ->middleware('permission:survey.proposal.view')
            ->name('survey.proposal');

        Route::post('{lead}/survey/proposal/store', [SurveyProposalController::class, 'survey_proposal_store'])
            ->middleware('permission:survey.proposal.create')
            ->name('survey.proposal.store');

    });

    /*
    |--------------------------------------------------------------------------
    | Survey Proposal (Facility, Equipment, Pricing, View)
    |--------------------------------------------------------------------------
    */
    Route::prefix('survey/proposal')->name('survey.proposal.')->group(function () {

        Route::middleware('permission:survey.proposal.edit')->group(function () {

            Route::get('{survey_proposal}/facility', [SurveyProposalController::class, 'survey_facility'])
                ->name('facility');

            Route::post('{survey_proposal}/facility/store', [SurveyProposalController::class, 'survey_facility_store'])
                ->name('facility.store');

            Route::get('facility/{facility}/edit', [SurveyProposalController::class, 'survey_facility_edit'])
                ->name('facility.edit');

            Route::post('{facility}/facility/update', [SurveyProposalController::class, 'survey_facility_update'])
                ->name('facility.update');

            Route::post('facility/{facility}/add-to-company', [SurveyProposalController::class, 'addFacilityToCompany'])
                ->name('facility.add_to_company');


            Route::get('{survey_proposal}/equipment', [SurveyProposalController::class, 'survey_equipment'])
                ->name('equipment');

            Route::post('{survey_proposal}/equipment/store', [SurveyProposalController::class, 'survey_equipment_store'])
                ->name('equipment.store');

            Route::get('equipment/{equipment}/edit', [SurveyProposalController::class, 'survey_equipment_edit'])
                ->name('equipment.edit');

            Route::post('{equipment}/equipment/update', [SurveyProposalController::class, 'survey_equipment_update'])
                ->name('equipment.update');

            Route::get('{survey_proposal}/pricing', [SurveyProposalController::class, 'pricing_proposal'])
                ->name('pricing.proposal');

        });

        Route::get('view/{id}', [SurveyProposalController::class, 'survey_view'])
            ->middleware('permission:survey.proposal.view')
            ->name('view');

        Route::get('download/{id}', [SurveyProposalController::class, 'survey_download'])
            ->middleware('permission:survey.proposal.view')
            ->name('download');

        // Action buttons
        Route::post('{survey_proposal}/approve', [SurveyProposalController::class, 'approve'])
            ->name('approve');

        Route::post('{survey_proposal}/reject', [SurveyProposalController::class, 'reject'])
            ->name('reject');

    });

    /*
    |--------------------------------------------------------------------------
    | Pricing Proposal CRUD
    |--------------------------------------------------------------------------
    */
    Route::prefix('pricing-proposal')->name('pricing_proposal.')->group(function () {

        Route::post('{survey_proposal}/store', [SurveyProposalController::class, 'pricing_store'])
            ->middleware('permission:pricing.proposal.create')
            ->name('store');

        Route::get('{pricing}/edit', [SurveyProposalController::class, 'pricing_proposal_edit'])
            ->middleware('permission:pricing.proposal.edit')
            ->name('edit');

        Route::post('{pricing}/update', [SurveyProposalController::class, 'updateExistingPricing'])
            ->middleware('permission:pricing.proposal.edit')
            ->name('update');

        Route::post('delete', [SurveyProposalController::class, 'deletePricing'])
            ->middleware('permission:pricing.proposal.delete')
            ->name('delete');

    });

});
