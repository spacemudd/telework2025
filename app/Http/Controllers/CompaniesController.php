<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function audit(Company $company)
    {
        $emailEvents = $company->emailEvents()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.companies.audit', [
            'company' => $company,
            'emailEvents' => $emailEvents,
        ]);
    }
} 