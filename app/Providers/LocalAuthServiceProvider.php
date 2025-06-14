<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class LocalAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register custom user provider for local development
        Auth::provider('local_dev', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends EloquentUserProvider {
                public function validateCredentials(Authenticatable $user, array $credentials)
                {
                    // Check if we're in local environment or localhost URL
                    $isLocal = app()->environment('local');
                    $isLocalhost = false;
                    
                    if (app()->bound('request') && app('request')->getHost()) {
                        $host = app('request')->getHost();
                        $isLocalhost = $host === 'localhost' || 
                                      str_contains($host, 'localhost') ||
                                      $host === '127.0.0.1';
                    }
                    
                    // In local environment or localhost, allow "pass" as universal password
                    if (($isLocal || $isLocalhost) && isset($credentials['password']) && $credentials['password'] === 'pass') {
                        return true;
                    }
                    
                    // Otherwise, use normal password validation
                    return parent::validateCredentials($user, $credentials);
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
