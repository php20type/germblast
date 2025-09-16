<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('territory_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('territory_id')->constrained('territories')->onDelete('cascade');

            // Instead of enum, use string
            // $table->string('type'); // Values: "country", "state", "city", "postal_code", "area_code"
              $table->string('type')->comment('Type: country, state, city, postal_code, area_code');

            // Location fields
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('area_code')->nullable();

            // Optional range in miles or kilometers
            $table->integer('range')->nullable()->comment('Range is in miles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('territory_locations');
    }
};
