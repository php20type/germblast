<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    protected $table = 'lead_sources';

    protected $fillable = [
        'lead_id',
        'source_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class,'source_id');
    }
}
