<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateSimulatedTasksJob;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanySimulationConfigController extends Controller
{
    public function index(Company $company)
    {
        //dd($company->config()->first());
        $company->config()->firstOrCreate(
            [
                'tasks_per_day' => 1,
                'auto_complete' => true,
            ]
        );

        return view('admin.companies.simulation-config.index', [
            'company' => $company,
            'config' => $company->config,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'tasks_per_day' => 'required|integer|min:1',
            'auto_complete' => 'boolean',
            'is_enabled' => 'boolean',
        ]);

        $company->config()->update([
                'tasks_per_day' => $validated['tasks_per_day'],
                'auto_complete' => $request->has('auto_complete'),
                'is_enabled' => $request->has('is_enabled'),
            ]);

        return redirect()->route('admin.companies.simulation-config.index', $company->id)
            ->with('success', 'تم تحديث إعدادات المحاكاة بنجاح.');
    }

    public function run(Company $company)
    {
        if (!$company->config) {
            return redirect()->route('admin.companies.simulation-config.index', $company->id)
                ->with('error', 'لا توجد إعدادات محاكاة لهذه الشركة.');
        }

        dispatch_sync(new GenerateSimulatedTasksJob($company, optional(auth()->user())->id));

        return redirect()->route('admin.companies.simulation-config.index', $company->id)
            ->with('success', 'تم تشغيل المحاكاة لهذه الشركة بنجاح.');
    }

    public function respond(Company $company)
    {
        if (!$company->config) {
            return redirect()->route('admin.companies.simulation-config.index', $company->id)
                ->with('error', 'لا توجد إعدادات محاكاة لهذه الشركة.');
        }

        dispatch_sync(new \App\Jobs\SimulateEmployeeResponseJob($company));

        return redirect()->route('admin.companies.simulation-config.index', $company->id)
            ->with('success', 'تم تنفيذ ردود الموظفين لهذه الشركة بنجاح.');
    }
}
