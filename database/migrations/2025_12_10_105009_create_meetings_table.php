<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // ==================
        // Meetings table
        // ==================
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('activity_type_id')->nullable();

            $table->string('name');
            $table->string('meeting_type')->comment('Zoom, Live');
            $table->integer('duration')->comment('in minutes')->nullable();
            $table->date('date')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->comment('Pending ,Completed, Cancelled')->default('Pending');

            $table->timestamps();

            $table->index('user_id');
            $table->index('activity_type_id');
        });

        // ==================
        // Zoom Meetings table
        // ==================
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('meeting_id');

            $table->string('zoom_meeting_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('host_id')->nullable();
            $table->string('host_email')->nullable();
            $table->text('topic')->nullable();
            $table->string('status')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration')->nullable();
            $table->date('date')->nullable();
            $table->string('timezone')->nullable();
            $table->string('agenda')->nullable();
            $table->text('start_url')->nullable();
            $table->text('join_url')->nullable();
            $table->string('password')->nullable();
            $table->string('encrypted_password')->nullable();
            $table->longText('response')->nullable();

            $table->timestamps();

            $table->index('meeting_id');
        });

        // ==================
        // Zoom Tokens in Users table
        // ==================
        Schema::table('users', function (Blueprint $table) {
            $table->text('zoom_access_token')->after('remember_token')->nullable();
            $table->text('zoom_refresh_token')->after('zoom_access_token')->nullable();
            $table->text('zoom_token_expiry')->after('zoom_refresh_token')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('zoom_meetings');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'zoom_access_token',
                'zoom_refresh_token',
                'zoom_token_expiry',
            ]);
        });
    }
};
