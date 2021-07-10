<?php

namespace App\Controller;

use App\Entity\Clientes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientesController extends AbstractController
{
    /**
     * @Route("/clientes", name="clientes")
     */
    public 
    function index(): Response
    {
        $clientes = $this->getDoctrine()
        ->getRepository(Clientes::class)
        ->findAll();
    
        $response = array();
        foreach ($clientes as $cliente) {
            $response[] = array(
                $cliente->getId(),
                $cliente->getNameClient(),
                $cliente->getEmailClient(), 
                $cliente->getPhoneClient(), 
                $cliente->getAddressClient(), 
            );
        }
            return $this->render('clientes/index.html.twig', [
            'response' => json_encode($response),
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

    /**
     * @Route("/clientes/show/{id}", name="showClientes")
     */

     public function show(){
         return $this->render('clientes/show.html.twig');
     }

     /**
     * @Route("/clientes/edit/{id}", name="editClientes")
     */

    public function edit(){
        return $this->render('clientes/edit.html.twig');
    }
}
