<?php

class OAuthSignInGoogleCallbackModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        parent::postProcess();

        // Catching ?code= parameter from redirect url
        $code = Tools::getValue('code');
        if (!$code) {
            Tools::redirect($this->context->link->getPageLink('index', true));
        }

        // Creating new Google_Client
        $clientId = Configuration::get('OAUTH_GOOGLE_CLIENT_ID');
        $clientSecret = Configuration::get('OAUTH_GOOGLE_CLIENT_SECRET');
        $redirectUrl = $this->context->link->getModuleLink('oauthsignin', 'googlecallback', [], true);
    
        $client = new \Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('email');
        $client->addScope('profile');

        // Switch ?code= parameter to Google_Client token
        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            Tools::redirect($this->context->link->getPageLink('index', true));
        }
        $client->setAccessToken($token);

        // Getting user data from Google
        $googleOAuth = new \Google\Service\Oauth2($client);
        $googleUser = $googleOAuth->userinfo->get();

        // Searching for existing Customer or creating new one
        $userEmail = $googleUser->email;
        $customer = new \Customer();
        $existingCustomerId = $customer->customerExists($userEmail, true, true);

        if (!$existingCustomerId) {
            $customer->firstname = $googleUser->given_name ?? 'Uzupełnij imię';
            $customer->lastname = $googleUser->family_name ?? 'Uzupełnij nazwisko';
            $customer->email = $userEmail;
            $customer->passwd = \Tools::hash(\Tools::passwdGen(12));
            $customer->add();
        } else {
            $customer = new \Customer($existingCustomerId);
        }

        // User login
        $this->context->cookie->id_customer = (int)$customer->id;
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->logged = 1;
        $this->context->cookie->email = $customer->email;
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->customer = $customer;

        $this->context->updateCustomer($customer);

        // Final redirect to home page
        Tools::redirect($this->context->link->getPageLink('index', true));
    }
}
