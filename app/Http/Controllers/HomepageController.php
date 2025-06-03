<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomepageController extends Controller
{
    function index()
    {
        return view('homepage.index', [
            'SEOData' => new SEOData(
                title: __('words.homepage-title') .' - ' . __('words.app-name'),
                description: __('words.homepage-description'),
                robots: 'index, follow',
                openGraphTitle: __('words.app-name'),
                image: asset('img/logo_v2_on_white.png'),
            )
        ]);
    }
}
