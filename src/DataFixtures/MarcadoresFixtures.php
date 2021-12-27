<?php

namespace App\DataFixtures;

use App\Entity\Marcador;
use App\Entity\Categoria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarcadoresFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $marcador = new Marcador();
        $marcador->setNombre('marcador_e');
        $marcador->setUrl('https://theoldreader.com');
        $marcador->setFavorito(TRUE);
        $marcador->setCategoria($this->getReference(CategoriasFixtures::CATEGORIA_INTERNET_REFERENCIA));
        
        $manager->persist($marcador);
        
        $manager->flush();
        
    }
}
