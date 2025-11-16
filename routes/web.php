<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/proyecto', function () {
    return view('proyecto');
})->name('proyecto');

Route::get('/prueba', function () {
    return view('prueba');
})->name('prueba');

// -------------------------------------------------------------

Route::post('/proyecto/guardar', [ProyectoController::class, 'guardarEnTiempoReal'])
    ->name('proyectos.guardarTiempoReal');
