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
    protected $signature = 'tasks:update-timestamps {--dry-run : Show what would be done without actually updating} {--limit= : Limit the number of tasks to process} {--date= : Specific date to filter tasks (format: Y-m-d, default: 2025-07-26)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix task data inconsistency: set due_date to created_at date and timestamps to 1-3 days after original due_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update task timestamps...');

        // Build query for tasks
        $query = Task::query();
        $query = $query->where('company_id', '005f3fbe-5299-47f3-b6b0-b03c8703ac90');

        // Filter by date (default to July 26th, 2025)
        $targetDate = $this->option('date') ?: '2025-07-26';
        $dateFilter = Carbon::parse($targetDate);
        
        $query->whereDate('created_at', $dateFilter);

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            $this->warn('No tasks found to process.');
            return 0;
        }

        $this->info("Found {$tasks->count()} tasks to process for date: {$dateFilter->format('Y-m-d')}.");

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

                // Use the task's due_date as the base date
                $originalDueDate = Carbon::parse($task->due_date);
                
                // Add random 1-3 days to the original due_date for the new due_date
                $daysToAdd = rand(1, 3);
                $newDueDate = $originalDueDate->copy()->addDays($daysToAdd);

                // Generate random timestamp during working hours (8 AM to 5 PM) for the original due_date
                $randomWorkingHour = rand(8, 17); // 8 AM to 5 PM
                $randomMinute = rand(0, 59);
                $randomSecond = rand(0, 59);
                
                $targetTimestamp = $originalDueDate->copy()
                    ->setTime($randomWorkingHour, $randomMinute, $randomSecond);

                if (!$isDryRun) {
                    // Update the task timestamps and due date
                    $task->update([
                        'created_at' => $targetTimestamp,
                        'updated_at' => $targetTimestamp,
                        'due_date' => $newDueDate,
                    ]);
                }

                $totalUpdated++;

                if ($this->output->isVerbose()) {
                    $this->line("Task ID {$task->id}: Original due date {$originalDueDate->format('Y-m-d')} -> New due date {$newDueDate->format('Y-m-d')} (added {$daysToAdd} days), New timestamp {$targetTimestamp->format('Y-m-d H:i:s')}");
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