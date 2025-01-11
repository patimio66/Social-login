<?php

namespace PrestaShop\Module\OAuthSignIn\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleCallbackController extends AbstractController
{
    public function callback(Request $request): Response
    {
        // Tutaj logika obsługi callbacku z Google
        // ...
        return new Response('OK callback'); 
    }
}
