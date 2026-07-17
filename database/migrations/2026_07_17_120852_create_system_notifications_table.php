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
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('title');
            $table->text('message');
            $table->string('module')->nullable(); // e.g., 'leads', 'training'
            $table->string('type')->nullable(); // e.g., 'assigned', 'failed', 'mention'
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->string('reference_type')->nullable(); // e.g., 'App\Models\Lead'
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('created_by')->nullable()->index(); // The user who triggered the notification, if applicable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_notifications');
    }
};
