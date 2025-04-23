<?php

namespace App\Http\Controllers\Admin;

use App\Events\CompanyApprovedEvent;
use App\Http\Controllers\Controller;
use App\Jobs\TeleworkSyncCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompaniesController extends Controller
{
    function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    function create()
    {
        return view('admin.companies.create');
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'address' => ['required', 'string', 'max:255'],
            'cr_number' => ['required', 'string', 'max:255', 'unique:companies,cr_number'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $company = Company::create($validated);
        event(new CompanyApprovedEvent($company));

        return redirect()->route('admin.companies.index')->with('success', __('words.company_created_successfully'));
    }

    function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    function audit(Company $company)
    {
        return view('admin.companies.audit', compact('company'));
    }

    function sync(Company $company)
    {
        TeleworkSyncCompany::dispatch($company);
        return redirect()->route('admin.companies.show', $company->id)->with('success', __('words.company_synced_successfully'));
    }

    public function email(Company $company)
    {
        return view('admin.companies.email', compact('company'));
    }

    public function sendEmail(Request $request, Company $company)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::raw($request->message, function ($mail) use ($request, $company) {
            $mail->to($company->email)
                 ->subject($request->subject);
        });

        return redirect()->route('admin.companies.show', $company->id)
                         ->with('success', 'تم إرسال البريد الإلكتروني بنجاح.');
    }
}
