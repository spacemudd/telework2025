<?php

// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'position',
        'identity_number',
        'user_id',
        'skills',
        'experience_level',
        'preferred_work_type',
        'is_job_seeker',
        'profile_completed',
        'cv_path',
        'bio',
    ];

    protected $casts = [
        'is_job_seeker' => 'boolean',
        'profile_completed' => 'boolean'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talentCategories()
    {
        return $this->belongsToMany(TalentCategory::class, 'employee_talent_categories')
                    ->withTimestamps();
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

    public function scopeJobSeekers($query)
    {
        return $query->where('is_job_seeker', true);
    }

    public function scopeProfileCompleted($query)
    {
        return $query->where('profile_completed', true);
    }

    public function scopeByTalentCategory($query, $categoryId)
    {
        return $query->whereHas('talentCategories', function($q) use ($categoryId) {
            $q->where('talent_categories.id', $categoryId);
        });
    }

    public function scopeByTalentCategories($query, array $categoryIds)
    {
        return $query->whereHas('talentCategories', function($q) use ($categoryIds) {
            $q->whereIn('talent_categories.id', $categoryIds);
        });
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function getLatestInterviewAttribute()
    {
        return $this->interviews()->latest()->first();
    }

    public function experiences()
    {
        return $this->hasMany(EmployeeExperience::class)->orderBy('start_date', 'desc');
    }

    public function educations()
    {
        return $this->hasMany(EmployeeEducation::class)->orderBy('start_date', 'desc');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'employee_skills')
                    ->withTimestamps();
    }

    public function hasExperiences()
    {
        return $this->experiences()->exists();
    }

    public function hasEducations()
    {
        return $this->educations()->exists();
    }
}
