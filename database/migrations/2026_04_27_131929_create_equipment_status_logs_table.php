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
        Schema::create('equipment_status_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('equipment_id')->index(); // "Which equipment was changed?"

            $table->string('from_status');
            $table->string('to_status');

            $table->text('note')->nullable();
            $table->unsignedBigInteger('territory_id')->index();

            $table->unsignedBigInteger('changed_by')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_status_logs');
    }
};
