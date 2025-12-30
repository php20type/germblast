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
        Schema::create('biological_response_intake', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();

            // Basic Information
            $table->string('project_name');
            $table->string('project_address')->nullable();
            $table->string('project_city')->nullable();
            $table->string('project_state')->nullable();
            $table->string('project_zip')->nullable();
            $table->string('project_leader')->nullable();
            $table->text('comments')->nullable();

            // Frontend Management Information
            $table->string('facility_type')->comment('residential, institutional, commercial and etc')->nullable();
            $table->string('casualties_or_illnesses')->comment('death , illness and etc')->nullable();
            $table->integer('estimated_man_hours')->nullable();
            $table->integer('estimated_people')->nullable();
            $table->string('type_of_loss')->comment('drug , trauma , zoonotic , infectious')->nullable();

            // Additional Contact Information
            $table->string('contact_name')->nullable();
            $table->string('contact_title')->nullable();
            $table->string('contact_phone')->nullable();

            // Insurance Information
            $table->boolean('insurance_notified')->default(0);
            $table->string('insurance_company_name')->nullable();
            $table->string('insurance_phone')->nullable();
            $table->boolean('coverage_determination')->default(0);
            $table->decimal('coverage_amount', 12, 2)->nullable();
            $table->decimal('deductible', 12, 2)->nullable();
            $table->string('claim_number')->nullable();
            $table->string('adjuster_phone')->nullable();
            $table->string('insurance_email')->nullable();
            $table->decimal('limit_or_cap', 12, 2)->nullable();

            // Illness & Death Information
            $table->boolean('person_travelled_outside')->default(0);
            $table->boolean('diagnosis')->default(0);
            $table->integer('number_of_diagnosis')->nullable();

            $table->string('cause_of_death')->nullable();
            $table->integer('number_of_deaths')->nullable();
            $table->boolean('body_unattended')->default(0);
            $table->integer('unattended_days')->nullable();

            $table->boolean('more_than_2_rooms')->default(0);
            $table->boolean('high_consequence_infectious_disease')->default(0);
            $table->boolean('police_cleanup')->default(0);
            $table->string('police_contact')->nullable();
            $table->string('police_number')->nullable();
            $table->boolean('overdose')->default(0);
            $table->boolean('gunshot')->default(0);

            // Cost Estimates
            $table->decimal('environment_hourly_rate', 10, 2)->nullable();
            $table->decimal('environment_response_total', 12, 2)->nullable();
            $table->decimal('supplies_hourly_rate', 10, 2)->nullable();
            $table->decimal('response_supplies_total', 12, 2)->nullable();
            $table->decimal('sub_total', 12, 2)->nullable();
            $table->decimal('waste_disposal', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biological_response_intake');
    }
};
