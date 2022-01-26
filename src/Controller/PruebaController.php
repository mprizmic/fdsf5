<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ServicioMio;

class PruebaController extends AbstractController
{
    /**
     * @Route("/prueba/sarasa/{parax}", name="app_prueba")
     */
    public function index($parax, ServicioMio $servicio_mio, Request $request): Response
    {
        $direccionIp = $request->getClientIp();

        $ff = $this->getParameter('app.formato_fecha');


        $nombre1 = $servicio_mio->retornarNombre();
        $servicio_mio->setNombre('Marcelo');
        $nombre2 = $servicio_mio->retornarNombre();

        return $this->render('prueba/index.html.twig', [
            'controller_name' => 'PruebaController',
            'param' => $parax,
            'direccionip' => $direccionIp,
            'ff'=> $ff,
            'version' => $this->getParameter('app.version'),
            'mi_nombre1' => $nombre1,
            'mi_nombre2' => $nombre2,
        ]);
    }
}
