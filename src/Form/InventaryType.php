<?php

namespace App\Form;

use App\Entity\Inventario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mac_inventory', TextType::class,[
                'label' => false
            ])
            ->add('model_inventory', TextType::class,[
                'label' => false
            ])
            ->add('brand_inventory', TextType::class, [
                'label' => false
            ])
            ->add('type_inventory',ChoiceType::class, [
                'choices'  => [
                    'Radio' => 'Radio',
                    'Router' => 'Router',
                    'Omni' => 'Omni',
                    'Septorial' => 'Septorial',

                ],
                'label' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventario::class,
        ]);
    }
}
