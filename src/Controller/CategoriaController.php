<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoria")
 */    
class CategoriaController extends AbstractController
{
    /**
     * @Route("/listado", name="app_listado_categoria")
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        $categorias = $categoriaRepository->findAll();

        dump($categorias);die();

        return $this->render('categoria/index.html.twig', [
            'controller_name' => 'CategoriaController',

        ]);
    }
    /**
     * @Route("/nueva", name="app_nueva_categoria")
     */    
    public function nueva(CategoriaRepository $categoriaRepository , EntityManagerInterface $entityManager, Request $request) 
    {

        $categoria = new Categoria();

        if ($this->isCsrfTokenValid('categoria', $request->request->get('_token'))){
            $nombre = $request->request->get('nombre', null);
            $categoria->setNombre($nombre);
            if ($nombre){
                $entityManager->persist($categoria);
                $entityManager->flush();
                $this->addFlash('success', 'Categoria creada correctamente');
                return $this->redirectToRoute('app_listado_categoria');
            }


        }

        return $this->render('categoria/nueva.html.twig', [
            'categoria' => $categoria,

        ]); 
    }
}
