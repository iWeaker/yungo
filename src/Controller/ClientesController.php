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

class ClientesController extends AbstractController
{
    /**
     * @Route("/clientes", name="clientes")
     */
    public function index(DataTableFactory $dataTableFactory , Request $request): Response
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
            return $this->render('clientes/index.html.twig', [
            'datatable' => $table,
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
