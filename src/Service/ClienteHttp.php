<?php

namespace App\Service;

/**
 * este servicio se va a inyectar en la validación de un campo
 * CUSTOM VALIDATION CONSTRAINT
 * Todas las clases se pueden utilizar como servicios sin que haga falta configurarlo
 */

use App\Repository\CategoriaRepository;
use Exception;
use Symfony\Component\HttpClient\HttpClient;

class ClienteHttp {

    private $clienteHttp;

    public function __construct()
    {
        $this->clienteHttp = HttpClient::create();
    }
    public function obtenerCodigoUrl(string $url){
        $codigoEstado = null;

        try {
            $respuesta = $this->clienteHttp->request('GET', $url);
            $codigoEstado = $respuesta->getStatusCode();
        } catch(Exception $e){
            $codigoEstado = null;
        }
        return $codigoEstado;
    }
}