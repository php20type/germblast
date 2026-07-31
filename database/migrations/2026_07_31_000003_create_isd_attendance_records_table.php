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
        Schema::create('isd_attendance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('isd_campus_id')->index();
            $table->string('school_year');
            $table->integer('week');
            $table->decimal('ada', 8, 2)->default(0);
            $table->decimal('pia', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isd_attendance_records');
    }
};
