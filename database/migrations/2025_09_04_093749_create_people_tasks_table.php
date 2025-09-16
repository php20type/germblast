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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_tasks');
    }
};
