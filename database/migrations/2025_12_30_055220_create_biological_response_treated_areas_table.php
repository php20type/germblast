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
        Schema::create('biological_response_treated_areas', function (Blueprint $table) {
            $table->id();

            // MySQL allows max 64 characters for index names
            $table->unsignedBigInteger('biological_response_intake_id');
            $table->index(
                'biological_response_intake_id',
                'br_treated_areas_intake_id_idx'
            );

            $table->string('area_name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biological_response_treated_areas');
    }
};
