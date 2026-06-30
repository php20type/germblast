<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityRoomType extends Model
{
    protected $table = 'facility_room_types';
    protected $fillable = [
        'id',
        'input_name',
        'name',
        'hours_required',
        'facility_types',
    ];

    protected $casts = [
        'facility_types' => 'array',
    ];
}
