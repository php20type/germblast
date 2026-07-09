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
        Schema::create('employee_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('avg_hours')->default(0);
            $table->integer('max_hours')->default(0);
            
            $table->string('mon_start', 5)->default('00:00');
            $table->string('mon_end', 5)->default('23:59');
            $table->string('tue_start', 5)->default('00:00');
            $table->string('tue_end', 5)->default('23:59');
            $table->string('wed_start', 5)->default('00:00');
            $table->string('wed_end', 5)->default('23:59');
            $table->string('thu_start', 5)->default('00:00');
            $table->string('thu_end', 5)->default('23:59');
            $table->string('fri_start', 5)->default('00:00');
            $table->string('fri_end', 5)->default('23:59');
            $table->string('sat_start', 5)->default('00:00');
            $table->string('sat_end', 5)->default('23:59');
            $table->string('sun_start', 5)->default('00:00');
            $table->string('sun_end', 5)->default('23:59');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_availabilities');
    }
};
