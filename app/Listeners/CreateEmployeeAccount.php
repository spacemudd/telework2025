<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
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

        $user = User::create([
            'name' => $employeeData->name,
            'email' => $employeeData->email,
            'password' => Hash::make($password),
            'locale' => 'ar',
        ]);

        // Optionally link the employee's user_id if the Employee model exists
        if (method_exists($employeeData, 'update')) {
            $employeeData->update(['user_id' => $user->id]);
        }

        $companyName = $employeeData->company->name;
        $linkedAt = $employeeData->created_at->format('d-m-Y');

        $user->notify(new \App\Notifications\EmployeeWelcomeNotification($companyName, $linkedAt, $user->email, $password));
    }
}
