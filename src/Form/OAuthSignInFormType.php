<?php

declare(strict_types=1);

namespace Prestashop\Module\OAuthSignIn\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class OAuthSignInFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('config_text', TextType::class, [
            'label' => $this->trans('Configuration text', 'Modules.OAuthSignIn.Admin'),
            'help' => $this->trans('Maximum 32 characters', 'Modules.OAuthSignIn.Admin'),
            ]);
            $builder->add('choice_field', ChoiceType::class, [
                'label'    => $this->trans('Select something', 'Modules.OAuthSignIn.Admin'),
                'choices'  => [
                    // "etykieta" => "wartość", 
                    $this->trans('Option A', 'Modules.OAuthSignIn.Admin') => 'A',
                    $this->trans('Option B', 'Modules.OAuthSignIn.Admin') => 'B',
                    $this->trans('Option C', 'Modules.OAuthSignIn.Admin') => 'C',
                ],
                'required' => false, 
                'help'     => $this->trans('Pick any option you like', 'Modules.OAuthSignIn.Admin'),
            ]);
    }
}
