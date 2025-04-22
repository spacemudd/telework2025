<?php

namespace Database\Seeders;

use App\Models\User;
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

        $user->assignRole('admin');
    }
}
