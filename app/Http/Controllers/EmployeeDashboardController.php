<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->employee->tasks()->latest()->paginate(10);
        return view('employee.dashboard', compact('tasks'));
    }
}
