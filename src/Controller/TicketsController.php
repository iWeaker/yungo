<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Entity\Direccion;
use App\Entity\Servicio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use App\Form\NewTicketType;
use Symfony\Component\HttpFoundation\Request;

class TicketsController extends AbstractController
{
    protected $em;
    /**
     * @var EntityManagerInterface
     */
    public function  __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }
    /**
     * @Route("/tickets", name="tickets")
     */
    public function index(): Response
    {
        $tickets = $this->em
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
     * @Route("/tickets/selector", name="selectorTickets")
     */
    public function clientSelector(){
        $response = array();
        foreach (( $this->getDoctrine()
            ->getRepository(Clientes::class)
            ->findAll()) as $cliente) {
            $response[] = array(
                $cliente->getId(),
                $cliente->getNameClient(),
                $cliente->getEmailClient(),
                $cliente->getPhoneClient(),
            );
        }
        return new JsonResponse([
            'status' => true,
            'msg' => $this->renderView('tickets/clientSelector.html.twig',[
                'response' => json_encode($response),
            ])
        ]);
    }
    //Ruta cuando ya se haya seleccionado el cliente
     /**
     * @Route("/tickets/create/{id}", name="createTickets")
     */
    public function create($id): Response
    {
        $cliente =$this->em->getRepository(Clientes::class)->findOneBy([
            'id' => $id
        ]);
        $response = array();
        foreach (($this->em->getRepository(Servicio::class)->findAllServicesCliente($id)) as $s) {
            $response[] = array(
               $s->getId(),
               $s->getFkAddress()->getNameAddress(),
               $s->getIpService(),
            );
        }
        return $this->render('tickets/create.html.twig', [
            'id' => $id,
            'name' => $cliente->getNameClient(),
            'response' => json_encode($response),
        ]);
    }
    //Ruta cuando ya se haya seleccionado el cliente y su servicio (IP)
    /**
     * @Route("/tickets/create/{id}/{service}", name="createTicketsNext")
     */
    public function createNext($id,$service,  Request $request): Response
    {
        $form = $this->createForm(NewTicketType::class, new Ticket());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $type = $form['type_ticket']->getData();
            $status = $form['status_ticket']->getData();
            $desc = $form['desc_ticket']->getData();
            $flag = true;
            $msg = "";
            if($type == null || $status == null || $desc == null){
                $flag = false;
                $msg = "Algun dato esta vacio";
            }
            if($flag){
                    $con = $this->getDoctrine();
                    $ticket = new Ticket();
                    $ticket->setDescTicket($desc);
                    $ticket->setTypeTicket($type);
                    $ticket->setStatusTicket($status);
                    $ticket->setFkClient($con->getRepository(Clientes::class)->findOneBy(['id' => $id]));
                    $ticket->setService($con->getRepository(Servicio::class)->findOneBy(['id' => $service]));
                    $ticket->setdateTicket(new \DateTime());
                    $persist = $con->getManager();
                    $persist->persist($ticket);

                try {
                    $persist->flush();
                    $msg = "Se ha insertado correctamente";
                }catch(\Exception $e){
                    $flag = false;
                    $msg = $e->getMessage();
                }
            }
            return new JsonResponse([
                'status' => $flag,
                'msg' => $msg,
            ]);
        }
        return $this->render('tickets/createWithService.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/tickets/fetchAddress/{id}", name="fetchAddress")
     */
    public function createFetchAddress($id){
        $response = array();
        foreach (($this->em
            ->getRepository(Direccion::class)
            ->findBy([
                'clientes' => $id
            ])) as $a) {
            $response[] = array(
                'id' => $a->getId(),
                'address' => $a->getNameAddress()
            );
        }
        return $this->json([
                'address' => $response
            ]
        );
    }
    /**
     * @Route("/tickets/show/{id}", name="showTickets")
     */
    public function show($id){
        $tickets = $this->getDoctrine()
        ->getRepository(Ticket::class)
        ->findOneBy([
            'id' => $id
        ]);
        return $this->render('tickets/show.html.twig' , [
            'ticket' => $tickets
        ]);
    }

    /**
     * @Route("/tickets/changeStatus/{id}", name="changeStatus")
     */
    public function changeStatus($id): JsonResponse
    {
        return new JsonResponse([
            'msg' => 'Hola'
        ]);
    }
}
