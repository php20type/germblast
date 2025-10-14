<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityComment extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel convention)
    protected $table = 'activity_comments';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'activity_id',
        'comment',
    ];

    /**
     * Relationship: an activity comment belongs to an activity
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class,'activity_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
