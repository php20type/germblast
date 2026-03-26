<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaskFitTestRecord extends Model
{
    protected $table = 'mask_fit_test_records';
    protected $fillable = [
        'user_id',
        'fit_test_date',
        'mask_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function maskType()
    {
        return $this->belongsTo(MaskType::class,'mask_type_id');
    }
}
