<?php

declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\FormBuilderInterface;

class OAuthSignInFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('enable_google', SwitchType::class, [
                'label' => $this->trans('Enable "Sign in with Google" button', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('google_client_id', TextType::class, [
                'label' => $this->trans('Google Client ID', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('google_client_secret', TextType::class, [
                'label' => $this->trans('Google Client Secret', 'Modules.Oauthsignin.Admin'),
                'required' => false,    
            ])
            ->add('google_redirect_url', TextType::class, [
                'label' => $this->trans('Your redirect URL', 'Modules.Oauthsignin.Admin'),
                'help' => $this->trans('Use this in Google Cloud Platform website', 'Modules.Oauthsignin.Admin'),
                'mapped' => true,
                'required' => false,
                'disabled' => true,
            ])
            ->add('enable_facebook', SwitchType::class, [
                'label' => $this->trans('Enable "Sign in with Facebook" button', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('fb_app_id', TextType::class, [
                'label' => $this->trans('Facebook App ID', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('fb_redirect_url', TextType::class, [
                'label' => $this->trans('Your redirect URL', 'Modules.Oauthsignin.Admin'),
                'help' => $this->trans('Use this in Meta for Developers website', 'Modules.Oauthsignin.Admin'),
                'mapped' => true,
                'required' => false,
                'disabled' => true,
            ]);
    }
}
