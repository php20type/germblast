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
        Schema::table('equipments', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(1)->change();
            $table->dropColumn('is_assigned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->enum('status', [
                'new',
                'ready',
                'dirty',
                'broken',
                'lost',
                'decommissioned'
            ])->default('new')->change();
            $table->boolean('is_assigned')->default(false)->after('status');
        });
    }
};
