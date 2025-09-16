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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id(); // id
            $table->string('code', 10)->unique()->nullable(); // currency code (e.g., USD)
            $table->string('name')->nullable(); // full name (e.g., US Dollar)
            $table->decimal('USDexchangerate', 15, 6)->nullable(); // exchange rate vs USD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
