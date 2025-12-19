<?php

namespace App\Services;

use Google_Client;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarService
{
    protected ?Usuario $user = null;

    /**
     * Set the user for this service instance
     */
    public function setUser(Usuario $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the user (either set explicitly or from auth)
     */
    protected function getUser(): Usuario
    {
        if ($this->user) {
            return $this->user;
        }

        $user = Auth::user();
        if (!$user instanceof Usuario) {
            throw new \Exception('No hay usuario autenticado.');
        }

        return $user;
    }

    /**
     * Create and configure Google Client for the current user
     */
    protected function client(): Google_Client
    {
        $user = $this->getUser();

        if (!$user->hasGoogleCalendarConnected()) {
            throw new \Exception('No tienes Google Calendar vinculado. Ve a tu perfil para conectar tu cuenta de Google.');
        }

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        $token = $user->getGoogleTokenArray();
        $client->setAccessToken($token);

        // Refrescar si expirado
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                
                // Mantener refresh token si no viene en la respuesta
                if (!isset($newToken['refresh_token']) && isset($token['refresh_token'])) {
                    $newToken['refresh_token'] = $token['refresh_token'];
                }
                
                $user->setGoogleToken($newToken);
                $client->setAccessToken($newToken);
            } else {
                // Token expirado sin refresh token, limpiar y pedir reautorización
                $user->clearGoogleToken();
                throw new \Exception('Tu sesión de Google ha caducado. Por favor, vuelve a conectar tu cuenta de Google.');
            }
        }

        return $client;
    }

    /**
     * Get Google Calendar service
     */
    public function service(): \Google_Service_Calendar
    {
        return new \Google_Service_Calendar($this->client());
    }

    /**
     * Check if current user has Google Calendar connected
     */
    public function isConnected(): bool
    {
        try {
            $user = $this->getUser();
            return $user->hasGoogleCalendarConnected();
        } catch (\Exception $e) {
            return false;
        }
    }
}
