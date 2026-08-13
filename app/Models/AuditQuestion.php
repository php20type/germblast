<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'audit_section_id',
        'question_number',
        'question',
        'question_type',
        'sort_order',
    ];

    public function section()
    {
        return $this->belongsTo(AuditSection::class, 'audit_section_id');
    }

    public function submissions()
    {
        return $this->hasMany(AuditSubmission::class, 'audit_question_id');
    }
}
