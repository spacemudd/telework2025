<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Shafiq alShaar',
            'email' => 'it@hadaf-hq.com',
            'email_verified_at' => now(),
            'password' => bcrypt('it@2025'),
            'locale' => 'ar',
        ]);

        // Create an admin team for this user
        $adminTeam = Team::create([
            'name' => 'Admin Team',
            'owner_id' => $user->id,
            'company_id' => null,
        ]);

        // Assign the user to the team
        $user->update(['team_id' => $adminTeam->id]);

        // Set the team context for role assignment
        setPermissionsTeamId($adminTeam->id);
        
        // Now assign the role
        $user->assignRole('admin');
    }
}
