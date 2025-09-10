<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnboardingStepMiddleware
{
    /**
     * Handle an incoming request to enforce onboarding step order.
     */
    public function handle(Request $request, Closure $next, string $step): Response
    {
        // Only apply to job seeker onboarding
        if (session('onboarding_role') !== 'job_seeker') {
            return $next($request);
        }

        $locale = app()->getLocale();

        switch ($step) {
            case 'step1':
                // Step 1 is always accessible if role is set
                break;

            case 'step2':
                // Step 2 requires step 1 to be completed
                if (!session('onboarding_step1')) {
                    return redirect()->route('onboarding.job-seeker', ['locale' => $locale])
                        ->with('error', __('auth.complete_previous_step'));
                }
                break;

            case 'step3':
                // Step 3 requires both step 1 and step 2 to be completed
                if (!session('onboarding_step1') || !session()->has('onboarding_step2')) {
                    // Redirect to the missing step
                    if (!session('onboarding_step1')) {
                        return redirect()->route('onboarding.job-seeker', ['locale' => $locale])
                            ->with('error', __('auth.complete_previous_step'));
                    }
                    return redirect()->route('onboarding.job-seeker.step2', ['locale' => $locale])
                        ->with('error', __('auth.complete_previous_step'));
                }
                break;
        }

        return $next($request);
    }
}