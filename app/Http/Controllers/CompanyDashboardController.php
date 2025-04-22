<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company; // Assuming user has company relationship
        $employees = $company ? $company->employees : [];

        return view('company.dashboard', compact('employees'));
    }
}
