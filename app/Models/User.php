<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, Impersonate, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'team_id',
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
}
