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
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('expected_services')->after('close_date')->nullable();
            $table->integer('expected_months')->after('expected_services')->nullable();
            $table->string('expected_price')->after('expected_months')->nullable();
            $table->string('expected_first_date')->after('expected_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'expected_services',
                'expected_months',
                'expected_price',
                'expected_first_date',
            ]);
        });
    }
};
