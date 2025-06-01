<?php

// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'position',
        'identity_number',
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            if (empty($employee->id)) {
                $employee->id = (string) Str::uuid();
            }
        });

        static::deleted(function ($employee) {
            $employee->user()->delete();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function sessions()
    {
        return $this->hasMany(EmployeeSession::class);
    }

    function employee_telework_syncs()
    {
        return $this->hasMany(EmployeeTeleworkSync::class);
    }
}
