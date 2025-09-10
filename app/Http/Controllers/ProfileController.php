<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $skills = \App\Models\Skill::active()->ordered()->get();
        $user = $request->user();
        
        // Load the employee relationship with skills
        if ($user->employee) {
            $user->employee->load('skills');
        }
        
        return view('profile.edit', [
            'user' => $user,
            'skills' => $skills,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        
        // Update user basic information
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->name = $validated['first_name'] . ' ' . $validated['last_name']; // Keep for backward compatibility
        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $user->clearMediaCollection('profile_images');
            $user->addMediaFromRequest('profile_image')
                ->toMediaCollection('profile_images');
        }

        // Update or create employee record for additional fields
        if ($user->employee) {
            $employee = $user->employee;
        } else {
            // Create employee record if it doesn't exist (for job seekers)
            $employee = $user->employee()->create([
                'name' => $user->name,
                'email' => $user->email,
                'company_id' => \App\Models\Company::where('name', 'Job Seeker Platform')->first()?->id,
                'is_job_seeker' => true,
            ]);
        }

        // Update employee-specific fields
        $employee->update([
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'experience_level' => $validated['experience_level'] ?? null,
            'preferred_work_type' => $validated['preferred_work_type'] ?? null,
        ]);

        // Sync skills relationship
        if (isset($validated['skills']) && is_array($validated['skills'])) {
            $employee->skills()->sync($validated['skills']);
        } else {
            $employee->skills()->detach();
        }

        return Redirect::route('profile.edit', ['locale' => app()->getLocale()])
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
