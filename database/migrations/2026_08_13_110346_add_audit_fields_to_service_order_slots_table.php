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
            $table->boolean('is_audit')->default(false);
            $table->boolean('is_audit_finalized')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_slots', function (Blueprint $table) {
            $table->dropColumn(['is_audit', 'is_audit_finalized']);
        });
    }
};
