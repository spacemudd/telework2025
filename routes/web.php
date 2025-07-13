<?php

use App\Http\Controllers\Admin\CompanyEmployeesController;
use App\Http\Controllers\Admin\CompanyPerformanceController;
use App\Http\Controllers\Admin\CompanySimulationConfigController;
use App\Http\Controllers\Admin\GlobalSearchController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\Employee\TrackerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Middleware\SetLocale;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeDashboardController;

Route::middleware(SetLocale::class)->get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->hasRole('admin')) {
        return redirect('/admin/dashboard');
    }

    if (auth()->user()->hasRole('company')) {
        return redirect('/company/dashboard');
    }

    if (auth()->user()->hasRole('employee')) {
        return redirect('/employee/dashboard');
    }

    Log::alert('User has no role', [
        'user_id' => auth()->user()->id,
        'user_email' => auth()->user()->email,
    ]);
})->name('dashboard');

Route::get('dev-login', function() {
    if (app()->isProduction()) return 404;
    auth()->login(User::admins()->firstOrFail());
    return redirect()->route('dashboard');
})->name('login.dev');

Route::get('/admin/impersonate-stop', function () {
    auth()->user()->leaveImpersonation();
    return redirect()->route('dashboard');
})->name('admin.impersonate.stop');

Route::prefix('admin')->middleware(['auth', 'role:admin', SetLocale::class])->group(function () {
    Route::get('/search', [GlobalSearchController::class, 'search'])->name('admin.search');

    Route::get('/simulation', [SimulationController::class, 'index'])->name('admin.simulation.index');
    Route::post('/simulation', [SimulationController::class, 'store'])->name('admin.simulation.store');
    Route::get('/simulation/run', [SimulationController::class, 'run'])->name('admin.simulation.run');

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::get('/impersonate/{user}', function (\App\Models\User $user) {
        auth()->user()->impersonate($user);
        return redirect()->route('dashboard');
    })->name('admin.impersonate');


    Route::post('/companies/{company}/simulation-config/run', [CompanySimulationConfigController::class, 'run'])->name('admin.companies.simulation-config.run');
    Route::post('/companies/{company}/simulation-config/respond', [CompanySimulationConfigController::class, 'respond'])->name('admin.companies.simulation-config.respond');
    Route::put('/companies/{company}/simulation-config', [CompanySimulationConfigController::class, 'update'])->name('admin.companies.simulation-config.update');
    Route::get('/companies/{company}/simulation-config', [CompanySimulationConfigController::class, 'index'])->name('admin.companies.simulation-config.index');

    Route::get('/companies/{company}/sync', [CompaniesController::class, 'sync'])->name('admin.companies.sync');
    Route::get('/companies/{company}/audit', [CompaniesController::class, 'audit'])->name('admin.companies.audit');
    Route::get('/companies/{company}/email', [CompaniesController::class, 'email'])->name('admin.companies.email');
    Route::post('/companies/{company}/email', [CompaniesController::class, 'sendEmail'])->name('admin.companies.sendEmail');
    Route::resource('/companies', CompaniesController::class)->names('admin.companies');

    Route::resource('/employees', EmployeesController::class)->names('admin.employees');

    Route::resource('/support-tickets', \App\Http\Controllers\Admin\SupportTicketsController::class)->names('admin.support-tickets');
    Route::post('/support-tickets/{ticket}/messages', [\App\Http\Controllers\Admin\SupportTicketsMessageController::class, 'store'])->name('admin.support-tickets.messages.store');

    Route::prefix('companies/{company}')->group(function () {
        Route::get('/employees/create', [CompanyEmployeesController::class, 'create'])->name('admin.employees.create');
        Route::get('/employees/{employee}', [CompanyEmployeesController::class, 'show'])->name('admin.companies.employees.show');
        Route::get('/employees/{employee}/edit', [CompanyEmployeesController::class, 'edit'])->name('admin.companies.employees.edit');
        Route::put('/employees/{employee}', [CompanyEmployeesController::class, 'update'])->name('admin.companies.employees.update');
        Route::post('/employees', [CompanyEmployeesController::class, 'store'])->name('admin.employees.store');
        Route::post('/employees/{employee}/disable', [CompanyEmployeesController::class, 'disable'])->name('admin.employees.disable');
        Route::post('/employees/{employee}/tasks', [CompanyEmployeesController::class, 'assignTask'])->name('admin.employees.assignTask');
    });

    Route::view('/settings', 'admin.settings.index')->name('admin.settings');
    Route::get('/company-performance', [\App\Http\Controllers\Admin\CompanyPerformanceController::class, 'index'])->name('admin.company-performance.index');

    Route::delete('/tasks/{task}', [\App\Http\Controllers\Admin\TasksController::class, 'destroy'])->name('admin.tasks.destroy');
});

Route::prefix('company')->middleware(['auth', 'role:company', SetLocale::class])->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
    Route::resource('/employees', \App\Http\Controllers\Company\EmployeesController::class)->names('company.employees');
    Route::post('/employees/{employee}/tasks', [\App\Http\Controllers\Company\EmployeesController::class, 'assignTask'])->name('company.employees.assignTask');
    Route::get('/attendance/export', [CompanyDashboardController::class, 'exportAttendance'])->name('company.attendance.export');
    Route::get('/tasks', [\App\Http\Controllers\Company\TasksController::class, 'index'])->name('company.tasks.index');
    Route::get('/tasks/export', [\App\Http\Controllers\Company\TasksController::class, 'export'])->name('company.tasks.export');
    Route::resource('/support-tickets', \App\Http\Controllers\Company\SupportTicketsController::class)->names('company.support-tickets');
    Route::post('/support-tickets/{ticket}/messages', [\App\Http\Controllers\Company\SupportTicketsMessageController::class, 'store'])->name('company.support-tickets.messages.store');
    Route::post('/tasks/{task}/comments', [\App\Http\Controllers\Company\TasksCommentController::class, 'store'])->name('company.tasks.comment');
});

Route::prefix('employee')->middleware(['auth', 'role:employee', SetLocale::class])->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    Route::put('/tasks/{task}/status', [\App\Http\Controllers\Employee\TaskController::class, 'updateStatus'])->name('employee.tasks.updateStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    App::setLocale($locale);

    if (auth()->check()) {
        $user = auth()->user();
        $user->locale = $locale;
        $user->save();
    }
    return redirect()->back();
});

Route::post('/employee/tracker/ping', [TrackerController::class, 'ping'])->name('employee.tracker.ping');
Route::post('/employee/tracker/stop', [TrackerController::class, 'stop'])->name('employee.tracker.stop');

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
