<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Crea un redirect o un alias alla rotta di Filament
Route::redirect('/login', '/admin/login')->name('login');
