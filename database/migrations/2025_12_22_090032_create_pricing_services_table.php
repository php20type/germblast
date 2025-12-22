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
        Schema::create('pricing_services', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pricing_id');
            $table->string('service_name');

            $table->timestamps();

            $table->index('pricing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_services');
    }
};
