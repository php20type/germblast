<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteComment extends Model
{
     use HasFactory;

    // Table name (optional if it follows Laravel convention)
    protected $table = 'note_comments';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'note_id',
        'comment',
    ];

    /**
     * Relationship: an activity comment belongs to an activity
     */
    public function note()
    {
        return $this->belongsTo(Note::class,'note_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
