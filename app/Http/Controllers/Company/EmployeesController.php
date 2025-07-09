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
        $employees = auth()->user()->owned_company->employees()->paginate(20);

        return view('company.employees.index', compact('employees'));
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
