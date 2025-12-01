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
         Schema::table('leads', function (Blueprint $table) {
            $table->string('forecasting_status')->default('pending')->after('expected_first_date');
        });

        // Add status to survey_proposals table
        Schema::table('survey_proposals', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('supplemental_body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('forecasting_status');
        });

        Schema::table('survey_proposals', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
