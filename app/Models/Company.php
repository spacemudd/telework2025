<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'address',
        'cr_number',
        'phone',
    ];

    protected static function booted()
    {
        static::creating(function ($company) {
            if (empty($company->id)) {
                $company->id = (string) Str::uuid();
                $company->code = 'C'.MaxNumber::generateForPrefix('C', 1000);
            }
        });
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    function company_audit_records()
    {
        return $this->hasMany(CompanyAuditRecord::class);
    }
    public function supportTickets()
    {
        return $this->morphMany(\App\Models\SupportTicket::class, 'supportable');
    }

    public function employeeRequests()
    {
        return $this->hasMany(EmployeeRequest::class);
    }

    public function config()
    {
        return $this->hasOne(SimulationConfig::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailEvents()
    {
        return $this->hasMany(EmailEvent::class);
    }

    public function apiCalls()
    {
        return $this->hasMany(ApiCall::class);
    }

    /**
     * Get YTD AI costs for this company
     */
    public function getYtdAiCosts()
    {
        return $this->apiCalls()
            ->whereYear('created_at', date('Y'))
            ->sum('total_cost');
    }

    /**
     * Get MTD AI costs for this company
     */
    public function getMtdAiCosts()
    {
        return $this->apiCalls()
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('n'))
            ->sum('total_cost');
    }
}
