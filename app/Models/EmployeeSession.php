<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSession extends Model
{
    protected $fillable = [
        'employee_id',
        'started_at',
        'ended_at',
        'duration',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
