<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user has an employee record
        if (!$user->employee) {
            // Send users without an employee record to the job seeker dashboard
            return redirect()->route('employee.job-seeker-dashboard');
        }
        
        $tasks = $user->employee->tasks()->latest()->paginate(10);
        return view('employee.dashboard', compact('tasks'));
    }

    public function jobSeekerDashboard()
    {
        return view('employee.job-seeker-dashboard');
    }
}
