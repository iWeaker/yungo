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
        $clientes = $this->getDoctrine()
        ->getRepository(Inventario::class)
        ->findAll();
    
        $response = array();
        foreach ($clientes as $cliente) {
            $response[] = array(
                $cliente->getId(),
                $cliente->getMacInventory(),
                $cliente->getModelInventory(), 
                $cliente->getBrandInventory(), 
                $cliente->getTypeInventory(), 
            );
        }
        
            return $this->render('inventario/index.html.twig', [
            'response' => json_encode($response),
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

    /**
     * @Route("/inventario/edit/{id}" , name="editInventario")
     *
     * 
     */
    public function edit($id){
        return $this->render('inventario/edit.html.twig', [
            'brand' => 'asdasdasd', 
            'model' => 'asf', 
            'id' => $id
        ]);
    }

    /**
     * @Route("/inventario/assign/{id}", name="assignInventario")
     * 
     */

     public function assign($id){
         return $this->render('inventario/assign.html.twig'); 

     }


}
