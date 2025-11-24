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
        Schema::create('pricing_proposal_facility', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pricing_proposal_id');
            $table->unsignedBigInteger('facility_id');
            $table->timestamps();

            $table->index('pricing_proposal_id');
            $table->index('facility_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_proposal_facility');
    }
};
