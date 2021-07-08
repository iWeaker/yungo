<?php

namespace App\Controller;

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use DateTime;

class TicketsController extends AbstractController
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function index(DataTableFactory $dataTableFactory, Request $request): Response
    {
        $table = $dataTableFactory->create()
                ->add('id', TextColumn::class)
                ->add('type_ticket', TextColumn::class)
                ->add('date_ticket', DateTimeColumn::class)
                ->add('desc_ticket', TextColumn::class)
                ->add('status_ticket', TextColumn::class)
                ->createAdapter(ORMAdapter::class, [
                    'entity' => Ticket::class,
            ])->handleRequest($request); 

        if($table->isCallback()){
            return $table->getResponse(); 
        }
            return $this->render('tickets/index.html.twig', [
            'datatable' => $table,
        ]);
    }


     /**
     * @Route("/tickets/create", name="createTickets")
     */
    public function create(): Response
    {
        return $this->render('tickets/create.html.twig', [
            'controller_name' => 'TicketsController',
        ]);
    }
}
