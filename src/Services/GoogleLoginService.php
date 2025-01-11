<?php

namespace PrestaShop\Module\OAuthSignIn\Services;

use Configuration;
use Google\Service\Oauth2;
use Google\Service\Oauth2\Userinfo;
use Google_Client;

use PrestaShop\Module\OAuthSignIn\Form\OAuthSignInDataConfiguration;

class GoogleLoginService
{
    private $clientId;
    private $clientSecret;
    private $redirectUrl;

    public function __construct(OAuthSignInDataConfiguration $dataConfiguration)
    {
        $this->clientId = Configuration::get('OAUTH_GOOGLE_CLIENT_ID');
        $this->clientSecret = Configuration::get('OAUTH_GOOGLE_CLIENT_SECRET');

        $config = $dataConfiguration->getConfiguration();
        $this->redirectUrl = $config['redirect_url'] ?? '';
    }

    private function getClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setRedirectUri($this->redirectUrl);

        $client->addScope('email');
        $client->addScope('profile');

        return $client;
    }

    public function getLoginUrl(): string
    {
        $client = $this->getClient();
        return $client->createAuthUrl();
    }

    public function fetchUserData(string $authCode): ?array
    {
        $client = $this->getClient();

        // Pobieramy token z Google
        $token = $client->fetchAccessTokenWithAuthCode($authCode);
        if (isset($token['error'])) {
            // Obsługa błędu
            return null;
        }

        // Ustawiamy token w kliencie
        $client->setAccessToken($token);

        // Klasa do pobierania danych użytkownika
        $googleOAuth = new Oauth2($client);
        $googleUser = $googleOAuth->userinfo->get();

        // Przykładowe dane, jakie możesz wyciągnąć
        return [
            'email' => $googleUser->email,
            'family_name' => $googleUser->familyName,
            'given_name' => $googleUser->givenName,
        ];
    }
}

