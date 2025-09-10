<?php

use App\Http\Controllers\Admin\CompanyEmployeesController;
use App\Http\Controllers\Admin\CompanyPerformanceController;
use App\Http\Controllers\Admin\CompanySimulationConfigController;
use App\Http\Controllers\Admin\GlobalSearchController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\Employee\TrackerController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Middleware\SetLocale;
use App\Models\User;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\JobPostingsController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeDashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\CompanyPagesController;
use App\Http\Controllers\TalentCategoryController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\EmployeeCvController;
use App\Http\Controllers\CompanyTasksReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MediaController;

// Redirect root to Arabic version
Route::get('/', function () {
    return redirect('/ar');
});

// Redirect /login to /ar/login
Route::get('/login', function () {
    return redirect('/ar/login');
});

// Redirect /register to /ar/register
Route::get('/register', function () {
    return redirect('/ar/register');
});

// Redirect /dashboard to /ar/dashboard (auth enforced by localized route)
Route::get('/dashboard', function () {
    return redirect('/ar/dashboard');
});

// Include auth routes
require __DIR__.'/auth.php';

// Media routes - no locale prefix needed
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show');

// Legal pages - Arabic only, no locale prefix needed
Route::get('/privacy', function() {
    app()->setLocale('ar');
    return app(\App\Http\Controllers\LegalController::class)->privacy();
})->name('legal.privacy');
Route::get('/terms', function() {
    app()->setLocale('ar');
    return app(\App\Http\Controllers\LegalController::class)->terms();
})->name('legal.terms');

// Public URLs.
Route::group([
    'prefix' => '{locale?}',
    'middleware' => [ 'extract_locale' ],
    'where' => ['locale' => 'en|ar']
], function() {
    Route::get('/', [HomepageController::class, 'index']);

    Route::get('/for-companies', [CompanyPagesController::class, 'forCompanies'])->name('company.for-companies');
    Route::post('/for-companies/contact', [CompanyPagesController::class, 'submitContactForm'])->name('company.contact.submit');

    // Talent Categories Routes
    Route::get('/talent-categories', [TalentCategoryController::class, 'index'])->name('talent-categories.index');
    Route::get('/talent-categories/{category}', [TalentCategoryController::class, 'show'])->name('talent-categories.show');
    Route::post('/talent-categories/search', [TalentCategoryController::class, 'search'])->name('talent-categories.search');
    
    // Vacancies Route
    Route::get('/vacancies', [\App\Http\Controllers\VacanciesController::class, 'index'])->name('vacancies.index');

    // Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{jobPosting}', [JobController::class, 'show'])->name('jobs.show')->where('jobPosting', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
    
    // Debug route for job posting
    Route::get('/debug-job/{id}', function($id) {
        $job = \App\Models\JobPosting::find($id);
        if ($job) {
            return 'Job found: ' . $job->title;
        }
        return 'Job not found with ID: ' . $id;
    });
    
    Route::middleware('auth')->group(function() {
        Route::post('/jobs/{jobPosting}/apply', [JobController::class, 'apply'])->name('jobs.apply')->where('jobPosting', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::get('/my-applications', [JobController::class, 'myApplications'])->name('jobs.my-applications');
    });

    // Onboarding Routes
    Route::middleware('auth')->prefix('onboarding')->group(function () {
        Route::get('/', [OnboardingController::class, 'index'])->name('onboarding.index');
        Route::post('/select-role', [OnboardingController::class, 'selectRole'])->name('onboarding.select-role');
        Route::get('/company', [OnboardingController::class, 'showCompanyForm'])->name('onboarding.company');
        Route::post('/company', [OnboardingController::class, 'completeCompanyOnboarding'])->name('onboarding.company.complete');
        
        // Job Seeker Multi-step Onboarding
        Route::get('/job-seeker', [OnboardingController::class, 'showJobSeekerForm'])->name('onboarding.job-seeker')->middleware('onboarding_step:step1');
        Route::post('/job-seeker/step1', [OnboardingController::class, 'completeJobSeekerStep1'])->name('onboarding.job-seeker.step1.complete');
        Route::get('/job-seeker/step2', [OnboardingController::class, 'showJobSeekerStep2'])->name('onboarding.job-seeker.step2')->middleware('onboarding_step:step2');
        Route::post('/job-seeker/step2', [OnboardingController::class, 'completeJobSeekerStep2'])->name('onboarding.job-seeker.step2.complete');
        Route::get('/job-seeker/step3', [OnboardingController::class, 'showJobSeekerStep3'])->name('onboarding.job-seeker.step3')->middleware('onboarding_step:step3');
        Route::post('/job-seeker/step3', [OnboardingController::class, 'completeJobSeekerStep3'])->name('onboarding.job-seeker.step3.complete');
        
        // Legacy routes for backward compatibility
        Route::get('/job-seeker/onboarding', [OnboardingController::class, 'showJobSeekerOnboarding'])->name('onboarding.job-seeker.onboarding');
        Route::post('/job-seeker', [OnboardingController::class, 'completeJobSeekerOnboarding'])->name('onboarding.job-seeker.complete');
    });

    // API endpoint for job title suggestions - outside auth middleware for public access
    Route::get('/api/job-titles/search', [OnboardingController::class, 'searchJobTitles'])->name('api.job-titles.search');

    

    // Interview Routes - moved inside localized group
    Route::middleware(['auth'])->prefix('interview')->name('interview.')->group(function () {
        Route::get('/start', [InterviewController::class, 'start'])->name('start');
        Route::get('/{interview}', [InterviewController::class, 'conduct'])->name('conduct');
        Route::post('/{interview}/questions/{question}/response', [InterviewController::class, 'storeResponse'])->name('response.store');
        Route::post('/{interview}/questions/{question}/re-record', [InterviewController::class, 'reRecord'])->name('response.re-record');
        Route::post('/{interview}/complete', [InterviewController::class, 'complete'])->name('complete');
        Route::get('/test-locale', [InterviewController::class, 'testLocale'])->name('test-locale');
        Route::post('/test-upload', [InterviewController::class, 'testUpload'])->name('test-upload');
        Route::get('/{interview}/questions/{question}/test-binding', [InterviewController::class, 'testRouteBinding'])->name('test-binding');
        Route::get('/{interview}/debug', [InterviewController::class, 'debugInterview'])->name('debug-interview');
        
        // Test route for debugging
        Route::get('/{interview}/test-response', [InterviewController::class, 'testResponse'])->name('test-response');
    });

    // Fallback dashboard route - redirects to onboarding if no role
    Route::middleware(['auth', 'team_context'])->get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }
        
        if ($user->hasRole('company')) {
            return redirect('/company/dashboard');
        }
        
        if ($user->hasRole('employee')) {
            $employee = $user->employee;
            if ($employee && $employee->company && $employee->company->name === 'Job Seeker Platform') {
                return redirect('/employee/job-seeker-dashboard');
            }
            return redirect('/employee/dashboard');
        }
        
        // No role, redirect to onboarding
        return redirect()->route('onboarding.index', ['locale' => app()->getLocale()]);
    })->name('dashboard');

    // Profile Routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// System URLs.

// Removed the main dashboard route to prevent redirect loops
// Users should be redirected directly to their role-specific dashboards

Route::get('dev-login', function() {
    if (app()->isProduction()) return 404;
    
    // Find admin user directly from the database
    $adminUser = \DB::table('model_has_roles')
        ->join('users', 'model_has_roles.model_id', '=', 'users.id')
        ->where('model_has_roles.role_id', 1) // admin role
        ->where('model_has_roles.model_type', 'App\\Models\\User')
        ->select('users.*')
        ->first();
    
    if (!$adminUser) {
        throw new \Exception('No admin user found. Please create an admin user first.');
    }
    
    // Convert to User model and login
    $user = User::find($adminUser->id);
    auth()->login($user);
    
    // Set team context for the admin user
    if ($user->team_id) {
        setPermissionsTeamId($user->team_id);
    }
    
    return redirect('/admin/dashboard');
})->name('login.dev');

Route::get('/admin/impersonate-stop', function () {
    auth()->user()->leaveImpersonation();
    return redirect('/admin/dashboard');
})->name('admin.impersonate.stop');

Route::prefix('admin')->middleware(['auth', 'team_context', 'role:admin', SetLocale::class])->group(function () {
    Route::get('/search', [GlobalSearchController::class, 'search'])->name('admin.search');

    Route::get('/simulation', [SimulationController::class, 'index'])->name('admin.simulation.index');
    Route::post('/simulation', [SimulationController::class, 'store'])->name('admin.simulation.store');
    Route::get('/simulation/run', [SimulationController::class, 'run'])->name('admin.simulation.run');
    Route::get('/simulation/companies', [SimulationController::class, 'companies'])->name('admin.simulation.companies');
    Route::post('/simulation/companies/bulk-enable', [SimulationController::class, 'bulkEnable'])->name('admin.simulation.companies.bulk-enable');
    Route::post('/simulation/companies/bulk-disable', [SimulationController::class, 'bulkDisable'])->name('admin.simulation.companies.bulk-disable');
    Route::get('/simulation/costs', [SimulationController::class, 'costs'])->name('admin.simulation.costs');

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::get('/impersonate/{user}', function (\App\Models\User $user) {
        auth()->user()->impersonate($user);
        return redirect('/admin/dashboard');
    })->name('admin.impersonate');


    Route::post('/companies/{company}/simulation-config/run', [CompanySimulationConfigController::class, 'run'])->name('admin.companies.simulation-config.run');
    Route::post('/companies/{company}/simulation-config/respond', [CompanySimulationConfigController::class, 'respond'])->name('admin.companies.simulation-config.respond');
    Route::put('/companies/{company}/simulation-config', [CompanySimulationConfigController::class, 'update'])->name('admin.companies.simulation-config.update');
    Route::get('/companies/{company}/simulation-config', [CompanySimulationConfigController::class, 'index'])->name('admin.companies.simulation-config.index');

    Route::get('/companies/export', [\App\Http\Controllers\Admin\CompaniesController::class, 'export'])->name('admin.companies.export');
    Route::resource('/companies', CompaniesController::class)->names('admin.companies');

    Route::get('/companies/{company}/sync', [CompaniesController::class, 'sync'])->name('admin.companies.sync');
    Route::get('/companies/{company}/audit', [CompaniesController::class, 'audit'])->name('admin.companies.audit');
    Route::get('/companies/{company}/email', [CompaniesController::class, 'email'])->name('admin.companies.email');
    Route::post('/companies/{company}/email', [CompaniesController::class, 'sendEmail'])->name('admin.companies.sendEmail');
    Route::get('/companies/{company}/tasks-stats', [CompaniesController::class, 'tasksStats'])->name('admin.companies.tasks-stats');
    
    // Team management routes
    Route::post('/companies/{company}/users/attach', [CompaniesController::class, 'attachUser'])->name('admin.companies.users.attach');
    Route::post('/companies/{company}/users/detach', [CompaniesController::class, 'detachUser'])->name('admin.companies.users.detach');
    Route::put('/companies/{company}/users/role', [CompaniesController::class, 'updateUserRole'])->name('admin.companies.users.role');

    // Company logo upload route
    Route::post('/companies/{company}/upload-logo', [CompaniesController::class, 'uploadLogo'])->name('admin.companies.upload-logo');

    // Job Postings routes
    Route::resource('/job-postings', JobPostingsController::class)->names('admin.job-postings');
    Route::post('/job-postings/{jobPosting}/toggle-status', [JobPostingsController::class, 'toggleStatus'])->name('admin.job-postings.toggle-status');

    Route::resource('/employees', EmployeesController::class)->names('admin.employees');

    Route::resource('/support-tickets', \App\Http\Controllers\Admin\SupportTicketsController::class)->names('admin.support-tickets');
    Route::post('/support-tickets/{ticket}/messages', [\App\Http\Controllers\Admin\SupportTicketsMessageController::class, 'store'])->name('admin.support-tickets.messages.store');

    Route::resource('/employee-requests', \App\Http\Controllers\Admin\EmployeeRequestsController::class)->names('admin.employee-requests');
    Route::post('/employee-requests/{employee_request}/messages', [\App\Http\Controllers\Admin\EmployeeRequestMessageController::class, 'store'])->name('admin.employee-requests.messages.store');

    Route::prefix('companies/{company}')->group(function () {
        Route::get('/employees/create', [CompanyEmployeesController::class, 'create'])->name('admin.companies.employees.create');
        Route::get('/employees/{employee}', [CompanyEmployeesController::class, 'show'])->name('admin.companies.employees.show');
        Route::get('/employees/{employee}/edit', [CompanyEmployeesController::class, 'edit'])->name('admin.companies.employees.edit');
        Route::put('/employees/{employee}', [CompanyEmployeesController::class, 'update'])->name('admin.companies.employees.update');
        Route::post('/employees', [CompanyEmployeesController::class, 'store'])->name('admin.companies.employees.store');
        Route::post('/employees/{employee}/disable', [CompanyEmployeesController::class, 'disable'])->name('admin.employees.disable');
        Route::post('/employees/{employee}/tasks', [CompanyEmployeesController::class, 'assignTask'])->name('admin.employees.assignTask');
    });

    Route::view('/settings', 'admin.settings.index')->name('admin.settings');
    Route::get('/company-performance', [\App\Http\Controllers\Admin\CompanyPerformanceController::class, 'index'])->name('admin.company-performance.index');

    Route::delete('/tasks/{task}', [\App\Http\Controllers\Admin\TasksController::class, 'destroy'])->name('admin.tasks.destroy');
});

Route::prefix('company')->middleware(['auth', 'team_context', 'role:company', SetLocale::class])->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
    Route::post('/switch', [\App\Http\Controllers\Company\CompanyController::class, 'switch'])->name('company.switch');
    Route::resource('/employees', \App\Http\Controllers\Company\EmployeesController::class)->names('company.employees');
    Route::post('/employees/{employee}/tasks', [\App\Http\Controllers\Company\EmployeesController::class, 'assignTask'])->name('company.employees.assignTask');
    Route::get('/attendance/export', [CompanyDashboardController::class, 'exportAttendance'])->name('company.attendance.export');
    Route::get('/tasks', [\App\Http\Controllers\Company\TasksController::class, 'index'])->name('company.tasks.index');
    Route::get('/tasks/export', [\App\Http\Controllers\Company\TasksController::class, 'export'])->name('company.tasks.export');
    Route::resource('/support-tickets', \App\Http\Controllers\Company\SupportTicketsController::class)->names('company.support-tickets');
    Route::post('/support-tickets/{ticket}/messages', [\App\Http\Controllers\Company\SupportTicketsMessageController::class, 'store'])->name('company.support-tickets.messages.store');
    Route::resource('/employee-requests', \App\Http\Controllers\Company\EmployeeRequestsController::class)->names('company.employee-requests');
    Route::post('/tasks/{task}/comments', [\App\Http\Controllers\Company\TasksCommentController::class, 'store'])->name('company.tasks.comment');
    Route::resource('/job-postings', \App\Http\Controllers\Company\JobPostingController::class)->names('company.job-postings');
    Route::post('/job-postings/{jobPosting}/toggle-status', [\App\Http\Controllers\Company\JobPostingController::class, 'toggleStatus'])->name('company.job-postings.toggle-status');
});

Route::prefix('employee')->middleware(['auth', SetLocale::class])->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    Route::get('/job-seeker-dashboard', [EmployeeDashboardController::class, 'jobSeekerDashboard'])->name('employee.job-seeker-dashboard');
    Route::post('/cv/upload', [EmployeeCvController::class, 'upload'])->name('employee.cv.upload');
    Route::get('/cv/view', [EmployeeCvController::class, 'view'])->name('employee.cv.view');
    Route::delete('/cv/delete', [EmployeeCvController::class, 'delete'])->name('employee.cv.delete');
    Route::put('/tasks/{task}/status', [\App\Http\Controllers\Employee\TaskController::class, 'updateStatus'])->name('employee.tasks.updateStatus');
    
    // Experience and Education routes
    Route::resource('/experiences', \App\Http\Controllers\EmployeeExperienceController::class)->names('employee.experiences');
    Route::resource('/educations', \App\Http\Controllers\EmployeeEducationController::class)->names('employee.educations');
});

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    
    // Set locale in session
    session(['locale' => $locale]);
    App::setLocale($locale);

    // Update user locale if authenticated
    if (auth()->check()) {
        $user = auth()->user();
        $user->locale = $locale;
        $user->save();
    }
    
    return redirect()->back();
});


Route::post('/employee/tracker/ping', [TrackerController::class, 'ping'])->name('employee.tracker.ping');
Route::post('/employee/tracker/stop', [TrackerController::class, 'stop'])->name('employee.tracker.stop');

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/subscription/initiate', [\App\Http\Controllers\PaymentController::class, 'initiateSubscription'])->name('payment.subscription.initiate');
    Route::get('/payment/subscription/status', [\App\Http\Controllers\PaymentController::class, 'checkSubscriptionStatus'])->name('payment.subscription.status');
});

// Noon payment callback (no auth required)
Route::get('/payment/noon/callback', [\App\Http\Controllers\PaymentController::class, 'handleCallback'])->name('payment.noon.callback');

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
