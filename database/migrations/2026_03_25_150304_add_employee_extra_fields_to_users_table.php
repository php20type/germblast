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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cell_phone')->nullable()->after('staff_type');
            $table->string('profile_image', 225)->nullable()->after('cell_phone');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('profile_image');
            $table->string('training_level')->nullable()->after('hourly_rate');
            $table->string('employee_type')->nullable()->after('training_level');

            $table->boolean('active')->default(true)->after('employee_type');
            $table->boolean('schedulable')->default(true)->after('active');

            $table->boolean('biological_response_team')->default(false)->after('schedulable');
            $table->boolean('healthcare_team')->default(false)->after('biological_response_team');
            $table->boolean('driver_trained')->default(false)->after('healthcare_team');
            $table->boolean('floor_certified')->default(false)->after('driver_trained');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'cell_phone',
                'profile_image',
                'hourly_rate',
                'training_level',
                'employee_type',
                'active',
                'schedulable',
                'biological_response_team',
                'healthcare_team',
                'driver_trained',
                'floor_certified',
            ]);
        });
    }
};
