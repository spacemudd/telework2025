<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\JobPosting::class => \App\Policies\JobPostingPolicy::class,
        \App\Models\EmployeeExperience::class => \App\Policies\EmployeeExperiencePolicy::class,
        \App\Models\EmployeeEducation::class => \App\Policies\EmployeeEducationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
} 