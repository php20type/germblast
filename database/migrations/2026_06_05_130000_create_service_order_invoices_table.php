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
        if (!Schema::hasTable('service_order_invoices')) {
            Schema::create('service_order_invoices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_order_id')->index();
                $table->string('invoice_no')->nullable();
                $table->date('invoice_date')->nullable();
                $table->date('due_date')->nullable();
                $table->string('status')->nullable();
                $table->json('line_items')->nullable();
                $table->text('notes')->nullable();
                $table->decimal('total_amount', 10, 2)->default(0.00);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_invoices');
    }
};
