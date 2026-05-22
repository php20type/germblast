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
        Schema::create('warehouse_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('employee');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->tinyInteger('type')->comment('1 = Regular Service, 2 = Call');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_schedules');
    }
};
