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
     * @Route("/prueba/sarasa/{parax}", name="prueba")
     */
    public function index($parax, Request $request, ServicioMio $servicioMio): Response
    {
        $direccionIp = $request->getClientIp();

        $ff = $this->getParameter('app.formato_fecha');
        $servicioMio->setNombre('Marcelo');

        return $this->render('prueba/index.html.twig', [
            'controller_name' => 'PruebaController',
            'param' => $parax,
            'direccionip' => $direccionIp,
            'ff'=> $ff,
            'version' => $this->getParameter('app.version'),
            'mi_nombre' => $servicioMio->retornarNombre(),
        ]);
    }
}
