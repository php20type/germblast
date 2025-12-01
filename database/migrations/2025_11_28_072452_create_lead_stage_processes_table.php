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
        Schema::create('lead_stage_processes', function (Blueprint $table) {
            $table->id();

              // Lead reference
            $table->unsignedBigInteger('lead_id');

            // ---- INITIAL MEETING ----
            $table->datetime('initial_meeting_scheduled_at')->nullable();
            $table->datetime('initial_meeting_completed_at')->nullable();
            $table->unsignedBigInteger('initial_meeting_completed_by')->nullable();

            // ---- SITE SURVEY ----
            $table->datetime('site_survey_scheduled_at')->nullable();
            $table->datetime('site_survey_completed_at')->nullable();
            $table->unsignedBigInteger('site_survey_completed_by')->nullable();

            // ---- INDEX ----
            $table->index('lead_id');
            $table->index('initial_meeting_completed_by');
            $table->index('site_survey_completed_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_stage_processes');
    }
};
