<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;

class EnableAllCompanySimulations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulation:enable-all-companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable simulation for all existing companies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Enabling simulation for all companies...');

        // Enable simulation for companies that have configs but are disabled
        $disabledCompanies = Company::whereHas('config', function($query) {
            $query->where('is_enabled', false);
        })->get();

        if ($disabledCompanies->isEmpty()) {
            $this->info('All companies already have simulation enabled.');
            return 0;
        }

        $this->info("Found {$disabledCompanies->count()} companies with disabled simulation.");

        $bar = $this->output->createProgressBar($disabledCompanies->count());
        $bar->start();

        foreach ($disabledCompanies as $company) {
            $company->config()->update(['is_enabled' => true]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully enabled simulation for all companies.');

        // Show summary
        $totalCompanies = Company::count();
        $enabledCompanies = Company::whereHas('config', function($query) {
            $query->where('is_enabled', true);
        })->count();
        $companiesWithoutConfig = Company::whereDoesntHave('config')->count();

        $this->info("Summary:");
        $this->info("- Total companies: {$totalCompanies}");
        $this->info("- Companies with enabled simulation: {$enabledCompanies}");
        $this->info("- Companies without config: {$companiesWithoutConfig}");

        return 0;
    }
} 