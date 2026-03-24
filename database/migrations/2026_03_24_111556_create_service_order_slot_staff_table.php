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
        Schema::create('service_order_slot_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_slot_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->decimal('slot_hours', 8, 2)->default(0);   
            $table->unique(['service_order_slot_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_slot_staff');
    }
};
