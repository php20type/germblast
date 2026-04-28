<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentStatusLog extends Model
{
    protected $table = 'equipment_status_logs';

    protected $fillable = [
        'equipment_id',
        'from_status',
        'to_status',
        'note',
        'territory_id',
        'changed_by',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class, 'territory_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
