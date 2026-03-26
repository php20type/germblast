<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaskType extends Model
{
    protected $table = 'mask_types';
    protected $fillable = ['name'];

    public function tests()
    {
        return $this->hasMany(MaskFitTestRecord::class,'mask_type_id');
    }
}
