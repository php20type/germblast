<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderEmployeePerformance extends Model
{
    protected $table = 'service_order_employee_performances';
    protected $fillable = [
        'service_order_id',
        'user_id',
        'employee_id',
        'disciplinary_issue_id',
        'notes',
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class,'service_order_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function issue()
    {
        return $this->belongsTo(DisciplinaryIssue::class, 'disciplinary_issue_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
