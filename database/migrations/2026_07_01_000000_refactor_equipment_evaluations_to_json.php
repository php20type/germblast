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
        Schema::table('equipment_evaluations', function (Blueprint $table) {
            // Drop old static columns
            $table->dropColumn([
                'non_electric_gurney',
                'wheelchair',
                'transport_chair',
                'iv_pole',
                'food_cart',
                'miscellaneous_pieces',
                'anesthesia_cart',
                'or_table',
                'stainless_steel_cart',
                'stainless_steel_table',
                'electrosurgical_device',
                'wall_mounted_monitor',
                'vital_signs_monitor',
                'vital_signs_monitor_ecg',
                'dvt_scd_device',
                'cpm',
                'infusion_pump',
                'bipap',
                'cpap',
                'pulse_oximeter',
                'hospital_bed',
                'electric_gurney',
                'manual_gurney',
                'pca',
                'cow',
                'patient_air_warmer',
                'enteral_feeding_pump',
                'geri_chair',
                'electric_scale',
                'defibrillator',
                'med_cart',
                'crash_cart',
                'bassinet',
                'infant_incubator',
                'infant_warmer',
                'ultrasound',
                'overbed_table',
                'portable_suction_pump',
                'stainless_steel_linen_cart',
                'stainless_steel_basin',
                'radiology_vest',
                'wall_mounted_computer',
                'telemedicine_device',
                'blower_mattress',
                'rolling_transfer_boards',
                'glucometer',
                'telemetry_monitor',
                'telemetry_pack',
                'patient_lift',
                'heat_lamp',
                'treadmill',
                'recumbant_bike',
                'misc_carts_baskets',
            ]);

            // Add new JSON columns
            $table->json('wash_counts')->nullable()->after('name');
            $table->json('cleaning_counts')->nullable()->after('wash_counts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_evaluations', function (Blueprint $table) {
            $table->dropColumn(['wash_counts', 'cleaning_counts']);

            $table->integer('non_electric_gurney')->default(0)->after('name');
            $table->integer('wheelchair')->default(0)->after('non_electric_gurney');
            $table->integer('transport_chair')->default(0)->after('wheelchair');
            $table->integer('iv_pole')->default(0)->after('transport_chair');
            $table->integer('food_cart')->default(0)->after('iv_pole');
            $table->integer('miscellaneous_pieces')->default(0)->after('food_cart');
            $table->integer('anesthesia_cart')->default(0)->after('wash_man_hours_cost');
            $table->integer('or_table')->default(0)->after('anesthesia_cart');
            $table->integer('stainless_steel_cart')->default(0)->after('or_table');
            $table->integer('stainless_steel_table')->default(0)->after('stainless_steel_cart');
            $table->integer('electrosurgical_device')->default(0)->after('stainless_steel_table');
            $table->integer('wall_mounted_monitor')->default(0)->after('electrosurgical_device');
            $table->integer('vital_signs_monitor')->default(0)->after('wall_mounted_monitor');
            $table->integer('vital_signs_monitor_ecg')->default(0)->after('vital_signs_monitor');
            $table->integer('dvt_scd_device')->default(0)->after('vital_signs_monitor_ecg');
            $table->integer('cpm')->default(0)->after('dvt_scd_device');
            $table->integer('infusion_pump')->default(0)->after('cpm');
            $table->integer('bipap')->default(0)->after('infusion_pump');
            $table->integer('cpap')->default(0)->after('bipap');
            $table->integer('pulse_oximeter')->default(0)->after('cpap');
            $table->integer('hospital_bed')->default(0)->after('pulse_oximeter');
            $table->integer('electric_gurney')->default(0)->after('hospital_bed');
            $table->integer('manual_gurney')->default(0)->after('electric_gurney');
            $table->integer('pca')->default(0)->after('manual_gurney');
            $table->integer('cow')->default(0)->after('pca');
            $table->integer('patient_air_warmer')->default(0)->after('cow');
            $table->integer('enteral_feeding_pump')->default(0)->after('patient_air_warmer');
            $table->integer('geri_chair')->default(0)->after('enteral_feeding_pump');
            $table->integer('electric_scale')->default(0)->after('geri_chair');
            $table->integer('defibrillator')->default(0)->after('electric_scale');
            $table->integer('med_cart')->default(0)->after('defibrillator');
            $table->integer('crash_cart')->default(0)->after('med_cart');
            $table->integer('bassinet')->default(0)->after('crash_cart');
            $table->integer('infant_incubator')->default(0)->after('bassinet');
            $table->integer('infant_warmer')->default(0)->after('infant_incubator');
            $table->integer('ultrasound')->default(0)->after('infant_warmer');
            $table->integer('overbed_table')->default(0)->after('ultrasound');
            $table->integer('portable_suction_pump')->default(0)->after('overbed_table');
            $table->integer('stainless_steel_linen_cart')->default(0)->after('portable_suction_pump');
            $table->integer('stainless_steel_basin')->default(0)->after('stainless_steel_linen_cart');
            $table->integer('radiology_vest')->default(0)->after('stainless_steel_basin');
            $table->integer('wall_mounted_computer')->default(0)->after('radiology_vest');
            $table->integer('telemedicine_device')->default(0)->after('wall_mounted_computer');
            $table->integer('blower_mattress')->default(0)->after('telemedicine_device');
            $table->integer('rolling_transfer_boards')->default(0)->after('blower_mattress');
            $table->integer('glucometer')->default(0)->after('rolling_transfer_boards');
            $table->integer('telemetry_monitor')->default(0)->after('glucometer');
            $table->integer('telemetry_pack')->default(0)->after('telemetry_monitor');
            $table->integer('patient_lift')->default(0)->after('telemetry_pack');
            $table->integer('heat_lamp')->default(0)->after('patient_lift');
            $table->integer('treadmill')->default(0)->after('heat_lamp');
            $table->integer('recumbant_bike')->default(0)->after('treadmill');
            $table->integer('misc_carts_baskets')->default(0)->after('recumbant_bike');
        });
    }
};
