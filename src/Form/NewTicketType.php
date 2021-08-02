<?php

namespace App\Form;

use App\Entity\Clientes;
use App\Entity\Ticket;
use App\Repository\ClientesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_ticket',ChoiceType::class, [
                'choices'  => [
                    'Ancho de Banda' => 'Ancho de banda',
                    'Bloqueo de Paginas' => 'Bloqueo de Paginas',
                    'Cobertura' => 'Cobertura',
                    'Desconexiones' => 'Desconexiones', 
                    'Problemas con Aplicaciones' => 'Problemas con Aplicaciones', 
                    'Problemas con Otros Dispositivos' => 'Problemas con Otros Dispositivos', 
                    'Radio Defectuoso' => 'Radio Defectuoso', 
                    'Red no Detectada' => 'Red no Detectada', 
                    'Otros' => 'Otros'
                ],
                'label' => false
            ])
            
            ->add('desc_ticket', TextareaType::class ,[
                'label' => false
            ])
            ->add('status_ticket', ChoiceType::class, [
                'choices'  => [
                    'Abierto' => 'Abierto',
                    'Nuevo' => 'Nuevo',
                    'Resuelto' => 'Resuelto',
                ],
                'label' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
