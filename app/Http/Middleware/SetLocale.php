<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // First check if user is authenticated and has a locale preference
        if (auth()->check() && auth()->user()->locale) {
            App::setLocale(auth()->user()->locale);
        } else {
            // Fallback to session locale or default
            $sessionLocale = session('locale');
            if ($sessionLocale && in_array($sessionLocale, ['en', 'ar'])) {
                App::setLocale($sessionLocale);
            } else {
                App::setLocale(config('app.locale', 'en'));
            }
        }

        return $next($request);
    }
}
