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
        Schema::create('people_urls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');

            $table->string('url')->nullable();
            $table->string('blog_url')->nullable();
            $table->string('twitter_url')->nullable();

            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_urls');
    }
};
