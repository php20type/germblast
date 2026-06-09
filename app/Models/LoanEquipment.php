<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanEquipment extends Model
{
    protected $table = 'loan_equipments';

    protected $fillable = [
        'name',
        'serial_number',
        'status',
        'company_id',
        'checked_out_by_id',
        'due_date',
        'processed_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'processed_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'checked_out_by_id');
    }
}
