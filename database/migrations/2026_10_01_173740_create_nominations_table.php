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
            $table->unsignedBigInteger('nomination_cycle_id')->index();
            $table->unsignedBigInteger('voter_id')->index();
            $table->unsignedBigInteger('nominee_id')->index();
            $table->unsignedBigInteger('office_id')->nullable()->index();
            $table->text('comments')->nullable();
            $table->timestamps();
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
