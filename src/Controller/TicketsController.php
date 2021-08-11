<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Entity\Comentarios;
use App\Entity\Direccion;
use App\Entity\Servicio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\Ticket;
use App\Form\NewTicketType;
use Symfony\Component\HttpFoundation\Request;

class TicketsController extends AbstractController
{
    protected $em;

    /**
     * @var EntityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
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
    public function clientSelector()
    {
        $response = array();
        foreach (($this->getDoctrine()
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
            'msg' => $this->renderView('tickets/clientSelector.html.twig', [
                'response' => json_encode($response),
            ])
        ]);
    }

    /**
     * @Route("/tickets/create/{id}", name="createTickets")
     */
    public function create($id): Response
    {
        $cliente = $this->em->getRepository(Clientes::class)->findOneBy([
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

    /**
     * @Route("/tickets/create/{id}/{service}", name="createTicketsNext")
     */
    public function createNext($id, $service, Request $request): Response
    {
        $form = $this->createForm(NewTicketType::class, new Ticket());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form['type_ticket']->getData();
            $status = $form['status_ticket']->getData();
            $desc = $form['desc_ticket']->getData();
            $flag = true;
            $msg = "";
            if ($type == null || $status == null || $desc == null) {
                $flag = false;
                $msg = "Algun dato esta vacio";
            }
            if ($flag) {
                $ticket = new Ticket();
                $ticket->setDescTicket($desc);
                $ticket->setTypeTicket($type);
                $ticket->setStatusTicket($status);
                $ticket->setFkClient($this->em->getRepository(Clientes::class)->findOneBy(['id' => $id]));
                $ticket->setService($this->em->getRepository(Servicio::class)->findOneBy(['id' => $service]));
                $ticket->setdateTicket(new \DateTime());
                $this->em->persist($ticket);
                try {
                    $this->em->flush();
                    $msg = "Se ha insertado correctamente";
                } catch (\Exception $e) {
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
    public function createFetchAddress($id)
    {
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
    public function show($id)
    {
        $tickets = $this->em
            ->getRepository(Ticket::class)
            ->findOneBy([
                'id' => $id
            ]);
        $response = array();
        foreach ($tickets->getComentarios() as $c) {
            $response[] = array(
                'comment' => $this->renderView('tickets/coments/comment.html.twig', [
                    'i' => $c->getId(),
                    'c' => $c->getCommentComment(),
                    'st' => $c->getImageComment(),
                    'file' => $c->getFilename(),
                ]),

            );
        }
        return $this->render('tickets/show.html.twig', [
            'ticket' => $tickets,
            'response' => $response
        ]);
    }

    /**
     * @Route("/tickets/changeStatus/{id}", name="changeStatus")
     *
     */
    public function changeStatus($id): JsonResponse
    {
        $t = $this->em->getRepository(Ticket::class)->findOneBy([
            'id' => $id
        ]);
        $flag = false;
        $msg = "Hubo algun problema";
        if (isset($_POST['st']) && !empty($_POST['st'])) {
            if ($t != null) {
                $t->setStatusTicket($_POST['st']);
                $this->em->persist($t);
                try {
                    $this->em->flush();
                    $flag = true;
                    $msg = "Se ha modificado correctamente";
                } catch (\Exception $e) {
                    $msg = $e->getMessage();
                }
            }
        }
        return new JsonResponse([
            'status' => $flag,
            'msg' => $msg
        ]);
    }

    /**
     * @Route("/tickets/comment/{id}", name="newComment")
     *
     */
    public function comment($id, Request $request): JsonResponse
    {
        $flag = true;
        $msg = "";
        $html = "";
        $extension = "";
        $newFilename = "";
        if ($request->isXmlHttpRequest()) {
            if($request->get('c') != "" || $request->files->get('i') != null){
                    $t = $request->get('c');
                    $i = $request->files->get('i');
                    if($i !=  null){
                        $extension = pathinfo($i->getClientOriginalName(), PATHINFO_EXTENSION);
                        if($extension == "jpg" || $extension == "png" || $extension == "bat"){
                            $originalFilename = pathinfo($i->getClientOriginalName(), PATHINFO_FILENAME);
                            $newFilename = $originalFilename.'-'.uniqid().'.'.$extension;
                            $newFilename = str_replace(' ', '', $newFilename);
                            $i->move(
                                $this->getParameter('image'),
                                $newFilename
                            );
                        }else{
                            $flag = false;
                            $msg = "El tipo de archivo no es admitido, solo JPG, PNG o BAT";
                        }
                    }
                    if($flag){
                        $c = new Comentarios();
                        if($i !=  null){
                            if($extension == "jpg" || $extension == "png" ){
                                $c->setImageComment(true);
                            }
                            $c->setFilename("".$newFilename);
                        }
                        $c->setCommentComment("" . $t);
                        $c->setCreatedAtComment(new \DateTime());
                        $c->setFkTicket($this->em->getRepository(Ticket::class)->findOneBy([
                            'id' => $id
                        ]));
                        try {
                            $this->em->persist($c);
                            $this->em->flush();
                            $flag = true;

                            $html = $this->renderView('tickets/coments/comment.html.twig', [
                                'i' => $c->getId(),
                                'c' => $c->getCommentComment(),
                                'st' => $c->getImageComment(),
                                'file' => $c->getFilename(),
                            ]);
                        } catch (\Exception $e) {
                            $msg = $e->getMessage();
                        }
                    }
            }else{
                $flag = false;
                $msg = "Por favor no dejes los campos vacios";
            }
        } else {
            $flag = false;
            $msg = "Algo salio mal";
        }
        return $this->json([
            'status' => $flag,
            'msg' => $msg,
            'html' => $html,
        ]);
    }
    /**
     * @Route("/tickets/deletecomment/{id}", name="deleteComment")
     *
     */
    public function deleteComment($id): JsonResponse
    {
        $comment = $this->em
            ->getRepository(Comentarios::class)
            ->findOneBy([
                'id' => $id
            ]);
        $flag = true;
        $msg = "";
        if($comment != null){
            try {
                $img = $comment->getFilename();
                (new Filesystem())->remove($this->getParameter('image')."/".$img);
                $this->em->remove($comment);
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
}

