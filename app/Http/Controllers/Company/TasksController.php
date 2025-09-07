<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Exports\TasksExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $company = $this->getCurrentCompany();
        
        if (!$company) {
            return redirect()->route('onboarding.company')->with('error', 'يرجى إكمال إعداد الشركة أولاً');
        }
        
        // Get all tasks for the company's employees
        $query = Task::whereHas('employee', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['employee', 'comments.user']);

        // Apply filters
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tasks = $query->latest()->paginate(20);
        $employees = $company->employees()->orderBy('name')->get();

        return view('company.tasks.index', compact('tasks', 'employees'));
    }

    public function export(Request $request)
    {
        $company = $this->getCurrentCompany();
        
        if (!$company) {
            return redirect()->route('onboarding.company')->with('error', 'يرجى إكمال إعداد الشركة أولاً');
        }
        
        // Get all tasks for the company's employees
        $query = Task::whereHas('employee', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['employee', 'comments.user']);

        // Apply filters from modal
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Handle multiple statuses from modal
        if ($request->filled('statuses')) {
            $query->whereIn('status', $request->statuses);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tasks = $query->latest()->get();

        // Determine format (default to excel)
        $format = $request->get('format', 'excel');
        $timestamp = now()->format('Y-m-d-H-i-s');
        
        if ($format === 'excel') {
            $filename = 'tasks-report-' . $company->code . '-' . $timestamp . '.xlsx';
            return Excel::download(new TasksExport($tasks), $filename);
        } else {
            // CSV format
            $filename = 'tasks-report-' . $company->code . '-' . $timestamp . '.csv';
            return Excel::download(new TasksExport($tasks), $filename, \Maatwebsite\Excel\Excel::CSV);
        }
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
} 