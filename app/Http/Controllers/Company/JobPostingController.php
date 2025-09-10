<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\JobCategory;
use App\Models\Sector;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    public function index()
    {
        $company = Auth::user()->primaryCompany;
        $jobPostings = JobPosting::where('company_id', $company->id)
            ->with(['jobCategory', 'applications'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.job-postings.index', compact('jobPostings'));
    }

    public function create()
    {
        $jobCategories = JobCategory::where('is_active', true)->get();
        return view('company.job-postings.create', compact('jobCategories'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->primaryCompany;

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'employment_type' => ['required', 'string', 'in:full_time,part_time,contract,freelance,remote'],
            'location' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gt:salary_min'],
            'closing_date' => ['nullable', 'date', 'after:today'],
        ]);

        $validated['company_id'] = $company->id;
        $validated['is_active'] = true;

        $jobPosting = JobPosting::create($validated);

        return redirect()->route('company.job-postings.index')
            ->with('success', __('words.job_posting_created_successfully'));
    }

    public function show(JobPosting $jobPosting)
    {
        // Ensure the job posting belongs to the company
        $this->authorize('view', $jobPosting);
        
        $jobPosting->load(['jobCategory', 'applications.user']);
        return view('company.job-postings.show', compact('jobPosting'));
    }

    public function edit(JobPosting $jobPosting)
    {
        // Ensure the job posting belongs to the company
        $this->authorize('update', $jobPosting);
        
        $jobCategories = JobCategory::where('is_active', true)->get();
        $sectors = Sector::where('is_active', true)->get();
        return view('company.job-postings.edit', compact('jobPosting', 'jobCategories', 'sectors'));
    }

    public function update(Request $request, JobPosting $jobPosting)
    {
        // Ensure the job posting belongs to the company
        $this->authorize('update', $jobPosting);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'sector_id' => ['nullable', 'exists:sectors,id'],
            'employment_type' => ['required', 'string', 'in:full_time,part_time,contract,freelance,remote'],
            'location' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gt:salary_min'],
            'closing_date' => ['nullable', 'date', 'after:today'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $jobPosting->update($validated);

        return redirect()->route('company.job-postings.index')
            ->with('success', __('words.job_posting_updated_successfully'));
    }

    public function destroy(JobPosting $jobPosting)
    {
        // Ensure the job posting belongs to the company
        $this->authorize('delete', $jobPosting);

        $jobPosting->delete();

        return redirect()->route('company.job-postings.index')
            ->with('success', __('words.job_posting_deleted_successfully'));
    }

    public function toggleStatus(JobPosting $jobPosting)
    {
        // Ensure the job posting belongs to the company
        $this->authorize('update', $jobPosting);

        $jobPosting->update(['is_active' => !$jobPosting->is_active]);

        $status = $jobPosting->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', __('words.job_posting_' . $status . '_successfully'));
    }
}
