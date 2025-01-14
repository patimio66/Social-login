<?php

namespace PrestaShop\Module\OAuthSignIn\Controllers;

use PrestaShop\Module\OAuthSignIn\Services\GoogleLoginService;
use Customer;
use Context;
use Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GoogleCallbackController extends AbstractController
{
    private $googleLoginService;

    public function __construct(GoogleLoginService $googleLoginService)
    {
        $this->googleLoginService = $googleLoginService;
    }

    public function callback(Request $request): Response
    {
        // Google przekieruje z ?code=..., więc łapiemy
        $code = $request->query->get('code');
        var_dump($code);
        if (!$code) {
            // Obsługa błędu lub brak parametru
            return $this->redirect('/');
        }

        // Wymiana code na token + pobranie danych
        $userData = $this->googleLoginService->fetchUserData($code);
        if (!$userData) {
            // Błąd w trakcie autentykacji
            return $this->redirect('/');
        }

        // Mamy userData['email'], userData['google_id'], itp.
        $customer = new Customer();
        $existingCustomerId = $customer->customerExists($userData['email'], true, true);
        
        if ($existingCustomerId) {
            // Użytkownik istnieje - pobierz go z bazy
            $customer = new Customer($existingCustomerId);
        } else {
            // Użytkownik nie istnieje - stworzymy nowego
            $customer->firstname = $userData['given_name'] ?? 'Google';
            $customer->lastname = $userData['family_name'] ?? 'User';
            $customer->email = $userData['email'];
            $customer->passwd = Tools::encrypt(Tools::passwdGen()); 
            // możesz też dodać info do customowej tabeli, zapisać google_id itp.

            // Zapis do bazy
            $customer->add();
        }

        // Logowanie w PrestaShop:
        $context = Context::getContext();
        $context->cookie->id_customer = (int) $customer->id;
        $context->cookie->customer_lastname = $customer->lastname;
        $context->cookie->customer_firstname = $customer->firstname;
        $context->cookie->logged = 1;
        $context->cookie->email = $customer->email;
        $context->customer = $customer;

        // Wracamy np. na stronę główną
        return $this->redirect('/');
    }
}