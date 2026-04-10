<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'report_type',
        'status',
        'total_amount',
        'submitted_at',
        'filled_at',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(ExpenseReportItem::class, 'expense_report_id');
    }

}
