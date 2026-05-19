<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Aplicación SPA: servir la vista principal también en /admin para evitar 404
Route::get('/admin', function () {
    return view('welcome');
});
