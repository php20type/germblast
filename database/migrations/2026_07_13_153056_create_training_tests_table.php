<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('video_url')->nullable();
            $table->integer('passing_percentage')->default(80);

            $table->string('status')->default('Active'); // Active / Inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_tests');
    }
};
