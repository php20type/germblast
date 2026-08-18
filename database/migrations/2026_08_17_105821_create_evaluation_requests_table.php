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
        Schema::create('evaluation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_user_id')->index();
            $table->unsignedBigInteger('evaluator_user_id')->nullable()->index();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('evaluation_requests');
    }
};
