<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::with('company')->latest()->paginate(20);
        return view('admin.employees.index', compact('employees'));
    }
    public function show(Employee $employee)
    {
        $employee = $employee->load('company', 'tasks');
        $company = $employee->company;
        return view('admin.employees.show', compact('employee', 'company'));
    }
}
