<?php

declare(strict_types=1);

namespace PrestaShop\Module\FirstModule\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FirstModuleConfigurationController extends FrameworkBundleAdminController
{
    public function index(Request $request): Response
    {
        $textFormDataHandler = $this->get('prestashop.module.firstmodule.form.firstmodule_form_data_handler');

        $textForm = $textFormDataHandler->getForm();
        $textForm->handleRequest($request);

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
            $errors = $textFormDataHandler->save($textForm->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('first_module');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/firstmodule/views/templates/admin/form.html.twig', [
            'firstModuleConfigurationForm' => $textForm->createView()
        ]);
    }
}
