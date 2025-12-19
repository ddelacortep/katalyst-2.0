<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // Verificar que hay usuario autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para conectar Google Calendar.');
        }

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        
        // Scope para crear eventos en el calendario
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        // Forzar offline para obtener refresh token
        $client->setAccessType('offline');
        
        // Force approval prompt para obtener refresh token siempre
        $client->setPrompt('consent');

        // Guardar el ID del usuario en el state para recuperarlo en callback
        $state = base64_encode(json_encode([
            'user_id' => Auth::id()
        ]));
        $client->setState($state);

        return redirect($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            Log::error('Google OAuth error: ' . $request->get('error'));
            return redirect()->route('proyecto')->with('error', 'Error al conectar con Google: ' . $request->get('error'));
        }

        // Recuperar el user_id del state
        $state = $request->get('state');
        $stateData = json_decode(base64_decode($state), true);
        
        if (!$stateData || !isset($stateData['user_id'])) {
            Log::error('Google OAuth: No se pudo recuperar el user_id del state');
            return redirect()->route('proyecto')->with('error', 'Error de autenticación. Intenta de nuevo.');
        }

        $userId = $stateData['user_id'];

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        try {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

            if (isset($token['error'])) {
                Log::error('Google token error: ' . ($token['error_description'] ?? $token['error']));
                return redirect()->route('proyecto')->with('error', 'Error obteniendo token: ' . ($token['error_description'] ?? $token['error']));
            }

            // Buscar el usuario y guardar su token
            $user = \App\Models\Usuario::find($userId);
            
            if (!$user) {
                Log::error('Google OAuth: Usuario no encontrado con ID ' . $userId);
                return redirect()->route('proyecto')->with('error', 'Usuario no encontrado.');
            }

            $user->setGoogleToken($token);

            Log::info('Google Calendar conectado para usuario: ' . $user->correo);

            return redirect()->route('proyecto')->with('status', '¡Google Calendar conectado correctamente! Ahora puedes guardar tareas en tu calendario.');

        } catch (\Exception $e) {
            Log::error('Google OAuth exception: ' . $e->getMessage());
            return redirect()->route('proyecto')->with('error', 'Error al conectar con Google Calendar: ' . $e->getMessage());
        }
    }

    /**
     * Desconectar Google Calendar del usuario actual
     */
    public function disconnect()
    {
        $user = Auth::user();
        
        if ($user) {
            $user->clearGoogleToken();
            return redirect()->route('proyecto')->with('status', 'Google Calendar desconectado correctamente.');
        }

        return redirect()->route('proyecto')->with('error', 'No se pudo desconectar Google Calendar.');
    }
}
