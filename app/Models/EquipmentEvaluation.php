<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentEvaluation extends Model
{
      protected $table = 'equipment_evaluations';

    protected $fillable = [
        'user_id',
        'lead_id',
        'survey_proposal_id',

        'non_electric_gurney',
        'wheelchair',
        'transport_chair',
        'iv_pole',
        'food_cart',
        'miscellaneous_pieces',
        'wash_man_hours',
        'wash_man_hours_cost',

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

        'cleaning_man_hours',
        'cleaning_man_hours_cost',
    ];

     public function surveyProposal()
    {
        return $this->belongsTo(SurveyProposal::class, 'survey_proposal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
