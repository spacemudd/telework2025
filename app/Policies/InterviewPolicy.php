<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Interview;
use App\Models\User;

class InterviewPolicy
{
    public function view(User $user, Interview $interview): bool
    {
        return $user->id === $interview->user_id;
    }

    public function update(User $user, Interview $interview): bool
    {
        return $user->id === $interview->user_id;
    }

    public function delete(User $user, Interview $interview): bool
    {
        return $user->id === $interview->user_id;
    }
}
