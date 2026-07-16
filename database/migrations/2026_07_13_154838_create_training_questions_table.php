<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->index();
            $table->text('question');
            $table->string('question_type'); // True/False, Single Choice, Multiple Choice
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->integer('marks')->default(1);
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('Active'); // Active / Inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_questions');
    }
};
