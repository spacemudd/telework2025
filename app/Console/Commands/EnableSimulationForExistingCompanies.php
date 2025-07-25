<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;

class EnableSimulationForExistingCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulation:enable-existing-companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable simulation for existing companies that do not have simulation configurations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for companies without simulation configurations...');

        $companiesWithoutConfig = Company::whereDoesntHave('config')->get();
        
        if ($companiesWithoutConfig->isEmpty()) {
            $this->info('All companies already have simulation configurations.');
            return 0;
        }

        $this->info("Found {$companiesWithoutConfig->count()} companies without simulation configurations.");

        $bar = $this->output->createProgressBar($companiesWithoutConfig->count());
        $bar->start();

        foreach ($companiesWithoutConfig as $company) {
            $company->config()->create([
                'tasks_per_day' => 1,
                'auto_complete' => true,
                'is_enabled' => true, // Enable simulation by default
                'completion_rate' => 70,
                'in_progress_rate' => 20,
                'comment_only_rate' => 10,
            ]);
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully enabled simulation for all existing companies.');

        return 0;
    }
} 