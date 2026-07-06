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
        Schema::table('service_order_slot_clocks', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('job_clock_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_clock_id')->index();
            $table->string('action')->default('Edit');
            
            $table->string('old_type')->nullable();
            $table->string('new_type')->nullable();
            
            $table->timestamp('old_clocked_in_at')->nullable();
            $table->timestamp('new_clocked_in_at')->nullable();
            
            $table->timestamp('old_clocked_out_at')->nullable();
            $table->timestamp('new_clocked_out_at')->nullable();
            
            $table->unsignedBigInteger('user_id')->nullable()->index(); // User who made the change
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_clock_audit_logs');
        Schema::table('service_order_slot_clocks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
