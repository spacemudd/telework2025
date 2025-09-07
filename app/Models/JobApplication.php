<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobApplication extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'job_posting_id',
        'user_id',
        'status',
        'cover_letter',
    ];
    
    protected static function booted()
    {
        static::creating(function ($jobApplication) {
            if (empty($jobApplication->id)) {
                $jobApplication->id = (string) Str::uuid();
            }
        });
    }
    
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
