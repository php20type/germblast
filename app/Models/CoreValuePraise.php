<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreValuePraise extends Model
{
    protected $table = 'core_value_praises';

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'recipient_name',
        'reason',
        'core_value',
    ];

    /**
     * The employee who submitted the praise.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * The employee who is praised (if matched with a user).
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
