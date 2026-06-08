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
            $table->string('invoice_type')->default('Final')->after('invoice_no');
            $table->unsignedBigInteger('created_by')->nullable()->after('total_amount');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->unsignedBigInteger('sent_by')->nullable()->after('updated_by');
            $table->dateTime('sent_date')->nullable()->after('sent_by');
            $table->text('cancellation_reason')->nullable()->after('sent_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_order_invoices', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_type',
                'created_by',
                'updated_by',
                'sent_by',
                'sent_date',
                'cancellation_reason'
            ]);
        });
    }
};
