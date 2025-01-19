<?php

class OAuthSignInGoogleCallbackModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        parent::postProcess();

        $code = Tools::getValue('code');
        if (!$code) {
            Tools::redirect($this->context->link->getPageLink('index', true));
        }

        $clientId = Configuration::get('OAUTH_GOOGLE_CLIENT_ID');
        $clientSecret = Configuration::get('OAUTH_GOOGLE_CLIENT_SECRET');
        $redirectUrl = $this->context->link->getModuleLink(
        'oauthsignin', 
        'googlecallback', 
        [], 
        true);
    
        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('email');
        $client->addScope('profile');

        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            Tools::redirect($this->context->link->getPageLink('index', true));
        }
        $client->setAccessToken($token);

        $googleOAuth = new \Google\Service\Oauth2($client);
        $googleUser = $googleOAuth->userinfo->get();

        $userEmail = $googleUser->email;
        $customer = new Customer();
        $existingCustomerId = $customer->customerExists($userEmail, true, true);

        if (!$existingCustomerId) {
            $customer->firstname = $googleUser->given_name ?? $this->trans(
            'Name', 
            [], 
            'Modules.Oauthsignin.Googlecallback');
            $customer->lastname = $googleUser->family_name ?? $this->trans(
            'Surname', 
            [], 
            'Modules.Oauthsignin.Googlecallback');
            $customer->email = $userEmail;
            $customer->passwd = Tools::hash(Tools::passwdGen(12));
            $customer->add();
        } else {
            $customer = new Customer($existingCustomerId);
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

        Tools::redirect($this->context->link->getPageLink('index', true));
    }
}
