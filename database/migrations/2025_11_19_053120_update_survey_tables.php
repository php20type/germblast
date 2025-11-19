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
        Schema::table('equipment_evaluations', function (Blueprint $table) {
            if (Schema::hasColumn('equipment_evaluations', 'lead_id')) {
                $table->dropColumn('lead_id');
            }
            if (! Schema::hasColumn('equipment_evaluations', 'name')) {
                $table->string('name')->nullable()->after('survey_proposal_id');
            }
        });

        Schema::table('survey_facilities', function (Blueprint $table) {
            if (Schema::hasColumn('survey_facilities', 'lead_id')) {
                $table->dropColumn('lead_id');
            }
        });

        Schema::table('survey_facility_maps', function (Blueprint $table) {
            if (Schema::hasColumn('survey_facility_maps', 'lead_id')) {
                $table->dropColumn('lead_id');
            }
        });

        Schema::table('survey_facility_atp', function (Blueprint $table) {
            if (! Schema::hasColumn('survey_facility_atp', 'id')) {
                $table->id()->first();
            }
            if (Schema::hasColumn('survey_facility_atp', 'lead_id')) {
                $table->dropColumn('lead_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_evaluations', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable();
            if (Schema::hasColumn('equipment_evaluations', 'name')) {
                $table->dropColumn('name');
            }
        });

        Schema::table('survey_facilities', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable();
        });

        Schema::table('survey_facility_maps', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable();
        });

        Schema::table('survey_facility_atp', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id')->nullable();
        });
    }
};
