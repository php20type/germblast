<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('lead_number')->nullable();
            $table->string('name');
            $table->text('description');

            $table->string('lead_status')->nullable()->comment('open,won,lost,cancelled,pending');
            $table->json('lead_flags')->nullable()->comment('watching, hot');

            $table->unsignedBigInteger('stage_id')->nullable()->default(1);
            $table->foreign('stage_id')->references('id')->on('lead_stages')->onDelete('set null');

            $table->decimal('confidence', 5, 2)->nullable();

            $table->integer('unknown_field')->nullable();

            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');

            $table->dateTime('close_date')->nullable();

            $table->timestamp('last_contacted')->nullable();
            $table->timestamp('last_modified')->nullable();

            $table->unsignedBigInteger('market_id')->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('set null');

            $table->unsignedBigInteger('outcome_id')->nullable();
            $table->foreign('outcome_id')->references('id')->on('outcomes')->onDelete('set null');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_leads');
    }
};
