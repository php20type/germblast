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
        Schema::table('service_order_slot_clocks', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable()->after('clocked_by');
            $table->unsignedBigInteger('driver_user_id')->nullable()->after('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_slot_clocks', function (Blueprint $table) {
            $table->dropColumn(['vehicle_id', 'driver_user_id']);
        });
    }
};
