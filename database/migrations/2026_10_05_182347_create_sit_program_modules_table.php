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
        Schema::create('sit_program_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sit_program_id')->index();
            $table->unsignedBigInteger('sit_module_id')->index();
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->unsignedBigInteger('completed_by')->nullable()->index();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sit_program_modules');
    }
};
