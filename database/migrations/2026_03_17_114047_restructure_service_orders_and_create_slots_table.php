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
         // Remove scheduling and clock columns from service_orders
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn([
                'scheduled_date',
                'scheduled_start_time',
                'scheduled_end_time',
                'scheduled_arrival_time',
                'scheduled_office',
                'scheduled_recurrence_count',
                'scheduled_recurrence_rule',
                'meet',
                'overnight',
                'clocked_by',
                'clocked_in_at',
                'clocked_out_at',
                'job_notes',
            ]);
        });

        // Create service_order_slots table
        Schema::create('service_order_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();

            $table->datetime('scheduled_start_time')->nullable();
            $table->datetime('scheduled_end_time')->nullable();
            $table->time('scheduled_arrival_time')->nullable();
            $table->string('scheduled_office')->nullable();
            $table->integer('scheduled_recurrence_count')->nullable();
            $table->string('scheduled_recurrence_rule')->default('N/A');
            $table->decimal('scheduled_hours', 8, 2)->nullable();
            $table->enum('meet', ['office', 'facility'])->nullable();
            $table->boolean('overnight')->default(0);

            $table->unsignedBigInteger('confirmed_by')->nullable()->index();
            $table->boolean('is_confirmed')->default(0);
            $table->timestamp('confirmed_at')->nullable();
            $table->text('confirmation_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_slots');

        Schema::table('service_orders', function (Blueprint $table) {
            $table->date('scheduled_date')->nullable()->after('intended_date');
            $table->time('scheduled_start_time')->nullable()->after('scheduled_date');
            $table->time('scheduled_end_time')->nullable()->after('scheduled_start_time');
            $table->time('scheduled_arrival_time')->nullable()->after('scheduled_end_time');
            $table->string('scheduled_office')->nullable()->after('scheduled_arrival_time');
            $table->integer('scheduled_recurrence_count')->nullable()->after('scheduled_office');
            $table->string('scheduled_recurrence_rule')->default('N/A')->after('scheduled_recurrence_count');
            $table->enum('meet', ['office', 'facility'])->default('office')->after('scheduled_recurrence_rule');
            $table->boolean('overnight')->default(0)->after('meet');
            $table->unsignedBigInteger('clocked_by')->nullable()->after('overnight');
            $table->timestamp('clocked_in_at')->nullable()->after('clocked_by');
            $table->timestamp('clocked_out_at')->nullable()->after('clocked_in_at');
            $table->text('job_notes')->nullable()->after('clocked_out_at');
        });
    }
};
