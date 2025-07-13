<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyPerformanceController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $jobTitle = $request->input('job_title');

        // Set default date range if not provided (last 30 days)
        if (!$dateFrom) {
            $dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        }
        if (!$dateTo) {
            $dateTo = Carbon::now()->format('Y-m-d');
        }

        // Build the query
        $query = Task::with(['employee.company'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        // Apply filters
        if ($companyId) {
            $query->whereHas('employee', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($jobTitle) {
            $query->whereHas('employee', function ($q) use ($jobTitle) {
                $q->where('position', 'like', '%' . $jobTitle . '%');
            });
        }

        // Get tasks for the report
        $tasks = $query->get();

        // Calculate statistics
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        // Group tasks by company
        $tasksByCompany = $tasks->groupBy('employee.company.name')->map(function ($companyTasks) {
            return [
                'total' => $companyTasks->count(),
                'completed' => $companyTasks->where('status', 'completed')->count(),
                'pending' => $companyTasks->where('status', 'pending')->count(),
                'in_progress' => $companyTasks->where('status', 'in_progress')->count(),
            ];
        });

        // Group tasks by employee
        $tasksByEmployee = $tasks->groupBy('employee.name')->map(function ($employeeTasks) {
            $employee = $employeeTasks->first()->employee;
            return [
                'employee' => $employee,
                'total' => $employeeTasks->count(),
                'completed' => $employeeTasks->where('status', 'completed')->count(),
                'pending' => $employeeTasks->where('status', 'pending')->count(),
                'in_progress' => $employeeTasks->where('status', 'in_progress')->count(),
            ];
        });

        // Group tasks by job title
        $tasksByJobTitle = $tasks->groupBy('employee.position')->map(function ($jobTasks) {
            return [
                'total' => $jobTasks->count(),
                'completed' => $jobTasks->where('status', 'completed')->count(),
                'pending' => $jobTasks->where('status', 'pending')->count(),
                'in_progress' => $jobTasks->where('status', 'in_progress')->count(),
            ];
        });

        // Get all companies for the filter dropdown
        $companies = Company::orderBy('name')->get();

        // Get all employees for the filter dropdown (filtered by company if selected)
        $employees = Employee::with('company')
            ->when($companyId, function ($q) use ($companyId) {
                return $q->where('company_id', $companyId);
            })
            ->orderBy('name')
            ->get();

        // Get all unique job titles for the filter dropdown
        $jobTitles = Employee::select('position')
            ->distinct()
            ->whereNotNull('position')
            ->where('position', '!=', '')
            ->orderBy('position')
            ->pluck('position');

        // Get daily task data for selected date range (for bar chart)
        $dailyTaskData = $this->getDailyTaskData($dateFrom, $dateTo);

        return view('admin.company-performance.index', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks',
            'completionRate',
            'tasksByCompany',
            'tasksByEmployee',
            'tasksByJobTitle',
            'companies',
            'employees',
            'jobTitles',
            'dateFrom',
            'dateTo',
            'companyId',
            'employeeId',
            'jobTitle',
            'dailyTaskData'
        ));
    }

    private function getDailyTaskData($dateFrom, $dateTo)
    {
        $startDate = Carbon::parse($dateFrom);
        $endDate = Carbon::parse($dateTo);
        
        // Get tasks for selected date range
        $tasks = Task::with('employee')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Initialize data arrays
        $days = [];
        $pendingData = [];
        $inProgressData = [];
        $completedData = [];
        
        // Generate all days in selected date range
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dayKey = $date->format('Y-m-d');
            $days[] = $date->format('M d'); // Month and day for chart labels
            
            // Count tasks by status for this day
            $dayTasks = $tasks->filter(function ($task) use ($dayKey) {
                return $task->created_at->format('Y-m-d') === $dayKey;
            });
            
            $pendingData[] = $dayTasks->where('status', 'pending')->count();
            $inProgressData[] = $dayTasks->where('status', 'in_progress')->count();
            $completedData[] = $dayTasks->where('status', 'completed')->count();
        }

        return [
            'labels' => $days,
            'datasets' => [
                [
                    'label' => 'معلقة',
                    'data' => $pendingData,
                    'backgroundColor' => 'rgba(107, 114, 128, 0.8)',
                    'borderColor' => 'rgba(107, 114, 128, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'قيد التنفيذ',
                    'data' => $inProgressData,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.8)',
                    'borderColor' => 'rgba(251, 191, 36, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'مكتملة',
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }
} 