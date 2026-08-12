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
        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->string('concern_area');
            $table->string('section');
            $table->unsignedBigInteger('user_id')->index();
            $table->text('notes');
            $table->boolean('is_resolved')->default(false);
            $table->unsignedBigInteger('resolved_by')->nullable()->index();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_plans');
    }
};
