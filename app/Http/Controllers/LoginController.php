<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $usuario = Usuario::where('nombre_usuario', $request->input('nombre_usuario'))->first();

        if ($usuario && Hash::check($request->input('contraseña'), $usuario->contrasena)) { 
            $response = redirect('/');
        } else {
            session()->flash('error', 'Credenciales inválidas');
            $response = redirect()->back()->withInput();
        }
        return $response; 
    }
} 
