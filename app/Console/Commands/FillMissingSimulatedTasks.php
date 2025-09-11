<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\SimulationConfig;
use App\Models\Task;
use App\Jobs\GenerateSimulatedTasksForDateJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FillMissingSimulatedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulation:fill-missing-tasks {--company-id= : Specific company ID to process} {--dry-run : Show what would be done without actually creating tasks} {--include-responses : Include employee responses for created tasks} {--no-email : Disable sending notifications/emails when creating tasks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill missing simulated tasks for companies with enabled simulation, avoiding weekends';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fill missing simulated tasks...');

        // Get companies with enabled simulation
        $query = Company::whereHas('config', function($query) {
            $query->where('is_enabled', true);
        })->with(['config', 'employees']);

        if ($companyId = $this->option('company-id')) {
            $query->where('id', $companyId);
        }

        $companies = $query->get();

        if ($companies->isEmpty()) {
            $this->warn('No companies found with enabled simulation.');
            return 0;
        }

        $this->info("Found {$companies->count()} companies with enabled simulation.");

        $isDryRun = $this->option('dry-run');
        $includeResponses = $this->option('include-responses');
        $disableEmail = $this->option('no-email');
        
        if ($isDryRun) {
            $this->warn('DRY RUN MODE: No tasks will actually be created.');
        }
        
        if ($includeResponses) {
            $this->info('INCLUDE RESPONSES MODE: Employee responses will be simulated for created tasks.');
        }

        if ($disableEmail) {
            $this->warn('EMAIL NOTIFICATIONS DISABLED: No task assignment emails/notifications will be sent.');
        }

        $totalTasksCreated = 0;
        $totalDaysProcessed = 0;

        $progressBar = $this->output->createProgressBar($companies->count());
        $progressBar->start();

        foreach ($companies as $company) {
            $this->newLine();
            $this->info("Processing company: {$company->name}");

            if ($company->employees->isEmpty()) {
                $this->warn("No employees found for company: {$company->name}");
                continue;
            }

            $config = $company->config;
            $tasksPerDay = $config->tasks_per_day;

            // Get the date range from company creation to yesterday (avoid today since regular job handles it)
            $startDate = Carbon::parse($company->created_at)->startOfDay();
            $endDate = Carbon::now()->subDay()->endOfDay();

            $missingDays = $this->findMissingDays($company, $startDate, $endDate);

            if ($missingDays->isEmpty()) {
                $this->info("No missing days found for company: {$company->name}");
                continue;
            }

            $this->info("Found " . $missingDays->count() . " missing days for company: {$company->name}");

            $companyTasksCreated = 0;
            $companyDaysProcessed = 0;

            foreach ($missingDays as $date) {
                // Skip weekends (Friday = 5, Saturday = 6)
                if ($date->dayOfWeek === 5 || $date->dayOfWeek === 6) {
                    $this->line("Skipping weekend: {$date->format('Y-m-d')} (day of week: {$date->dayOfWeek})");
                    continue;
                }

                $this->line("Creating tasks for date: {$date->format('Y-m-d')}");

                // Create tasks for each employee
                foreach ($company->employees as $employee) {
                    if (!$isDryRun) {
                        // Dispatch job to create tasks for this employee on this specific date
                        GenerateSimulatedTasksForDateJob::dispatch($employee, $tasksPerDay, $date, $includeResponses, !$disableEmail)->onQueue('openai');
                    }
                    
                    $companyTasksCreated += $tasksPerDay;
                }

                $companyDaysProcessed++;
                $totalDaysProcessed++;
            }

            $totalTasksCreated += $companyTasksCreated;

            $action = $isDryRun ? "Would create" : "Created";
            $this->info("{$action} {$companyTasksCreated} tasks for {$companyDaysProcessed} days in company: {$company->name}");
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
        
        $action = $isDryRun ? "would be queued" : "queued for creation";
        $this->info("Summary:");
        $this->info("- Total companies processed: {$companies->count()}");
        $this->info("- Total days processed: {$totalDaysProcessed}");
        $this->info("- Total tasks {$action}: {$totalTasksCreated}");

        return 0;
    }

    /**
     * Find days that don't have any tasks for the given company
     */
    private function findMissingDays(Company $company, Carbon $startDate, Carbon $endDate): \Illuminate\Support\Collection
    {
        $missingDays = collect();

        // Get all dates that have tasks for this company (via employee relationship)
        $datesWithTasks = Task::whereHas('employee', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as task_date')
            ->distinct()
            ->pluck('task_date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        // Generate all dates in the range
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $dateString = $currentDate->format('Y-m-d');
            
            // If this date doesn't have any tasks, add it to missing days
            if (!in_array($dateString, $datesWithTasks)) {
                $missingDays->push($currentDate->copy());
            }
            
            $currentDate->addDay();
        }

        return $missingDays;
    }
} 