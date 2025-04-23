<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $employee = Auth::user()->employee;

        if ($task->employee_id !== $employee->id) {
            abort(403);
        }

        $task->status = $request->status;
        $task->save();

        return back()->with('success', __('words.task_status_updated'));
    }
}
