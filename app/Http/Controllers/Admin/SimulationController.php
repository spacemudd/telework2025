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

        return redirect()->route('admin.simulation.index')
            ->with('success', 'تم تشغيل المحاكاة بنجاح.');
    }

    public function respond()
    {
        dispatch_sync(new SimulateEmployeeResponseJob());

        return redirect()->route('admin.simulation.index')
            ->with('success', 'تم تنفيذ ردود الموظفين بنجاح.');
    }

    public function companies()
    {
        $companies = \App\Models\Company::with(['config', 'employees'])->get();
        
        $enabledCompanies = $companies->filter(function ($company) {
            return $company->config && $company->config->is_enabled;
        });
        
        $disabledCompanies = $companies->filter(function ($company) {
            return !$company->config || !$company->config->is_enabled;
        });

        $companiesWithoutConfig = $companies->filter(function ($company) {
            return !$company->config;
        });

        $companiesWithConfig = $companies->filter(function ($company) {
            return $company->config;
        });

        // Calculate statistics
        $stats = [
            'total_companies' => $companies->count(),
            'enabled_companies' => $enabledCompanies->count(),
            'disabled_companies' => $disabledCompanies->count(),
            'companies_without_config' => $companiesWithoutConfig->count(),
            'total_employees' => $companies->sum(function($company) { return $company->employees->count(); }),
            'avg_tasks_per_day' => $companiesWithConfig->avg('config.tasks_per_day'),
            'avg_completion_rate' => $companiesWithConfig->avg('config.completion_rate'),
        ];

        return view('admin.simulation.companies', compact(
            'companies', 
            'enabledCompanies', 
            'disabledCompanies', 
            'companiesWithoutConfig',
            'stats'
        ));
    }

    public function bulkEnable(Request $request)
    {
        $companyIdsJson = $request->input('company_ids', '[]');
        $companyIds = json_decode($companyIdsJson, true) ?: [];
        
        if (empty($companyIds)) {
            return back()->with('error', 'يرجى اختيار شركة واحدة على الأقل.');
        }

        $companies = \App\Models\Company::whereIn('id', $companyIds)->get();
        
        foreach ($companies as $company) {
            if (!$company->config) {
                $company->config()->create([
                    'tasks_per_day' => 1,
                    'auto_complete' => true,
                    'is_enabled' => true, // Enable simulation by default
                    'completion_rate' => 70,
                    'in_progress_rate' => 20,
                    'comment_only_rate' => 10,
                ]);
            } else {
                $company->config()->update(['is_enabled' => true]);
            }
        }

        return back()->with('success', 'تم تفعيل المحاكاة لـ ' . count($companies) . ' شركة.');
    }

    public function bulkDisable(Request $request)
    {
        $companyIdsJson = $request->input('company_ids', '[]');
        $companyIds = json_decode($companyIdsJson, true) ?: [];
        
        if (empty($companyIds)) {
            return back()->with('error', 'يرجى اختيار شركة واحدة على الأقل.');
        }

        $companies = \App\Models\Company::whereIn('id', $companyIds)->get();
        
        foreach ($companies as $company) {
            if ($company->config) {
                $company->config()->update(['is_enabled' => false]);
            }
        }

        return back()->with('success', 'تم تعطيل المحاكاة لـ ' . count($companies) . ' شركة.');
    }
}
