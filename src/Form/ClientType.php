<?php

namespace App\Form;

use App\Entity\Clientes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_client', TextType::class ,[
                'attr' => [
                    'placeholder' => 'Nombre del cliente'
                ],
                'label' => false
            ])
            ->add('email_client', EmailType::class ,[
                'attr' => [
                    'placeholder' => 'Correo del cliente'
                ],
                'label' => false
            ])
            ->add('phone_client', TextType::class ,[
                'attr' => [
                    'placeholder' => 'Numero telefonico'
                ],
                'label' => false
            ])
            ->add('submit_client', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clientes::class,
        ]);
    }
}
