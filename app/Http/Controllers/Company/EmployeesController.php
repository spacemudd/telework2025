<?php

namespace App\Http\Controllers\Company;

use App\Events\TaskAssignedEvent;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $company = $this->getCurrentCompany();
        $employees = $company->employees()->paginate(20);

        return view('company.employees.index', compact('employees'));
    }

    private function getCurrentCompany()
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
        
        if (!$company) {
            abort(403, 'You are not associated with any company.');
        }
        
        return $company;
    }

    public function show(Employee $employee)
    {
        return view('company.employees.show', [
            'employee' => $employee,
        ]);
    }

    public function assignTask(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'in:low,medium,high'],
        ]);

        $task = $employee->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
        ]);

        // Fire the task assigned event to send email notification
        event(new TaskAssignedEvent($task));

        return redirect()->route('company.employees.show', $employee->id)->with('success', __('words.task_assigned_successfully'));
    }
}
