<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTeamContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set team context for authenticated users
        if (auth()->check() && auth()->user()->team_id) {
            setPermissionsTeamId(auth()->user()->team_id);
        }

        return $next($request);
    }
}
