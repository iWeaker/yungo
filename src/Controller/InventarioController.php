<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inventario;
use App\Form\NewInventaryType;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Omines\DataTablesBundle\DataTableFactory;

use Symfony\Component\Routing\Annotation\Route;



class InventarioController extends AbstractController
{
    
    /**
     * @Route("/inventario", name="inventario")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $inventario = $this->getDoctrine()
        ->getRepository(Inventario::class)
        ->findAll();
    
        $response = array();
        foreach ($inventario as $inv) {
            $response[] = array(
                $inv->getId(),
                $inv->getMacInventory(),
                $inv->getModelInventory(), 
                $inv->getBrandInventory(), 
                $inv->getTypeInventory(), 
            );
        }
        
            return $this->render('inventario/index.html.twig', [
            'response' => json_encode($response),
            'button' => '<button>hola</button>',
        ]);
    }

    /**
     * @Route("/inventario/create" , name="createInventario")
     *
     * 
     */
    public function create(Request $request){
        

        $form = $this->createForm(NewInventaryType::class, new Inventario);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            
            $brand = $form['brand_inventory']->getData(); 
            $model = $form['model_inventory']->getData(); 
            $mac   = $form['mac_inventory']->getData();
            $type  = $form['type_inventory']->getData(); 
            if($brand == null || $model == null || $mac == null || $type == null){
                $error = "Error de ambos";
            }else{
                $in = new Inventario();
                $in->setMacInventory($mac);
                $in->setTypeInventory($type);
                $in->setModelInventory($model); 
                $in->setBrandInventory($brand); 
                $entityManager->persist($in);
                try{
                    $entityManager->flush();
                    return new JsonResponse(array(
                        'status' => true,
                        'msg' => 'Se ha registrado con exito!'
                    ));
                }catch(\Exception $e) {
                    $message = $e->getMessage();
                }

            }
        }
        return $this->render('inventario/create.html.twig', [
            'form' => $form->createView(),
        ]);
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
