<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EmployeeEmailDomainStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employees:email-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show statistics of email domains used by employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all users with employee role using direct database query
        $employeeUsers = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_type', User::class)
            ->where('roles.name', 'employee')
            ->select('users.*')
            ->get();

        $totalEmployees = $employeeUsers->count();

        if ($totalEmployees === 0) {
            $this->info('No employees found.');
            return;
        }

        // Extract domains and count them
        $domainCounts = [];
        
        foreach ($employeeUsers as $user) {
            $email = $user->email;
            $domain = substr(strrchr($email, "@"), 1);
            
            if (!isset($domainCounts[$domain])) {
                $domainCounts[$domain] = 0;
            }
            $domainCounts[$domain]++;
        }

        // Sort by count (descending)
        arsort($domainCounts);

        // Display results
        $this->info("Employees: {$totalEmployees}");
        $this->newLine();

        foreach ($domainCounts as $domain => $count) {
            $percentage = round(($count / $totalEmployees) * 100, 1);
            $this->line("Using {$domain}: {$count} ({$percentage}%)");
        }

        $this->newLine();
        $this->info("Total unique domains: " . count($domainCounts));
    }
}
