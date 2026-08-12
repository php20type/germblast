<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    use HasFactory;

    protected $table = 'action_plans';

    protected $fillable = [
        'concern_area',
        'section',
        'user_id',
        'notes',
        'is_resolved',
        'resolved_by',
        'resolved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
