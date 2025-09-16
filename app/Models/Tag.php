<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
        'created_by', // to users table
        'tag_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function company()
    {
        return $this->hasMany(Company::class, 'tag_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'tag_id');
    }

    // Lead Tags pivot table
    public function leadTags()
    {
        return $this->hasMany(LeadTag::class, 'tag_id');
    }
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_tags')
            ->withTimestamps();
    }


}
