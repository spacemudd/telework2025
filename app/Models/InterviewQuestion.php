<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class InterviewQuestion extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'interview_id',
        'question_text',
        'question_text_ar',
        'question_order',
        'response_audio_url',
        'response_text',
        'recording_duration',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($question) {
            if (empty($question->id)) {
                $question->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }

    public function getLocalizedQuestionAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->question_text_ar 
            ? $this->question_text_ar 
            : $this->question_text;
    }
}
