<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    protected $fillable = [
        'nomination_cycle_id',
        'voter_id',
        'nominee_id',
        'office_id',
        'comments',
    ];

    public function cycle()
    {
        return $this->belongsTo(NominationCycle::class, 'nomination_cycle_id');
    }

    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    public function nominee()
    {
        return $this->belongsTo(User::class, 'nominee_id');
    }

    public function office()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_id');
    }
}
