<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    use HasFactory;

    protected $table = 'system_notifications';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'module',
        'type',
        'reference_id',
        'reference_type',
        'is_read',
        'created_by',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the creator of the notification (optional).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
