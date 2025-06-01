<?php

namespace App\Jobs;

use App\Mail\DailyCompanyTasksReport;
use App\Models\Company;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CompanyTasksReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $company;

    /**
     * Create a new job instance.
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get yesterday's date range
        $yesterday = now();
        $startOfYesterday = $yesterday->copy()->subYear()->startOfDay();
        $endOfYesterday = $yesterday->copy()->addYear()->endOfDay();

        $tasksByEmployee = [];

        // Get all employees of the company
        $employees = $this->company->employees()->with([
            'tasks' => function ($query) use ($startOfYesterday, $endOfYesterday) {
                $query->whereBetween('created_at', [$startOfYesterday, $endOfYesterday])
                    ->orWhereBetween('updated_at', [$startOfYesterday, $endOfYesterday]);
            },
            'tasks.activities' => function ($query) use ($startOfYesterday, $endOfYesterday) {
                $query->whereBetween('created_at', [$startOfYesterday, $endOfYesterday]);
            }
        ])->get();

        foreach ($employees as $employee) {
            $employeeTasks = [
                'assigned' => [],
                'updated' => [],
                'completed' => []
            ];

            foreach ($employee->tasks as $task) {
                // New tasks assigned yesterday
                if ($task->created_at->between($startOfYesterday, $endOfYesterday)) {
                    $employeeTasks['assigned'][] = $task;
                }

                // Tasks that were updated yesterday (status changed)
                if ($task->activities->count() > 0) {
                    $employeeTasks['updated'][] = $task;
                }

                // Tasks that were completed yesterday
                if ($task->status === 'completed' &&
                    $task->updated_at->between($startOfYesterday, $endOfYesterday)) {
                    $employeeTasks['completed'][] = $task;
                }
            }

            // Only add employee to report if they have any task activity
            if (count($employeeTasks['assigned']) > 0 ||
                count($employeeTasks['updated']) > 0 ||
                count($employeeTasks['completed']) > 0) {
                $tasksByEmployee[$employee->name] = $employeeTasks;
            }

        }

        // Send email if there's any activity to report
        if (count($tasksByEmployee) > 0) {
            Log::info('Sending daily company tasks report.');
            Mail::to($this->company->email)
                ->send(new DailyCompanyTasksReport($this->company, $tasksByEmployee));
        }
    }
}
