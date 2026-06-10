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
        Schema::create('core_value_praises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->index();
            $table->unsignedBigInteger('recipient_id')->nullable()->index();
            $table->string('recipient_name');
            $table->text('reason');
            $table->string('core_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_value_praises');
    }
};
