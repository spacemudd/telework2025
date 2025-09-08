<?php

namespace App\Policies;

use App\Models\EmployeeExperience;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeExperience $experience): bool
    {
        return $user->employee && $user->employee->id === $experience->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeExperience $experience): bool
    {
        return $user->employee && $user->employee->id === $experience->employee_id;
    }
}
