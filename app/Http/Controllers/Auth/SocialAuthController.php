<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle()
    {
        // Store the current locale in session for callback
        session(['oauth_locale' => app()->getLocale()]);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Random password since they're using OAuth
                    'email_verified_at' => now(), // Google users are pre-verified
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                // Update existing user with Google ID if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            }
            
            // Log the user in
            Auth::login($user);
            
            // Get the stored locale or default to 'en'
            $locale = session('oauth_locale', 'en');
            
            // Check if user has a role assigned
            if ($user->roles->count() === 0) {
                // New user, redirect to onboarding
                return redirect()->route('onboarding.index', ['locale' => $locale]);
            }
            
            // Existing user with role, redirect to dashboard
            return redirect()->intended(route('dashboard', ['locale' => $locale], absolute: false));
            
        } catch (\Exception $e) {
            $locale = session('oauth_locale', 'en');
            return redirect()->route('login', ['locale' => $locale])->with('error', 'Authentication failed. Please try again.');
        }
    }

    /**
     * Redirect to LinkedIn OAuth provider
     */
    public function redirectToLinkedIn()
    {
        // Store the current locale in session for callback
        session(['oauth_locale' => app()->getLocale()]);
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback
     */
    public function handleLinkedInCallback(Request $request)
    {
        try {
            // Log all request parameters for debugging
            \Log::info('LinkedIn Callback Request:', [
                'all_params' => $request->all(),
                'query_params' => $request->query(),
                'code' => $request->get('code'),
                'state' => $request->get('state'),
                'error' => $request->get('error'),
                'error_description' => $request->get('error_description'),
            ]);
            
            // Check if there's an error from LinkedIn
            if ($request->has('error')) {
                \Log::error('LinkedIn OAuth Error from callback:', [
                    'error' => $request->get('error'),
                    'error_description' => $request->get('error_description'),
                ]);
                throw new \Exception('LinkedIn OAuth Error: ' . $request->get('error_description', $request->get('error')));
            }
            
            // Check if code parameter is missing
            if (!$request->has('code')) {
                \Log::error('LinkedIn OAuth: No authorization code received');
                throw new \Exception('No authorization code received from LinkedIn');
            }
            
            $linkedinUser = Socialite::driver('linkedin')->user();
            
            // Log the LinkedIn user data for debugging
            \Log::info('LinkedIn User Data:', [
                'id' => $linkedinUser->getId(),
                'name' => $linkedinUser->getName(),
                'email' => $linkedinUser->getEmail(),
                'avatar' => $linkedinUser->getAvatar(),
            ]);
            
            // Check if user already exists
            $user = User::where('email', $linkedinUser->getEmail())->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $linkedinUser->getName(),
                    'email' => $linkedinUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Random password since they're using OAuth
                    'email_verified_at' => now(), // LinkedIn users are pre-verified
                    'linkedin_id' => $linkedinUser->getId(),
                ]);
            } else {
                // Update existing user with LinkedIn ID if not set
                if (!$user->linkedin_id) {
                    $user->update(['linkedin_id' => $linkedinUser->getId()]);
                }
            }
            
            // Log the user in
            Auth::login($user);
            
            // Get the stored locale or default to 'en'
            $locale = session('oauth_locale', 'en');
            
            // Check if user has a role assigned
            if ($user->roles->count() === 0) {
                // New user, redirect to onboarding
                return redirect()->route('onboarding.index', ['locale' => $locale]);
            }
            
            // Existing user with role, redirect to dashboard
            return redirect()->intended(route('dashboard', ['locale' => $locale], absolute: false));
            
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('LinkedIn OAuth Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            $locale = session('oauth_locale', 'en');
            return redirect()->route('login', ['locale' => $locale])->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }
}
