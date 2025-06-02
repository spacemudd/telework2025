<?php

use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\SetLocale;
use App\Providers\EventServiceProvider;
use App\Providers\HorizonServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Sentry\Laravel\Integration;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Integration::handles($exceptions);
    })
    ->withProviders([
        EventServiceProvider::class,
        HorizonServiceProvider::class,
    ])
    ->withSchedule(function ($schedule) {
        $schedule->job(new \App\Jobs\GenerateSimulatedTasksJob())->daily()->between('05:00', '16:00');
        $schedule->job(new \App\Jobs\SimulateEmployeeResponseJob())->daily()->between('05:00', '16:00');

        // Schedule daily company tasks report for each company
        foreach (\App\Models\Company::all() as $company) {
            $schedule->job(new \App\Jobs\CompanyTasksReport($company))->dailyAt('05:00');
        }
    })
    ->create();
