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
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'country_id')) {
                $table->dropColumn('country_id');
            }

            if (Schema::hasColumn('companies', 'state_id')) {
                $table->dropColumn('state_id');
            }

            if (Schema::hasColumn('companies', 'city_id')) {
                $table->dropColumn('city_id');
            }

            if (Schema::hasColumn('companies', 'postalCode')) {
                $table->dropColumn('postalCode');
            }
        });

        Schema::create('company_locations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id')->index();
            $table->string('location_name')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->index();
            $table->unsignedBigInteger('state_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('zip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_locations');

        Schema::table('companies', function (Blueprint $table) {
            $table->string('postalCode')->after('legacy_id')->nullable();

            $table->unsignedBigInteger('country_id')->after('industry_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');

            $table->unsignedBigInteger('state_id')->after('country_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->unsignedBigInteger('city_id')->after('state_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }
};
