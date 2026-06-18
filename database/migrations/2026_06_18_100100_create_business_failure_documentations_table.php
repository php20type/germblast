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
        Schema::create('business_failure_documentations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_failure_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_failure_documentations');
    }
};
