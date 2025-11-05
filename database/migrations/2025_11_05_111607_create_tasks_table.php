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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->string('owner_type')->comment('company, people, or lead')->nullable();
            $table->unsignedBigInteger('owner_id')->comment('ID of the owner record (company_id, people_id, or lead_id)')->nullable();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamp('created_time')->nullable();
            $table->timestamp('due_time')->nullable();
            $table->timestamp('completed_time')->nullable();

            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_legacy_id')->nullable();

            $table->unsignedBigInteger('assignee_id')->nullable();
            // We are not defining the relation here as its creating some issue in cpanel while migrating
            $table->string('assignee_name')->nullable();

            $table->unsignedBigInteger('completed_user_id')->nullable();
            // We are not defining the relation here as its creating some issue in cpanel while migrating
            $table->string('completed_user_name')->nullable();

            $table->timestamps();

            $table->index(['owner_type', 'owner_id']);
            $table->index('assignee_id');
            $table->index('completed_user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
