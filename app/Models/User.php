<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\SecureMediaUrls;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, Impersonate, HasRoles, InteractsWithMedia, SecureMediaUrls;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'team_id',
        'google_id',
        'linkedin_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function owned_company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class)
                    ->withPivot('role', 'is_primary')
                    ->withTimestamps();
    }

    public function primaryCompany()
    {
        return $this->companies()->where('is_primary', true)->first();
    }

    /**
     * Get the primary company for this user (fallback to old relationship during migration)
     */
    public function getPrimaryCompanyAttribute()
    {
        if ($this->companies()->exists()) {
            return $this->primaryCompany();
        }
        
        // Fallback to old relationship during migration
        return $this->owned_company;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    function scopeAdmins($query)
    {
        return $query->role('admin');
    }
    
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Get the full name attribute (backward compatibility)
     */
    public function getNameAttribute($value)
    {
        // If we have first_name and last_name, concatenate them
        if ($this->first_name && $this->last_name) {
            return trim($this->first_name . ' ' . $this->last_name);
        }
        
        // Fallback to the stored name value
        return $value;
    }

    /**
     * Set the name attribute and split into first_name and last_name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        
        // Split the name into first and last name
        $nameParts = explode(' ', trim($value), 2);
        $this->attributes['first_name'] = $nameParts[0] ?? '';
        $this->attributes['last_name'] = $nameParts[1] ?? '';
    }

    /**
     * Register media collections for the user
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_images')
            ->singleFile()
            ->useDisk('s3');
    }

    /**
     * Get the user's profile image URL
     */
    public function getProfileImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('profile_images');
        return $media ? $this->getSecureMediaUrl($media) : null;
    }
}
