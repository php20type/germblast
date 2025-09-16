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
        Schema::create('activities', function (Blueprint $table) {
             $table->id();

            $table->unsignedBigInteger('activity_type_id')->nullable(); // Foreign key
            $table->foreign('activity_type_id')->references('id')->on('activity_types')->onDelete('set null');

            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('all_day')->default(false);
            $table->string('location')->nullable();

            $table->unsignedBigInteger('participant_id')->nullable();
            $table->foreign('participant_id')->references('id')->on('people')->onDelete('set null');

            $table->text('agenda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
