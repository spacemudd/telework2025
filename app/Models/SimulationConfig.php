<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulationConfig extends Model
{
    protected $fillable = [
        'tasks_per_day',
        'auto_complete',
        'is_enabled',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
