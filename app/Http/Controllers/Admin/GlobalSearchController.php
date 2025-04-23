<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json([]);
        }

        $companies = Company::where('name', 'like', "%$query%")
            ->limit(5)
            ->get();

        $employees = Employee::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->limit(5)
            ->get();

        $company_results = $companies->map(function ($company) {
            return [
                'type' => 'شركة',
                'name' => $company->name,
                'extra' => $company->email ?? '',
                'link' => url('/admin/companies/' . $company->id),
            ];
        });

        $employee_results = $employees->map(function ($employee) {
                return [
                    'type' => 'موظف',
                    'name' => $employee->name,
                    'extra' => $employee->email ?? '',
                    'link' => url('/admin/employees/' . $employee->id),
                ];
            });

        $results = array_merge($employee_results->toArray(), $company_results->toArray());

        return response()->json($results);
    }
}
