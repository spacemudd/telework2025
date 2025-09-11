<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id'
        ]);

        $companyId = $request->company_id;
        $user = auth()->user();

        // Check if user is linked to this company
        if (!$user->companies()->where('company_id', $companyId)->exists()) {
            abort(403, 'You are not authorized to access this company.');
        }

        // Store selected company in session
        session(['selected_company_id' => $companyId]);

        return redirect()->back()->with('success', __('words.company_switched_successfully'));
    }

    public function getCurrentCompany()
    {
        $user = auth()->user();
        $selectedCompanyId = session('selected_company_id');
        
        if ($selectedCompanyId) {
            $company = $user->companies()->where('company_id', $selectedCompanyId)->first();
            if ($company) {
                return $company;
            }
        }
        
        // Fallback to primary company or first available company
        $company = $user->primaryCompany;
        if (!$company && $user->companies()->exists()) {
            $company = $user->companies()->first();
        }
        
        return $company;
    }
}
