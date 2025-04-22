<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAuditRecord extends Model
{
    protected $fillable = [
        'company_id',
        'recipient_email',
        'subject',
        'body_snippet',
        'status',
    ];
}
