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
        Schema::table('survey_proposals', function (Blueprint $table) {
            // drop old column
            if (Schema::hasColumn('survey_proposals', 'client_name')) {
                $table->dropColumn('client_name');
            }

            $table->unsignedBigInteger('company_id')->nullable()->after('lead_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('survey_proposals', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropColumn('company_id');

            $table->string('client_name')->nullable()->after('lead_id');
        });
    }
};
