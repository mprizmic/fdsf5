<?php

namespace App\Repository;

use App\Entity\Marcador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marcador|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marcador|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marcador[]    findAll()
 * @method Marcador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarcadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marcador::class);
    }

    public function buscarPorNombreCategoria($nombreCategoria)
    {
        $query =  $this->createQueryBuilder('m')
        ->innerJoin('m.categoria', 'c')
        ->where('c.nombre = :nombreCategoria')
        ->orderBy('m.creado', 'DESC')
        ->setParameter('nombreCategoria', $nombreCategoria )
        ->getQuery()
        ;
        
        return $query->getResult();
    }
    
    public function buscarTodos()
    {
        $query =  $this->createQueryBuilder('m')
        ->orderBy('m.creado', 'DESC')
        ->addOrderBy('m.nombre', 'ASC')
        ->getQuery()
        ;
        
        return $query->getResult();
    }
    

    public function buscarPorNombre($nombre)
    {
        $query = $this->createQueryBuilder('m')
        ->where('m.nombre like :nombre')
        ->orderBy('m.creado', 'DESC')
        ->setParameter('nombre', "%$nombre%" )
        ->getQuery()
        ;

        return $query->getResult();
    }

    public function paginacion($dql, $pagina = 1, $elementos_por_pagina = 5) {
        $paginador = new Paginator($dql);
        $paginador->getQuery()
            ->setFirstResult($elementos_por_pagina * ($pagina - 1))
            ->setMaxResults($elementos_por_pagina);
        return  $paginador; 
    }
    // /**
    //  * @return Marcador[] Returns an array of Marcador objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marcador
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
