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
        Schema::table('equipment_status_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('territory_id')->nullable()->change();
            $table->unsignedBigInteger('changed_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_status_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('territory_id')->nullable(false)->change();
            $table->unsignedBigInteger('changed_by')->nullable(false)->change();
        });
    }
};
