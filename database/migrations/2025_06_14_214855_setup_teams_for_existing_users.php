<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Team;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, create a default team for the admin user
        $adminUser = User::where('email', 'it@hadaf-hq.com')->first();
        if ($adminUser) {
            $adminTeam = Team::create([
                'name' => 'Admin Team',
                'owner_id' => $adminUser->id,
                'company_id' => null,
            ]);
            $adminUser->update(['team_id' => $adminTeam->id]);
            
            // Set team context and assign admin role
            setPermissionsTeamId($adminTeam->id);
            $adminUser->assignRole('admin');
        }

        // Get all companies and create teams for each
        $companies = Company::with('user')->get();
        
        foreach ($companies as $company) {
            if ($company->user) {
                // Create a team for this company
                $team = Team::create([
                    'name' => $company->name . ' Team',
                    'owner_id' => $company->user->id,
                    'company_id' => $company->id,
                ]);

                // Assign the company owner to this team
                $company->user->update(['team_id' => $team->id]);
                
                // Set team context and assign company role (company owner always gets company role)
                setPermissionsTeamId($team->id);
                $company->user->assignRole('company');

                // Get all employees of this company and assign them to the same team
                $employees = Employee::where('company_id', $company->id)->get();
                
                foreach ($employees as $employee) {
                    // Find the user associated with this employee (if exists)
                    $employeeUser = User::where('email', $employee->email)->first();
                    if ($employeeUser) {
                        $employeeUser->update(['team_id' => $team->id]);
                        
                        // Set the team context and assign employee role (all employees get employee role)
                        setPermissionsTeamId($team->id);
                        $employeeUser->assignRole('employee');
                    }
                }
            }
        }

        // Handle any users without teams (create individual teams for them)
        $usersWithoutTeams = User::whereNull('team_id')->get();
        foreach ($usersWithoutTeams as $user) {
            $individualTeam = Team::create([
                'name' => $user->name . ' Team',
                'owner_id' => $user->id,
                'company_id' => null,
            ]);
            $user->update(['team_id' => $individualTeam->id]);
            
            // Set team context and assign company role as default
            setPermissionsTeamId($individualTeam->id);
            $user->assignRole('company');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset all users' team_id to null
        User::query()->update(['team_id' => null]);
        
        // Delete all teams
        Team::query()->delete();
    }
};
