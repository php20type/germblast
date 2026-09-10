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
            $table->dropColumn(['confirmed_by', 'confirmed_at']);
            $table->unsignedBigInteger('last_updated_by')->nullable()->after('is_confirmed')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_slots', function (Blueprint $table) {
            $table->dropColumn('last_updated_by');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('is_confirmed')->index();
            $table->timestamp('confirmed_at')->nullable()->after('is_confirmed');
        });
    }
};
