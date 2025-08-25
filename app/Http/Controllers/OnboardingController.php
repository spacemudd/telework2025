<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    /**
     * Show the onboarding wizard step 1 - Choose role type
     */
    public function index()
    {
        // If user already has a role, redirect to dashboard
        if (auth()->user()->roles->count() > 0) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.index');
    }

    /**
     * Handle role selection
     */
    public function selectRole(Request $request)
    {
        $request->validate([
            'role_type' => 'required|in:company,job_seeker'
        ]);

        if ($request->role_type === 'job_seeker') {
            // For now, redirect back with disabled message
            return back()->with('error', __('Job seeker option is coming soon!'));
        }

        // Store the selected role in session and redirect to company onboarding
        session(['onboarding_role' => 'company']);
        return redirect()->route('onboarding.company');
    }

    /**
     * Show company onboarding form
     */
    public function showCompanyForm()
    {
        if (session('onboarding_role') !== 'company') {
            return redirect()->route('onboarding.index');
        }

        return view('onboarding.company');
    }

    /**
     * Handle company onboarding completion
     */
    public function completeCompanyOnboarding(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_size' => 'required|in:1-10,11-50,51-200,201-500,500+',
            'industry' => 'required|string|max:255',
            'expected_time_to_hire' => 'required|in:immediately,1-2_weeks,1_month,3_months,6_months,not_sure'
        ]);

        DB::transaction(function () use ($request) {
            $user = auth()->user();
            
            // Create a team for this company user
            if (!$user->team_id) {
                $team = Team::create([
                    'name' => $request->company_name . ' Team',
                    'owner_id' => $user->id,
                    'company_id' => null, // Will be updated after company creation
                ]);

                // Update user with team_id
                $user->update(['team_id' => $team->id]);
            } else {
                // Use existing team but update its name
                $team = $user->team;
                $team->update(['name' => $request->company_name . ' Team']);
            }

            // Create the actual Company record
            $company = \App\Models\Company::create([
                'name' => $request->company_name,
                'email' => $user->email,
                'user_id' => $user->id,
                'address' => 'Address to be updated',
                'cr_number' => 'CR to be updated',
                'phone' => 'Phone to be updated',
            ]);

            // Update team with company_id
            $team->update(['company_id' => $company->id]);

            // Update user's name to company name
            $user->update(['name' => $request->company_name]);

            // Set team context for role assignment
            setPermissionsTeamId($team->id);
            
            // Assign the company role to the user
            $user->assignRole('company');
        });

        // Clear onboarding session data
        session()->forget('onboarding_role');

        return redirect()->route('dashboard')->with('success', __('Welcome! Your company profile has been set up successfully.'));
    }
}
