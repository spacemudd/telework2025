<?php

namespace App\Http\Controllers;

use App\Models\EmployeeExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        $employee = Auth::user()->employee;
        $experiences = $employee->experiences;
        
        return view('employee.experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        return view('employee.experiences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $employee = Auth::user()->employee;
        
        $experience = $employee->experiences()->create([
            'company_name' => $request->company_name,
            'job_title' => $request->job_title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->boolean('is_current'),
        ]);

        return redirect()->route('employee.experiences.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم إضافة الخبرة بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeExperience $experience)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($experience->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('employee.experiences.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeExperience $experience)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($experience->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $experience->update([
            'company_name' => $request->company_name,
            'job_title' => $request->job_title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->boolean('is_current'),
        ]);

        return redirect()->route('employee.experiences.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم تحديث الخبرة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeExperience $experience)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($experience->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        $experience->delete();

        return redirect()->route('employee.experiences.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم حذف الخبرة بنجاح');
    }
}
