<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EmployeeRequest extends Model
{
    use HasUuids;

    protected $fillable = [
        'job_title',
        'quantity',
        'note',
        'status',
        'company_id',
    ];

    protected $appends = [
        'status_translated',
    ];

    protected static function booted()
    {
        static::creating(function ($request) {
            $request->code = 'R'.MaxNumber::generateForPrefix('R', 1000);
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(EmployeeRequestMessage::class);
    }

    public function getStatusTranslatedAttribute()
    {
        if ($this->status === 'pending') {
            return __('words.pending');
        } elseif ($this->status === 'responded') {
            return 'تم الرد';
        } elseif ($this->status === 'closed') {
            return __('words.closed');
        } else {
            return 'غير معروف';
        }
    }
}
