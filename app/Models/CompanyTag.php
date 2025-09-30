<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTag extends Model
{
     protected $table = 'company_tags';

    protected $fillable = [
        'company_id',
        'tag_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
