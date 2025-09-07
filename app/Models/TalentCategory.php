<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentCategory extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'description_ar', 'description_en',
        'icon', 'color', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_talent_categories')
                    ->withTimestamps();
    }

    public function jobSeekers()
    {
        return $this->employees()->where('is_job_seeker', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_$locale"};
    }

    public function getLocalizedDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_$locale"};
    }
}
