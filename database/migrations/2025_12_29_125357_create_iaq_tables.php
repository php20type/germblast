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
        Schema::create('iaq_zones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_location_id')->index();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('iaq_devices', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedBigInteger('iaq_zone_id')->index();
            $table->string('node_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iaq_zones');
        Schema::dropIfExists('iaq_devices');
    }
};
