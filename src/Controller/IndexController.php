<?php
namespace App\Controller;

use App\Form\BuscadorType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MarcadorRepository;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;

class IndexController extends AbstractController
{
    /**
     * @Route(
     *      "/buscar/{busqueda}", name="app_busqueda", defaults={"busqueda":""}
     * )
     */
    public function busqueda(string $busqueda, MarcadorRepository $marcadorRepository, Request $request)
    {
        $formularioBusqueda = $this->createForm(BuscadorType::class);

        $formularioBusqueda->handleRequest($request);
        $marcadores = [];

        if ($formularioBusqueda->isSubmitted()) {
            if ($formularioBusqueda->isValid()){
                $busqueda = $formularioBusqueda->get('busqueda')->getData();
            }
        };

        if (!empty($busqueda)){
            $marcadores = $marcadorRepository->buscarPorNombre($busqueda);
        };

        if (!empty($busqueda) || $formularioBusqueda->isSubmitted()){
            return $this->render('index/index.html.twig', [
                'formulario_busqueda' => $formularioBusqueda->createView(),
                'marcadores' => $marcadores,
            ]);
        };

        return $this->render('comunes/_buscador.html.twig', [
            'formulario_busqueda' => $formularioBusqueda->createView(),
        ]);
    }


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
