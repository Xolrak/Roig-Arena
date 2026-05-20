<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Panel de administración independiente
Route::get('/panel-admin', function () {
    return view('panel-admin');
});

// Compatibilidad con redirecciones antiguas
Route::get('/admin', function () {
    return redirect('/panel-admin');
});
