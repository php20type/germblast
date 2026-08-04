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
        Schema::create('timecards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->date('work_date');
            $table->time('clock_in');
            $table->time('clock_out')->nullable();
            $table->tinyInteger('clock_type')->default(0)->comment('0:None, 1:Travel, 2:Service, 3:Break, 4:Office Work, 5:Warehouse, 6:Training, 7:Service Prep, 8:UMC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timecards');
    }
};
