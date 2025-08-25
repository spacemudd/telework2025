<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $company = auth()->user()->owned_company;
        
        if (!$company) {
            return redirect()->route('onboarding.company')->with('error', 'يرجى إكمال إعداد الشركة أولاً');
        }
        
        // Ensure the task belongs to the authenticated user's company
        if ($task->employee->company_id !== $company->id) {
            abort(403, 'Unauthorized access to task');
        }
        
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        if ($request->has('reopen')) {
            $task->status = 'pending';
            $task->save();
        } elseif ($request->has('approve')) {
            $task->approved_at = now();
            $task->save();
        }

        return back()->with('success', 'تم إرسال التعليق بنجاح.');
    }
}
