<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobPosting extends Model
{
    use SoftDeletes;
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'title',
        'description',
        'job_category_id',
        'sector_id',
        'company_id',
        'employment_type',
        'location',
        'salary_min',
        'salary_max',
        'closing_date',
        'is_active',
    ];
    
    protected $casts = [
        'closing_date' => 'date',
        'is_active' => 'boolean',
        'salary_min' => 'float',
        'salary_max' => 'float',
    ];
    
    protected static function booted()
    {
        static::creating(function ($jobPosting) {
            if (empty($jobPosting->id)) {
                $jobPosting->id = (string) Str::uuid();
            }
        });
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }
    
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
    
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
