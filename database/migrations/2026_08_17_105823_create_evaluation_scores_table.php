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
        Schema::create('evaluation_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_user_id')->index();
            $table->unsignedBigInteger('evaluator_user_id')->nullable()->index();
            $table->string('evaluation_type')->nullable(); // 'general' or 'sit'
            $table->unsignedBigInteger('evaluation_request_id')->nullable()->index();
            $table->unsignedBigInteger('sit_evaluation_attempt_id')->nullable()->index();
            $table->unsignedBigInteger('evaluation_question_id')->index();
            $table->integer('score')->nullable();
            $table->integer('max_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_scores');
    }
};
