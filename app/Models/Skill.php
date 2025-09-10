<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'is_translatable',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_translatable' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getDisplayNameAttribute()
    {
        if (app()->getLocale() === 'ar' && $this->is_translatable && $this->name_ar) {
            return $this->name_ar;
        }
        
        return $this->name;
    }
}
