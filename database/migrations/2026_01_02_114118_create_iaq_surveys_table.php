<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iaq_surveys', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id')->index();

            /* =====================
               BASIC INFORMATION
            ===================== */
            $table->string('survey_name')->nullable();
            $table->text('building_description')->nullable();
            $table->text('reported_issues')->nullable();

            /* =====================
               GENERAL WALKTHROUGH
            ===================== */
            $table->boolean('odor')->default(false);
            $table->text('odor_desc')->nullable();

            $table->boolean('dirty_unsanitary')->default(false);
            $table->text('dirty_unsanitary_desc')->nullable();

            $table->boolean('visible_microbial')->default(false);
            $table->text('visible_microbial_desc')->nullable();

            $table->boolean('material_staining')->default(false);
            $table->text('material_staining_desc')->nullable();

            $table->boolean('adequate_ventilation')->default(false);
            $table->text('adequate_ventilation_desc')->nullable();

            $table->boolean('hvac_duct_blocked')->default(false);
            $table->text('hvac_duct_blocked_desc')->nullable();

            $table->boolean('filter_adequate')->default(false);
            $table->text('filter_adequate_desc')->nullable();
            $table->string('filter_change_freq')->nullable();

            $table->boolean('chemical_storage')->default(false);
            $table->text('chemical_storage_desc')->nullable();

            $table->boolean('temp_within_ashre')->default(false);
            $table->text('temp_within_ashre_desc')->nullable();

            $table->boolean('overcrowding')->default(false);
            $table->text('overcrowding_desc')->nullable();

            $table->boolean('poor_iaq_activities')->default(false);
            $table->text('poor_iaq_activities_desc')->nullable();

            $table->boolean('water_intrusion')->default(false);
            $table->text('water_intrusion_desc')->nullable();

            $table->boolean('carpet_present')->default(false);
            $table->text('carpet_present_desc')->nullable();
            $table->string('carpet_clean_freq')->nullable();

            $table->boolean('pest_management')->default(false);
            $table->text('pest_management_desc')->nullable();
            $table->string('pest_management_freq')->nullable();

            $table->boolean('dirty_air_diffusers')->default(false);
            $table->text('dirty_air_diffusers_desc')->nullable();

            $table->boolean('mhvac_equipment')->default(false);
            $table->text('mhvac_equipment_desc')->nullable();

            /* =====================
               SAMPLING DETAILS
            ===================== */
            $table->string('location')->nullable();
            $table->string('parameter')->nullable();
            $table->string('volume')->nullable();
            $table->string('sampler')->nullable();
            $table->text('result')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iaq_surveys');
    }
};
