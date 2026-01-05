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
        Schema::create('water_management_phase', function (Blueprint $table) {
             $table->id();

            $table->unsignedBigInteger('company_id')->index();

              /* =====================
               BASIC DETAILS
            ===================== */
            $table->string('survey_name');
            $table->string('municipal_water_supplier')->nullable();

            /* =====================
               FACILITY RISK FACTORS
            ===================== */
            $table->boolean('is_healthcare_facility')->default(false);
            $table->boolean('houses_elderly_patients')->default(false);
            $table->boolean('has_multiple_housing_units')->default(false);
            $table->boolean('has_more_than_two_floors')->default(false);
            $table->boolean('has_cooling_tower')->default(false);
            $table->boolean('has_hot_tub_or_spa')->default(false);
            $table->boolean('has_indoor_fountain')->default(false);
            $table->boolean('has_central_mister_or_humidifier')->default(false);
            $table->boolean('conducts_organ_transplant')->default(false);
            $table->boolean('history_of_legionella')->default(false);

            /* =====================
               MONITORING DETAILS
            ===================== */
            $table->text('current_monitoring_activities')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_management_phase');
    }
};
