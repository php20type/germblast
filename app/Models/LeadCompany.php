<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCompany extends Model
{
    protected $table = 'lead_companies';

    protected $fillable = [
        'lead_id',
        'company_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
