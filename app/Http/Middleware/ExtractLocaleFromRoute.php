<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class ExtractLocaleFromRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from the route parameter
        $locale = $request->route('locale');
        
        // If locale is provided and is supported, set it
        if ($locale && in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            
            // Store in session for persistence
            session(['locale' => $locale]);
        } else {
            // If no locale in URL, check session or use default
            $sessionLocale = session('locale');
            if ($sessionLocale && in_array($sessionLocale, ['en', 'ar'])) {
                App::setLocale($sessionLocale);
            } else {
                // Use default locale from config
                App::setLocale(config('app.locale', 'en'));
            }
        }

        return $next($request);
    }
}
