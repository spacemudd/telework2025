<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use App\Models\TalentCategory;
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

        $logos = collect(File::files(public_path('logos')))
            ->filter(function ($file) {
                $ext = strtolower($file->getExtension());
                return in_array($ext, ['png', 'jpg', 'jpeg', 'svg', 'webp']);
            })
            ->sortBy(fn($file) => $file->getFilename())
            ->map(fn($file) => 'logos/' . $file->getFilename())
            ->values();

        return view('homepage.index', compact('SEOData', 'talentCategories', 'logos'));
    }
}
