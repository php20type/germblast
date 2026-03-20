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
        Schema::table('service_orders', function (Blueprint $table) {
            $table->integer('microfiber')->default(0)->after('status');
            $table->integer('swabs')->default(0)->after('microfiber');
            $table->integer('oxivir_jars')->default(0)->after('swabs');
            $table->integer('opticide_gallons')->default(0)->after('oxivir_jars');
            $table->integer('halomist')->default(0)->after('opticide_gallons');
            $table->integer('water')->default(0)->after('halomist');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn(['microfiber','swabs','oxivir_jars','opticide_gallons','halomist','water']);
        });
    }
};
