<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'تم حذف المهمة بنجاح.');
    }
}
