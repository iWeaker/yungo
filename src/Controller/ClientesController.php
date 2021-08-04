<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Entity\Direccion;
use App\Entity\Servicio;
use App\Form\ClientType;
use App\Form\AddressType;
use App\Form\NewClientType;
use App\Form\ServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class ClientesController extends AbstractController
{
    protected $em;
    /**
     * @var EntityManagerInterface
     */
    public function  __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }
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
    public function create(Request $request)
    {
        $form = $this->createForm(NewClientType::class, new Clientes());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name_client']->getData();
            $email = $form['email_client']->getData();
            $phone = $form['phone_client']->getData();
            $address = $form['fkAddress']->getData();
            $zone = $form['zone_place']->getData();
            $packet = $form['name_packet']->getData();
            $ip = $form['ip']->getData();
            $flag = true;
            $msg = "";
            if($name == null || $email == null || $phone == null || $address == null || $zone == null || $packet == null || $ip == null){
                $flag = false;
                $msg = "No se validaron correctamente, verifique los datos.";
            }
            if($flag){
                if(! filter_var($phone, FILTER_VALIDATE_INT) && $flag){ $flag = false; $msg = "Campo telefono solo numeros.";  }
                if(! filter_var($ip, FILTER_VALIDATE_IP) && $flag){ $flag = false; $msg = "No es una ip valida."; }
                if(count($this->getDoctrine()->getRepository(Servicio::class)->findBy([
                    'ip_service' => $ip
                ])) > 0){ $flag = false; $msg = "La ip ya se encuentra en uso";   }
                if($flag){
                    $client = new Clientes();
                    $client->setNameClient($name);
                    $client->setEmailClient($email);
                    $client->setPhoneClient($phone);
                    $this->em->persist($client);
                    try {
                        $ad = new Direccion();
                        $ad->setClientes($client);
                        $ad->setFkZone($zone);
                        $ad->setNameAddress($address);
                        $this->em->persist($ad);
                        $se = new Servicio();
                        $se->setFkAddress($ad);
                        $se->setFkPacket($packet);
                        $se->setIpService($ip);
                        $this->em->persist($se);
                        $this->em->flush();
                        $msg = "Se ha realizado con exito";
                    }catch(\Exception $e) {
                        $flag = false;
                        $msg = $e->getMessage();
                    }
                }
                return $this->json(array(
                    'status' => $flag,
                    'msg' => $msg
                ));
            }
        }
        return $this->render('clientes/create.html.twig', [
            'controller_name' => 'ClientesController',
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/clientes/delete/{id}", name="deleteClientes")
     *
     */
    public function delete($id): JsonResponse
    {
        $cliente = $this->getDoctrine()
            ->getRepository(Clientes::class)
            ->findOneBy([
                'id' => $id
            ]);
        $flag = true;
        $msg = "";
        if($cliente != null){
            try {
                $this->em->remove($cliente);
                $this->em->flush();
                $msg = "Se ha eliminado de manera correcta";
            }catch(\Exception $e) {
                $flag = false;
                $msg = $e->getMessage();
            }
        }
        return new JsonResponse([
            'status' => $flag,
            'msg' => $msg
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

            $cl = $form['name_client']->getData();
            $em = $form['email_client']->getData();
            $ph = $form['phone_client']->getData();
            $flag = true;
            $msg = "";
            if($cl == null || $em == null || $ph == null){
                $flag = false;
                $msg = "No se enviaron los datos de manera correcta";
            }
            if($flag){
                $cliente->setNameClient($cl);
                $cliente->setEmailClient($em);
                $cliente->setPhoneClient($ph);
                $this->em->persist($cliente);
                try{
                    $this->em->flush();
                    $msg = "Se realizaron los cambios correctamente";
                }catch(\Exception $e) {
                    $flag = false;
                    $msg = $e->getMessage();
                }
            }
            return $this->json(array(
                'status' => $flag,
                'msg' => $msg,
                'name' => $cl,
                'email' => $em,
                'phone' => $ph
            ));
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
     * @Route("/clientes/addAddress/{id}", name="addClientesAddress")
     *
     */
    public function addAddress($id, Request $request){
        $form = $this->createForm(AddressType::class, new Direccion());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address = $form['name_address']->getData();
            $zone = $form['fkZone']->getData();
            $flag = true;
            $msg = "Sucedio algo";
            if($address == null || $zone == null){$flag = false;$msg = "No se estan recibiendo todos los datos";}
            if($flag){
                $con = $this->getDoctrine()->getManager();
                $direccion = new Direccion();
                $direccion->setNameAddress($address);
                $direccion->setFkZone($zone);
                /** @var Clientes|object|null $client */
                $client= $this->getDoctrine()->getRepository(Clientes::class)->findOneBy([
                    'id'=> $id
                ]);
                $direccion->setClientes($client);
                $con->persist($direccion);
                try {
                    $con->flush();
                    $msg = "Se ha registrado correctamente";
                }catch(\Exception $e) {
                    $msg = $e->getMessage();
                }
            }
            return $this->json(array(
                'status' => $flag,
                'msg' => $msg,
            ));
        }
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/addAddress.html.twig' , [
                'id' => $id,
                'form' => $form->createView(),
            ])
        );
        return $this->json($response);
    }
    /**
     * @Route("/clientes/editAddress/{id}", name="editClientesAddress")
     */
    public function editAddress($id, Request $request){
        $d = $this->em
        ->getRepository(Direccion::class)
        ->findOneBy([
            'id' => $id
        ]);
        $form = $this->createForm(AddressType::class, new Direccion());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $address = $form['name_address']->getData();
            $zone = $form['fkZone']->getData();
            $flag = true;
            $msg = "";
            if($address == null || $zone == null){
                $flag = false;
                $msg =  "No se estan recibiendo todos los datos";
            }
            if($flag){
                $d->setNameAddress($address);
                $d->setFkZone($zone);
                $this->em->persist($d);
                try{
                    $this->em->flush();
                    $msg = "Se ha editado correctamente";
                }catch(\Exception $e) {
                    $flag = false;
                    $msg = $e->getMessage();
                }
            }
            return $this->json(array(
                'status' => $flag,
                'msg' => $msg,
            ));
        }
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editAddress.html.twig' , [
                'id' => $id, 
                'form' => $form->createView(), 
                'address' => $d->getNameAddress(),
                'idzona' => (string) $d->getFkZone()->getId(),
            ])
        );
        return $this->json($response);
    }
    /**
     * @Route("/clientes/deleteAddress/{id}", name="deleteClientesAddress")
     */
    public function deleteAddress($id){
        $d = $this->em
            ->getRepository(Direccion::class)
            ->findOneBy([
                'id' => $id
            ]);
        $flag = true;
        $msg = "";
        if($d != null){
            $this->em->remove($d);
            try{
                $this->em->flush();
                $msg = "Se ha eliminado correctamente";
            }catch(\Exception $e) {
                $flag = false;
                $msg = $e->getMessage();
            }
        }else{
            $flag = false;
            $msg = "Algo sucedio";
        }
        return new JsonResponse([
            'status' => $flag,
            'msg' => $msg
        ]);
    }
    /**
     * @Route("/clientes/editService/{id}", name="editClientesService")
     */
    public function editService($id){
        $servicio = $this->em->getRepository(Servicio::class)
        ->findMultiServices($id);
        $response = array(
            'status' => "",
            'message' =>  $this->renderView('clientes/editService.html.twig' , [
                'id' => $id,
                'service'  => $servicio,
            ])
        );
        return $this->json($response);
    }
    /**
     * @Route("/clientes/editServiceSpecific/{idService}/{inventory}", name="editServiceSpecific")
     */
    public function editServiceSpecific($idService, $inventory, Request $request): JsonResponse
    {
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
                return new JsonResponse([
                    'status' => false,
                    'msg' => 'Verifica los datos'
                ]);
            }else{
                $servicio->setFkPacket($packet);
                $servicio->setFkInventary($inventory);
                $entityManager->persist($servicio);
                try{
                    $entityManager->flush();
                    return new JsonResponse([
                        'status' => true,
                        'msg' => 'Se ha realizado con exito'
                    ]);
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                    return new JsonResponse([
                        'status' => false,
                        'msg'=> 'Sucedio un problema en el sistema'
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
