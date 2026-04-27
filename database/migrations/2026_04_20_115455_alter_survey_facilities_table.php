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
        Schema::table('survey_facilities', function (Blueprint $table) {

        $table->dropColumn([
            'city',
            'state'
        ]);

        $table->boolean('is_added_to_company')->default(false)->after('total_cost');
        $table->unsignedBigInteger('country_id')->nullable()->index()->after('address');
        $table->unsignedBigInteger('state_id')->nullable()->index()->after('country_id');
        $table->unsignedBigInteger('city_id')->nullable()->index()->after('state_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('survey_facilities', function (Blueprint $table) {

            $table->dropColumn([
                'is_added_to_company',
                'country_id',
                'state_id',
                'city_id'
            ]);

            // restore old fields
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');

         });
    }
};
