<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SupportTicketsMessage extends Model
{
    use HasUuids;

    protected $fillable = [
        'message',
        'sender_id',
        'sender_type',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}
