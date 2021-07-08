<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientesController extends AbstractController
{
    /**
     * @Route("/clientes", name="clientes")
     */
    public function index(): Response
    {
        return $this->render('clientes/index.html.twig', [
            'controller_name' => 'ClientesController',
        ]);
    }

    /**
     * @Route("/clientes/create", name="createClientes")
     */
    public function create(): Response
    {
        return $this->render('clientes/create.html.twig', [
            'controller_name' => 'ClientesController',
        ]);
    }
}
