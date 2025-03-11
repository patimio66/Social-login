<?php

declare(strict_types=1);

/**
 * Class OAuthSignInFacebookCallbackModuleFrontController
 *
 * Handles the Facebook OAuth callback process
 */
class OAuthSignInFacebookCallbackModuleFrontController extends ModuleFrontController
{
    /**
     * Processes the Facebook callback request:
     * - Checks for the access token
     * - Fetches user details (email, first_name, last_name) from Facebook
     * - Logs in an existing customer or creates a new account if needed
     *
     * @return void
     */
    public function postProcess(): void
    {
        parent::postProcess();

        $accessToken = Tools::getValue('access_token');
        if (!$accessToken) {
            header('Content-Type: application/json; charset=utf-8');
            die(json_encode(['error' => $this->trans('No access token provided',
            [],
            'Modules.Oauthsignin.Facebookcallback'
        )]));
        }

        $url = 'https://graph.facebook.com/me?fields=email,first_name,last_name'
             . '&access_token=' . urlencode($accessToken);
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (!isset($data['email'])) {
            header('Content-Type: application/json; charset=utf-8');
            die(json_encode(['error' => $this->trans(
                'The email address could not be retrieved',
                [],
                'Modules.Oauthsignin.Facebookcallback'
            )]));
        }

        $email = $data['email'];
        $customer = new Customer();
        $existingCustomerId = $customer->customerExists($email, true, true);

        if (!$existingCustomerId) {
            $customer->firstname = $data['first_name'] ?? 'Name';
            $customer->lastname = $data['last_name'] ?? 'Surname';
            $customer->email = $email;
            $customer->passwd = Tools::hash(Tools::passwdGen(12));
            $customer->add();
        } else {
            $customer = new Customer($existingCustomerId);
        }

        $this->context->cookie->id_customer = (int)$customer->id;
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->logged = 1;
        $this->context->cookie->email = $customer->email;
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->customer = $customer;
        $this->context->updateCustomer($customer);

        $redirectUrl = $this->context->link->getPageLink('index', true);
        die(json_encode(['redirect_url' => $redirectUrl]));
    }
}
