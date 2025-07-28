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

    /**
     * Get task creation data for the company
     */
    public function getTaskCreationData($year = null, $month = null)
    {
        if (!$year) $year = now()->year;
        if (!$month) $month = now()->month;
        
        $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        // Get all employees for this company
        $employeeIds = $this->employees()->pluck('id');
        
        if ($employeeIds->isEmpty()) {
            return [
                'dates' => [],
                'counts' => [],
                'total_tasks' => 0,
                'days_with_tasks' => 0,
                'days_without_tasks' => 0,
                'first_employee_date' => null,
                'missing_days' => []
            ];
        }

        // Get tasks created in the selected month
        $tasks = \App\Models\Task::whereIn('employee_id', $employeeIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Get the first employee creation date for this company
        $firstEmployeeDate = $this->employees()->orderBy('created_at')->first()?->created_at;
        
        // Generate all dates in the month
        $dates = [];
        $counts = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $dateKey = $currentDate->format('Y-m-d');
            $dates[] = $currentDate->format('d');
            
            $dayTasks = $tasks->filter(function ($task) use ($currentDate) {
                return $task->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
            });
            
            $counts[] = $dayTasks->count();
            $currentDate->addDay();
        }

        // Calculate missing days (days without tasks since first employee was added)
        $missingDays = [];
        if ($firstEmployeeDate && $firstEmployeeDate->lt($startDate)) {
            // If first employee was added before this month, check for missing days
            $checkStartDate = $startDate->copy();
            $checkEndDate = $endDate->copy();
            
            $currentCheckDate = $checkStartDate->copy();
            while ($currentCheckDate->lte($checkEndDate)) {
                $dayTasks = $tasks->filter(function ($task) use ($currentCheckDate) {
                    return $task->created_at->format('Y-m-d') === $currentCheckDate->format('Y-m-d');
                });
                
                if ($dayTasks->isEmpty() && $currentCheckDate->isWeekday()) {
                    $missingDays[] = $currentCheckDate->format('Y-m-d');
                }
                
                $currentCheckDate->addDay();
            }
        }

        return [
            'dates' => $dates,
            'counts' => $counts,
            'total_tasks' => $tasks->count(),
            'days_with_tasks' => $tasks->groupBy(function ($task) {
                return $task->created_at->format('Y-m-d');
            })->count(),
            'days_without_tasks' => count($missingDays),
            'first_employee_date' => $firstEmployeeDate,
            'missing_days' => $missingDays
        ];
    }

    /**
     * Get comprehensive missing days since first employee was added
     */
    public function getMissingDaysSinceFirstEmployee()
    {
        $firstEmployee = $this->employees()->orderBy('created_at')->first();
        
        if (!$firstEmployee) {
            return [
                'total_missing_days' => 0,
                'missing_days_by_month' => [],
                'first_employee_date' => null,
                'last_task_date' => null
            ];
        }

        $firstEmployeeDate = $firstEmployee->created_at;
        $startDate = $firstEmployeeDate->copy()->startOfDay();
        $endDate = now()->endOfDay();
        
        // Get all tasks for this company
        $employeeIds = $this->employees()->pluck('id');
        $tasks = \App\Models\Task::whereIn('employee_id', $employeeIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $missingDays = [];
        $missingDaysByMonth = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $dateKey = $currentDate->format('Y-m-d');
            $monthKey = $currentDate->format('Y-m');
            
            $dayTasks = $tasks->filter(function ($task) use ($currentDate) {
                return $task->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
            });
            
            if ($dayTasks->isEmpty() && $currentDate->isWeekday()) {
                $missingDays[] = $dateKey;
                
                if (!isset($missingDaysByMonth[$monthKey])) {
                    $missingDaysByMonth[$monthKey] = [];
                }
                $missingDaysByMonth[$monthKey][] = $dateKey;
            }
            
            $currentDate->addDay();
        }

        $lastTask = $tasks->sortByDesc('created_at')->first();

        return [
            'total_missing_days' => count($missingDays),
            'missing_days_by_month' => $missingDaysByMonth,
            'first_employee_date' => $firstEmployeeDate,
            'last_task_date' => $lastTask ? $lastTask->created_at : null,
            'all_missing_days' => $missingDays
        ];
    }
}
