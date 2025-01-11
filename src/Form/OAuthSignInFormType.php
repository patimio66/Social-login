<?php

declare(strict_types=1);

namespace PrestaShop\Module\OAuthSignIn\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OAuthSignInFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'label' => $this->trans('Your Redirect URL', 'Modules.OAuthSignIn.Admin'),
                'mapped' => false,
                'required' => false,
                'disabled' => true,
            ]);
            
    }
}
