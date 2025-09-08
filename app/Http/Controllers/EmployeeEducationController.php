<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeEducationController extends Controller
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
        $educations = $employee->educations;
        
        return view('employee.educations.index', compact('educations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        return view('employee.educations.create');
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
            'title' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'certificate_type' => 'nullable|string|max:255',
        ]);

        $employee = Auth::user()->employee;
        
        $education = $employee->educations()->create([
            'title' => $request->title,
            'institute_name' => $request->institute_name,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->boolean('is_current'),
            'certificate_type' => $request->certificate_type,
        ]);

        return redirect()->route('employee.educations.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم إضافة التعليم بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeEducation $education)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($education->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('employee.educations.edit', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeEducation $education)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($education->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'institute_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'certificate_type' => 'nullable|string|max:255',
        ]);

        $education->update([
            'title' => $request->title,
            'institute_name' => $request->institute_name,
            'start_date' => $request->start_date,
            'end_date' => $request->is_current ? null : $request->end_date,
            'is_current' => $request->boolean('is_current'),
            'certificate_type' => $request->certificate_type,
        ]);

        return redirect()->route('employee.educations.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم تحديث التعليم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeEducation $education)
    {
        if (!Auth::user()->employee) {
            abort(403, 'You must be an employee to access this resource');
        }
        if ($education->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
        $education->delete();

        return redirect()->route('employee.educations.index', ['locale' => app()->getLocale()])
            ->with('success', 'تم حذف التعليم بنجاح');
    }
}
