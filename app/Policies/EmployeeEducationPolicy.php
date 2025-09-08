<?php

namespace App\Policies;

use App\Models\EmployeeEducation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeEducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeEducation $education): bool
    {
        return $user->employee && $user->employee->id === $education->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeEducation $education): bool
    {
        return $user->employee && $user->employee->id === $education->employee_id;
    }
}
