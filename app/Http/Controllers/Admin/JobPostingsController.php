<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobPostingsController extends Controller
{
    /**
     * Handle company logo upload with validation
     */
    private function handleLogoUpload($request, $company)
    {
        if ($request->hasFile('company_logo') && $request->file('company_logo')->isValid()) {
            $file = $request->file('company_logo');
            
            // Validate file type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['company_logo' => 'Only JPEG, PNG, GIF, and WebP images are allowed.']);
            }
            
            // Validate file size (2MB max)
            if ($file->getSize() > 2048 * 1024) {
                return back()->withErrors(['company_logo' => 'File size must not exceed 2MB.']);
            }
            
            // Sanitize filename
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            if (empty($filename)) {
                $filename = 'company_logo_' . time() . '.' . $file->getClientOriginalExtension();
            }
            
            try {
                $company->addMediaFromRequest('company_logo')
                    ->usingName($filename)
                    ->toMediaCollection('logos');
            } catch (\Exception $e) {
                return back()->withErrors(['company_logo' => 'Failed to upload logo. Please try again.']);
            }
        }
        
        return null; // No error
    }
    public function index()
    {
        $jobPostings = JobPosting::with('company')->latest()->paginate(10);
        return view('admin.job-postings.index', compact('jobPostings'));
    }
    
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::where('is_active', true)->get();
        return view('admin.job-postings.create', compact('companies', 'jobCategories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'company_id' => ['nullable', 'string', 'exists:companies,id'],
            'employment_type' => ['required', 'string', 'in:full_time,part_time,contract,freelance,remote'],
            'location' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gt:salary_min'],
            'closing_date' => ['nullable', 'date', 'after:today'],
            'is_active' => ['sometimes', 'boolean'],
            // New company fields
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_logo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Additional validation based on company option
        if ($request->filled('company_name')) {
            // Creating new company - validate required fields
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
            ]);
        } else {
            // Using existing company - validate company_id is required
            $request->validate([
                'company_id' => ['required', 'string', 'exists:companies,id'],
            ]);
        }

        // Handle company creation or selection
        if ($request->filled('company_name')) {
            // Create new company
            $company = Company::create([
                'name' => $validated['company_name'],
                'email' => $validated['company_email'],
                'phone' => $validated['company_phone'],
                'website' => $validated['company_website'],
            ]);

            // Handle logo upload with validation
            $logoError = $this->handleLogoUpload($request, $company);
            if ($logoError) {
                return $logoError;
            }

            $validated['company_id'] = $company->id;
        } else {
            // Use existing company
            $validated['company_id'] = $request->company_id;
        }

        // Remove company fields from job posting data
        unset($validated['company_name'], $validated['company_email'], $validated['company_phone'], $validated['company_website'], $validated['company_logo']);
        
        $jobPosting = JobPosting::create($validated);
        
        return redirect()->route('admin.job-postings.index')
                        ->with('success', __('words.job_posting_created_successfully'));
    }
    
    public function show(JobPosting $jobPosting)
    {
        $jobPosting->load(['company', 'jobCategory', 'applications.user']);
        return view('admin.job-postings.show', compact('jobPosting'));
    }
    
    public function edit(JobPosting $jobPosting)
    {
        $companies = Company::all();
        $jobCategories = JobCategory::where('is_active', true)->get();
        return view('admin.job-postings.edit', compact('jobPosting', 'companies', 'jobCategories'));
    }
    
    public function update(Request $request, JobPosting $jobPosting)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'company_id' => ['nullable', 'string', 'exists:companies,id'],
            'employment_type' => ['required', 'string', 'in:full_time,part_time,contract,freelance,remote'],
            'location' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gt:salary_min'],
            'closing_date' => ['nullable', 'date', 'after:today'],
            'is_active' => ['sometimes', 'boolean'],
            // New company fields
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_logo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Additional validation based on company option
        if ($request->filled('company_name')) {
            // Creating new company - validate required fields
            $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
            ]);
        } else {
            // Using existing company - validate company_id is required
            $request->validate([
                'company_id' => ['required', 'string', 'exists:companies,id'],
            ]);
        }

        // Handle company creation or selection
        if ($request->filled('company_name')) {
            // Create new company
            $company = Company::create([
                'name' => $validated['company_name'],
                'email' => $validated['company_email'],
                'phone' => $validated['company_phone'],
                'website' => $validated['company_website'],
            ]);

            // Handle logo upload with validation
            $logoError = $this->handleLogoUpload($request, $company);
            if ($logoError) {
                return $logoError;
            }

            $validated['company_id'] = $company->id;
        } else {
            // Use existing company
            $validated['company_id'] = $request->company_id;
        }

        // Remove company fields from job posting data
        unset($validated['company_name'], $validated['company_email'], $validated['company_phone'], $validated['company_website'], $validated['company_logo']);
        
        $jobPosting->update($validated);
        
        return redirect()->route('admin.job-postings.show', $jobPosting->id)
                        ->with('success', __('words.job_posting_updated_successfully'));
    }
    
    public function destroy(JobPosting $jobPosting)
    {
        $jobPosting->delete();
        
        return redirect()->route('admin.job-postings.index')
                        ->with('success', __('words.job_posting_deleted_successfully'));
    }

    public function toggleStatus(JobPosting $jobPosting)
    {
        $jobPosting->update(['is_active' => !$jobPosting->is_active]);
        
        $status = $jobPosting->is_active ? __('words.enabled') : __('words.disabled');
        
        return redirect()->back()
                        ->with('success', __('words.job_posting_status_updated', ['status' => $status]));
    }
}
