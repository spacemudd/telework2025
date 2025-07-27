<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Task extends Model
{
    use LogsActivity;

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'issx',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->useLogName('task_status')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
