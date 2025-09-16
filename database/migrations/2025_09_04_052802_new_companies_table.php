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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('legacy_id')->nullable();
            $table->string('postalCode')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('set null');

            $table->unsignedBigInteger('company_type_id')->nullable();
            $table->foreign('company_type_id')->references('id')->on('company_types')->onDelete('set null');

            $table->unsignedBigInteger('territory_id')->nullable();
            $table->foreign('territory_id')->references('id')->on('territories')->onDelete('set null');

            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->unsignedInteger('employees_count')->nullable();

            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
