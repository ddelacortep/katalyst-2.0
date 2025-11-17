<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function showRegisterForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:Usuario,nombre_usuario',
            'correo' => 'required|string|email|max:255|unique:Usuario,correo',
            'contraseña' => 'required|string|min:6|confirmed',
        ]);

        // Crear un nuevo usuario
        $usuario = new \App\Models\Usuario();
        $usuario->nombre_usuario = $request->input('nombre_usuario');
        $usuario->correo = $request->input('correo');
        $usuario->contrasena = \Illuminate\Support\Facades\Hash::make($request->input('contraseña'));
        $usuario->save();

        
        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
