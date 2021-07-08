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

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(DataTableFactory $dataTableFactory, Request $request): Response
    {
        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class)
            ->add('name_client', TextColumn::class)
            ->add('email_client', TextColumn::class)
            ->add('phone_client', TextColumn::class)
            ->add('address_client', TextColumn::class)
            ->createAdapter(ORMAdapter::class, [
                'entity' => Clientes::class,
            ])->handleRequest($request); 

        if($table->isCallback()){
            return $table->getResponse(); 
        }
            return $this->render('home/index.html.twig', [
            'datatable' => $table,
        ]);
    }



}
