<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimulationConfig extends Model
{
    protected $fillable = [
        'tasks_per_day',
        'auto_complete',
        'is_enabled',
        'completion_rate',
        'in_progress_rate',
        'comment_only_rate',
    ];

    protected $casts = [
        'auto_complete' => 'boolean',
        'is_enabled' => 'boolean',
        'completion_rate' => 'integer',
        'in_progress_rate' => 'integer',
        'comment_only_rate' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
