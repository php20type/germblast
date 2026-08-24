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
        Schema::create('service_order_atp_samples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();
            $table->string('atp_type')->comment('pre or post');
            $table->string('facility_id');
            $table->string('result');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn('atp_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->json('atp_details')->nullable()->after('hotel_details');
        });

        Schema::dropIfExists('service_order_atp_samples');
    }
};
