<?php

namespace App\DataFixtures;

use App\Entity\Categoria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriasFixtures extends Fixture
{
    public const CATEGORIA_INTERNET_REFERENCIA = 'categoria-internet';


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $categoria = new Categoria();
        $categoria->setColor('red');
        $categoria->setNombre('esta');
        $manager->persist($categoria);

        $manager->flush();
        
        $this->addReference(self::CATEGORIA_INTERNET_REFERENCIA, $categoria);
    }
}
