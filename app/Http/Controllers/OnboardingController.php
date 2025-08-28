<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Company;
use App\Models\TalentCategory;
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
        // If user already has a role, redirect to appropriate dashboard
        if (auth()->user()->roles->count() > 0) {
            $user = auth()->user();
            
            if ($user->hasRole('admin')) {
                return redirect('/admin/dashboard');
            }
            
            if ($user->hasRole('company')) {
                return redirect('/company/dashboard');
            }
            
            if ($user->hasRole('employee')) {
                $employee = $user->employee;
                if ($employee && $employee->company && $employee->company->name === 'Job Seeker Platform') {
                    return redirect('/employee/job-seeker-dashboard');
                }
                return redirect('/employee/dashboard');
            }
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
            // Store the selected role in session and redirect to job seeker onboarding
            session(['onboarding_role' => 'job_seeker']);
            return redirect()->route('onboarding.job-seeker');
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
                $team = $user->team;
            }

            // Create the company
            $company = Company::create([
                'name' => $request->company_name,
                'email' => $user->email,
                'user_id' => $user->id,
                'address' => 'Address to be updated',
                'cr_number' => 'CR-' . time(),
                'phone' => 'Phone to be updated',
            ]);

            // Update team with company_id
            $team->update(['company_id' => $company->id]);

            // Set team context for role assignment
            setPermissionsTeamId($team->id);
            
            // Assign the company role to the user
            $user->assignRole('company');
        });

        // Clear onboarding session data
        session()->forget('onboarding_role');

        return redirect()->route('company.dashboard')->with('success', __('Welcome! Your company profile has been set up successfully.'));
    }

    /**
     * Show job seeker onboarding form
     */
    public function showJobSeekerForm()
    {
        if (session('onboarding_role') !== 'job_seeker') {
            return redirect()->route('onboarding.index');
        }

        $talentCategories = TalentCategory::active()->ordered()->get();
        
        return view('onboarding.job-seeker', compact('talentCategories'));
    }

    /**
     * Show job seeker onboarding form with talent categories
     */
    public function showJobSeekerOnboarding()
    {
        $talentCategories = TalentCategory::active()->ordered()->get();
        
        return view('onboarding.job-seeker', compact('talentCategories'));
    }

    /**
     * Handle job seeker onboarding completion
     */
    public function completeJobSeekerOnboarding(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'talent_categories' => 'required|array|min:1',
            'talent_categories.*' => 'exists:talent_categories,id',
            'skills' => 'required|string|max:500',
            'experience_level' => 'required|in:entry,mid_level,senior,expert',
            'preferred_work_type' => 'required|in:full_time,part_time,contract,freelance'
        ]);

        DB::transaction(function () use ($request) {
            $user = auth()->user();
            
            // Create a team for this job seeker user
            if (!$user->team_id) {
                $team = Team::create([
                    'name' => $user->name . ' Team',
                    'owner_id' => $user->id,
                    'company_id' => null,
                ]);

                // Update user with team_id
                $user->update(['team_id' => $team->id]);
            }

            // Update user's name
            $user->update(['name' => $request->full_name]);

            // Create a dummy company for job seekers (this allows us to create an employee record)
            $company = \App\Models\Company::create([
                'name' => 'Job Seeker Platform',
                'email' => 'platform@hadaf.com',
                'user_id' => $user->id,
                'address' => 'Virtual Platform',
                'cr_number' => 'JS-PLATFORM-' . time(),
                'phone' => 'N/A',
            ]);

            // Update team with company_id
            $team = $user->team;
            $team->update(['company_id' => $company->id]);

            // Create Employee record for job seeker
            $employee = \App\Models\Employee::create([
                'company_id' => $company->id,
                'name' => $request->full_name,
                'email' => $user->email,
                'phone' => null,
                'position' => 'Job Seeker',
                'identity_number' => 'JS-' . time(), // Generate a unique identity number
                'user_id' => $user->id,
                'skills' => $request->skills,
                'experience_level' => $request->experience_level,
                'preferred_work_type' => $request->preferred_work_type,
                'is_job_seeker' => true,
                'profile_completed' => true,
            ]);

            // Attach talent categories
            $employee->talentCategories()->attach($request->talent_categories);

            // Set team context for role assignment
            setPermissionsTeamId($user->team_id);
            
            // Assign the employee role to the user (job seekers are treated as employees)
            $user->assignRole('employee');
        });

        // Clear onboarding session data
        session()->forget('onboarding_role');

        return redirect()->route('employee.job-seeker-dashboard')->with('success', __('words.profile_completed_successfully'));
    }
}
