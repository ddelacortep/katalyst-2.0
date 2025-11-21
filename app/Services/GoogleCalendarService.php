<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\DB;

class GoogleCalendarService
{
    protected function client(): Google_Client
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        $row = DB::table('google_tokens')->where('id', 1)->first();
        if (! $row) {
            throw new \Exception('No Google token found. Autoriza primero: /google/auth');
        }

        $token = json_decode($row->token, true);
        $client->setAccessToken($token);

        // Refrescar si expirado
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                // merge refresh token if not returned again
                if (!isset($newToken['refresh_token']) && isset($token['refresh_token'])) {
                    $newToken['refresh_token'] = $token['refresh_token'];
                }
                DB::table('google_tokens')->where('id',1)->update([
                    'token' => json_encode($newToken),
                    'updated_at' => now()
                ]);
                $client->setAccessToken($newToken);
            } else {
                throw new \Exception('El token ha caducado y no hay refresh token. Reautoriza.');
            }
        }

        return $client;
    }

    public function service()
    {
        return new \Google_Service_Calendar($this->client());
    }
}
