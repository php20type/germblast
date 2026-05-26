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
        Schema::table('service_orders', function (Blueprint $table) {
            // Drop old single-value consumable fields
            $table->dropColumn([
                'microfiber',
                'swabs',
                'oxivir_jars',
                'opticide_gallons',
                'halomist',
                'water'
            ]);

            // Add new pre/post checklist consumables fields
            $table->json('pre_checklist_consumables')->nullable()->after('plan_debrief');
            $table->json('post_checklist_consumables')->nullable()->after('pre_checklist_consumables');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn(['pre_checklist_consumables', 'post_checklist_consumables']);

            $table->integer('microfiber')->nullable()->default(0)->after('plan_debrief');
            $table->integer('swabs')->nullable()->default(0)->after('microfiber');
            $table->integer('oxivir_jars')->nullable()->default(0)->after('swabs');
            $table->integer('opticide_gallons')->nullable()->default(0)->after('oxivir_jars');
            $table->integer('halomist')->nullable()->default(0)->after('opticide_gallons');
            $table->integer('water')->nullable()->default(0)->after('halomist');
        });
    }
};
