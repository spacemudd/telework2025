<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\SimulationConfig;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateSimulatedTasksJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The company instance.
     *
     * @var Company
     */
    protected ?Company $company;

    /**
     * Create a new job instance.
     *
     * @param Company|null $company
     */
    public function __construct(?Company $company = null)
    {
        $this->company = $company;
    }

    public function handle(): void
    {
        $configs = SimulationConfig::with('company.employees');
        if ($this->company) {
            $configs = $configs->where('company_id', $this->company->id);
        }
        $configs = $configs->get();

        foreach ($configs as $config) {
            $company = $config->company;
            if (!$company) {
                \Log::error('Company not found for simulation config', [
                    'config_id' => $config->id,
                ]);
                continue;
            }

            if (!$company || !$company->config->is_enabled) {
                \Log::info('Skipping task generation for disabled company', [
                    'company_id' => $company->id,
                    'company_name' => $company->name,
                ]);
                continue;
            }

            if ($company->employees->isEmpty()) {
                \Log::info('No employees found for company', [
                    'company_id' => $company->id,
                    'company_name' => $company->name,
                ]);
                continue;
            }

            foreach ($company->employees as $employee) {
                GenerateSimulatedTasksJobBatch::dispatch($employee, $config->tasks_per_day);
            }
        }
    }
}
