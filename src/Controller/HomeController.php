<?php

namespace App\Controller;

use App\Entity\Clientes;
use Omines\DataTablesBundle\DataTableFactory;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTable;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class HomeController extends AbstractController
{
    private $serializer; 
    private $normalizers;
    private $encoders; 

    function _construct(){
        $this->encoders = [new XmlEncoder(), new JsonEncoder()];
        $this->normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }
    /**
     * @Route("/", name="home")
     */
    public function index( DataTableFactory $dataTableFactory, Request $request): Response
    {
        $client = $this->getDoctrine()
        ->getRepository(Clientes::class)
        ->findAll();
    
        $response = array();
        foreach ($client as $user) {
            $response[] = array(
                $user->getId(),
                $user->getNameClient(),
                $user->getEmailClient(), 
                $user->getPhoneClient(), 
               
            );
        }
        
        return $this->render('home/index.html.twig', [
            'response' => json_encode($response)
        ]);
        
    }
    
    

}
