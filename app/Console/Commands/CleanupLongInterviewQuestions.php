<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\InterviewService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupLongInterviewQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interview:cleanup-questions {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up existing long interview questions to ensure they are short and simple';

    /**
     * Execute the console command.
     */
    public function handle(InterviewService $interviewService): int
    {
        $this->info('Starting cleanup of long interview questions...');
        
        if ($this->option('dry-run')) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }
        
        try {
            if ($this->option('dry-run')) {
                // In dry-run mode, just show what would be changed
                $this->info('This would clean up long questions in the database.');
                $this->info('Run without --dry-run to actually perform the cleanup.');
                return 0;
            }
            
            $updatedCount = $interviewService->cleanupLongQuestions();
            
            if ($updatedCount > 0) {
                $this->info("Successfully cleaned up {$updatedCount} long interview questions.");
                Log::info("Cleanup command completed", ['questions_updated' => $updatedCount]);
            } else {
                $this->info('No long interview questions found. All questions are already properly sized.');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error during cleanup: ' . $e->getMessage());
            Log::error('Cleanup command failed', ['error' => $e->getMessage()]);
            return 1;
        }
    }
}
