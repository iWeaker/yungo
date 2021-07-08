<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inventario;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\DataTableFactory;

use Symfony\Component\Routing\Annotation\Route;



class InventarioController extends AbstractController
{
    
    /**
     * @Route("/inventario", name="inventario")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
                ->add('id', TextColumn::class)
                ->add('brand_inventory', TextColumn::class)
                ->add('type_inventory', TextColumn::class)
                ->add('model_inventory', TextColumn::class)
                ->add('mac_inventory', TextColumn::class)
                ->createAdapter(ORMAdapter::class, [
                    'entity' => Inventario::class,
            ])->handleRequest($request); 

        if($table->isCallback()){
            return $table->getResponse(); 
        }
            return $this->render('inventario/index.html.twig', [
            'datatable' => $table,
        ]);
    }

    /**
     * @Route("/inventario/create" , name="createInventario")
     *
     * 
     */
    public function create(){
        return $this->render('inventario/create.html.twig');
    }


}
