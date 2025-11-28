
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\CanvanController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\GoogleAuthController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/proyecto', [ProyectoController::class, 'index'])
        ->name('proyecto');

    Route::post('/proyecto/guardar', [ProyectoController::class, 'store'])
        ->name('proyecto.store');

    Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])
        ->name('proyecto.show');

    Route::post('/tareas/guardar', [TareaController::class, 'store'])
        ->name('tareas.store');

    Route::delete('/tareas/{tarea}', [TareaController::class, 'destroy'])
        ->name('tareas.destroy');
    
    Route::get('/tareas/{id}/edit', [TareaController::class, 'edit'])->name('tareas.edit');

    Route::put('/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');

    Route::delete('/proyecto/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyecto.destroy');

    // Rutas de invitaciones a proyectos - Gestionadas por ParticipaController
    Route::post('/participa/invitar', [App\Http\Controllers\ParticipaController::class, 'store'])
        ->name('participa.store');
    
    Route::delete('/participa/{proyectoId}/{usuarioId}', [App\Http\Controllers\ParticipaController::class, 'destroy'])
        ->name('participa.destroy');   

    Route::get('/canvan', [CanvanController::class, 'index'])->name('canvan');

    Route::get('/canvan/{id}', [CanvanController::class, 'show'])
        ->name('canvan.show');

});

Route::get('/', function () {
    return view('login');
});


Route::get('/prueba', function () {
    return view('prueba', [
        'tasks' => collect(),
    ]);
})->name('prueba');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.submit');

// ---------------------

Route::get('/google/auth', [GoogleAuthController::class, 'redirect'])->name('google.auth');
Route::get('/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::post('/tasks/{task}/push-to-calendar', [CalendarController::class, 'pushTaskToCalendar'])
    ->name('tasks.push-to-calendar');

Route::get('tareas', [TareaController::class, 'index'])->name('tareas.index');

