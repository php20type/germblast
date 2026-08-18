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
        Schema::create('sit_evaluation_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technician_id')->index();
            $table->unsignedBigInteger('evaluator_id')->nullable()->index();
            $table->integer('attempt_number')->default(1);
            $table->integer('score')->nullable();
            $table->boolean('passed')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->text('development_plan')->nullable();
            $table->text('other_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sit_evaluation_attempts');
    }
};
