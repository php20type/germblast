<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $table = 'equipment_types';

    protected $fillable = [
        'id',
        'input_name',
        'name',
        'type',
        'hours_required',
    ];
}
