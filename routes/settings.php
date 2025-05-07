<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'role:admin'])->group(function () {
    Route::view('/settings/company-defaults', 'admin.settings.company-defaults')->name('settings.company-defaults');
    Route::view('/settings/attendance-sheet', 'admin.settings.attendance-sheet')->name('settings.attendance-sheet');
    Route::view('/settings/ticketing-system', 'admin.settings.ticketing-system')->name('settings.ticketing-system');
    Route::view('/settings/alerts', 'admin.settings.alerts')->name('settings.alerts');
    Route::view('/settings/telework-integration', 'admin.settings.telework-integration')->name('settings.telework-integration');
});
