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
        Schema::create('pricing_proposals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('survey_proposal_id');

            // Auto-calculated fields
            $table->decimal('pricing_total', 15, 2)->nullable();
            $table->decimal('partial_cost_service', 15, 2)->nullable();
            $table->decimal('awareness', 15, 2)->nullable();
            $table->decimal('education', 15, 2)->nullable();
            $table->decimal('technology', 15, 2)->nullable();
            $table->decimal('response', 15, 2)->nullable();
            $table->decimal('logistics_expense', 15, 2)->nullable();

            // User editable fields
            $table->string('proposal_name')->nullable();
            $table->integer('proposal_order')->nullable();
            $table->decimal('override_pricing', 15, 2)->nullable();
            $table->decimal('discounts', 15, 2)->nullable();
            $table->text('descriptions')->nullable();

            // Contract details
            $table->integer('services_per_year')->nullable();
            $table->integer('contract_terms')->nullable();
            $table->boolean('prepayment_discount')->comment('1=yes, 0=no')->nullable();
            $table->timestamps();

            $table->index('survey_proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_proposals');
    }
};
