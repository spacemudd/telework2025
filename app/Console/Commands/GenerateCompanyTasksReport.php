<?php

namespace App\Console\Commands;

use App\Jobs\CompanyTasksReport;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCompanyTasksReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:company-tasks
                          {company? : The ID of the company to generate report for. If not provided, generates for all companies.}
                          {--date= : The date to generate report for (format: Y-m-d). Defaults to yesterday}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send company tasks report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companyId = $this->argument('company');
        $date = $this->option('date');

        if ($companyId) {
            $company = Company::find($companyId);
            if (!$company) {
                $this->error("Company with ID {$companyId} not found.");
                return 1;
            }
            $companies = collect([$company]);
        } else {
            $companies = Company::get();
        }

        $count = 0;
        foreach ($companies as $company) {
            CompanyTasksReport::dispatch($company);
            $this->info("Dispatched report generation for company: {$company->name}");
            $count++;
        }

        $this->info("Successfully dispatched reports for {$count} " . Str::plural('companies', $count) . ".");
        return 0;
    }
}
