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
        Schema::create('biological_readiness_includes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('biological_readiness_id');
            $table->index('biological_readiness_id', 'bio_ready_id_idx');

            $table->text('includes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biological_readiness_includes');
    }
};
