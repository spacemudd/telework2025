<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class CleanupDuplicateSkills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skills:cleanup-duplicates {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate skills, keeping the oldest record for each unique name';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        }

        // Find duplicates based on 'name' field
        $duplicates = DB::table('skills')
            ->select('name', DB::raw('COUNT(*) as count'), DB::raw('MIN(id) as keep_id'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('✅ No duplicate skills found.');
            return;
        }

        $this->info("Found {$duplicates->count()} skills with duplicates:");
        
        $totalDeleted = 0;
        
        foreach ($duplicates as $duplicate) {
            $this->line("- {$duplicate->name} ({$duplicate->count} records)");
            
            // Get all records for this skill name, ordered by id (oldest first)
            $skillRecords = Skill::where('name', $duplicate->name)
                ->orderBy('id')
                ->get();
            
            // Keep the first (oldest) record, delete the rest
            $toDelete = $skillRecords->skip(1);
            
            foreach ($toDelete as $skill) {
                $this->line("  → Would delete ID {$skill->id} (created: {$skill->created_at})");
                
                if (!$isDryRun) {
                    $skill->delete();
                    $totalDeleted++;
                }
            }
        }
        
        if ($isDryRun) {
            $this->warn("🔍 DRY RUN: Would delete {$this->countRecordsToDelete($duplicates)} duplicate records");
            $this->info('Run without --dry-run to actually delete the duplicates');
        } else {
            $this->info("✅ Successfully deleted {$totalDeleted} duplicate skills");
        }
    }
    
    private function countRecordsToDelete($duplicates)
    {
        $total = 0;
        foreach ($duplicates as $duplicate) {
            $total += ($duplicate->count - 1); // Keep one, delete the rest
        }
        return $total;
    }
}
