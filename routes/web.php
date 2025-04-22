<?php

use App\Http\Controllers\Admin\CompanyEmployeesController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->middleware(['auth', 'role:admin', SetLocale::class])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/companies/{company}/sync', [CompaniesController::class, 'sync'])->name('admin.companies.sync');
    Route::get('/companies/{company}/audit', [CompaniesController::class, 'audit'])->name('admin.companies.audit');
    Route::resource('/companies', CompaniesController::class)->names('admin.companies');

    Route::prefix('companies/{company}')->group(function () {
        Route::get('/employees/create', [CompanyEmployeesController::class, 'create'])->name('admin.employees.create');
        Route::get('/employees/{employee}', [CompanyEmployeesController::class, 'show'])->name('admin.companies.employees.show');
        Route::post('/employees', [CompanyEmployeesController::class, 'store'])->name('admin.employees.store');
        Route::post('/employees/{employee}/disable', [CompanyEmployeesController::class, 'disable'])->name('admin.employees.disable');
        Route::post('/employees/{employee}/tasks', [CompanyEmployeesController::class, 'assignTask'])->name('admin.employees.assignTask');
    });
});

Route::prefix('company')->middleware(['auth', 'role:company', SetLocale::class])->group(function () {
    Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
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

require __DIR__.'/auth.php';
