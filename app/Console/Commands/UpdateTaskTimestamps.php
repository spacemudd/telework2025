<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateTaskTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:update-timestamps {--company-id= : Specific company ID to process} {--dry-run : Show what would be done without actually updating} {--limit= : Limit the number of tasks to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update task timestamps by subtracting 1-3 days from due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update task timestamps...');

        // Build query for tasks
        $query = Task::query();

        if ($companyId = $this->option('company-id')) {
            $query->where('company_id', $companyId);
        }

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            $this->warn('No tasks found to process.');
            return 0;
        }

        $this->info("Found {$tasks->count()} tasks to process.");

        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('DRY RUN MODE: No timestamps will actually be updated.');
        }

        $totalUpdated = 0;
        $totalSkipped = 0;

        $progressBar = $this->output->createProgressBar($tasks->count());
        $progressBar->start();

        foreach ($tasks as $task) {
            try {
                // Check if task has a due date
                if (!$task->due_date) {
                    $this->warn("Task ID {$task->id} has no due date, skipping.");
                    $totalSkipped++;
                    $progressBar->advance();
                    continue;
                }

                // Parse the due date
                $dueDate = Carbon::parse($task->due_date);
                
                // Subtract random 1-3 days from due date
                $daysToSubtract = rand(1, 3);
                $targetDate = $dueDate->copy()->subDays($daysToSubtract);

                // Generate random timestamp during working hours (8 AM to 5 PM) for the target date
                $randomWorkingHour = rand(8, 17); // 8 AM to 5 PM
                $randomMinute = rand(0, 59);
                $randomSecond = rand(0, 59);
                
                $targetTimestamp = $targetDate->copy()
                    ->setTime($randomWorkingHour, $randomMinute, $randomSecond);

                if (!$isDryRun) {
                    // Update the task timestamps
                    $task->update([
                        'created_at' => $targetTimestamp,
                        'updated_at' => $targetTimestamp,
                    ]);
                }

                $totalUpdated++;

                if ($this->output->isVerbose()) {
                    $this->line("Task ID {$task->id}: Due date {$dueDate->format('Y-m-d')} -> Target date {$targetTimestamp->format('Y-m-d H:i:s')} (subtracted {$daysToSubtract} days)");
                }

            } catch (\Exception $e) {
                $this->error("Error processing task ID {$task->id}: " . $e->getMessage());
                Log::error('Error updating task timestamp', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
                $totalSkipped++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        if ($isDryRun) {
            $this->info("DRY RUN COMPLETED: Would have updated {$totalUpdated} tasks, skipped {$totalSkipped} tasks.");
        } else {
            $this->info("COMPLETED: Updated {$totalUpdated} tasks, skipped {$totalSkipped} tasks.");
        }

        return 0;
    }
} 