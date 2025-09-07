<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyContactRequest;
use App\Mail\CompanyContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CompanyPagesController extends Controller
{
    public function forCompanies()
    {
        $SEOData = new SEOData(
            title: __('words.companies.title') .' - ' . __('words.app-name'),
            description: __('words.companies.subtitle'),
            openGraphTitle: __('words.app-name'),
            image: asset('img/logo_v2_on_white.png')
        );

        return view('company.for-companies', compact('SEOData'));
    }

    public function submitContactForm(CompanyContactRequest $request)
    {
        // Send email notification
        Mail::to(config('mail.company_contact_email', 'contact@hadaf.sa'))
            ->send(new CompanyContactFormSubmitted($request->validated()));

        return back()->with('success', __('messages.contact_form_submitted'));
    }
}
