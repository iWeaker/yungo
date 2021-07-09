<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;

class TicketsController extends AbstractController
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function index(): Response
    {
        $tickets = $this->getDoctrine()
        ->getRepository(Ticket::class)
        ->findAll();
    
        $response = array();
        foreach ($tickets as $ticket) {
            $response[] = array(
                $ticket->getId(),
                $ticket->getTypeTicket(),
                $ticket->getDateTicket()->format('Y-m-d H:i:s'), 
                $ticket->getDescTicket(), 
                $ticket->getStatusTicket(), 
            );
        }
            return $this->render('tickets/index.html.twig', [
                'response' => json_encode($response)
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

    /**
     * @Route("/tickets/show/{id}", name="showTickets")
     * 
     *
     * 
     */
    public function show($id){
        return $this->render('tickets/show.html.twig');
    }
}
