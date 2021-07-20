<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Entity\Direccion;
use App\Form\ClientType;
use App\Form\AddressType;
use App\Form\NewClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientesController extends AbstractController
{
    private static $error = "";
    /**
     * @Route("/clientes", name="clientes")
     */
    public function index(): Response
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
        $form = $this->createForm(NewClientType::class, new Clientes);
        return $this->render('clientes/create.html.twig', [
            'controller_name' => 'ClientesController',
            'form' => $form->createView()
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
            'ticket' => $cliente->getTickets(),
            
        ]);
     }

     /**
     * @Route("/clientes/editPersonal/{id}", name="editClientesPersonal")
     */

    public function editPersonal($id, Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        
        $cliente = $this->getDoctrine()
        ->getRepository(Clientes::class)
        ->findOneBy([
            'id' => $id
        ]);

        $form = $this->createForm(ClientType::class, new Clientes());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $cl = $form['name_client']->getData();
            $em = $form['email_client']->getData();
            $ph = $form['phone_client']->getData();
            
            if($cl == null || $em == null || $ph == null){
                self::$error = "Error de ambos";
            }else{
                
                $cliente->setNameClient($cl);
                $cliente->setEmailClient($em);
                $cliente->setPhoneClient($ph);
                $entityManager->persist($cliente);
                try{
                    $entityManager->flush();
                    return $this->json(array(
                        'status' => true,
                        'name' => $cl,
                        'email' => $em, 
                        'phone' => $ph
                    ));
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                }

            }
        }
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editPersonal.html.twig' , [
                'id' => $id, 
                'form' => $form->createView(),
                'name' => $cliente->getNameClient(),
                'email' => $cliente->getEmailClient(), 
                'phone' => $cliente->getPhoneClient(),
            ])
        );
        return $this->json($response);
        
    }

    /**
     * @Route("/clientes/editAddress/{id}", name="editClientesAddress")
     */

    public function editAddress($id){
        $direccion = $this->getDoctrine()
        ->getRepository(Direccion::class)
        ->findOneBy([
            'id' => $id
        ]);

        $form = $this->createForm(AddressType::class, new Direccion());
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editAddress.html.twig' , [
                'id' => $id, 
                'form' => $form->createView(), 
                'address' => $direccion->getNameAddress(),
                'idzona' => (string) $direccion->getFkZone()->getId(),
                'idpaquete' => (string) $direccion->getFkPacket()->getId(), 
                'idinventario' => $direccion->getFkInventary() ? $direccion->getFkInventary()->getId(): null, 
                
                
            ])
        );
        return $this->json($response);
        
    }

   
}
