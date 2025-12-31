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
        Schema::create('biological_readiness', function (Blueprint $table) {
             $table->id();

            $table->unsignedBigInteger('company_id')->index();

            $table->string('status')->default('Pending');

            $table->string('project_name');

            $table->decimal('per_hour_reduction_amount', 10, 2)->nullable();

            $table->integer('length'); // contract length (months)

            $table->decimal('monthly_rate', 10, 2);

            $table->text('default_readiness_includes_1')->nullable();
            $table->text('default_readiness_includes_2')->nullable();

            // fixed description as per requirement
            $table->string('service_description')->nullable();

            // calculated field (length * monthly_rate)
            $table->decimal('line_total', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biological_readiness');
    }
};
