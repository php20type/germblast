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
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nomination_cycle_id');
            $table->unsignedBigInteger('voter_id');
            $table->unsignedBigInteger('nominee_id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('nomination_cycle_id')->references('id')->on('nomination_cycles')->onDelete('cascade');
            $table->foreign('voter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('nominee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('office_locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominations');
    }
};
