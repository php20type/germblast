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
        Schema::create('service_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_order_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();    // who wrote the note
            $table->unsignedBigInteger('person_id')->nullable()->index();  // contact person referenced
            $table->text('notes');
            $table->string('image_path')->nullable();
            $table->boolean('notify_sales_team')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_notes');
    }
};
