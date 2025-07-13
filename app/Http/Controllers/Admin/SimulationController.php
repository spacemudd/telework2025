<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SimulationConfig;
use App\Jobs\GenerateSimulatedTasksJob;
use App\Jobs\SimulateEmployeeResponseJob;

class SimulationController extends Controller
{
    public function index()
    {
        $config = SimulationConfig::first() ?? new SimulationConfig([
            'tasks_per_day' => 2,
            'auto_complete' => true,
            'completion_rate' => 70,
            'in_progress_rate' => 20,
            'comment_only_rate' => 10,
        ]);

        return view('admin.simulation.index', compact('config'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks_per_day' => 'required|integer|min:1',
            'auto_complete' => 'required|boolean',
            'completion_rate' => 'required|integer|min:0|max:100',
            'in_progress_rate' => 'required|integer|min:0|max:100',
            'comment_only_rate' => 'required|integer|min:0|max:100',
        ]);

        // Validate that total doesn't exceed 100%
        $totalRate = $validated['completion_rate'] + $validated['in_progress_rate'] + $validated['comment_only_rate'];
        if ($totalRate > 100) {
            return back()->withErrors(['total_rate' => 'إجمالي النسب لا يمكن أن يتجاوز 100%'])->withInput();
        }

        SimulationConfig::updateOrCreate(
            ['id' => 1],
            [
                'tasks_per_day' => $validated['tasks_per_day'],
                'auto_complete' => $validated['auto_complete'],
                'completion_rate' => $validated['completion_rate'],
                'in_progress_rate' => $validated['in_progress_rate'],
                'comment_only_rate' => $validated['comment_only_rate'],
            ]
        );

        return redirect()->route('admin.simulation.index')->with('success', 'تم تحديث إعدادات المحاكاة بنجاح.');
    }

    public function run()
    {
        dispatch_sync(new GenerateSimulatedTasksJob(null, optional(auth()->user())->id));

        //SimulateEmployeeResponseJob::dispatch();

        return redirect()->route('admin.simulation.index')->with('success', 'تم تشغيل المحاكاة بنجاح.');
    }
}
