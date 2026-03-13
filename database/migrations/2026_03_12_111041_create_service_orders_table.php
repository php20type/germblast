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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('service_id')->index();

            $table->string('order_no')->nullable();

            // Intended date
            $table->date('intended_date')->nullable();

            // Scheduled times
            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_start_time')->nullable();
            $table->time('scheduled_end_time')->nullable();
            $table->time('scheduled_arrival_time')->nullable();
            $table->string('scheduled_office')->nullable();
            $table->integer('scheduled_recurrence_count')->nullable();
            $table->string('scheduled_recurrence_rule')->default('N/A');

            $table->enum('meet', ['office', 'facility'])->default('office');
            $table->boolean('overnight')->default(0);

            // Clock in/out
            $table->unsignedBigInteger('clocked_by')->nullable();
            $table->timestamp('clocked_in_at')->nullable();
            $table->timestamp('clocked_out_at')->nullable();
            $table->text('job_notes')->nullable();

            $table->string('status')->default('pending'); // pending, completed, cancelled

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
