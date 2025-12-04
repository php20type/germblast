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
         Schema::table('survey_facilities', function (Blueprint $table) {
            $table->decimal('total_cost', 10, 2)->nullable()->after('man_hours_cost');
        });

        Schema::table('equipment_evaluations', function (Blueprint $table) {
            $table->decimal('total_cost', 10, 2)->nullable()->after('cleaning_man_hours_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_facilities', function (Blueprint $table) {
            $table->dropColumn('total_cost');
        });

        Schema::table('equipment_evaluations', function (Blueprint $table) {
            $table->dropColumn('total_cost');
        });
    }
};
