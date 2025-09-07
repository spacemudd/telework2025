<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobApplication;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with(['company', 'jobCategory'])
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('closing_date')
                    ->orWhere('closing_date', '>=', now()->format('Y-m-d'));
            });

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('job_category_id')) {
            $query->where('job_category_id', $request->job_category_id);
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $jobPostings = $query->latest()->paginate(10)->withQueryString();

        // Data for filters
        $locations = JobPosting::query()->whereNotNull('location')->distinct()->pluck('location');
        $jobCategories = JobCategory::all();
        $employmentTypes = ['full_time', 'part_time', 'contract', 'freelance', 'remote'];
        
        // Create SEO data for job listings
        $SEOData = new \RalphJSmit\Laravel\SEO\Support\SEOData();
        $SEOData->title = __('words.job_listings');
        $SEOData->description = __('words.browse_available_jobs');
                        
        return view('jobs.index', compact('jobPostings', 'SEOData', 'locations', 'jobCategories', 'employmentTypes'));
    }
    
    public function show($locale, $jobPosting)
    {
        // Debug information
        \Log::info('JobController::show called with locale: ' . $locale . ', ID: ' . $jobPosting);
        
        try {
            // Find the job posting by ID
            $jobPosting = JobPosting::findOrFail($jobPosting);
            
            \Log::info('Job posting found: ' . $jobPosting->title);
            
            $hasApplied = false;
            
            if (Auth::check()) {
                $hasApplied = JobApplication::where('job_posting_id', $jobPosting->id)
                                ->where('user_id', Auth::id())
                                ->exists();
            }
            
            // Create SEO data for the job posting
            $SEOData = new \RalphJSmit\Laravel\SEO\Support\SEOData();
            $SEOData->title = $jobPosting->title . ' - ' . $jobPosting->company->name;
            $SEOData->description = \Illuminate\Support\Str::limit(strip_tags($jobPosting->description), 160);
            
            return view('jobs.show', compact('jobPosting', 'hasApplied', 'SEOData'));
        } catch (\Exception $e) {
            \Log::error('Error in JobController::show: ' . $e->getMessage());
            abort(404, 'Job posting not found');
        }
    }
    
    public function apply(Request $request, $locale, $jobPosting)
    {
        // Find the job posting by ID
        $jobPosting = JobPosting::findOrFail($jobPosting);
        
        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string'],
        ]);
        
        // Check if already applied
        $existingApplication = JobApplication::where('job_posting_id', $jobPosting->id)
                                ->where('user_id', Auth::id())
                                ->first();
                                
        if ($existingApplication) {
            return redirect()->route('jobs.show', ['jobPosting' => $jobPosting->id, 'locale' => $locale])
                            ->with('info', __('words.already_applied_for_job'));
        }
        
        // Create application
        JobApplication::create([
            'job_posting_id' => $jobPosting->id,
            'user_id' => Auth::id(),
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);
        
        return redirect()->route('jobs.show', ['jobPosting' => $jobPosting->id, 'locale' => $locale])
                        ->with('success', __('words.job_application_submitted_successfully'));
    }
    
    public function myApplications()
    {
        $applications = JobApplication::with('jobPosting.company')
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->paginate(10);
        
        // Create SEO data for my applications page
        $SEOData = new \RalphJSmit\Laravel\SEO\Support\SEOData();
        $SEOData->title = __('words.my_applications');
        $SEOData->description = __('words.view_your_job_applications');
                            
        return view('jobs.my-applications', compact('applications', 'SEOData'));
    }
}
