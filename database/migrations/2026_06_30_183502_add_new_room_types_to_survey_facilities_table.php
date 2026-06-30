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
        Schema::table('survey_facilities', function (Blueprint $table) {
            $table->dropColumn([
                'square_footage',
                'offices',
                'standard_bathrooms',
                'single_bathrooms',
                'football_lockerroom',
                'regular_lockerrooms',
                'weight_room',
                'training_room',
                'equipment_room',
                'coachs_office',
                'shoulder_pads',
                'helmets',
                'wrestling_mats'
            ]);
            $table->json('room_counts')->nullable()->after('facility_type');
        });

        Schema::table('facility_room_types', function (Blueprint $table) {
            $table->json('facility_types')->nullable()->after('hours_required');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_facilities', function (Blueprint $table) {
            $table->integer('square_footage')->nullable()->after('facility_type');
            $table->integer('offices')->nullable()->after('square_footage');
            $table->integer('standard_bathrooms')->nullable()->after('offices');
            $table->integer('single_bathrooms')->nullable()->after('standard_bathrooms');
            $table->integer('football_lockerroom')->nullable()->after('single_bathrooms');
            $table->integer('regular_lockerrooms')->nullable()->after('football_lockerroom');
            $table->integer('weight_room')->nullable()->after('regular_lockerrooms');
            $table->integer('training_room')->nullable()->after('weight_room');
            $table->integer('equipment_room')->nullable()->after('training_room');
            $table->integer('coachs_office')->nullable()->after('equipment_room');
            $table->integer('shoulder_pads')->nullable()->after('coachs_office');
            $table->integer('helmets')->nullable()->after('shoulder_pads');
            $table->integer('wrestling_mats')->nullable()->after('helmets');

            $table->dropColumn('room_counts');
        });

        Schema::table('facility_room_types', function (Blueprint $table) {
            $table->dropColumn('facility_types');
        });
    }
};
