<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyEquipmentImage extends Model
{
     protected $table = 'survey_equipment_images';

    protected $fillable = [
        'user_id',
        'survey_equipment_id',
        'description',
        'file_name',
        'file_path',
        'file_type',
    ];

     public function equipment()
    {
        return $this->belongsTo(EquipmentEvaluation::class, 'survey_equipment_id');
    }

    /**
     * Relationship: belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
