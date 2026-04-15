<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseReportItem extends Model
{
    protected $fillable = [
        'expense_report_id',
        'expense_type_id',
        'description',
        'amount_requested',
        'receipt_picture',
        'approved_amount',
        'reason_code',
    ];
    public function expenseReport()
    {
        return $this->belongsTo(ExpenseReport::class, 'expense_report_id');
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function reason()
    {
        return $this->belongsTo(ExpenseItemReason::class, 'reason_code');
    }
}
