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
        Schema::create('people_phones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');

            $table->string('phone')->nullable();
            $table->string('home_phones')->nullable();
            $table->string('mobile_phones')->nullable();
            $table->string('work_phones')->nullable();
            $table->string('fax_phones')->nullable();

            $table->timestamps();

            // Foreign key relation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_phones');
    }
};
