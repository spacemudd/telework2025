<?php

namespace App\Http\Controllers\Admin;

use App\Events\CompanyApprovedEvent;
use App\Http\Controllers\Controller;
use App\Jobs\TeleworkSyncCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompaniesController extends Controller
{
    function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    function create()
    {
        return view('admin.companies.create');
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'address' => ['required', 'string', 'max:255'],
            'cr_number' => ['required', 'string', 'max:255', 'unique:companies,cr_number'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $company = Company::create($validated);
        event(new CompanyApprovedEvent($company));

        return redirect()->route('admin.companies.index')->with('success', __('words.company_created_successfully'));
    }

    function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    function audit(Company $company)
    {
        return view('admin.companies.audit', compact('company'));
    }

    function sync(Company $company)
    {
        TeleworkSyncCompany::dispatch($company);
        return redirect()->route('admin.companies.show', $company->id)->with('success', __('words.company_synced_successfully'));
    }

    public function email(Company $company)
    {
        return view('admin.companies.email', compact('company'));
    }

    public function sendEmail(Request $request, Company $company)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::raw($request->message, function ($mail) use ($request, $company) {
            $mail->to($company->email)
                  ->bcc(['sara@hadaf-hq.com', 'trainee.affairs@hadaf-hq.com', 'cfo@hadaf-hq.com'])
                  ->subject($request->subject);
        });

        return redirect()->route('admin.companies.show', $company->id)
                         ->with('success', 'تم إرسال البريد الإلكتروني بنجاح.');
    }

    public function export()
    {
        $companies = \App\Models\Company::with(['employees'])->get();
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $csvHeader = [
            'Code',
            'Name',
            'Email',
            'Address',
            'CR Number',
            'Active Employees',
            'Tasks Created This Month',
            'Date Added',
        ];

        $rows = [];
        foreach ($companies as $company) {
            // Count employees (non-deleted)
            $activeEmployees = $company->employees()->count();
            // Get all employee IDs for this company
            $employeeIds = $company->employees()->pluck('id');
            // Count tasks created this month for these employees
            $tasksThisMonth = 0;
            if ($employeeIds->count() > 0) {
                $tasksThisMonth = \App\Models\Task::whereIn('employee_id', $employeeIds)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->count();
            }
            $rows[] = [
                $company->code,
                $company->name,
                $company->email,
                $company->address,
                $company->cr_number,
                $activeEmployees,
                $tasksThisMonth,
                $company->created_at ? $company->created_at->format('Y-m-d H:i') : '',
            ];
        }

        // UTF-8 BOM for Excel compatibility
        $output = "\xEF\xBB\xBF";
        $output .= implode(',', $csvHeader) . "\n";
        foreach ($rows as $row) {
            $output .= implode(',', array_map(function ($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }

        $filename = 'companies_' . now()->format('Y_m_d_His') . '.csv';

        return response($output, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function tasksStats(Request $request, Company $company)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        if (!$dateFrom) {
            $dateFrom = now()->startOfMonth()->format('Y-m-d');
        }
        if (!$dateTo) {
            $dateTo = now()->format('Y-m-d');
        }
        $employeeIds = $company->employees()->pluck('id');
        $tasks = \App\Models\Task::whereIn('employee_id', $employeeIds)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        // Daily data for chart
        $startDate = \Carbon\Carbon::parse($dateFrom);
        $endDate = \Carbon\Carbon::parse($dateTo);
        $days = [];
        $pendingData = [];
        $inProgressData = [];
        $completedData = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dayKey = $date->format('Y-m-d');
            $days[] = $date->format('M d');
            $dayTasks = $tasks->filter(function ($task) use ($dayKey) {
                return $task->created_at->format('Y-m-d') === $dayKey;
            });
            $pendingData[] = $dayTasks->where('status', 'pending')->count();
            $inProgressData[] = $dayTasks->where('status', 'in_progress')->count();
            $completedData[] = $dayTasks->where('status', 'completed')->count();
        }
        $chartData = [
            'labels' => $days,
            'datasets' => [
                [
                    'label' => __('words.pending'),
                    'data' => $pendingData,
                    'backgroundColor' => 'rgba(107, 114, 128, 0.8)',
                    'borderColor' => 'rgba(107, 114, 128, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => __('words.in_progress'),
                    'data' => $inProgressData,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.8)',
                    'borderColor' => 'rgba(251, 191, 36, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => __('words.completed'),
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
        return response()->json([
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'chartData' => $chartData,
        ]);
    }
}
