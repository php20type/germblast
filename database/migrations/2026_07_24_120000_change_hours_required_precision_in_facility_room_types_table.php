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
        Schema::table('facility_room_types', function (Blueprint $table) {
            $table->decimal('hours_required', 8, 3)->default(0.5)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_room_types', function (Blueprint $table) {
            $table->decimal('hours_required', 8, 2)->default(0.5)->change();
        });
    }
};