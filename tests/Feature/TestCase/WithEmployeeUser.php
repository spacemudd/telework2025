<?php

namespace Tests\Feature\TestCase;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait WithEmployeeUser
{
    /**
     * Create a user with the employee role.
     *
     * @return \App\Models\User
     */
    protected function createEmployeeUser(): User
    {
        $user = User::factory()->create();
        
        // Manually insert the role relationship since we can't use assignRole in tests
        $roleId = DB::table('roles')->where('name', 'employee')->first()->id ?? 2; // Fallback to ID 2 if not found
        
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,
            'model_type' => 'App\\Models\\User',
            'model_id' => $user->id,
            'team_id' => 1 // Default team ID
        ]);
        
        return $user;
    }
}
