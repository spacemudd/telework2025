<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeRequestsController extends Controller
{
    public function index()
    {
        $requests = EmployeeRequest::with('company')
            ->latest()
            ->paginate(20);
        return view('admin.employee_requests.index', compact('requests'));
    }

    public function show(EmployeeRequest $employeeRequest)
    {
        $employeeRequest->load('messages.sender', 'company');
        return view('admin.employee_requests.show', compact('employeeRequest'));
    }
}
