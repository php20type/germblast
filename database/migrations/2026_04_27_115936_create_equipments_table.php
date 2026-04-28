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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();

            $table->string('barcode')->nullable();
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('type_id')->index();
            $table->enum('status', [
            'new',
            'ready',
            'dirty',
            'broken',
            'lost',
            'decommissioned'
        ])->default('new')->index();

        $table->boolean('is_assigned')->default(false);

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
