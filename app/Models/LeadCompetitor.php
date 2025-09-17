<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCompetitor extends Model
{

    protected $table = 'lead_competitors';

    protected $fillable = [
        'lead_id',
        'competitor_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function competitor()
    {
        return $this->belongsTo(Competitor::class,'competitor_id');
    }

}
