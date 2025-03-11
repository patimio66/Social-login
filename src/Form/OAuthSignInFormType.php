<?php

declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OAuthSignInFormType extends TranslatorAwareType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
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
                'help' => $this->trans('Use this during registration in Google Cloud Platform website', 'Modules.Oauthsignin.Admin'),
                'required' => false,
                'disabled' => true,
            ])
            ->add('google_btn_shape', ChoiceType::class, [
                'label' => $this->trans('Select button shape', 'Modules.Oauthsignin.Admin'),
                'choices'  => [
                    $this->trans('Rectangular', 'Modules.Oauthsignin.Admin') => 'google-default',
                    $this->trans('Rounded', 'Modules.Oauthsignin.Admin') => 'google-rounded'
                ],
                'required' => true,
            ])
            ->add('google_btn_theme', ChoiceType::class, [
                'label' => $this->trans('Select button theme', 'Modules.Oauthsignin.Admin'),
                'choices'  => [
                    $this->trans('Light', 'Modules.Oauthsignin.Admin') => 'google-light',
                    $this->trans('Dark', 'Modules.Oauthsignin.Admin') => 'google-dark',
                    $this->trans('Neutral', 'Modules.Oauthsignin.Admin') => 'google-neutral'
                ],
                'required' => true,
            ])
            ->add('enable_facebook', SwitchType::class, [
                'label' => $this->trans('Enable "Sign in with Facebook" button', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('fb_app_id', TextType::class, [
                'label' => $this->trans('Facebook App ID', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('fb_api_version', TextType::class, [
                'label' => $this->trans('Facebook API Version', 'Modules.Oauthsignin.Admin'),
                'required' => false,
            ])
            ->add('fb_redirect_url', TextType::class, [
                'label' => $this->trans('Your redirect URL', 'Modules.Oauthsignin.Admin'),
                'help' => $this->trans('Use this during registration in Meta for Developers website', 'Modules.Oauthsignin.Admin'),
                'required' => false,
                'disabled' => true,
            ])
            ->add('fb_btn_shape', ChoiceType::class, [
                'label' => $this->trans('Select button shape', 'Modules.Oauthsignin.Admin'),
                'choices'  => [
                    $this->trans('Rectangular', 'Modules.Oauthsignin.Admin') => 'default',
                    $this->trans('Rounded', 'Modules.Oauthsignin.Admin') => 'rounded'
                ],
                'required' => true,
            ]);
    }
}
