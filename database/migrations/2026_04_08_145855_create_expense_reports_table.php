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
        Schema::create('expense_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->date('report_date')->nullable();
            $table->string('report_type'); // Personal Expense, Job-related, etc.
            $table->string('status')->default('Open'); // Open, Submitted, Filled, Rejected
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('filled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_reports');
    }
};
