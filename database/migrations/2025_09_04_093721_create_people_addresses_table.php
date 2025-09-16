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
        Schema::create('people_addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');

            $table->string('address')->nullable();
            $table->string('main_address')->nullable();
            $table->string('work_address')->nullable();
            $table->string('home_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('mailing_address')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_addresses');
    }
};
