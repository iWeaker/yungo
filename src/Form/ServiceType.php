<?php

namespace App\Form;

use App\Entity\Inventario;
use App\Entity\Paquete;
use App\Repository\InventarioRepository;
use App\Repository\PaqueteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $myid = $options['myid'];
        $builder
            
            ->add('fkPacket', EntityType::class, [
                'class' => Paquete::class,
                'query_builder' => function (PaqueteRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.id', 'ASC'); 
                },
                'choice_label' => 'name_packet',
                'label' => false
            ])

            ->add('fkInventary', EntityType::class, [
                'class' => Inventario::class,
                'query_builder' => function (InventarioRepository $er) use ($myid){
                    return $er->createQueryBuilder('i')
                        ->leftJoin('i.servicio', 's')
                        ->where('s.fkInventary is null OR i.id ='.$myid)
                        ->orderBy('i.id', 'ASC');
                        
                },
                'choice_label' => 'mac_inventory',
                'label' => false
            ])
            ->add('submit', SubmitType::class,[
                'label' => false
            ]) 
            
        ;
    }
    /**      
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'myid',
        ]);
    }
}
