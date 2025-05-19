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
        ]);

        return view('admin.simulation.index', compact('config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tasks_per_day' => 'required|integer|min:1',
            'auto_complete' => 'required|boolean',
        ]);

        SimulationConfig::updateOrCreate(
            ['id' => 1],
            $request->only(['tasks_per_day', 'auto_complete'])
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
