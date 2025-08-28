<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateCompanyUserRelationships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:migrate-relationships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing company-user relationships to new pivot table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting company-user relationship migration...');
        
        $companies = \App\Models\Company::whereNotNull('email')->get();
        $bar = $this->output->createProgressBar($companies->count());
        
        $this->info("Found {$companies->count()} companies to migrate");
        
        foreach ($companies as $company) {
            // Use existing user_id relationship
            $user = \App\Models\User::find($company->user_id);
            
            if ($user) {
                // Check if relationship already exists
                if ($company->users()->where('user_id', $user->id)->exists()) {
                    $this->line(" ⚠ Relationship already exists for: {$company->name} -> {$user->email}");
                    
                    // Update company flags even if relationship exists
                    $company->update([
                        'owner_email' => $company->email,
                        'migration_completed' => true
                    ]);
                } else {
                    // Create pivot relationship
                    $company->users()->attach($user->id, [
                        'role' => 'owner',
                        'is_primary' => !$user->companies()->exists(), // First company is primary
                    ]);
                    
                    // Update company
                    $company->update([
                        'owner_email' => $company->email,
                        'migration_completed' => true
                    ]);
                    
                    $this->line(" ✓ Migrated: {$company->name} -> {$user->email}");
                }
            } else {
                $this->warn(" ⚠ No user found for company: {$company->name} (user_id: {$company->user_id})");
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $migratedCount = \App\Models\Company::where('migration_completed', true)->count();
        $this->info("Migration completed! {$migratedCount} companies migrated successfully.");
    }
}
