<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('company_tasks');
        Schema::dropIfExists('people_tasks');
        Schema::dropIfExists('lead_tasks');
        Schema::dropIfExists('tasks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::create('company_tasks', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamp('created_time')->nullable();
            $table->timestamp('due_time')->nullable();
            $table->timestamp('completed_time')->nullable();

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_legacy_id')->nullable();

            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');
            $table->string('assignee_name')->nullable();

            $table->unsignedBigInteger('completed_user_id')->nullable();
            $table->foreign('completed_user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('completed_user_name')->nullable();

            $table->timestamps();

        });


         Schema::create('people_tasks', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamp('created_time')->useCurrent();
            $table->timestamp('due_time')->nullable();
            $table->timestamp('completed_time')->nullable();

            // relations
            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('people')->cascadeOnDelete();

            $table->string('subject_type')->default('People');
            $table->unsignedBigInteger('subject_legacy_id')->nullable();

            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users')->nullOnDelete();

            $table->string('assignee_name')->nullable();

            $table->unsignedBigInteger('completed_user_id')->nullable();
            $table->foreign('completed_user_id')->references('id')->on('users')->nullOnDelete();

            $table->string('completed_user_name')->nullable();

            $table->timestamps();

        });


        Schema::create('lead_tasks', function (Blueprint $table) {
             $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamp('created_time')->useCurrent();
            $table->timestamp('due_time')->nullable();
            $table->timestamp('completed_time')->nullable();

            // relations
            $table->unsignedBigInteger('lead_id');
            $table->string('subject_type')->default('People');
            $table->unsignedBigInteger('subject_legacy_id')->nullable();

            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->string('assignee_name')->nullable();

            $table->unsignedBigInteger('completed_user_id')->nullable();
            $table->string('completed_user_name')->nullable();

            $table->timestamps();

            // foreign keys (optional, depends on your setup)
            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnDelete();
            $table->foreign('assignee_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('completed_user_id')->references('id')->on('users')->nullOnDelete();

        });
    }
};
