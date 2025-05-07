<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SimulateEmployeeResponseJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected ?Company $company;

    public function __construct(?Company $company = null)
    {
        $this->company = $company;
    }

    public function handle(): void
    {
        Log::info('Generating simulated employee responses job.');

        $tasks = Task::whereIn('status', ['pending', 'in_progress'])
            ->whereHas('employee', function ($query) {
                $query->where('company_id', $this->company->id);
            })
            ->get();

        $tasks->chunk(5)->each(function ($chunk) {
            SimulateEmployeeResponseJobBatch::dispatch($chunk);
        });
    }
}
