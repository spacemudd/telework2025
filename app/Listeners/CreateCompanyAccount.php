<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Team;
use App\Notifications\CompanyWelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateCompanyAccount
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
        DB::beginTransaction();
        $company = $event->company;

        $password = Str::random(12);

        // Create the user first
        $user = User::create([
            'name' => $company->name,
            'email' => $company->email,
            'password' => Hash::make($password),
        ]);

        // Create the company team with the user as owner
        $companyTeam = Team::create([
            'name' => $company->name . ' Team',
            'company_id' => $company->id,
            'owner_id' => $user->id,
        ]);

        // Update user with team_id
        $user->update(['team_id' => $companyTeam->id]);

        // Set team context and assign role
        setPermissionsTeamId($companyTeam->id);
        $user->assignRole('company');

        $company->user_id = $user->id;
        $company->save();

        // Create simulation configuration with enabled by default
        $company->config()->create([
            'tasks_per_day' => 1,
            'auto_complete' => true,
            'is_enabled' => true, // Enable simulation by default
            'completion_rate' => 70,
            'in_progress_rate' => 20,
            'comment_only_rate' => 10,
        ]);

        DB::commit();

        $user->notify(new CompanyWelcomeNotification($company->name, $user->email, $password));
    }
}
