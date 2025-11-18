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
        Schema::create('survey_facility_atp', function (Blueprint $table) {
            // Link to survey facility (index only, no foreign key)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('survey_facility_id')->nullable();

            // ATP test fields
            $table->string('location')->nullable();
            $table->string('atp_value')->nullable();

            // File upload fields
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('lead_id');
            $table->index('survey_facility_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_facility_atp');
    }
};
