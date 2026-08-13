<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_order_slot_id',
        'audit_question_id',
        'employee_id',
        'score',
        'notes',
        'photo_path',
        'created_by',
    ];

    public function slot()
    {
        return $this->belongsTo(ServiceOrderSlot::class, 'service_order_slot_id');
    }

    public function question()
    {
        return $this->belongsTo(AuditQuestion::class, 'audit_question_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
