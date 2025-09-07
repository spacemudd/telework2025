<?php

namespace App\Providers;

use Illuminate\Foundation\Http\Kernel;
use App\Http\Middleware\TeamsPermission;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\Interview;
use App\Policies\InterviewPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** @var Kernel $kernel */
        $kernel = app()->make(Kernel::class);

        $kernel->addToMiddlewarePriorityBefore(
            SubstituteBindings::class,
            TeamsPermission::class,
        );

        // Register Interview Policy
        Gate::policy(Interview::class, InterviewPolicy::class);

        // Register URL macro for localized routes
        URL::macro('localized', function ($name, $parameters = []) {
            $parameters['locale'] = $parameters['locale'] ?? app()->getLocale();
            return route($name, $parameters);
        });
    }
}
