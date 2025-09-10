<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Company;
use App\Models\TalentCategory;
use App\Models\Skill;
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
        // Ensure team context is set before role checks
        if (auth()->check() && auth()->user()->team_id) {
            setPermissionsTeamId(auth()->user()->team_id);
        }

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
            return redirect()->route('onboarding.job-seeker', ['locale' => app()->getLocale()]);
        }

        // Store the selected role in session and redirect to company onboarding
        session(['onboarding_role' => 'company']);
        return redirect()->route('onboarding.company', ['locale' => app()->getLocale()]);
    }

    /**
     * Show company onboarding form
     */
    public function showCompanyForm()
    {
        if (session('onboarding_role') !== 'company') {
            return redirect()->route('onboarding.index', ['locale' => app()->getLocale()]);
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

        return redirect()->route('company.dashboard', ['locale' => app()->getLocale()])->with('success', __('Welcome! Your company profile has been set up successfully.'));
    }

    /**
     * Show job seeker onboarding form
     */
    public function showJobSeekerForm()
    {
        if (session('onboarding_role') !== 'job_seeker') {
            return redirect()->route('onboarding.index', ['locale' => app()->getLocale()]);
        }

        $talentCategories = TalentCategory::active()->ordered()->get();
        $skills = Skill::active()->orderByRaw('CASE WHEN name_ar IS NOT NULL AND name_ar != "" THEN 0 ELSE 1 END')->orderBy('sort_order')->orderBy('name')->get();
        
        return view('onboarding.job-seeker', compact('talentCategories', 'skills'));
    }

    /**
     * Show job seeker onboarding form with talent categories
     */
    public function showJobSeekerOnboarding()
    {
        $talentCategories = TalentCategory::active()->ordered()->get();
        $skills = Skill::active()->orderByRaw('CASE WHEN name_ar IS NOT NULL AND name_ar != "" THEN 0 ELSE 1 END')->orderBy('sort_order')->orderBy('name')->get();
        
        return view('onboarding.job-seeker', compact('talentCategories', 'skills'));
    }

    /**
     * Handle job seeker onboarding completion
     */
    public function completeJobSeekerOnboarding(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'skills' => 'required|string',
            'experience_level' => 'required|in:none,1_3_years,3_5_years,5_plus_years',
            'preferred_work_type' => 'required|in:full_time,part_time,contract,freelance'
        ]);

        // Convert comma-separated skills string to array
        $skillIds = array_filter(explode(',', $request->skills));
        
        // Validate skill IDs exist
        if (empty($skillIds)) {
            return back()->withErrors(['skills' => 'Please select at least one skill.'])->withInput();
        }
        
        $validSkillIds = Skill::whereIn('id', $skillIds)->pluck('id')->toArray();
        if (count($skillIds) !== count($validSkillIds)) {
            return back()->withErrors(['skills' => 'Invalid skills selected.'])->withInput();
        }

        DB::transaction(function () use ($request, $skillIds) {
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
            $fullName = $request->first_name . ' ' . $request->last_name;
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $fullName // Keep for backward compatibility
            ]);

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
                'name' => $fullName,
                'email' => $user->email,
                'phone' => null,
                'position' => 'Job Seeker',
                'identity_number' => 'JS-' . time(), // Generate a unique identity number
                'user_id' => $user->id,
                'skills' => '', // Keep for backward compatibility, but we'll use relationships
                'experience_level' => $request->experience_level,
                'preferred_work_type' => $request->preferred_work_type,
                'is_job_seeker' => true,
                'profile_completed' => true,
            ]);

            // Attach skills
            $employee->skills()->attach($skillIds);

            // Attach talent categories
            $employee->talentCategories()->attach($request->talent_categories);

            // Set team context for role assignment
            setPermissionsTeamId($user->team_id);
            
            // Assign the employee role to the user (job seekers are treated as employees)
            $user->assignRole('employee');
        });

        // Clear onboarding session data
        session()->forget('onboarding_role');

        return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])->with('success', __('words.profile_completed_successfully'));
    }
}
