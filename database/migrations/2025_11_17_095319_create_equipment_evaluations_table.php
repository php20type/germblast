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
        Schema::create('equipment_evaluations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('survey_proposal_id')->nullable();

            // Fields from your screenshot
            $table->integer('non_electric_gurney')->nullable();
            $table->integer('wheelchair')->nullable();
            $table->integer('transport_chair')->nullable();
            $table->integer('iv_pole')->nullable();
            $table->integer('food_cart')->nullable();
            $table->integer('miscellaneous_pieces')->nullable();
            $table->integer('wash_man_hours')->nullable();
            $table->decimal('wash_man_hours_cost', 15, 2)->nullable();

            $table->integer('anesthesia_cart')->nullable();
            $table->integer('or_table')->nullable();
            $table->integer('stainless_steel_cart')->nullable();
            $table->integer('stainless_steel_table')->nullable();
            $table->integer('electrosurgical_device')->nullable();
            $table->integer('wall_mounted_monitor')->nullable();
            $table->integer('vital_signs_monitor')->nullable();
            $table->integer('vital_signs_monitor_ecg')->nullable();
            $table->integer('dvt_scd_device')->nullable();
            $table->integer('cpm')->nullable();
            $table->integer('infusion_pump')->nullable();
            $table->integer('bipap')->nullable();
            $table->integer('cpap')->nullable();
            $table->integer('pulse_oximeter')->nullable();
            $table->integer('hospital_bed')->nullable();
            $table->integer('electric_gurney')->nullable();
            $table->integer('manual_gurney')->nullable();
            $table->integer('pca')->nullable();
            $table->integer('cow')->nullable();
            $table->integer('patient_air_warmer')->nullable();
            $table->integer('enteral_feeding_pump')->nullable();
            $table->integer('geri_chair')->nullable();
            $table->integer('electric_scale')->nullable();
            $table->integer('defibrillator')->nullable();
            $table->integer('med_cart')->nullable();
            $table->integer('crash_cart')->nullable();
            $table->integer('bassinet')->nullable();
            $table->integer('infant_incubator')->nullable();
            $table->integer('infant_warmer')->nullable();
            $table->integer('ultrasound')->nullable();
            $table->integer('overbed_table')->nullable();
            $table->integer('portable_suction_pump')->nullable();
            $table->integer('stainless_steel_linen_cart')->nullable();
            $table->integer('stainless_steel_basin')->nullable();
            $table->integer('radiology_vest')->nullable();
            $table->integer('wall_mounted_computer')->nullable();
            $table->integer('telemedicine_device')->nullable();
            $table->integer('blower_mattress')->nullable();
            $table->integer('rolling_transfer_boards')->nullable();
            $table->integer('glucometer')->nullable();
            $table->integer('telemetry_monitor')->nullable();
            $table->integer('telemetry_pack')->nullable();
            $table->integer('patient_lift')->nullable();
            $table->integer('heat_lamp')->nullable();
            $table->integer('treadmill')->nullable();
            $table->integer('recumbant_bike')->nullable();
            $table->integer('misc_carts_baskets')->nullable();
            $table->integer('cleaning_man_hours')->nullable();
            $table->decimal('cleaning_man_hours_cost', 15, 2)->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('lead_id');
            $table->index('survey_proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_evaluations');
    }
};
