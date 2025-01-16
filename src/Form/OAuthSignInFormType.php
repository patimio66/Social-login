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
            'label' => $this->trans('Enable "Sign in with Google" button', 'Modules.OAuthSignIn.Admin'),
            'required' => false,
            ])
            ->add('google_client_id', TextType::class, [
            'label' => $this->trans('Google Client ID', 'Modules.OAuthSignIn.Admin'),
            'help' => $this->trans('Maximum 255 characters', 'Modules.OAuthSignIn.Admin'),
            'required' => false,
            ])
            ->add('google_client_secret', TextType::class, [
                'label' => $this->trans('Google Client Secret', 'Modules.OAuthSignIn.Admin'),
                'help' => $this->trans('Maximum 255 characters', 'Modules.OAuthSignIn.Admin'),
                'required' => false,    
            ])
            ->add('redirect_url', TextType::class, [
                'label' => $this->trans('Use this redirect URL in Google Cloud Platform', 'Modules.OAuthSignIn.Admin'),
                'mapped' => true,
                'required' => false,
                'disabled' => true,
            ])
            ->add('enable_facebook', SwitchType::class, [
                'label' => $this->trans('Enable "Sign in with Facebook" button', 'Modules.OAuthSignIn.Admin'),
                'required' => false,
            ])
            ->add('fb_app_id', TextType::class, [
                'label' => $this->trans('Facebook App ID', 'Modules.OAuthSignIn.Admin'),
                'required' => false,
            ]);
    }
}
