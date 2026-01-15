<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use App\Models\Company;
use App\Models\TalentCategory;
use App\Models\Skill;
use App\Notifications\JobSeekerWelcomeNotification;
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
            'role_type' => 'required|in:company,job_seeker',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
        ]);

        // If first/last name provided (social auth confirmation), update the user
        if (auth()->check() && ($request->filled('first_name') || $request->filled('last_name'))) {
            $user = auth()->user();
            $firstName = $request->filled('first_name') ? $request->string('first_name')->toString() : ($user->first_name ?? '');
            $lastName = $request->filled('last_name') ? $request->string('last_name')->toString() : ($user->last_name ?? '');
            $user->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => trim($firstName . ' ' . $lastName),
            ]);
        }

        if ($request->role_type === 'job_seeker') {
            $user = auth()->user();
            if ($user && !session('job_seeker_welcome_sent')) {
                $user->notify(new JobSeekerWelcomeNotification());
                session(['job_seeker_welcome_sent' => true]);
            }

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
     * Handle job seeker onboarding step 1 completion
     */
    public function completeJobSeekerStep1(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'skills' => 'required|string',
            'experience_level' => 'required|in:none,1_3_years,3_5_years,5_plus_years',
            'preferred_work_type' => 'required|in:full_time,part_time,contract,freelance,remote'
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

        // Store step 1 data in session
        session([
            'onboarding_step1' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'skills' => $skillIds,
                'experience_level' => $request->experience_level,
                'preferred_work_type' => $request->preferred_work_type,
                'talent_categories' => $request->talent_categories ?? []
            ]
        ]);

        return redirect()->route('onboarding.job-seeker.step2', ['locale' => app()->getLocale()]);
    }

    /**
     * Show job seeker onboarding step 2 - Experience
     */
    public function showJobSeekerStep2()
    {
        if (session('onboarding_role') !== 'job_seeker' || !session('onboarding_step1')) {
            return redirect()->route('onboarding.job-seeker', ['locale' => app()->getLocale()]);
        }

        return view('onboarding.job-seeker-step2');
    }

    /**
     * Handle job seeker onboarding step 2 completion
     */
    public function completeJobSeekerStep2(Request $request)
    {
        if (session('onboarding_role') !== 'job_seeker' || !session('onboarding_step1')) {
            return redirect()->route('onboarding.job-seeker', ['locale' => app()->getLocale()]);
        }

        // If skip is requested, just move to next step
        if ($request->has('skip')) {
            session(['onboarding_step2' => []]);
            return redirect()->route('onboarding.job-seeker.step3', ['locale' => app()->getLocale()]);
        }

        // Validate experiences
        $request->validate([
            'experiences' => 'sometimes|array',
            'experiences.*.job_title' => 'required|string|max:255',
            'experiences.*.company_name' => 'required|string|max:255',
            'experiences.*.start_date' => 'required|date',
            'experiences.*.end_date' => 'nullable|date|after:experiences.*.start_date',
            'experiences.*.is_current' => 'sometimes|boolean',
            'experiences.*.description' => 'nullable|string|max:1000'
        ]);

        // Store step 2 data in session
        session([
            'onboarding_step2' => $request->experiences ?? []
        ]);

        return redirect()->route('onboarding.job-seeker.step3', ['locale' => app()->getLocale()]);
    }

    /**
     * Show job seeker onboarding step 3 - Education
     */
    public function showJobSeekerStep3()
    {
        if (session('onboarding_role') !== 'job_seeker' || !session('onboarding_step1') || !session()->has('onboarding_step2')) {
            return redirect()->route('onboarding.job-seeker', ['locale' => app()->getLocale()]);
        }

        return view('onboarding.job-seeker-step3');
    }

    /**
     * Handle job seeker onboarding step 3 completion and finalize profile
     */
    public function completeJobSeekerStep3(Request $request)
    {
        if (session('onboarding_role') !== 'job_seeker' || !session('onboarding_step1') || !session()->has('onboarding_step2')) {
            return redirect()->route('onboarding.job-seeker', ['locale' => app()->getLocale()]);
        }

        // Validate educations unless skipped
        if (!$request->has('skip')) {
            $request->validate([
                'educations' => 'sometimes|array',
                'educations.*.title' => 'required|string|max:255',
                'educations.*.institute_name' => 'required|string|max:255',
                'educations.*.start_date' => 'required|date',
                'educations.*.end_date' => 'nullable|date|after:educations.*.start_date',
                'educations.*.is_current' => 'sometimes|boolean',
                'educations.*.certificate_type' => 'nullable|string|max:100'
            ]);
        }

        // Get all session data
        $step1Data = session('onboarding_step1');
        $step2Data = session('onboarding_step2', []);
        $step3Data = $request->has('skip') ? [] : ($request->educations ?? []);

        DB::transaction(function () use ($step1Data, $step2Data, $step3Data) {
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
            $fullName = $step1Data['first_name'] . ' ' . $step1Data['last_name'];
            $user->update([
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'name' => $fullName
            ]);

            // Create a dummy company for job seekers
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
                'identity_number' => 'JS-' . time(),
                'user_id' => $user->id,
                'skills' => '',
                'experience_level' => $step1Data['experience_level'],
                'preferred_work_type' => $step1Data['preferred_work_type'],
                'is_job_seeker' => true,
                'profile_completed' => true,
            ]);

            // Attach skills
            $employee->skills()->attach($step1Data['skills']);

            // Attach talent categories
            if (!empty($step1Data['talent_categories'])) {
                $employee->talentCategories()->attach($step1Data['talent_categories']);
            }

            // Create experiences
            foreach ($step2Data as $experienceData) {
                \App\Models\EmployeeExperience::create([
                    'employee_id' => $employee->id,
                    'job_title' => $experienceData['job_title'],
                    'company_name' => $experienceData['company_name'],
                    'start_date' => $experienceData['start_date'],
                    'end_date' => $experienceData['is_current'] ?? false ? null : $experienceData['end_date'],
                    'is_current' => $experienceData['is_current'] ?? false,
                    'description' => $experienceData['description'] ?? null,
                ]);
            }

            // Create educations
            foreach ($step3Data as $educationData) {
                \App\Models\EmployeeEducation::create([
                    'employee_id' => $employee->id,
                    'title' => $educationData['title'],
                    'institute_name' => $educationData['institute_name'],
                    'start_date' => $educationData['start_date'],
                    'end_date' => $educationData['is_current'] ?? false ? null : $educationData['end_date'],
                    'is_current' => $educationData['is_current'] ?? false,
                    'certificate_type' => $educationData['certificate_type'] ?? null,
                ]);
            }

            // Set team context for role assignment
            setPermissionsTeamId($user->team_id);
            
            // Assign the employee role to the user
            $user->assignRole('employee');
        });

        // Clear all onboarding session data
        session()->forget(['onboarding_role', 'onboarding_step1', 'onboarding_step2']);

        return redirect()->route('employee.job-seeker-dashboard', ['locale' => app()->getLocale()])->with('success', __('words.profile_completed_successfully'));
    }

    /**
     * Legacy method for backward compatibility
     * @deprecated Use completeJobSeekerStep3 instead
     */
    public function completeJobSeekerOnboarding(Request $request)
    {
        return $this->completeJobSeekerStep1($request);
    }

    /**
     * Search job titles for autocomplete
     */
    public function searchJobTitles(Request $request)
    {
        $query = $request->get('q', '');
        $locale = app()->getLocale();
        
        if (empty($query)) {
            return response()->json([]);
        }

        // Get job titles from language file
        $jobTitles = __('words.job_titles');
        
        // Filter job titles based on search query
        $filteredTitles = [];
        foreach ($jobTitles as $key => $title) {
            // Search in both Arabic and English characters
            if (str_contains(strtolower($title), strtolower($query))) {
                $filteredTitles[] = [
                    'id' => $key,
                    'text' => $title,
                    'value' => $title
                ];
            }
        }
        
        // Limit results to 10 for better performance
        $filteredTitles = array_slice($filteredTitles, 0, 10);
        
        return response()->json($filteredTitles);
    }
}
