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
        Schema::table('service_outlines', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('outline_name');
            $table->integer('range')->default(0)->after('description'); // 0 to 100
        });
    }

    public function down(): void
    {
        Schema::table('service_outlines', function (Blueprint $table) {
            $table->dropColumn(['description','range']);
        });
    }
};
