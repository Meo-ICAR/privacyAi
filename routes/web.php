<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Crea un redirect o un alias alla rotta di Filament
Route::redirect('/login', '/admin/login')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/impersonate/{user}', [App\Http\Controllers\ImpersonateController::class, 'impersonate'])->name('impersonate');
    Route::get('/stop-impersonating', [App\Http\Controllers\ImpersonateController::class, 'stopImpersonating'])->name('stop-impersonating');
    Route::get('/templates/dipendenti_import_template.xlsx', function () {
        return response()->download(storage_path('app/templates/dipendenti_import_template.xlsx'));
    })->name('template.dipendenti');
});
