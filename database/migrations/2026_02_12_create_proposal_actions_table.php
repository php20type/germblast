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
        Schema::create('proposal_actions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('survey_proposal_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->enum('status', ['approved', 'rejected']);
            $table->text('comment')->nullable();

            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_actions');
    }
};
