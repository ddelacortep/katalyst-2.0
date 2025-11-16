<?php

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

Route::get('/proyecto', function () {
    return view('proyecto');
})->name('proyecto');

Route::get('/proyectos', function () {
    return view('proyectos');
})->name('proyectos');

Route::get('/prueba', function () {
    return view('prueba');
})->name('prueba');
