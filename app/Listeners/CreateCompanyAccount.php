<?php

namespace App\Listeners;

use App\Models\User;
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

        $user = User::create([
            'name' => $company->name,
            'email' => $company->email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('company');

        $company->user_id = $user->id;
        $company->save();
        DB::commit();

        $user->notify(new CompanyWelcomeNotification($company->name, $user->email, $password));
    }
}
