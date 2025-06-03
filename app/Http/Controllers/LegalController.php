<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LegalController extends Controller
{
    public function privacy()
    {
        $seo = new SEOData(
            title: __('Privacy Policy') . ' - Telework2025',
            description: __('Our privacy policy explains how we collect, use, and protect your personal information.')
        );
        
        return view('legal.privacy', compact('seo'));
    }
} 