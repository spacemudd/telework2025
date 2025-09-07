<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Team;
use Spatie\Permission\Models\Role;

class FixTeamsAndRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:teams-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix teams and roles assignment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting teams and roles fix...');
        
        // Clear permission cache first
        app()['cache']->forget(config('permission.cache.key'));
        $this->info('Cleared permission cache');
        
        // Check if roles exist
        $adminRole = Role::where('name', 'admin')->first();
        $companyRole = Role::where('name', 'company')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        
        $this->info("Admin role exists: " . ($adminRole ? 'Yes' : 'No'));
        $this->info("Company role exists: " . ($companyRole ? 'Yes' : 'No'));
        $this->info("Employee role exists: " . ($employeeRole ? 'Yes' : 'No'));
        
        // Fix admin user
        $adminUser = User::where('email', 'it@hadaf-hq.com')->first();
        if ($adminUser && $adminUser->team_id) {
            setPermissionsTeamId($adminUser->team_id);
            $adminUser->syncRoles(['admin']);
            $this->info("Fixed admin user roles");
        }
        
        // Fix company users
        $companies = Company::with('user')->get();
        foreach ($companies as $company) {
            if ($company->user && $company->user->team_id) {
                setPermissionsTeamId($company->user->team_id);
                $company->user->syncRoles(['company']);
                $this->info("Fixed company user: " . $company->user->email);
                
                // Fix employees
                $employees = Employee::where('company_id', $company->id)->get();
                foreach ($employees as $employee) {
                    $employeeUser = User::where('email', $employee->email)->first();
                    if ($employeeUser && $employeeUser->team_id) {
                        setPermissionsTeamId($employeeUser->team_id);
                        $employeeUser->syncRoles(['employee']);
                        $this->info("Fixed employee user: " . $employeeUser->email);
                    }
                }
            }
        }
        
        $this->info('Teams and roles fix completed!');
        
        // Show summary with proper team context
        $this->info("\nSummary:");
        $this->info("Total users: " . User::count());
        $this->info("Users with teams: " . User::whereNotNull('team_id')->count());
        
        // Count roles properly by checking each user with their team context
        $adminCount = 0;
        $companyCount = 0;
        $employeeCount = 0;
        
        foreach (User::whereNotNull('team_id')->get() as $user) {
            setPermissionsTeamId($user->team_id);
            if ($user->hasRole('admin')) $adminCount++;
            if ($user->hasRole('company')) $companyCount++;
            if ($user->hasRole('employee')) $employeeCount++;
        }
        
        $this->info("Users with admin role: " . $adminCount);
        $this->info("Users with company role: " . $companyCount);
        $this->info("Users with employee role: " . $employeeCount);
        
        // Test a specific user
        $testUser = Company::first()->user ?? User::first();
        if ($testUser && $testUser->team_id) {
            setPermissionsTeamId($testUser->team_id);
            $this->info("\nTest user ({$testUser->email}) roles: " . $testUser->roles->pluck('name')->implode(', '));
        }
    }
}
