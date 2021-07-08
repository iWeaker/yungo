<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yajra\DataTables\Facades\DataTables;


class InventarioController extends AbstractController
{
    /**
     * @Route("/inventario", name="inventario")
     */
    public function index(): Response
    {
        return $this->render('inventario/index.html.twig', [
            'controller_name' => 'InventarioController',
        ]);
    }


    /**
     * @Route("/inventario/api", name="apiInventario")
     * 
     */

    public function data(Request $request)
    {
        
        if($request->ajax())
        {
            $data = Inventario::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row)
            {
                $btn="<a href='/inventario/$row->idInventario/edit' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded'>Editar</a>
                <a href='/inventario/asignarEquipo/$row->idInventario' class='bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 border border-purple-700 rounded'>Asignar</a>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('tablas.equipoTabla');
        
    }
}
