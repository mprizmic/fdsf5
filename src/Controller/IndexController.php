<?php

namespace App\Controller;

use App\Repository\MarcadorRepository;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/editar-favorito", name="app_editar_favorito")
     */
    public function editarFavorito(MarcadorRepository $marcadorRepository, EntityManagerInterface $entityManager, Request $request)
    {
        //chequea que sea una peticion AJAX
        if ($request->isXmlHttpRequest()){
            
            $actualizado = true;

            $idMarcador = $request->get('id');
            //getdoctrine esta DEPRECATED. Hay que pasar el EntityManagerInterface de parámetro
            //$entityManager = $this->getDoctrine()->getManager();
            $marcador = $marcadorRepository->findOneById($idMarcador);
            $marcador->setFavorito(!$marcador->getFavorito());

            try {
            $entityManager->flush();
            } catch (\Exception $e){
                $actualizado = false;
            };

            return $this->json([ 'actualizado' => $actualizado ]);
        }
        //si no es una peticion AJAX tira error
        throw $this->createNotFoundException();
    }


    /**
     * @Route("/favoritos", name="app_favoritos")
     */
    public function favoritos(MarcadorRepository $marcadorRepository)
    {
        $marcadores = $marcadorRepository->findBy([
            'favorito' => true,
        ]);

        return $this->render('index/index.html.twig', ['marcadores' => $marcadores]);
    }

    /**
     * @Route("/{categoria}", name="app_index", defaults={"categoria": ""})
     */
    public function index(String $categoria, CategoriaRepository $categoriaRepository, MarcadorRepository $marcadorRepository): Response
    {
        if (!empty($categoria)) {
            if (!$categoriaRepository->findByNombre($categoria)) {
                throw $this->createNotFoundException("La categoria '$categoria' no existe");
            }
            $marcadores = $marcadorRepository->buscarPorNombreCategoria($categoria);
        } else {
            $marcadores = $marcadorRepository->findAll();
        }

        return $this->render('index/index.html.twig', [
            'marcadores' => $marcadores,
        ]);
    }
}
