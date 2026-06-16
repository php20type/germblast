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
        Schema::create('change_request_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('change_request_id')->index();
            $table->string('title');
            $table->unsignedBigInteger('assigned_to')->nullable()->index();
            $table->date('due_date')->nullable();
            $table->string('status')->default('Pending'); // e.g. Pending, Completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_request_tasks');
    }
};
