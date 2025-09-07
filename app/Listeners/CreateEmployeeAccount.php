<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateEmployeeAccount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $employeeData = $event->employee;

        $password = Str::random(12);

        DB::beginTransaction();
        
        // Find or create the company's team
        $companyTeam = Team::where('company_id', $employeeData->company_id)->first();
        
        if (!$companyTeam) {
            // Create team for the company if it doesn't exist
            $companyTeam = Team::create([
                'name' => $employeeData->company->name . ' Team',
                'company_id' => $employeeData->company_id,
                'owner_id' => $employeeData->company->user_id,
            ]);
        }

        $user = User::create([
            'name' => $employeeData->name,
            'email' => $employeeData->email,
            'password' => Hash::make($password),
            'locale' => 'ar',
            'team_id' => $companyTeam->id,
        ]);

        // Set team context and assign role
        setPermissionsTeamId($companyTeam->id);
        $user->assignRole('employee');

        $employeeData->user_id = $user->id;
        $employeeData->save();

        $companyName = $employeeData->company->name;
        $linkedAt = $employeeData->created_at->format('d-m-Y');
        DB::commit();

        $user->notify(new \App\Notifications\EmployeeWelcomeNotification($companyName, $linkedAt, $user->email, $password));
    }
}
