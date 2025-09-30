<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleTag extends Model
{
     protected $table = 'people_tags';

    protected $fillable = [
        'people_id',
        'tag_id',
    ];

    public function people()
    {
        return $this->belongsTo(People::class,'people_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
