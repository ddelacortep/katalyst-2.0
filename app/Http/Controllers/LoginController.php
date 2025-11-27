<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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
            if (Auth::check() && Auth::id() !== $usuario->id) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            Auth::login($usuario);
            $request->session()->regenerate();
            $response = redirect('/proyecto');
        } else {
            session()->flash('error', 'Credenciales inválidas');
            $response = redirect()->back()->withInput();
        }
        return $response;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
