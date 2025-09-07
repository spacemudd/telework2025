<?php

namespace App\Providers;

use App\Http\Controllers\Auth\CustomLinkedInProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class LinkedInServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Socialite::extend('linkedin', function ($app) {
            $config = $app['config']['services.linkedin'];
            return Socialite::buildProvider(CustomLinkedInProvider::class, $config);
        });
    }
}
