<?php

namespace App\Controller;

use App\Form\InventaryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inventario;
use App\Form\NewInventaryType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\Routing\Annotation\Route;

class InventarioController extends AbstractController
{
    protected $em;
    /**
     * @var EntityManagerInterface
     */
    public function  __construct(EntityManagerInterface $entityManager){
       $this->em = $entityManager;
    }
    /**
     * @Route("/inventario", name="inventario")
     */
    public function index(): Response
    {
        $inventario =$this->em
        ->getRepository(Inventario::class)
        ->findAll();
        $response = array();
        foreach ($inventario as $inv) {
            $ip = "Sin asginar ip";
            if($inv->getServicio() != null){
                $ip = $inv->getServicio()->getIpService();
            }
            $response[] = array(
                $inv->getId(),
                $inv->getMacInventory(),
                $inv->getModelInventory(), 
                $inv->getBrandInventory(), 
                $inv->getTypeInventory(),
                $ip
            );
        }
            return $this->render('inventario/index.html.twig', [
            'response' => json_encode($response),
        ]);
    }
    /**
     * @Route("/inventario/create" , name="createInventario")
     */
    public function create(Request $request){
        $form = $this->createForm(NewInventaryType::class, new Inventario);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $brand = $form['brand_inventory']->getData();
            $model = $form['model_inventory']->getData(); 
            $mac   = $form['mac_inventory']->getData();
            $type  = $form['type_inventory']->getData();
            $flag = true;
            $msg = "";
            if($brand == null || $model == null || $mac == null || $type == null){$flag = false;$msg = "Algun dato no esta escrito correctamente";}
            if($flag){
                $in = new Inventario();
                $in->setMacInventory($mac);
                $in->setTypeInventory($type);
                $in->setModelInventory($model); 
                $in->setBrandInventory($brand);
                $this->em ->persist($in);
                try{
                    $this->em ->flush();
                    $msg = "Se ha realizado correctamente";
                }catch(\Exception $e) {
                    $msg = $e->getMessage();
                }
            }
            return new JsonResponse(array(
                'status' => $flag,
                'msg' => $msg
            ));
        }
        return $this->render('inventario/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/inventario/edit/{id}" , name="editInventario")
     */
    public function edit($id, Request  $request){
        $form = $this->createForm(InventaryType::class, new Inventario());
        $inv = $this->em->getRepository(Inventario::class)->findOneBy([
            'id' => $id
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $brand = $form['brand_inventory']->getData();
            $model = $form['model_inventory']->getData();
            $mac   = $form['mac_inventory']->getData();
            $radio = $form['type_inventory']->getData();
            $flag = true;
            $msg = "";
            if($brand == null || $model == null || $mac == null || $radio == null){$flag = false;$msg = "Algun dato no esta escrito correctamente";}
            if(!filter_var($mac, FILTER_VALIDATE_MAC)){ $flag=false; $msg = "No es valido esa Mac proporcionada"; }
            if($flag) {
                $v = $this->em->getRepository(Inventario::class)->checkDuplicatedMac($id, $mac);
                if (count($v) > 0) {
                       $flag= false;
                       $msg = "Existe una MAC igual en el sistema";
                } else {
                    $inv->setBrandInventory($brand);
                    $inv->setModelInventory($model);
                    $inv->setMacInventory($mac);
                    $inv->setTypeInventory($radio);
                    $this->em ->persist($inv);
                    try {
                        $this->em ->flush();
                        $msg = "Se ha realizado con exito la actualizacion";
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
        return $this->render('inventario/edit.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
            'brand' => $inv->getBrandInventory(),
            'type' => $inv->getTypeInventory(),
            'model' => $inv->getModelInventory(),
            'mac' => $inv->getMacInventory()
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
