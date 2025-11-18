<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/proyecto', [ProyectoController::class, 'index'])
        ->name('proyecto');
});

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

Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.submit');

// ---------------------

Route::post('/proyecto/guardar', [ProyectoController::class, 'store'])
    ->name('proyecto.store');

Route::post('/tareas/guardar', [TareaController::class, 'store'])
    ->name('tareas.store');

Route::delete('/tareas/{id}', [TareaController::class, 'destroy'])
    ->name('tareas.destroy');

Route::get('/proyecto', [ProyectoController::class, 'index'])
    ->name('proyecto');

Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])
    ->name('proyecto.show');

Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('proyecto.show');

Route::get('/tareas/{id}/edit', [TareaController::class, 'edit'])->name('tareas.edit');
