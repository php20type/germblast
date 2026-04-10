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
        Schema::create('service_order_employee_performances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_order_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('disciplinary_issue_id')->index();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_employee_performances');
    }
};
