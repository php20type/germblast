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
        Schema::table('service_order_invoices', function (Blueprint $table) {
            $table->dropColumn(['invoice_type', 'due_date', 'status', 'cancellation_reason']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_invoices', function (Blueprint $table) {
            $table->string('invoice_type')->nullable()->after('invoice_no');
            $table->date('due_date')->nullable()->after('invoice_date');
            $table->string('status')->default('Draft')->after('due_date');
            $table->text('cancellation_reason')->nullable()->after('sent_date');
        });
    }
};
