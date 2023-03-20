<?php

namespace App\Controller;

use App\Entity\Proyectos;
use App\Form\ProyectosType;
use App\Repository\ProyectosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proyectos')]
class ProyectosController extends AbstractController
{
    #[Route('/', name: 'app_proyectos_index', methods: ['GET'])]
    public function index(ProyectosRepository $proyectosRepository): Response
    {
        return $this->render('proyectos/index.html.twig', [
            'proyectos' => $proyectosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_proyectos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProyectosRepository $proyectosRepository): Response
    {
        $proyecto = new Proyectos();
        $form = $this->createForm(ProyectosType::class, $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proyectosRepository->save($proyecto, true);

            return $this->redirectToRoute('app_proyectos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proyectos/new.html.twig', [
            'proyecto' => $proyecto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proyectos_show', methods: ['GET'])]
    public function show(Proyectos $proyecto): Response
    {
        return $this->render('proyectos/show.html.twig', [
            'proyecto' => $proyecto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_proyectos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Proyectos $proyecto, ProyectosRepository $proyectosRepository): Response
    {
        $form = $this->createForm(ProyectosType::class, $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proyectosRepository->save($proyecto, true);

            return $this->redirectToRoute('app_proyectos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proyectos/edit.html.twig', [
            'proyecto' => $proyecto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proyectos_delete', methods: ['POST'])]
    public function delete(Request $request, Proyectos $proyecto, ProyectosRepository $proyectosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proyecto->getId(), $request->request->get('_token'))) {
            $proyectosRepository->remove($proyecto, true);
        }

        return $this->redirectToRoute('app_proyectos_index', [], Response::HTTP_SEE_OTHER);
    }
}
