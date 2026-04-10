<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseItemReason extends Model
{
    protected $fillable = ['name'];

    public function expenseReportItems()
    {
        return $this->hasMany(ExpenseReportItem::class, 'reason_code');
    }
}
