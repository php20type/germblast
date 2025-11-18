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
        Schema::create('survey_facilities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('survey_proposal_id')->nullable();

            // Facility fields
            $table->string('facility_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('facility_type')->nullable();
            // Additional facility details
            $table->integer('square_footage')->nullable();
            $table->integer('offices')->nullable();
            $table->integer('standard_bathrooms')->nullable();   // Standard (Community) Bathrooms
            $table->integer('single_bathrooms')->nullable();
            $table->integer('football_lockerroom')->nullable();
            $table->integer('regular_lockerrooms')->nullable();
            $table->integer('weight_room')->nullable();
            $table->integer('training_room')->nullable();
            $table->integer('equipment_room')->nullable();
            $table->integer('coachs_office')->nullable();
            $table->integer('shoulder_pads')->nullable();
            $table->integer('helmets')->nullable();
            $table->integer('wrestling_mats')->nullable();

            // Total man hours + cost
            $table->integer('man_hours')->nullable();
            $table->decimal('man_hours_cost', 15, 2)->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('lead_id');
            $table->index('survey_proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_facilities');
    }
};
