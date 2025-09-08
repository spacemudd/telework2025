<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class EmployeeEducation extends Model
{
    use HasFactory;
    
    protected $table = 'employee_educations';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'title',
        'institute_name',
        'start_date',
        'end_date',
        'is_current',
        'certificate_type',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($education) {
            if (empty($education->id)) {
                $education->id = (string) Str::uuid();
            }
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Scope for future filtering
    public function scopeWithCertificate($query, $certificateType)
    {
        return $query->where('certificate_type', $certificateType);
    }
}
