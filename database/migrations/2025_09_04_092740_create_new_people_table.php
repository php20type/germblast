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
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name');
            $table->string('bio')->nullable();
            $table->unsignedBigInteger('legacy_id')->nullable();
            $table->string('postalCode')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->string('marketing_status')->nullable()->comment('Bouncing, Unsubscribed, No email address, Marketable');

            $table->unsignedBigInteger('territory_id')->nullable();
            $table->foreign('territory_id')->references('id')->on('territories')->onDelete('set null');

            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
