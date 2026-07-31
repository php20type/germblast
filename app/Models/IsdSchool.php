<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IsdSchool extends Model
{
    use HasFactory;

    protected $table = 'isd_schools';

    protected $fillable = [
        'id',
        'name',
    ];

    public function campuses(): HasMany
    {
        return $this->hasMany(IsdCampus::class, 'isd_school_id');
    }
}
