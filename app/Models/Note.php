<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'note',
        'owner_type',
        'owner_id',
    ];

     /**
     * Polymorphic relation to owner (company, people, lead)
     */
    public function owner(): MorphTo
    {
        return $this->morphTo(null, 'owner_type', 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(NoteComment::class,'note_id');
    }

     /**
     * Relation to companies mentioned in this note
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'note_companies', 'note_id', 'company_id');
    }

    /**
     * Relation to peoples mentioned in this note
     */
    public function peoples()
    {
        return $this->belongsToMany(People::class, 'note_people', 'note_id', 'people_id');
    }

    /**
     * Relation to users mentioned in this note
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'note_users', 'note_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
