<?php

namespace App\Controller;

use App\Entity\Marcador;
use App\Form\MarcadorType;
use App\Repository\MarcadorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marcador")
 */
class MarcadorController extends AbstractController
{

    /**
     * @Route("/new", name="marcador_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marcador = new Marcador();
        $form = $this->createForm(MarcadorType::class, $marcador);
        $form->handleRequest($request);

        // form->isValid aplica las validaciones que le puse en PHP a través de las anotaciones en Marcador::class
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marcador);
            $entityManager->flush();

            $this->addFlash('success', 'Marcador creado');

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marcador/new.html.twig', [
            'marcador' => $marcador,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="marcador_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Marcador $marcador, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarcadorType::class, $marcador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Marcador modificado');

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marcador/edit.html.twig', [
            'marcador' => $marcador,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="marcador_delete", methods={"POST"})
     */
    public function delete(Request $request, Marcador $marcador, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marcador->getId(), $request->request->get('_token'))) {
            $entityManager->remove($marcador);
            $entityManager->flush();

            $this->addFlash('success', 'Marcador eliminado');
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
