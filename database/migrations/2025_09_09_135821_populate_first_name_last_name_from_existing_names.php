<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate first_name and last_name from existing name data
        \DB::table('users')->whereNull('first_name')->orWhereNull('last_name')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                if ($user->name) {
                    $nameParts = explode(' ', trim($user->name), 2);
                    $firstName = $nameParts[0] ?? '';
                    $lastName = $nameParts[1] ?? '';
                    
                    \DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                        ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear first_name and last_name fields
        \DB::table('users')->update([
            'first_name' => null,
            'last_name' => null,
        ]);
    }
};
