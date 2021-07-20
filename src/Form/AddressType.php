<?php

namespace App\Form;

use App\Entity\Direccion;
use App\Entity\Inventario;
use App\Entity\Sitios;
use App\Entity\Paquete;
use App\Repository\InventarioRepository;
use App\Repository\SitiosRepository;
use App\Repository\PaqueteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_address', TextType::class, [
                'label' => false
            ])
            ->add('fkZone', EntityType::class, [
                'class' => Sitios::class,
                'query_builder' => function (SitiosRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.zone_place', 'ASC');
                },
                'choice_label' => 'zone_place',
                'label' => false
            ])
            ->add('fkPacket', EntityType::class, [
                'class' => Paquete::class,
                'query_builder' => function (PaqueteRepository $err) {
                    return $err->createQueryBuilder('a')
                        ->orderBy('a.name_packet', 'ASC');
                },
                'choice_label' => 'name_packet',
                'label' => false
            ])
            ->add('fkInventary', EntityType::class, [
                'class' => Inventario::class,
                'query_builder' => function (InventarioRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.mac_inventory', 'ASC');
                    
                },
                'choice_label' => 'mac_inventory',
                'label' => false
            ])
            ->add('submit_address', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Direccion::class,
        ]);
    }
}
