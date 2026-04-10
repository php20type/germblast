<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaryIssue extends Model
{
    protected $table = 'disciplinary_issues';
    protected $fillable = ['name'];

    public function performances()
    {
        return $this->hasMany(ServiceOrderEmployeePerformance::class,'disciplinary_issue_id');
    }
}
