<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCall extends Model
{
    protected $fillable = [
        'company_id',
        'api_provider',
        'endpoint',
        'model',
        'tokens_used',
        'cost_per_token',
        'total_cost',
        'request_prompt',
        'response_content',
        'metadata',
        'status',
        'error_message',
    ];

    protected $casts = [
        'metadata' => 'array',
        'tokens_used' => 'integer',
        'cost_per_token' => 'decimal:8',
        'total_cost' => 'decimal:4',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get YTD cost for a company
     */
    public static function getYtdCost($companyId)
    {
        return static::where('company_id', $companyId)
            ->whereYear('created_at', date('Y'))
            ->sum('total_cost');
    }

    /**
     * Get MTD cost for a company
     */
    public static function getMtdCost($companyId)
    {
        return static::where('company_id', $companyId)
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('n'))
            ->sum('total_cost');
    }

    /**
     * Get cost for a specific date range
     */
    public static function getCostForDateRange($companyId, $startDate, $endDate)
    {
        return static::where('company_id', $companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_cost');
    }

    /**
     * Get total tokens for a company in a date range
     */
    public static function getTokensForDateRange($companyId, $startDate, $endDate)
    {
        return static::where('company_id', $companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('tokens_used');
    }

    /**
     * Get cost breakdown by endpoint
     */
    public static function getCostBreakdownByEndpoint($companyId, $startDate, $endDate)
    {
        return static::where('company_id', $companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('endpoint, SUM(total_cost) as total_cost, COUNT(*) as call_count, SUM(tokens_used) as total_tokens')
            ->groupBy('endpoint')
            ->get();
    }
} 