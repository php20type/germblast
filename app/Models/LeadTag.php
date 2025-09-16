<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadTag extends Model
{
    protected $table = 'lead_tags';

    protected $fillable = [
        'lead_id',
        'tag_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
