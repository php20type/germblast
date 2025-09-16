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
        Schema::create('people_emails', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');

            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('support_email')->nullable();

            $table->timestamps();

            // Foreign key relation

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_emails');
    }
};
