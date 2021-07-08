<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketsController extends AbstractController
{
    /**
     * @Route("/tickets", name="tickets")
     */
    public function index(): Response
    {
        return $this->render('tickets/index.html.twig', [
            'controller_name' => 'TicketsController',
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
