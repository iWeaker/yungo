<?php

namespace App\Form;

use App\Entity\Clientes;
use App\Entity\Paquete;
use App\Entity\Sitios;
use App\Repository\PaqueteRepository;
use App\Repository\SitiosRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_client', TextType::class,[
                'label' => false
            ])
            ->add('email_client', EmailType::class,[
                'label' => false
            ])
            ->add('phone_client', TextType::class,[
                'label' => false
            ])
            ->add('fkAddress', TextType::class, [
                'label' => false
            ])
            ->add('zone_place', EntityType::class, [
                'class' => Sitios::class,
                'mapped' => false,
                'query_builder' => function (SitiosRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.zone_place', 'ASC');
                },
                'choice_label' => 'zone_place',
                'label' => false
            ])
            ->add('name_packet', EntityType::class, [
                'class' => Paquete::class,
                'mapped' => false,
                'query_builder' => function (PaqueteRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name_packet', 'ASC');
                },
                'choice_label' => 'name_packet',
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clientes::class,
        ]);
    }
}
