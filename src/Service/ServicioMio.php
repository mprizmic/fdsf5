<?php

namespace App\Service;

/**
 * este servicio se va a inyectar .....
 */

class ServicioMio {

    private $mi_nombre;

    public function __construct()
    {
        $this->mi_nombre = 'Ezequiel';
    }
    public function setNombre($nombre)
    {
        $this->mi_nombre = $nombre;
    }
    public function retornarNombre(){
        
        return $this->mi_nombre;
    }
}