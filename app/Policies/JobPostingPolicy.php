<?php

namespace App\Policies;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPostingPolicy
{
    use HandlesAuthorization;

    public function view(User $user, JobPosting $jobPosting)
    {
        return $user->primaryCompany && $user->primaryCompany->id === $jobPosting->company_id;
    }

    public function update(User $user, JobPosting $jobPosting)
    {
        return $user->primaryCompany && $user->primaryCompany->id === $jobPosting->company_id;
    }

    public function delete(User $user, JobPosting $jobPosting)
    {
        return $user->primaryCompany && $user->primaryCompany->id === $jobPosting->company_id;
    }
}
