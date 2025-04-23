<?php

namespace App\Jobs;

use App\Mail\TeleworkSyncCompanyMail;
use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class TeleworkSyncCompany implements ShouldQueue
{
    use Queueable;

    public $company;

    /**
     * Create a new job instance.
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->company->employees as $employee) {
            \App\Models\EmployeeTeleworkSync::create([
                'employee_id' => $employee->id,
                'company_id' => $this->company->id,
                'payload' => json_encode(['synced_at' => now()->toDateTimeString()])
            ]);
        }

        Mail::to($this->company->email)
            ->send(new TeleworkSyncCompanyMail($this->company));
    }
}
