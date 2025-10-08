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
        Schema::create('note_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');

            // Index for faster lookups
            $table->index(['note_id', 'people_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_people');
    }
};
