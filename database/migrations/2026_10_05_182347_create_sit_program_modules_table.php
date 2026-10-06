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
            $table->foreignId('sit_program_id')->constrained('sit_programs')->onDelete('cascade');
            $table->foreignId('sit_module_id')->constrained('sit_modules')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->foreignId('completed_by')->nullable()->constrained('users')->onDelete('set null');
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
