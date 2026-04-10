<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get all expense report items with this type
     */
    public function expenseReportItems()
    {
        return $this->hasMany(ExpenseReportItem::class, 'expense_type_id');
    }
}
