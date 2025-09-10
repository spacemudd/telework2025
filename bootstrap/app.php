<?php

use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\SetTeamContext;
use App\Providers\EventServiceProvider;
use App\Providers\HorizonServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
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
        $middleware->web(append: [
            SetTeamContext::class,
        ]);
        
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'team_context' => SetTeamContext::class,
            'extract_locale' => \App\Http\Middleware\ExtractLocaleFromRoute::class,
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'onboarding_step' => \App\Http\Middleware\OnboardingStepMiddleware::class,
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
        // Run once daily at specific times (adjusted for GMT+3 timezone)
        // 5:00 AM GMT+3 = 2:00 AM UTC
        $schedule->job(new \App\Jobs\GenerateSimulatedTasksJob())->dailyAt('02:00');
        // 6:00 AM GMT+3 = 3:00 AM UTC  
        $schedule->job(new \App\Jobs\SimulateEmployeeResponseJob())->dailyAt('03:00'); // Run after task generation

        // Schedule daily company tasks report for each company
        // 8:00 AM GMT+3 = 5:00 AM UTC
        try {
            if (Schema::hasTable('companies')) {
                foreach (\App\Models\Company::all() as $company) {
                    $schedule->job(new \App\Jobs\CompanyTasksReport($company))->dailyAt('05:00');
                }
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet, skip scheduling
        }
    })
    ->create();
