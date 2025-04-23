<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTeleworkSync extends Model
{
    protected $fillable = [
        'company_id',
        'employee_id',
        'payload',
    ];
}
