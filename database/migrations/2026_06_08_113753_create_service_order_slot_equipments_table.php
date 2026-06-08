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
        if (!Schema::hasTable('service_order_slot_equipments')) {
            Schema::create('service_order_slot_equipments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_order_slot_id')->index();
                $table->unsignedBigInteger('equipment_id')->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_slot_equipments');
    }
};
