<?php

namespace App\Service;

/**
 * este servicio se va a inyectar .....
 */

class ServicioMio {

    private $mi_nombre;

    public function __construct(string $nombre = 'Mepk')
    {
        $this->mi_nombre = $nombre;
    }
    public function setNombre($nombre)
    {
        $this->mi_nombre = $nombre;
    }
    public function retornarNombre(): string
    {
        
        return $this->mi_nombre;
    }
}