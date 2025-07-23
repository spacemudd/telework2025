<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EmployeeRequestMessage extends Model
{
    use HasUuids;

    protected $fillable = [
        'message',
        'sender_id',
        'sender_type',
    ];

    public function employeeRequest()
    {
        return $this->belongsTo(EmployeeRequest::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}
