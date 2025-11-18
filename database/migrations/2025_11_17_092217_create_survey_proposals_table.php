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
        Schema::create('survey_proposals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->string('client_name')->nullable();
            $table->date('date')->nullable();
            $table->longText('description')->nullable();
            $table->string('enrollment')->nullable();
            $table->integer('wada')->nullable();
            $table->decimal('aba', 10, 2)->nullable();
            $table->integer('service_technicians')->nullable();
            $table->integer('distance')->nullable();
            $table->integer('man_hours')->nullable();
            $table->decimal('estimate', 15, 2)->nullable();

            $table->longText('specialist_narrative')->nullable();

            $table->string('supplemental_title')->nullable();
            $table->longText('supplemental_body')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('lead_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_proposals');
    }
};
