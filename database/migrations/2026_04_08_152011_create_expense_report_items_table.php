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
        Schema::create('expense_report_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_report_id')->index();
            $table->unsignedBigInteger('expense_type_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->decimal('amount_requested', 10, 2)->default(0);
            $table->string('receipt_picture')->nullable();
            $table->decimal('approved_amount', 10, 2)->default(0);
            $table->unsignedBigInteger('reason_code')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_report_items');
    }
};
