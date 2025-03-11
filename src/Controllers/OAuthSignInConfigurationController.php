<?php

declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Controllers;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OAuthSignInConfigurationController
 *
 * Handles the display and processing of the OAuthSignIn configuration form
 * in back office
 */
class OAuthSignInConfigurationController extends FrameworkBundleAdminController
{
    /**
     * Renders the OAuthSignIn configuration form and processes the submitted data.
     * Shows a success message on valid submission or displays errors otherwise.
     *
     * @param Request $request
     *
     * @return Response The HTML response displaying the form
     */
    public function index(Request $request): Response
    {
        $textFormDataHandler = $this->get('prestashop.module.oauthsignin.form.oauthsignin_form_data_handler');

        $textForm = $textFormDataHandler->getForm();
        $textForm->handleRequest($request);

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $errors = $textFormDataHandler->save($textForm->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update', 'Modules.Oauthsignin.Admin', []));

                return $this->redirectToRoute('o_auth_sign_in');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/oauthsignin/views/templates/admin/form.html.twig', [
            'oAuthSignInConfigurationForm' => $textForm->createView()
        ]);
    }
}
