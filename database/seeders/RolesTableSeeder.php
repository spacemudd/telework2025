<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create global roles (team_id = null means they can be used across all teams)
        Role::firstOrCreate(['name' => 'admin', 'team_id' => null]);
        Role::firstOrCreate(['name' => 'company', 'team_id' => null]);
        Role::firstOrCreate(['name' => 'employee', 'team_id' => null]);
    }
}
