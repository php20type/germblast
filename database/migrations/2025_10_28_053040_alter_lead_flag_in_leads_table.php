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
            // Drop the old JSON field
            $table->dropColumn('lead_flags');

            // Add new boolean fields
            $table->boolean('is_watching')->default(0)->after('lead_status')->comment('1 = Watching, 0 = Not Watching');
            $table->boolean('is_hot')->default(0)->after('is_watching')->comment('1 = Hot, 0 = Not Hot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['is_watching', 'is_hot']);
            $table->json('lead_flags')->nullable()->comment('watching, hot');
        });
    }
};
