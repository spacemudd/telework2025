<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LegalController extends Controller
{
    public function privacy()
    {
        $SEOData = new SEOData(
            title: __('Privacy Policy') . ' - Telework2025',
            description: __('Our privacy policy explains how we collect, use, and protect your personal information.')
        );

        return view('legal.privacy', compact('SEOData'));
    }

    public function terms()
    {
        $SEOData = new SEOData(
            title: __('Terms of Service') . ' - Telework2025',
            description: __('Our terms of service outline the rules and regulations for using our platform.')
        );

        return view('legal.terms', compact('SEOData'));
    }
}
