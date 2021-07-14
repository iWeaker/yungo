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

     public function show($id){

        $cliente = $this->getDoctrine()
        ->getRepository(Clientes::class)
        ->findOneBy([
            'id' => $id
        ]);

        return $this->render('clientes/show.html.twig',  [
            'id' => $cliente->getId(),
            'name' => $cliente->getNameClient(),
            'email' => $cliente->getEmailClient(), 
            'phone' => $cliente->getPhoneClient(),
            'address' => $cliente->getFkAddress(), 
            
        ]);
     }

     /**
     * @Route("/clientes/editPersonal/{id}", name="editClientesPersonal")
     */

    public function editPersonal($id){
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editPersonal.html.twig' , ['id' => $id])
        );
        return $this->json($response);
        
    }

    /**
     * @Route("/clientes/editAddress/{id}", name="editClientesAddress")
     */

    public function editAddress($id){
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editAddress.html.twig' , ['id' => $id])
        );
        return $this->json($response);
        
    }
}
