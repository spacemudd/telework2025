<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'comment' => 'nullable|string|max:1000',
        ]);

        $employee = Auth::user()->employee;

        if ($task->employee_id !== $employee->id) {
            abort(403);
        }

        $task->status = $request->status;
        $task->save();

        if ($request->filled('comment')) {
            TaskComment::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'comment' => $request->comment,
            ]);
        }

        return back()->with('success', __('words.task_status_updated'));
    }
}
