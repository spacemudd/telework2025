<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        $company = auth()->user()->owned_company;
        
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
        $company = auth()->user()->owned_company;
        
        // Get all tasks for the company's employees with the same filters
        $query = Task::whereHas('employee', function ($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['employee', 'comments.user']);

        // Apply same filters as index
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

        $tasks = $query->latest()->get();

        // Headers
        $csvHeaders = [
            'اسم الموظف',
            'عنوان المهمة',
            'الوصف',
            'الأولوية',
            'الحالة',
            'تاريخ الاستحقاق',
            'تاريخ الإنشاء',
            'التعليقات'
        ];
        
        $rows = [$csvHeaders];

        foreach ($tasks as $task) {
            $comments = $task->comments->map(function ($comment) {
                return $comment->user->name . ': ' . $comment->comment . ' (' . $comment->created_at->format('Y-m-d H:i') . ')';
            })->implode(' | ');

            $row = [
                $task->employee->name,
                $task->title,
                $task->description,
                __('words.' . $task->priority),
                __('words.' . $task->status),
                Carbon::parse($task->due_date)->format('Y-m-d'),
                $task->created_at->format('Y-m-d H:i'),
                $comments
            ];

            $rows[] = $row;
        }

        $filename = 'tasks-report-' . $company->code . '-' . now()->format('Y-m-d') . '.csv';

        $handle = fopen('php://temp', 'r+');
        
        // Add UTF-8 BOM for Excel compatibility
        fwrite($handle, "\xEF\xBB\xBF");
        
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        return Response::stream(function () use ($handle) {
            fpassthru($handle);
        }, 200, [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }


} 