<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_order_room_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();
            $table->string('barcode');
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('service_order_equipment_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();
            $table->string('barcode');
            $table->string('status'); // 'service', 'washed'
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('service_order_clean_patches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();
            $table->string('barcode');
            $table->string('patch_size'); // 'large_rectangle', 'medium_rectangle', etc.
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_clean_patches');
        Schema::dropIfExists('service_order_equipment_records');
        Schema::dropIfExists('service_order_room_records');
    }
};
