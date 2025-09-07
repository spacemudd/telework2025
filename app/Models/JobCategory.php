<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'name_ar',
        'icon_svg',
        'slug',
        'is_active'
    ];
    
    /**
     * Get the localized name based on current locale
     */
    public function getLocalizedNameAttribute()
    {
        return app()->getLocale() === 'ar' && $this->name_ar ? $this->name_ar : $this->name;
    }
    
    /**
     * Get job postings in this category
     */
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }
}
