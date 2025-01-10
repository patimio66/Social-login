<?php

declare(strict_types=1);

namespace Prestashop\Module\FirstModule\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class FirstModuleFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('config_text', TextType::class, [
            'label' => $this->trans('Configuration text', 'Modules.Firstmodule.Admin'),
            'help' => $this->trans('Maximum 32 characters', 'Modules.Firstmodule.Admin'),
            ]);
            $builder->add('choice_field', ChoiceType::class, [
                'label'    => $this->trans('Select something', 'Modules.FirstModule.Admin'),
                'choices'  => [
                    // "etykieta" => "wartość", 
                    $this->trans('Option A', 'Modules.FirstModule.Admin') => 'A',
                    $this->trans('Option B', 'Modules.FirstModule.Admin') => 'B',
                    $this->trans('Option C', 'Modules.FirstModule.Admin') => 'C',
                ],
                'required' => false, 
                'help'     => $this->trans('Pick any option you like', 'Modules.FirstModule.Admin'),
            ]);
    }
}
