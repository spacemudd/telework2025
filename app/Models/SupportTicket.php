<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class SupportTicket extends Model
{
    use HasUuids;

    protected $fillable = [
        'subject',
        'status',
    ];

    protected $appends = [
        'status_translated',
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->code = 'T'.MaxNumber::generateForPrefix('C', 1000);
        });
    }

    public function supportable()
    {
        return $this->morphTo();
    }

    public function messages()
    {
        return $this->hasMany(SupportTicketsMessage::class);
    }

    function getStatusTranslatedAttribute()
    {
        if ($this->status === 'open') {
            return __('words.active-ticket-status');
        } elseif ($this->status === 'closed') {
            return __('words.closed-ticket-status');
        } else {
            return __('words.unkown-ticket-status');
        }
    }
}
