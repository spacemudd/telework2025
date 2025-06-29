<?php

namespace App\Http\Controllers\Admin;

use App\Events\EmployeeAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyEmployeesController extends Controller
{
    public function create(Company $company)
    {
        return view('admin.employees.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'identity_number' => ['required', 'string', 'max:255', 'unique:employees,identity_number'],
            'phone' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);

        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        $validated['company_id'] = $company->id;

        $employee = Employee::create($validated);
        event(new EmployeeAddedEvent($employee));

        return redirect()->route('admin.companies.show', $company->id)->with('success', __('words.employee_created_successfully'));
    }

    public function disable(Company $company, Employee $employee)
    {
        // For now, we simply soft delete the employee if soft deletes are enabled
        // Or alternatively, you can add a status field and mark it disabled.
        $employee->delete();

        return redirect()->route('admin.companies.show', $company->id)->with('success', __('words.employee_disabled_successfully'));
    }

    function show(Company $company, Employee $employee)
    {
        return view('admin.employees.show', compact('company', 'employee'));
    }

    public function edit(Company $company, Employee $employee)
    {
        return view('admin.employees.edit', compact('company', 'employee'));
    }

    public function update(Request $request, Company $company, Employee $employee)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email,' . $employee->id],
            'identity_number' => ['required', 'string', 'max:255', 'unique:employees,identity_number,' . $employee->id],
            'phone' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);

        // Validate email uniqueness in users table too, excluding the current employee's user
        $userRule = 'required|email|unique:users,email';
        if ($employee->user) {
            $userRule .= ',' . $employee->user->id;
        }
        
        $request->validate([
            'email' => $userRule,
        ]);

        // Update employee information
        $employee->update($validated);

        // Update user information if user exists
        if ($employee->user) {
            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.companies.employees.show', [$company->id, $employee->id])
            ->with('success', __('words.employee_updated_successfully'));
    }

    public function assignTask(Request $request, Company $company, Employee $employee)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $employee->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
        ]);

        return redirect()->route('admin.companies.employees.show', [$company->id, $employee->id])
            ->with('success', __('words.task_assigned_successfully'));
    }
}
