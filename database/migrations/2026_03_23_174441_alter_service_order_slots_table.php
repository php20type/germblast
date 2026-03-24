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
        Schema::table('service_order_slots', function (Blueprint $table) {
            $table->dropColumn('scheduled_office');
            $table->unsignedBigInteger('scheduled_office')->nullable()->after('scheduled_arrival_time');
            $table->index('scheduled_office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_slots', function (Blueprint $table) {
            $table->dropColumn('scheduled_office');
            $table->string('scheduled_office')->nullable()->after('scheduled_arrival_time');
        });
    }
};
