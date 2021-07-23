<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Entity\Direccion;
use App\Entity\Servicio;
use App\Entity\Sitios;
use App\Entity\Ticket;
use App\Form\ClientType;
use App\Form\AddressType;
use App\Form\NewClientType;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

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
    public function create(Request $request): Response
    {
        $form = $this->createForm(NewClientType::class, new Clientes);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name_client']->getData();
            $email = $form['email_client']->getData();
            $phone = $form['phone_client']->getData();
            $address = $form['fkAddress']->getData();
            $zone = $form['zone_place']->getData();
            $packet = $form['name_packet']->getData();

            if($name == null || $email == null || $phone == null || $address == null || $zone == null || $packet == null){

            }else{
                $client = new Clientes();

            }
        }
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

        
        
        $cliente = $this->getDoctrine()
        ->getRepository(Clientes::class)
        ->findOneBy([
            'id' => $id
        ]);

        $form = $this->createForm(ClientType::class, new Clientes());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
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

    public function editAddress($id, Request $request){
        $direccion = $this->getDoctrine()
        ->getRepository(Direccion::class)
        ->findOneBy([
            'id' => $id
        ]);
        $form = $this->createForm(AddressType::class, new Direccion());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $address = $form['name_address']->getData();
            $zone = $form['fkZone']->getData();
            if($address == null || $zone == null){
                return $this->json(array(
                    'status' => false, 
                    'msg' => ''
                ));
            }else{
                $direccion = $this->getDoctrine()
                ->getRepository(Direccion::class)
                ->findOneBy([
                    'id' => $id
                ]);
                $direccion->setNameAddress($address); 
                $direccion->setFkZone($zone); 
                $entityManager->persist($direccion); 
                try{
                    $entityManager->flush(); 
                    
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                }
                return $this->json(array(
                    'status' => true, 
                    'msg' => "Se ha realizado con exito",
                )); 
            }
        }
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editAddress.html.twig' , [
                'id' => $id, 
                'form' => $form->createView(), 
                'address' => $direccion->getNameAddress(),
                'idzona' => (string) $direccion->getFkZone()->getId(),
                /*'idpaquete' => (string) $direccion->getFkPacket()->getId(), 
                'idinventario' => $direccion->getFkInventary() ? $direccion->getFkInventary()->getId(): null,*/    
            ])
        );
        return $this->json($response);
    }
    /**
     * @Route("/clientes/deleteAddress/{id}", name="deleteClientesAddress")
     */
    public function deleteAddress($id){
        $direccion = $this->getDoctrine()
            ->getRepository(Direccion::class)
            ->findOneBy([
                'id' => $id
            ]);
        $servicio = $this->getDoctrine()->getRepository(Servicio::class)
            ->findMultiServices($id);
        $ticket = $this->getDoctrine()->getRepository(Ticket::class)
            ->findMultiTicket($id);
        if($direccion != null){
            $entityManager = $this->getDoctrine()->getManager();
            /*foreach ($servicio as $service) {
                $entityManager->remove($service);
            }
            foreach ($ticket as $t) {
                $entityManager->remove($t);
            }*/
            $entityManager->remove($direccion);
            $entityManager->flush();



            return new JsonResponse([
                'msg' => $id
            ]);
        }

    }
    /**
     * @Route("/clientes/editService/{id}", name="editClientesService")
     */
    public function editService($id){
        $servicio = $this->getDoctrine()->getRepository(Servicio::class)
        ->findMultiServices($id);

        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editService.html.twig' , [
                'id' => $id, 
                //'form' => $form->createView(),
                //'packet' => (string) $servicio->getFkPacket()->getId(),
                //'mac' => (string) $servicio->getFkInventary()->getId()
                'service'  => $servicio,

            ])
        );
        return $this->json($response);
    }

    /**
     * @Route("/clientes/editServiceSpecific/{idService}/{inventory}", name="editServiceSpecific")
     */

    public function editServiceSpecific($idService, $inventory, Request $request){
        $servicio = $this->getDoctrine()->getRepository(Servicio::class)
            ->findOneBy([
                'id' => $idService
            ]);
        $form = $this->createForm(ServiceType::class, new Servicio(),['myid' => $inventory]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $packet = $form['fkPacket']->getData();
            $inventory = $form['fkInventary']->getData();
            if($packet == null || $inventory == null){

            }else{
                $servicio->setFkPacket($packet);
                $servicio->setFkInventary($inventory);
                $entityManager->persist($servicio);
                try{
                    $entityManager->flush();
                    return new JsonResponse([
                        'status' => true
                    ]);
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                    return new JsonResponse([
                        'status' => false
                    ]);
                }

            }


        }
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editServiceSpecific.html.twig' , [
                'idService' => $idService,
                'inventory' => $inventory,
                'form' => $form->createView(),
                'packet' => (string) $servicio->getFkPacket()->getId(),
                'mac' => (string) $servicio->getFkInventary()->getId()
            ])
        );
        return $this->json($response);
    }
   
}
