<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use App\Models\TalentCategory;
use App\Models\JobPosting;
use App\Models\JobCategory;
use Illuminate\Support\Facades\File;

class HomepageController extends Controller
{
    public function index()
    {
        $SEOData = new SEOData(
            title: __('words.homepage-title') .' - ' . __('words.app-name'),
            description: __('words.homepage-description'),
            openGraphTitle: __('words.app-name'),
            image: asset('img/logo_v2_on_white.png')
        );

        $talentCategories = TalentCategory::active()->ordered()->get();

        // Fetch cities from job postings
        $cities = JobPosting::whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->sort()
            ->values();

        // Fetch job categories
        $jobCategories = JobCategory::all();

        // Fetch active job postings with company information
        $jobPostings = JobPosting::with(['company', 'jobCategory'])
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('closing_date')
                      ->orWhere('closing_date', '>=', now());
            })
            ->latest()
            ->limit(6)
            ->get();

        $logos = collect(File::files(public_path('logos')))
            ->filter(function ($file) {
                $ext = strtolower($file->getExtension());
                return in_array($ext, ['png', 'jpg', 'jpeg', 'svg', 'webp']);
            })
            ->sortBy(fn($file) => $file->getFilename())
            ->map(fn($file) => 'logos/' . $file->getFilename())
            ->values();

        return view('homepage.index', compact('SEOData', 'talentCategories', 'logos', 'jobPostings', 'cities', 'jobCategories'));
    }
}