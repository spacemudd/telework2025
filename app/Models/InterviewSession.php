<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class InterviewSession extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'interview_id',
        'session_data',
        'audio_recording_url',
        'recording_duration',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'session_data' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($session) {
            if (empty($session->id)) {
                $session->id = (string) Str::uuid();
            }
        });
    }

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }
}
