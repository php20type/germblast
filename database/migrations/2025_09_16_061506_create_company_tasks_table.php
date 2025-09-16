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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_tasks');
    }
};
