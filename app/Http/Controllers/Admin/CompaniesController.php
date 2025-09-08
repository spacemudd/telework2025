<?php

namespace App\Http\Controllers\Admin;

use App\Events\CompanyApprovedEvent;
use App\Http\Controllers\Controller;
use App\Jobs\TeleworkSyncCompany;
use App\Mail\TeamInvitationMail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'email' => ['required', 'email', 'max:255'], // No longer unique
            'address' => ['required', 'string', 'max:255'],
            'cr_number' => ['required', 'string', 'max:255', 'unique:companies,cr_number'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        // Check if user exists with this email
        $user = User::where('email', $validated['email'])->first();
        $generatedPassword = null;
        
        if (!$user) {
            // Create new user
            $generatedPassword = Str::random(12);
            $user = User::create([
                'email' => $validated['email'],
                'name' => $validated['name'],
                'password' => Hash::make($generatedPassword),
            ]);
            // Assign company role
            $user->assignRole('company');
        }

        // Create company
        $company = Company::create($validated);
        
        // Attach user to company with owner role
        $company->users()->attach($user->id, [
            'role' => 'owner',
            'is_primary' => !$user->companies()->exists(), // First company is primary
        ]);

        // Create simulation configuration with enabled by default
        $company->config()->create([
            'tasks_per_day' => 1,
            'auto_complete' => true,
            'is_enabled' => true, // Enable simulation by default
            'completion_rate' => 70,
            'in_progress_rate' => 20,
            'comment_only_rate' => 10,
        ]);

        // Send invitation email to owner (queue)
        Mail::to($user->email)->queue(new TeamInvitationMail($company, $user->email, $generatedPassword, 'owner'));

        return redirect()->route('admin.companies.index')->with('success', __('words.company_created_successfully'));
    }

    function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    function edit(Company $company)
    {
        $company->load('users');
        return view('admin.companies.edit', compact('company'));
    }

    function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:companies,name,' . $company->id],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cr_number' => ['required', 'string', 'max:255', 'unique:companies,cr_number,' . $company->id],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $company->update($validated);

        return redirect()->route('admin.companies.show', $company->id)
                        ->with('success', __('words.company_updated_successfully'));
    }

    public function attachUser(Request $request, Company $company)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:owner,admin,member',
        ]);

        $email = $request->email;
        $role = $request->role;

        // Check if user already exists
        $user = User::where('email', $email)->first();
        
        if ($user) {
            // User exists, check if already attached to this company
            if ($company->users()->where('user_id', $user->id)->exists()) {
                return back()->with('error', __('words.user_already_attached_to_company'));
            }
            
            // Link existing user to company
            $this->attachUserToCompany($company, $user->id, $role);
            
            // Ensure base company role for routing
            if (!$user->hasRole('company')) {
                $user->assignRole('company');
            }
            
            return back()->with('success', __('words.user_already_exists'));
        } else {
            // Create new user
            $password = Str::random(12);
            $user = User::create([
                'email' => $email,
                'name' => explode('@', $email)[0], // Use part before @ as name
                'password' => Hash::make($password),
            ]);
            
            // Assign company role
            $user->assignRole('company');
            
            // Link user to company
            $this->attachUserToCompany($company, $user->id, $role);
            
            // Send invitation email
            Mail::to($email)->send(new TeamInvitationMail($company, $email, $password, $role));
            
            return back()->with('success', __('words.user_invited_successfully'));
        }
    }

    private function attachUserToCompany($company, $userId, $role)
    {
        // If this is an owner role, make sure only one owner exists
        if ($role === 'owner') {
            $company->users()->update(['is_primary' => false]);
        }

        // For invited users, if they don't have any other primary company, make this one primary
        $user = User::find($userId);
        $hasPrimaryCompany = $user->companies()->where('is_primary', true)->exists();
        
        $company->users()->attach($userId, [
            'role' => $role,
            'is_primary' => $role === 'owner' || !$hasPrimaryCompany,
        ]);
    }

    public function detachUser(Request $request, Company $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $user = $company->users()->where('user_id', $userId)->first();

        if (!$user) {
            return back()->with('error', __('words.user_not_found_in_company'));
        }

        // Don't allow removing the last owner
        if ($user->pivot->role === 'owner' && $company->users()->where('role', 'owner')->count() <= 1) {
            return back()->with('error', __('words.cannot_remove_last_owner'));
        }

        $company->users()->detach($userId);

        return back()->with('success', __('words.user_detached_successfully'));
    }

    public function updateUserRole(Request $request, Company $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:owner,admin,member',
        ]);

        $userId = $request->user_id;
        $newRole = $request->role;

        $user = $company->users()->where('user_id', $userId)->first();

        if (!$user) {
            return back()->with('error', __('words.user_not_found_in_company'));
        }

        // If changing to owner role, update primary status
        if ($newRole === 'owner') {
            $company->users()->update(['is_primary' => false]);
            $company->users()->updateExistingPivot($userId, [
                'role' => $newRole,
                'is_primary' => true,
            ]);
        } else {
            $company->users()->updateExistingPivot($userId, [
                'role' => $newRole,
                'is_primary' => false,
            ]);
        }

        return back()->with('success', __('words.user_role_updated_successfully'));
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

    public function uploadLogo(Request $request, Company $company)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);
        
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            // Delete existing logo if it exists
            if ($company->getFirstMedia('logos')) {
                $company->getFirstMedia('logos')->delete();
            }
            
            // Upload new logo
            $company->addMediaFromRequest('logo')
                ->toMediaCollection('logos');
        }
        
        return redirect()->route('admin.companies.edit', $company->id)
                        ->with('success', __('words.company_logo_uploaded_successfully'));
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
