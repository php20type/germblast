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
        Schema::create('time_off_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason')->nullable();
            $table->string('status')->default('submitted'); // submitted, approved, denied
            $table->unsignedBigInteger('actioned_by')->nullable();
            $table->dateTime('actioned_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('actioned_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_off_requests');
    }
};
