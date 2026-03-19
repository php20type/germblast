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
        Schema::create('service_order_slot_clocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_slot_id')->index();
            $table->string('type')->comment('service, travel, break');
            $table->unsignedBigInteger('clocked_by')->nullable()->index();
            $table->timestamp('clocked_in_at')->nullable();
            $table->timestamp('clocked_out_at')->nullable();

            // Auto-calculated on clock out
            $table->decimal('clocked_hours', 8, 2)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_slot_clocks');
    }
};
