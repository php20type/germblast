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
            // Pre Checklist
            $table->text('service_plan_narrative')->nullable()->after('status');
            $table->text('sales_narrative')->nullable()->after('service_plan_narrative');
            $table->string('plan_review_status')->nullable()->after('sales_narrative');

            // Post Checklist
            $table->text('plan_debrief')->nullable()->after('plan_review_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn([
                'service_plan_narrative',
                'sales_narrative',
                'plan_review_status',
                'plan_debrief'
            ]);
        });
    }
};
