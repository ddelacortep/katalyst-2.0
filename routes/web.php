<?php

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/prueba', function () {
    return view('prueba');
})->name('prueba');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login'); 

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

// ---------------------

Route::post('/proyecto/guardar', [ProyectoController::class, 'store'])
    ->name('proyecto.store');

Route::post('/tareas/crear', [TareaController::class, 'create'])
    ->name('tareas.create');

Route::get('/proyecto', [ProyectoController::class, 'index'])
    ->name('proyecto'); 