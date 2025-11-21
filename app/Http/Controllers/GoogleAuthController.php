<?php

namespace App\Http\Controllers;

use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        $client = new Google_Client();
        $client->setClientId(config('app.google_client_id', env('GOOGLE_CLIENT_ID')));
        $client->setClientSecret(config('app.google_client_secret', env('GOOGLE_CLIENT_SECRET')));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        // Pedimos scope para crear eventos
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        // Forzar offline para obtener refresh token
        $client->setAccessType('offline');
        // Force approval prompt so we get a refresh token the first time
        $client->setPrompt('consent');

        return redirect($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return "Error: " . $request->get('error');
        }

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

        if (isset($token['error'])) {
            return "Token error: " . $token['error_description'] ?? $token['error'];
        }

        // Guarda token (siempre solo un registro)
        DB::table('google_tokens')->truncate();
        DB::table('google_tokens')->insert([
            'token' => json_encode($token),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('status', 'Google autorizado — tokens guardados.');
    }
}
